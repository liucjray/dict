<?php

namespace App\Services;

use GuzzleHttp\Client;

class ShanBayService
{
    public function send(array $req)
    {
        $cReq = collect($req);
        if ($cReq->has('q') && $cReq->get('q')) {
            $q = $cReq->get('q');
            return $this->callApi($q);
        }
    }

    public function callApi($q)
    {
        $uri = sprintf('https://api.shanbay.com/bdc/search/?word=%s', $q);
        $client = new Client();
        return (string) $client
            ->request('GET', $uri)
            ->getBody()->getContents();
    }
}