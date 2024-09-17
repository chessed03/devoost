<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'code'        => 'required|string|size:8',
            'description' => 'required|string|max:255',
        ]);
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = Product::createItem($data);

        return response()->json($service, 201);
    }

    public function update(Request $request)
    {
        $this->validateRequest($request);

        $data    = (object) $request->all();
        $service = Product::updateItem($data);

        return response()->json($service, 201);
    }

    public function disable(Request $request)
    {
        $id      = $request->id;
        $service = Product::disableItem($id);

        return response()->json($service, 201);
    }

    public function getItems(Request $request)
    {
        $service = Product::getItems();

        return response()->json($service, 201);
    }

    public function getItem(Request $request)
    {
        $id      = $request->id;
        $service = Product::getItem($id);

        return response()->json($service, 201);
    }

    public function getItemCode(Request $request)
    {
        $code    = $request->product_code;
        $service = Product::getItemCode($code);

        return response()->json($service, 201);
    }

}
