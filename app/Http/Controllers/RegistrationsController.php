<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationsCreateRequest;
use App\Http\Resources\RegistrationsResource;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Exceptions\HttpResponseException;
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

    public function downloadPdf(string $npwp)
    {
        $data = $this->detail($npwp);
        $pdfData = $data->toArray($data);
        $pdfData['currentYear'] = date('Y');
        $pdfData['membership_id'] = '123.456/890/2024';

        $pdf = Pdf::loadView('index', $pdfData)->setPaper('a4', 'landscape');
        //  $pdf = Pdf::loadFile(storage_path('kta_2023.pdf'));
        return $pdf->stream();
    }

    public function detail(string $npwp): RegistrationsResource
    {
        $regist = Registration::where('npwp', $npwp)->first();
        if (!$regist) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'NPWP tidak di temukan'
                    ]
                ]
            ])->setStatusCode(400));
        }
        return new RegistrationsResource($regist);
    }
}
