<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
     /**
     * Relationship with User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleUsers()
    {
        return $this->hasMany(User::class);
    }
}
