<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Traits\Number as Algonumber;
use Illuminate\Http\Request;

class IyataController extends Controller
{

    use Algonumber;
    private function validateRequest(Request $request): void
    {
        $request->validate([
            'number_evaluate' => 'required|int',
            'number_base'     => 'required|string',
            'number_query'    => 'required|int',
            'number_list'     => 'required|string',
        ]);
    }
    public function algoritmia(Request $request)
    {
        $result = (object) [
            'service' => false,
            'message' => 'No fué posible procesar la información.',
            'data'    => null
        ];

        try {

            $this->validateRequest($request);

            $data = (object) $request->all();

            $result_process = [];
            $eval_number    = $data->number_evaluate;
            $base_numbers   = $data->number_base;
            $eval_iteration = $data->number_query;
            $list_numbers   = $data->number_list;

            $this->setList(explode(",", $base_numbers));

            $array_numbers = explode(" ", $list_numbers);

            for ($i = 0; $i < $eval_iteration; $i++) {
                $result_process[] = $this->find($array_numbers[$i]);
            }

            $result->service = true;
            $result->message = 'Proceso exitoso';
            $result->data    = $result_process;

        } catch (\Illuminate\Validation\ValidationException $exception) {

            $result->data = $exception->errors();

        } catch (\Exception $exception) {

            $result->data = $exception->getMessage();

        }

        return response()->json($result, 201);
    }

    public function vuejs(Request $request)
    {

    }

}
