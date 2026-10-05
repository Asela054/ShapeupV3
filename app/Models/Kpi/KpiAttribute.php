<?php

namespace App\Models\Kpi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiAttribute extends Model
{
    use HasFactory;

    protected $table = 'kpi_attributes';

    protected $fillable = [
        'description',
        'kpi_category_id',
        'category',
        'fixed_points',
    ];

    public function category()
    {
        return $this->belongsTo(KpiCategory::class, 'kpi_category_id');
    }
}
