<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortBy extends Model
{
    use HasFactory;
    protected $table='sort_by';

    protected $fillable = [
        'sort_by_id',
        'sort_by_name',
        'is_active',
        'is_deleted'
    ];
}
