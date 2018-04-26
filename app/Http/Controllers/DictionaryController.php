<?php

namespace App\Http\Controllers;

use App\Services\CookieService;
use App\Services\ShanbayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DictionaryController extends Controller
{
    private $shanbaySer;
    private $cookieSer;

    public function __construct(
        ShanbayService $shanbayService,
        CookieService $cookieService
    ) {
        $this->shanbaySer = $shanbayService;
        $this->cookieSer = $cookieService;
    }

    public function index(Request $request)
    {
        $req = [
            'q' => $request->get('q', ''),
        ];

        $respJson = $this->shanbaySer->send($req);

        $resp = json_decode($respJson, true);

        if ($req['q'] && $resp['msg'] == 'SUCCESS') {
            $this->cookieSer->setDictHistory($req['q']);
        }

        $qHistory = $this->cookieSer->parseDictHistory();

        return view('Dictionary.index', [
            'req'  => (object)$req,
            'resp' => (object)$resp,
            'qHistory' => $qHistory,
        ]);
    }
}