<?php
namespace App\Http\Controllers;


use App\Helpers\DBHelper;
use App\Helpers\Helper;
use App\Helpers\Http;
use App\Helpers\Server;
use Illuminate\Http\Request;
use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;
use Yajra\Datatables\Datatables;

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

        /*if ($request->has('arovia') && $request->get('arovia') != '')
            $q->where()->equals('arovia', $request->get('arovia'));*/
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
            ->make(true);

        return $object;
    }

    public function create()
    {
        return view('pages.distritos.create', compact(''));
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {
        return view('pages.distritos.edit', compact(''));
    }

    public function update($id, Request $request)
    {

    }

    public function delete($id)
    {

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