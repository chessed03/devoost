<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{

    use HasFactory;

    protected $table = 'users';

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
        $item->email     = $data->email;
        $item->password  = Hash::make($data->password);
        $item->is_active = self::ENABLED;

        if ($item->save()) {

            $result->service = true;
            $result->message = 'Usuario creado correctamente.';

        }

        return $result;

    }

}
