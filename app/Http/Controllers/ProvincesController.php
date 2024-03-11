<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use App\Models\Province;

class ProvincesController extends Controller
{
    public function get(): JsonResponse {
        $provinces = Province::query()->whereRaw('LENGTH(code) = 2');

        return response()->json([
            'data' => $provinces->get()
        ])->setStatusCode(200);
    }

    public function getCities(int $province_code): JsonResponse {
        if (Str::length($province_code) !== 2){
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'Provinsi tidak ditemukan'
                    ]
                ]
            ])->setStatusCode(400));
        }
        $provinces = Province::query()->whereRaw('substring_index(code, ".", 1) = '.$province_code.' and length(code) = 5');

        return response()->json([
            'data' => $provinces->get()
        ])->setStatusCode(200);
    }
}
