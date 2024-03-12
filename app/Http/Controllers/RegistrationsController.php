<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationsCreateRequest;
use App\Http\Resources\RegistrationsCollection;
use App\Http\Resources\RegistrationsResource;
use App\Models\Province;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
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
        $pdfData['provinces'] = $pdfData['provinces']->toArray();
        $provinceId = explode('.', $pdfData['provinces']['code']);
        [$province] = Province::where('code', $provinceId)->get()->toArray();
        $pdfData['company_address'] = $pdfData['company_address'] .', '. strtolower($pdfData['provinces']['name'] .', '. strtolower($province['name']));

        $pdf = Pdf::loadView('index', $pdfData)->setPaper('a4', 'landscape');
        //  $pdf = Pdf::loadFile(storage_path('kta_2023.pdf'));
        return $pdf->stream();
    }

    public function detail(string $npwp): RegistrationsResource
    {
        $regist = Registration::where('npwp', $npwp)->where('period', date('Y'))->first();
        if (!$regist) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'NPWP tidak di temukan'
                    ]
                ]
            ])->setStatusCode(400));
        }
        return new RegistrationsResource($regist->load('provinces'));
    }

    public function get(Request $request): RegistrationsCollection
    {
        $user = Auth::user();
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $regist = Registration::query();

        $regist = $regist->where(function (Builder $builder) use ($request) {
            $status = $request->input('status');
            if ($status) {
                $builder->where('status', $status);
            }

            $period = $request->input('period');
            if ($period) {
                $builder->where('period', $period);
            }
        });

        $regist = $regist->paginate($size, ['*'], 'page', $page);
        return new RegistrationsCollection($regist);
    }
}
