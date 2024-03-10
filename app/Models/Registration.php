<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $table = "registrations";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone_number',
        'position',
        'company_address',
        'npwp',
        'qualification',
        'status',
        'period',
        'province_id'
    ];

    public function provinces(): BelongsTo
    {
        return $this->belongsTo(Province::class, "province_id", "id");
    }
}
