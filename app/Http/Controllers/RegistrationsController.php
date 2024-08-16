<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationsCreateRequest;
use App\Http\Requests\RegistrationsUpdateRequest;
use App\Http\Requests\RegistrationsUpdateStatus;
use App\Http\Resources\RegistrationsCollection;
use App\Http\Resources\RegistrationsResource;
use App\Models\Province;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $registration->membership_id = $this->generateMembershipId($registration->id, $registration->period);

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
        $pdfData['company_address'] = $pdfData['company_address'] . ', ' . strtolower($pdfData['provinces']['name'] . ', ' . strtolower($province['name']));

        $pdf = Pdf::loadView('index', $pdfData)->setPaper('a4', 'landscape');
        //  $pdf = Pdf::loadFile(storage_path('kta_2023.pdf'));
        return $pdf->stream();
    }

    public function detailNpwp(string $npwp): RegistrationsResource
    {
        $period = $_GET['period'] ?? date('Y');
        $regist = Registration::where('npwp', $npwp)->where('period', $period)->first();

        if (!$regist) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'NPWP tidak di temukan'
                    ]
                ]
            ])->setStatusCode(400));
        }
        [$city] = Province::where('id', $regist['province_id'])->get()->toArray();
        [$provinceCode] = explode('.', $city['code']);
        [$province] = Province::where('code', $provinceCode)->get()->toArray();
        $regist['province'] = $province;

        return new RegistrationsResource($regist->load('city'));
    }

    public function detail(int $id): RegistrationsResource
    {
        $regist = Registration::where('id', $id)->first();

        if (!$regist) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => [
                        'Data tidak di temukan'
                    ]
                ]
            ])->setStatusCode(400));
        }
        [$city] = Province::where('id', $regist['province_id'])->get()->toArray();
        [$provinceCode] = explode('.', $city['code']);
        [$province] = Province::where('code', $provinceCode)->get()->toArray();
        $regist['province'] = $province;

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

            $prov = $request->input('prov');
            if ($prov) {
                $builder->where('province_code', $prov);
            }

            $npwp = $request->input('npwp');
            if ($npwp) {
                $builder->where('npwp', $npwp);
            }
        });

        $regist = $regist->paginate($size, ['*'], 'page', $page);

        return new RegistrationsCollection($regist);
    }

    public function update(int $id, RegistrationsUpdateRequest $request): RegistrationsResource
    {
        $regist = Registration::where('id', $id)->first();
        if (!$regist) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => ['Data tidak ditemukan']
                ]
            ]));
        }

        $data = $request->validated();
        $regist->fill($data);
        $regist->save();

        return new RegistrationsResource($regist);
    }

    public function summaryProvinces(Request $request): JsonResponse
    {
        $date = $request->input('period', date('Y'));
        $regist = DB::table('provinces', 'a')->selectRaw('substr(code, 1,2) as provinceid, qualification')->join('registrations', 'a.id', '=', 'registrations.province_id', 'inner')->where('status', '=', 1)->where('period', '=', $date);

        $provinces = DB::table('provinces', 'b')->joinSub($regist, 'city', 'city.provinceid', '=', 'b.code', 'left')->whereRaw('length(b.code) = 2')->groupBy('code')->groupBy('b.name')->selectRaw("b.code, b.name, SUM(IF(qualification = 'KECIL', 1, 0)) as KECIL, SUM(IF(qualification = 'MENENGAH', 1, 0)) as MENENGAH, SUM(IF(qualification = 'BESAR', 1, 0)) as BESAR, SUM(IF(qualification = 'SPESIALIS', 1, 0)) as SPESIALIS, SUM(IF(qualification = 'KECIL', 1, 0) + IF(qualification = 'MENENGAH', 1, 0) + IF(qualification = 'BESAR', 1, 0) + IF(qualification = 'SPESIALIS', 1, 0)) as total");

        return response()->json([
            'data' => $provinces->get()
        ])->setStatusCode(200);
    }

    public function summaryCity(int $province, Request $request): JsonResponse
    {
        $date = $request->input('period', date('Y'));
        $regist = Registration::where('status', '=', 1)->where('period', '=', $date);
        $provinces = DB::table('provinces', 'b')->leftJoinSub($regist, 'c', 'b.id', '=', 'c.province_id')->whereRaw('substr(code, 1,2) = ?', [$province])->whereRaw('length(code) = 5')->groupBy('code')->groupBy('name')->selectRaw("code, name, SUM(IF(qualification = 'KECIL', 1, 0)) as KECIL, SUM(IF(qualification = 'MENENGAH', 1, 0)) as MENENGAH, SUM(IF(qualification = 'BESAR', 1, 0)) as BESAR, SUM(IF(qualification = 'SPESIALIS', 1, 0)) as SPESIALIS, SUM(IF(qualification = 'KECIL', 1, 0) + IF(qualification = 'MENENGAH', 1, 0) + IF(qualification = 'BESAR', 1, 0) + IF(qualification = 'SPESIALIS', 1, 0)) as total");

        return response()->json([
            'data' => $provinces->get()
        ])->setStatusCode(200);
    }

    private function generateMembershipId(int $id, ?string $period): string
    {
        $identifier = sprintf("%04d", $id);
        $period = $period ?? date("Y");

        return $identifier . "/GAKINDO/" . $period;
    }
}
