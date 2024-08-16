<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon_Type extends Model
{
    use HasFactory;
    protected $table='icon_mime_type';

    protected $fillable = [
        'icon_type_id',
        'icon_type_name',
        'is_active',
        'is_deleted'
    ];
}
