<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'client_id' => 'required',
        ]);
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = Order::createItem($data);

        return response()->json($service, 201);
    }

    public function update(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = Order::updateItem($data);

        return response()->json($service, 201);
    }

    public function disable(Request $request)
    {
        $id      = $request->id;
        $service = Order::disableItem($id);

        return response()->json($service, 201);
    }

    public function getItems(Request $request)
    {
        $service = Order::getItems();

        return response()->json($service, 201);
    }

    public function getItem(Request $request)
    {
        $id      = $request->id;
        $service = Order::getItem($id);

        return response()->json($service, 201);
    }

}
