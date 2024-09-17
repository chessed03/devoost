<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductPrice extends Model
{

    use HasFactory;

    protected $table = 'product_prices';

    const ENABLED    = 1;

    const DISABLED   = 0;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function createItem($data)
    {

        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $item             = new self();
        $item->product_id = $data->product_id;
        $item->price      = $data->price;
        $item->start      = Carbon::now();
        $item->end        = null;
        $item->is_active  = self::ENABLED;
        $existing         = self::where('product_id', $data->product_id)
                                ->where('is_active', self::ENABLED)
                                ->first();

        if ($existing) {

            $result->message = 'El producto ya tiene un precio registrado.';

        } else {
            if ($item->save()) {

                $result->service = true;
                $result->message = 'Precio creado correctamente.';

            }
        }

        return $result;

    }

    public static function updateItem($data)
    {

        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $price = (Object) [
            'product_id' => $data->product_id,
            'price'      => $data->price,
        ];

        $item            = self::find($data->id);
        $item->end       = Carbon::now();
        $item->is_active = self::DISABLED;

        if ($item->update()) {

            self::createItem($price);
            $result->service = true;
            $result->message = 'Precio actualizado correctamente.';

        }

        return $result;

    }

    public static function disableItem($id)
    {
        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $item              = self::find($id);
        $item->is_active   = self::DISABLED;

        if ($item->update()) {

            $result->service = true;
            $result->message = 'Precio eliminado correctamente.';

        }

        return $result;
    }

    public static function getItems()
    {

        $result = (Object)[
            'service' => false,
            'data' => [],
        ];

        $query = self::query()
            ->with(['product' => function($query) {
                $query->select('id', 'description');
            }])
            ->where('is_active', self::ENABLED)
            ->orderBy('id', 'desc')
            ->get();

        if ($query) {

            $result->service = true;
            $result->data    = $query;

        }

        return $result;

    }

    public static function getItem($id)
    {

        $result = (Object)[
            'service' => false,
            'data' => [],
        ];

        $query = self::query()
            ->where('id', $id)
            ->first();

        if ($query) {

            $result->service = true;
            $result->data    = $query;

        }

        return $result;

    }

    public static function getItemByProductId($product_id)
    {

        $result = (Object)[
            'service' => false,
            'data' => [],
        ];

        $query = self::query()
            ->with(['product' => function($query) {
                $query->select('id', 'code', 'description');
            }])
            ->where('product_id', $product_id)
            ->where('is_active', self::ENABLED)
            ->first();

        if ($query) {

            $result->service = true;
            $result->data    = $query;

        }

        return $result;

    }

    public static function disableItemsByProductId($product_id)
    {
        $query = self::query()
            ->where('product_id', $product_id)
            ->where('is_active', self::ENABLED)
            ->update([
                'end'       => Carbon::now(),
                'is_active' => self::DISABLED,
            ]);

        return true;
    }

}
