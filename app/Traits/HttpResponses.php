<?php

namespace App\Traits;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\MessageBag;

trait HttpResponses
{

    public function response(string $message, string|int $status, array|Model|JsonResource $data = [])
    {
        return response()->json([
            'messsage' => $message,
            'status' => $status,
            'data' => $data,
        ],$status);
    }

    public function error(string $message, string|int $status, array|MessageBag $errors = [] , array|Model $data = [])
    {
        return response()->json([
            'messsage' => $message,
            'status' => $status,
            'erros' => $errors,
            'data' => $data,
        ],$status);
    }

}
