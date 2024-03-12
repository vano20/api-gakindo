<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'position' => $this->position,
            'company_address' => $this->company_address,
            'npwp' => $this->npwp,
            'qualification' => $this->qualification,
            'status' => $this->status,
            'period' => $this->period,
            'province_id' => $this->province_id,
            'membership_id' => $this->membership_id,
            'provinces' => $this->provinces
        ];
    }
}
