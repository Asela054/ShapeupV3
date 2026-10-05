<?php

namespace App\Models\Kpi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiYear extends Model
{
    use HasFactory;

    protected $table = 'kpi_years';

    protected $fillable = [
        'year_name',
        'start_date',
        'end_date',
        'status',
    ];

    public function summaries()
    {
        return $this->hasMany(KpiSummary::class, 'year_id');
    }

    public function transactions()
    {
        return $this->hasMany(KpiTransaction::class, 'year_id');
    }
}
