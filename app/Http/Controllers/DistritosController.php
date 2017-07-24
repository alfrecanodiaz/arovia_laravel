<?php
namespace App\Http\Controllers;

use App\Helpers\DBHelper;
use App\Helpers\Helper;
use App\Helpers\Http;
use App\Helpers\Server;
use GuzzleHttp\Exception\RequestException;
use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class DistritosController extends Controller
{
    /**
     * @var Http
     */
    private $http;
    /**
     * @var GenericBuilder
     */
    private $builder;
    /**
     * @var string
     */
    private $query;

    public function __construct()
    {
        $this->builder = new GenericBuilder();
        $this->http = new Http();
    }

    public function index()
    {
        return view('pages.distritos.index', compact(''));
    }

    public function indexAjax(Request $request)
    {
        $q = $this->builder->select()
            ->setTable('datos_por_distrito')
            ->setColumns([
                'cartodb_id',
                'consejo_de_desarrollo_distrital',
                'fecha_creacion',
                'nombre_municipio',
                'nro_comunidades',
                'plan_de_desarrollo_distrital'
            ])
            ->orderBy('nombre_municipio');

        if ($request->has('consejo_distrital') && $request->get('consejo_distrital') != '')
            $q->where()->equals('consejo_de_desarrollo_distrital', $request->get('consejo_distrital'));
        if ($request->has('plan_distrital') && $request->get('plan_distrital') != '')
            $q->where()->equals('plan_de_desarrollo_distrital', $request->get('plan_distrital'));
        if ($request->has('distrito') && $request->get('distrito') != '')
            $q->where()->like('nombre_municipio', "%{$request->get('distrito')}%");

        $this->query = DBHelper::prepare($this->builder, $q);
        $this->http->get($this->query, Server::FORMAT_JSON);

        $data = $this->http->getData();

        $object = Datatables::of($data->rows)
            ->addColumn('action', function ($row) {
                $asEdit = "mapa.distritos.edit";
                $asDestroy = "mapa.distritos.delete";
                $editRoute = route( $asEdit, [$row->cartodb_id]);
                $deleteRoute = route( $asDestroy, [$row->cartodb_id]);

                return Helper::getTableButtons($editRoute, $deleteRoute);
            })
            ->editColumn('consejo_de_desarrollo_distrital', function ($row){
                return Helper::withHref("mapa.distritos.edit", $row->cartodb_id, $row->consejo_de_desarrollo_distrital);
            })
            ->editColumn('fecha_creacion', function ($row){
                return Helper::withHref("mapa.distritos.edit", $row->cartodb_id, $row->fecha_creacion);
            })
            ->editColumn('nombre_municipio', function ($row){
                return Helper::withHref("mapa.distritos.edit", $row->cartodb_id, $row->nombre_municipio);
            })
            ->editColumn('nro_comunidades', function ($row){
                return Helper::withHref("mapa.distritos.edit", $row->cartodb_id, $row->nro_comunidades);
            })
            ->editColumn('plan_de_desarrollo_distrital', function ($row){
                return Helper::withHref("mapa.distritos.edit", $row->cartodb_id, $row->plan_de_desarrollo_distrital);
            })
            ->escapeColumns([]) //Para renderizar HTML
            ->make(true);

        return $object;
    }

    public function create()
    {
        return view('pages.distritos.create', compact(''));
    }

    public function store(Request $request)
    {
        $request->request->add(['the_geom' => 'ST_SetSRID(ST_MakePoint('.$request->get("lon").', '.$request->get("lat").'), 4326)']);

        $q = $this->builder->insert()->setTable('datos_por_distrito');
        $q->setValues($request->except(['_token', 'lon', 'lat']));

        $this->query = DBHelper::prepare($this->builder, $q);

        try {
            $this->http->post($this->query);
        } catch (RequestException $e) {
            flash($this->http->getErrorFlash('store', 'distrito').$this->http->getErrorMessage($e))->error();
            return redirect()->back()->withInput($request->input());
        }

        flash($this->http->getSuccessFlash('store', 'Distrito'))->success();

        return redirect()->route('mapa.distritos.index');
    }

    public function edit($id)
    {
        $q = $this->builder->select()->setTable('datos_por_distrito');
        $q->setColumns([
            /*'the_geom',*/
            'ST_AsGeoJSON(the_geom) as the_geom',
            'cartodb_id',
            'actividades_economicas',
            'caracteristica_municipal',
            'consejo_de_desarrollo_distrital',
            'enlace_nube',
            'fecha_creacion',
            'nombre_municipio',
            'nro_comunidades',
            'plan_de_desarrollo_distrital',
            'poblacion',
            'poblacion_rural',
            'poblacion_urbana',
            'superficie',
            'temas_prioritarios_distritales',
            '_url'
        ]);
        $q->where()->equals('cartodb_id', $id);
        $q->limit(1);

        $this->query = DBHelper::prepare($this->builder, $q);

        $this->http->get($this->query, Server::FORMAT_JSON);

        $data = $this->http->getFirstRow();

        return view('pages.distritos.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $request->request->add(['the_geom' => 'ST_SetSRID(ST_MakePoint('.$request->get("lon").', '.$request->get("lat").'), 4326)']);

        $q = $this->builder->update()->setTable('datos_por_distrito');
        $q->setValues($request->except(['_token', 'lon', 'lat']));
        $q->where()->equals('cartodb_id', (int)$id);

        $this->query = DBHelper::prepare($this->builder, $q);

        try {
            $this->http->post($this->query);
        } catch (RequestException $e) {
            flash($this->http->getErrorFlash('update', 'distrito').$this->http->getErrorMessage($e))->error();
            return redirect()->back()->withInput($request->input());
        }

        flash($this->http->getSuccessFlash('update', 'Distrito'))->success();

        return redirect()->route('mapa.distritos.index');
    }

    public function delete($id)
    {
        $q = $this->builder->delete()->setTable('datos_por_distrito');
        $q->where()->equals('cartodb_id', (int)$id);

        $this->query = DBHelper::prepare($this->builder, $q);

        $this->http->post($this->query);

        flash($this->http->getSuccessFlash('delete', 'Distrito'))->success();

        return redirect()->route('mapa.distritos.index');
    }

    public function autocomplete(Request $request)
    {
        if ($request->has('term')  && trim($request->has('term') !== ''))
        {
            $q = $this->builder->select()
                ->setTable('datos_por_distrito')
                ->setColumns(['cartodb_id', 'nombre_municipio'])
                ->orderBy('nombre_municipio');

            $q->where()->like('nombre_municipio', "%{$request->get('term')}%");
            $q->limit(5);

            $this->query = DBHelper::prepare($this->builder, $q);
        }
        $this->http->post($this->query);

        $data = $this->http->getData();

        if (!empty($data->rows)) {
            foreach ($data->rows as $row)
                $results[] = ['id' => $row->cartodb_id, 'value' => $row->nombre_municipio];
        }

        if (isset($results))
            return response()->json($results);
        else
            return response()->json("");
    }
}