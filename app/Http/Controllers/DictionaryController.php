<?php

namespace App\Http\Controllers;

use App\Services\Cookie\CookieCEService;
use App\Services\Cookie\CookieCJService;
use App\Services\TianHuoService;
use App\Services\ShanBayService;
use App\Services\TranslateShellService;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    private $shanbaySer;
    private $tianhuoSer;
    private $translateShellSer;

    private $cookieCESer;
    private $cookieCJSer;

    public function __construct(
        ShanBayService $shanbayService,
        TianHuoService $HJService,
        TranslateShellService $translateShellService,
        CookieCEService $cookieCEService,
        CookieCJService $cookieCJService
    ) {
        $this->shanbaySer = $shanbayService;
        $this->tianhuoSer = $HJService;
        $this->translateShellSer = $translateShellService;
        $this->cookieCESer = $cookieCEService;
        $this->cookieCJSer = $cookieCJService;
    }

    public function index(Request $request)
    {
        $req = [
            'q' => $request->get('q', 'try to input some words here..'),
            'l' => $request->get('l', $this->translateShellSer->getDefaultLanguageKey()),
        ];

        $resp = '';

        if ($req['q']) {
            $this->cookieCESer->setDictHistory($req['q']);
            $resp = $this->translateShellSer->send($req);
        }

        $qHistory = $this->cookieCESer->parseDictHistory();

        return view('Dictionary.index', [
            'l' => $this->translateShellSer->getLanguage(),
            'req'  => (object)$req,
            'resp' => $resp,
            'qHistory' => $qHistory,
        ]);
    }

    public function ce(Request $request)
    {
        $req = [
            'q' => $request->get('q', 'vocabulary'),
        ];

        $respJson = $this->shanbaySer->send($req);

        $resp = json_decode($respJson, true);

        if ($req['q'] && $resp['msg'] == 'SUCCESS') {
            $this->cookieCESer->setDictHistory($req['q']);
        }

        $qHistory = $this->cookieCESer->parseDictHistory();

        return view('Dictionary.ce', [
            'req'  => (object)$req,
            'resp' => (object)$resp,
            'qHistory' => $qHistory,
        ]);
    }

    public function cj(Request $request)
    {
        $req = [
            'q' => $request->get('q', '單詞'),
        ];

        $resp = $this->tianhuoSer->send($req);

//        if ($req['q'] && $resp['msg'] == 'SUCCESS') {
            $this->cookieCJSer->setDictHistory($req['q']);
//        }

        $qHistory = $this->cookieCJSer->parseDictHistory();

        return view('Dictionary.cj', [
            'req'  => (object)$req,
            'resp' => (object)$resp,
            'qHistory' => $qHistory,
        ]);

    }
}