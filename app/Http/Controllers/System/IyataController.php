<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IyataController extends Controller
{

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'number_evaluate' => 'required|int',
            'number_base'     => 'required|string',
            'number_query'    => 'required|int',
            'number_list'     => 'required|string',
        ]);
    }
    public function algoritmia(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        dd($data);
    }

    public function vuejs(Request $request)
    {

    }

}
