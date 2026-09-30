<?php

namespace App\Models\Kpi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiCategory extends Model
{
    use HasFactory;

    protected $table = 'kpi_categories';

    protected $fillable = [
        'name',
        'parent_id',
        'description',
    ];

    public function parent()
    {
        return $this->belongsTo(KpiCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(KpiCategory::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->hasMany(KpiAttribute::class, 'kpi_category_id');
    }
}
