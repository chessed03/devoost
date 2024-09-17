<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;

    protected $table = 'orders';

    const ENABLED    = 1;

    const DISABLED   = 0;

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public static function generteNumber()
    {

        $dateTime    = date('YmdHi');
        $randomCode  = uniqid('', true);
        $orderNumber = $dateTime . '-' . $randomCode;

        return $orderNumber;

    }
    public static function createItem($data)
    {

        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $item            = new self();
        $item->client_id = $data->client_id;
        $item->number    = self::generteNumber();
        $item->is_active = self::ENABLED;

        if ($item->save()) {

            OrderDetail::createItems($item->id, $data->products);
            $result->service = true;
            $result->message = 'Orden creado correctamente.';

        }

        return $result;

    }

    public static function updateItem($data)
    {

        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $item            = self::find($data->id);
        $item->client_id = $data->client_id;
        $item->is_active = self::ENABLED;

        if ($item->update()) {

            OrderDetail::updateItems($item->id, $data->products);
            $result->service = true;
            $result->message = 'Orden actualizado correctamente.';

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

            $result->service = true;
            $result->message = 'Orden eliminado correctamente.';

        }

        return $result;
    }

    public static function disableItemsByClientId($client_id)
    {
        $result = (object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $query = self::where('client_id', $client_id)
            ->update(['is_active' => self::DISABLED]);

        if ($query) {
            $result->service = true;
            $result->message = 'Ordenes eliminadas correctamente';
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
            ->with(['client' => function($query) {
                $query->select('id','name', 'last_name');
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

}
