<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{

    public function getOrderItems(Request $request)
    {
        $id      = $request->id;
        $service = OrderDetail::getItemsByOrderId($id);

        return response()->json($service, 201);
    }

}
