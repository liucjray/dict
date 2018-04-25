<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\Controller;
use App\Services\ShanbayService;
use Illuminate\Http\Request;

class ShanbayController extends Controller
{
    private $shanbaySer;

    public function __construct(ShanbayService $shanbayService)
    {
        $this->shanbaySer = $shanbayService;
    }

    public function index(Request $request)
    {
        $req = [
            'q' => $request->get('q', ''),
        ];

        $respJson = $this->shanbaySer->send($req);

        $resp = json_decode($respJson, true);

        //echo '<pre>'; print_r($resp);

        return view('Dictionary.index', [
            'req'  => (object)$req,
            'resp' => (object)$resp,
        ]);
    }
}