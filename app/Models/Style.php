<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;
    protected $table='style';
    protected $primaryKey='style_id';

    protected $fillable = [
        'style_id',
        'style_name',
        'title',
        'style_search_key',
        'style_url_key',
        'meta_description',
        'is_active',
        'is_deleted'
    ];

    public function icon()
    {
        return $this->hasMany(Icon::class, 'style_id')
        ->inRandomOrder()
        ->limit(4);       
    }
}

