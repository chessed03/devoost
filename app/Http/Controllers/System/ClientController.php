<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'     => 'required|email',
        ]);
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = Client::createItem($data);

        return response()->json($service, 201);
    }

    public function update(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = Client::updateItem($data);

        return response()->json($service, 201);
    }

    public function disable(Request $request)
    {
        $id      = $request->id;
        $service = Client::disableItem($id);

        return response()->json($service, 201);
    }

    public function getItems(Request $request)
    {
        $service = Client::getItems();

        return response()->json($service, 201);
    }

    public function getItem(Request $request)
    {
        $id      = $request->id;
        $service = Client::getItem($id);

        return response()->json($service, 201);
    }

}
