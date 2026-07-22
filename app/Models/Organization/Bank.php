<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    
    protected $table = 'banks';

    protected $fillable = [
        'code', 'bank', 'status', 'create_by', 'update_by',
    ];

    public function branches()
    {
        return $this->hasMany(BankBranch::class, 'bankcode', 'code');
    }
}