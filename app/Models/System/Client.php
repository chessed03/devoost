<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    const ENABLED    = 1;

    const DISABLED   = 0;

    public static function createItem($data)
    {

        $result = (Object)[
            'service' => false,
            'message' => 'Error.',
        ];

        $item            = new self();
        $item->name      = $data->name;
        $item->last_name = $data->last_name;
        $item->email     = $data->email;
        $item->is_active = self::ENABLED;

        if ($item->save()) {

            $result->service = true;
            $result->message = 'Cliente creado correctamente.';

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
        $item->name      = $data->name;
        $item->last_name = $data->last_name;
        $item->email     = $data->email;
        $item->is_active = self::ENABLED;

        if ($item->update()) {

            $result->service = true;
            $result->message = 'Cliente actualizado correctamente.';

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

            Order::disableItemsByClientId($id);
            $result->service = true;
            $result->message = 'Cliente eliminado correctamente.';

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

}
