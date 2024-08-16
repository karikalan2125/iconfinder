<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    protected $table='license';

    protected $fillable = [
        'license_id',
        'license_name',
        'is_active',
        'is_deleted'
    ];
}
