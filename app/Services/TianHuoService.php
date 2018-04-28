<?php

namespace App\Services;

use DiDom\Document;
use GuzzleHttp\Client;

class TianHuoService
{
    public function send(array $req)
    {
        $cReq = collect($req);
        if ($cReq->has('q') && $cReq->get('q')) {
            $q = $cReq->get('q');
            $resp = $this->callApi($q);
            return $this->parseHtml($resp);
        }
    }

    public function callApi($q)
    {
        $uri = sprintf('http://cdict.info/cjquery/%s', $q);
        $client = new Client();
        return (string) $client
            ->request('GET', $uri)
            ->getBody();
    }

    public function parseHtml($html = '')
    {
        $rtn = [];

        $document = new Document($html);
        $lis = $document->find('.resultbox ul li');

        foreach ($lis as $li) {
            $rtn[] = $li->text();
        }

        return array_unique($rtn);
    }
}