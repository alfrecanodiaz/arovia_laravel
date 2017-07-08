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

class DepartamentosController extends Controller
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
        $arovia = array('' => 'Todos', 'si' => 'Si', 'no' => 'No');

        return view('pages.departamentos.index', compact('arovia'));
    }

    public function indexAjax(Request $request)
    {
        $q = $this->builder->select()
            ->setTable('paraguay_2012_departamentos')
            ->setColumns(['cartodb_id', 'arovia', 'dpto', 'dpto_desc'])
            ->orderBy('dpto')
            ->orderBy('dpto_desc');

        if ($request->has('arovia') && $request->get('arovia') != '')
            $q->where()->equals('arovia', $request->get('arovia'));
        if ($request->has('departamento') && $request->get('departamento') != '')
            $q->where()->like('dpto_desc', "%{$request->get('departamento')}%");

        $this->query = DBHelper::prepare($this->builder, $q);
        $this->http->get($this->query, Server::FORMAT_JSON);

        $data = $this->http->getData();

        $object = Datatables::of($data->rows)
            ->addColumn('action', function ($row) {
                $asEdit = "mapa.departamentos.edit";
                $asDestroy = "mapa.departamentos.delete";
                $editRoute = route( $asEdit, [$row->cartodb_id]);
                $deleteRoute = route( $asDestroy, [$row->cartodb_id]);

                return Helper::getTableButtons($editRoute, $deleteRoute);
            })
            ->editColumn('dpto', function ($row){
               return Helper::withHref("mapa.departamentos.edit", $row->cartodb_id, $row->dpto);
            })
            ->editColumn('dpto_desc', function ($row){
                return Helper::withHref("mapa.departamentos.edit", $row->cartodb_id, $row->dpto_desc);
            })
            ->editColumn('arovia', function ($row){
                return Helper::withHref("mapa.departamentos.edit", $row->cartodb_id, $row->arovia);
            })
            ->make(true);

        return $object;
    }

    public function create()
    {
        $arovia = array('' => 'Todos', 'si' => 'Si', 'no' => 'No');

        return view('pages.departamentos.create', compact('arovia'));
    }

    public function store(Request $request)
    {
        $q = $this->builder->insert()->setTable('paraguay_2012_departamentos');
        $q->setValues($request->except(['_token']));

        $this->query = DBHelper::prepare($this->builder, $q);

        try {
            $this->http->post($this->query);
        } catch (RequestException $e) {
            flash($this->http->getErrorFlash('store', 'departamento').$this->http->getErrorMessage($e))->error();
            return redirect()->back()->withInput($request->input());
        }

        flash($this->http->getSuccessFlash('store', 'Departamento'))->success();

        return redirect()->route('mapa.departamentos.index');
    }

    public function edit($id)
    {
        $q = $this->builder->select()->setTable('paraguay_2012_departamentos');
        $q->setColumns(['the_geom', 'cartodb_id', 'arovia', 'dpto', 'dpto_desc']);
        $q->where()->equals('cartodb_id', $id);
        $q->limit(1);

        $this->query = DBHelper::prepare($this->builder, $q);

        $this->http->get($this->query, Server::FORMAT_JSON);

        $data = $this->http->getFirstRow();

        return view('pages.departamentos.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $q = $this->builder->update()->setTable('paraguay_2012_departamentos');
        $q->setValues($request->except(['_token']));
        $q->where()->equals('cartodb_id', (int)$id);

        $this->query = DBHelper::prepare($this->builder, $q);

        try {
            $this->http->post($this->query);
        } catch (RequestException $e) {
            flash($this->http->getErrorFlash('update', 'departamento').$this->http->getErrorMessage($e))->error();
            return redirect()->back()->withInput($request->input());
        }

        flash($this->http->getSuccessFlash('update', 'Departamento'))->success();

        return redirect()->route('mapa.departamentos.index');
    }

    public function delete($id)
    {
        $q = $this->builder->delete()->setTable('paraguay_2012_departamentos');
        $q->where()->equals('cartodb_id', (int)$id);

        $this->query = DBHelper::prepare($this->builder, $q);

        $this->http->post($this->query);

        flash($this->http->getSuccessFlash('delete', 'Departamento'))->success();

        return redirect()->route('mapa.departamentos.index');
    }

    public function autocomplete(Request $request)
    {
        if ($request->has('term')  && trim($request->has('term') !== ''))
        {
            $q = $this->builder->select()
                ->setTable('paraguay_2012_departamentos')
                ->setColumns(['cartodb_id', 'dpto_desc'])
                ->orderBy('dpto_desc');

            $q->where()->like('dpto_desc', "%{$request->get('term')}%");
            $q->limit(5);

            $this->query = DBHelper::prepare($this->builder, $q);
        }
        $this->http->post($this->query);

        $data = $this->http->getData();

        if (!empty($data->rows)) {
            foreach ($data->rows as $row)
                $results[] = ['id' => $row->cartodb_id, 'value' => $row->dpto_desc];
        }

        if (isset($results))
            return response()->json($results);
        else
            return response()->json("");
    }
}