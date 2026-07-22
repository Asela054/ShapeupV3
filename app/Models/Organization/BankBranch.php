<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    use HasFactory;
    
    protected $table = 'bank_branches';

    protected $fillable = [
        'bankcode', 'code', 'branch', 'status', 'create_by', 'update_by',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bankcode', 'code');
    }
}