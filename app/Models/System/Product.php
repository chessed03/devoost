<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    const ENABLED    = 1;

    const DISABLED   = 0;

    public function productPrice()
    {
        return $this->hasOne(ProductPrice::class, 'product_id')->where('is_active', ProductPrice::ENABLED);
    }

    public static function createItem($data)
    {

        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $validator = Validator::make((array) $data, [
            'code' => [
                'required',
                Rule::unique('products')->where(function ($query) {
                    return $query->where('is_active', self::ENABLED);
                })
            ],
        ]);

        if ($validator->fails()) {
            $result->message = 'Ya existe un producto con ese codigo.';
            return $result;
        }

        $item              = new self();
        $item->code        = $data->code;
        $item->description = $data->description;
        $item->is_active   = self::ENABLED;

        if ($item->save()) {

            $result->service = true;
            $result->message = 'Producto creado correctamente.';

        }

        return $result;

    }

    public static function updateItem($data)
    {

        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $item              = self::find($data->id);
        $item->code        = $data->code;
        $item->description = $data->description;
        $item->is_active   = self::ENABLED;

        if ($item->update()) {

            $result->service = true;
            $result->message = 'Producto actualizado correctamente.';

        }

        return $result;

    }

    public static function disableItem($id)
    {
        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $item            = self::find($id);
        $item->is_active = self::DISABLED;

        if ($item->update()) {
            ProductPrice::disableItemsByProductId($item->id);
            $result->service = true;
            $result->message = 'Producto eliminado correctamente.';

        }

        return $result;
    }

    public static function getItems()
    {

        $result = (Object)[
            'service' => false,
            'data'    => [],
        ];

        $query = self::query()
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
            'data'    => [],
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

    public static function getItemCode($code)
    {

        $result = (Object)[
            'service' => false,
            'data'    => [],
        ];

        $query = self::query()
            ->where('code', $code)
            ->first();

        if ($query) {

            $price = ProductPrice::getItemByProductId($query->id);

            $result->service = true;
            $result->data    = $price->data;

        }

        return $result;

    }

}
