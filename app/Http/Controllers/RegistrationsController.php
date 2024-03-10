<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationsCreateRequest;
use App\Http\Resources\RegistrationsResource;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegistrationsController extends Controller
{
    public function create(RegistrationsCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $registration = new Registration($data);
        $registration->period = date("Y");
        $registration->status = 0;
        $registration->save();

        return (new RegistrationsResource($registration))->response()->setStatusCode(201);
    }

    public function downloadPdf()
    {
        $currentYear = date('Y');
        $data = [
            'title' => 'How to create PDF',
            'date' => date('d/m/Y'),
            'currentYear' => $currentYear,
        ];

        $pdf = Pdf::loadView('index', $data)->setPaper('a4', 'landscape');
        //  $pdf = Pdf::loadFile(storage_path('kta_2023.pdf'));
        return $pdf->stream();
    }
}
