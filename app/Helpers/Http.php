<?php
namespace App\Helpers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;

class Http
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var GenericBuilder
     */
    private $builder;
    /**
     * @var Response
     */
    private $http;

    public function __construct()
    {
        $this->client = new Client();
        $this->builder = new GenericBuilder();
    }

    public function get($q, $format)
    {
        $http = $this->client->request('GET', Server::API_URL, [
            'query' => [
                'format' => $format,
                'q' => $q
            ]
        ]);

        $this->http = $http;

        return $http;
    }

    public function post($q)
    {
        $http = $this->client->request('POST', Server::API_URL, [
            'json' => [
                'q' => $q,
                'api_key' => Server::API_KEY
            ]
        ]);

        $this->http = $http;

        return $http;
    }

    public function getData()
    {
        return json_decode($this->http->getBody()->getContents());
    }

    public function getFirstRow()
    {
        $data = json_decode($this->http->getBody()->getContents());
        return reset($data->rows);
    }

    public function getErrorMessage(RequestException $e)
    {
        if ($e->hasResponse()) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            return reset($response->error);
        } else {
            return 'Network unavailable.';
        }
    }

    public function getErrorFlash($type, $label)
    {
        if ($type === 'store')
            return "Hubo un error al crear el $label: ";
        else if ($type === 'update')
            return "Hubo un error al actualizar el $label: ";
        else
            return false;
    }

    public function getSuccessFlash($type, $label)
    {
        if ($type === 'store')
            return "$label creado exitosamente.";
        else if ($type === 'update')
            return "$label actualizado exitosamente.";
        else if ($type === 'delete')
            return "$label eliminado exitosamente.";
        else
            return false;
    }
}