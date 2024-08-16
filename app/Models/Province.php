<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table = "provinces";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    public function provinces(): HasMany
    {
        return $this->hasMany(Registration::class, "province_id", "id");
    }

    public function province(): HasMany
    {
        return $this->hasMany(Registration::class, "province_code", "code");
    }
}
