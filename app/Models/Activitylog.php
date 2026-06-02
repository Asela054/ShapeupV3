<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activitylog extends Model
{
    use HasFactory;
    
    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'event',
        'causer_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array'
    ];

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
