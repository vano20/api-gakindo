<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use App\Http\Requests\ProvincesRequest;
use App\Http\Resources\ProvincesResource;
use App\Http\Resources\ProvincesCollection;
use App\Models\Province;

class ProvincesController extends Controller
{
    public function getCities(Request $request): JsonResponse {
        $selectedProvinces = $request->input('province');
        if (Str::length($selectedProvinces) !== 2){
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'Provinsi tidak ditemukan'
                    ]
                ]
            ])-> setStatusCode(400));
        }
        $provinces = Province::query()->whereRaw('substring_index(code, ".", 1) = '.$request->input('province').' and length(code) = 5');

        return response()->json([
            'data' => $provinces->get()
        ])->setStatusCode(200);
    }
}
