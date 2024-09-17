<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{

    use HasFactory;

    protected $table = 'order_details';

    const ENABLED    = 1;

    const DISABLED   = 0;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function createItems($order_id, $items)
    {

       foreach ($items as $detail) {

           $item             = new self();
           $item->order_id   = $order_id;
           $item->product_id = $detail["product_id"];
           $item->quantity   = $detail["quantity"];
           $item->is_active  = self::ENABLED;

          $item->save();

       }

        return true;
    }

    public static function updateItems($order_id, $items)
    {

        $orderItems = self::where('order_id', $order_id)->get()->keyBy('product_id');

        foreach ($items as $detail) {

            $item = $orderItems->get($detail["product_id"]);

            if ($item) {
                $item->quantity   = $detail["quantity"];
                $item->is_active  = self::ENABLED;
            }

            else {
                $item             = new self();
                $item->order_id   = $order_id;
                $item->product_id = $detail["product_id"];
                $item->quantity   = $detail["quantity"];
                $item->is_active  = self::ENABLED;
            }

            $item->save();

        }

        foreach ($orderItems as $prod_id => $item) {
            if (!in_array($prod_id, array_column($items, 'product_id'))) {
                $item->is_active = self::DISABLED;
                $item->update();
            }
        }

        return true;
    }

    public static function getItemsByOrderId($order_id)
    {
        $result = (Object)[
            'service' => false,
            'data' => [],
        ];

        $query = self::query()
            ->with(['product' => function($query) {
                $query->select('id', 'code', 'description')
                    ->with('productPrice');
            }])
            ->where('order_id', $order_id)
            ->where('is_active', self::ENABLED)
            ->get();

        if ($query) {

            $result->service = true;
            $result->data    = $query;

        }

        return $result;
    }

}
