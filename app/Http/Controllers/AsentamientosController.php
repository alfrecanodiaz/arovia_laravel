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

class AsentamientosController extends Controller
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
        return view('pages.asentamientos.index', compact(''));
    }

    public function indexAjax(Request $request)
    {
        $q = $this->builder->select()
            ->setTable('datos_por_asentamiento')
            ->setColumns([
                'cartodb_id',
                'fecha_de_creacion',
                'nombre',
                'poblacion',
                'superficie'
            ])
            ->orderBy('nombre');

        if ($request->has('asentamiento') && $request->get('asentamiento') != '')
            $q->where()->like('nombre', "%{$request->get('asentamiento')}%");

        $this->query = DBHelper::prepare($this->builder, $q);
        $this->http->get($this->query, Server::FORMAT_JSON);

        $data = $this->http->getData();

        $object = Datatables::of($data->rows)
            ->addColumn('action', function ($row) {
                $asEdit = "mapa.asentamientos.edit";
                $asDestroy = "mapa.asentamientos.delete";
                $editRoute = route( $asEdit, [$row->cartodb_id]);
                $deleteRoute = route( $asDestroy, [$row->cartodb_id]);

                return Helper::getTableButtons($editRoute, $deleteRoute);
            })
            ->editColumn('nombre', function ($row){
                return Helper::withHref("mapa.asentamientos.edit", $row->cartodb_id, $row->nombre);
            })
            ->editColumn('fecha_de_creacion', function ($row){
                return Helper::withHref("mapa.asentamientos.edit", $row->cartodb_id, $row->fecha_de_creacion);
            })
            ->editColumn('poblacion', function ($row){
                return Helper::withHref("mapa.asentamientos.edit", $row->cartodb_id, $row->poblacion);
            })
            ->editColumn('superficie', function ($row){
                return Helper::withHref("mapa.asentamientos.edit", $row->cartodb_id, $row->superficie);
            })
            ->escapeColumns([]) //Para renderizar HTML
            ->make(true);

        return $object;
    }

    public function create()
    {
        return view('pages.asentamientos.create', compact(''));
    }

    public function store(Request $request)
    {
        $old_geom = $request->get('the_geom');
        
        if (Helper::formatPolygon($request->get('the_geom')))
            $request['the_geom'] = "ST_GeomFromGeoJSON('".Helper::formatPolygon($request->get('the_geom'))."')";

        $q = $this->builder->insert()->setTable('datos_por_asentamiento');
        $q->setValues($request->except(['_token']));

        $this->query = DBHelper::prepare($this->builder, $q);

        try {
            $this->http->post($this->query);
        } catch (RequestException $e) {
            flash($this->http->getErrorFlash('store', 'asentamiento').$this->http->getErrorMessage($e))->error();
            $request['the_geom'] = $old_geom;
            return redirect()->back()->withInput($request->input());
        }

        flash($this->http->getSuccessFlash('store', 'Asentamiento'))->success();

        return redirect()->route('mapa.asentamientos.index');
    }

    public function edit($id)
    {
        $q = $this->builder->select()->setTable('datos_por_asentamiento');
        $q->setColumns([
            // 'the_geom',
            'ST_AsGeoJSON(the_geom) as the_geom',
            'cartodb_id',
            '_url',
            'caracteristicas',
            'dedicacion_de_la_comunidad',
            'fecha_de_creacion',
            'infraestrucutra_local',
            'nombre',
            'origen_asentamiento',
            'poblacion',
            'superficie'
        ]);
        $q->where()->equals('cartodb_id', $id);
        $q->limit(1);

        $this->query = DBHelper::prepare($this->builder, $q);

        $this->http->get($this->query, Server::FORMAT_JSON);

        $data = $this->http->getFirstRow();

        return view('pages.asentamientos.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $old_geom = $request->get('the_geom');

        if (Helper::formatPolygon($request->get('the_geom')))
            $request['the_geom'] = "ST_GeomFromGeoJSON('".Helper::formatPolygon($request->get('the_geom'))."')";

        $q = $this->builder->update()->setTable('datos_por_asentamiento');
        $q->setValues($request->except(['_token']));
        $q->where()->equals('cartodb_id', (int)$id);

        $this->query = DBHelper::prepare($this->builder, $q);
        // dd($this->query);

        try {
            $this->http->post($this->query);
        } catch (RequestException $e) {
            flash($this->http->getErrorFlash('update', 'asentamiento').$this->http->getErrorMessage($e))->error();
            $request['the_geom'] = $old_geom;
            return redirect()->back()->withInput($request->input());
        }

        flash($this->http->getSuccessFlash('update', 'Asentamiento'))->success();

        return redirect()->route('mapa.asentamientos.index');
    }

    public function delete($id)
    {
        $q = $this->builder->delete()->setTable('datos_por_asentamiento');
        $q->where()->equals('cartodb_id', (int)$id);

        $this->query = DBHelper::prepare($this->builder, $q);

        $this->http->post($this->query);

        flash($this->http->getSuccessFlash('delete', 'Asentamiento'))->success();

        return redirect()->route('mapa.asentamientos.index');
    }

    public function autocomplete(Request $request)
    {
        if ($request->has('term')  && trim($request->has('term') !== ''))
        {
            $q = $this->builder->select()
                ->setTable('datos_por_asentamiento')
                ->setColumns(['cartodb_id', 'nombre'])
                ->orderBy('nombre');

            $q->where()->like('nombre', "%{$request->get('term')}%");
            $q->limit(5);

            $this->query = DBHelper::prepare($this->builder, $q);
        }
        $this->http->post($this->query);

        $data = $this->http->getData();

        if (!empty($data->rows)) {
            foreach ($data->rows as $row)
                $results[] = ['id' => $row->cartodb_id, 'value' => $row->nombre];
        }

        if (isset($results))
            return response()->json($results);
        else
            return response()->json("");
    }
}