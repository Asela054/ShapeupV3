<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'tbl_user';
    protected $primaryKey = 'idtbl_user';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'imagepath',
        'status',
        'updatedatetime',
        'tbl_user_type_idtbl_user_type',
    ];

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];
    public function userType()
    {
        return $this->belongsTo(Usertype::class, 'tbl_user_type_idtbl_user_type', 'idtbl_user_type');
    }

    public function privileges()
    {
        return $this->hasMany(UserPrivilege::class, 'tbl_user_idtbl_user', 'idtbl_user');
    }

    public function employeeProfile()
    {
        return $this->hasOne(Employee::class, 'useraccountid', 'idtbl_user');
    }

    public function salesManagerProfile()
    {
        return $this->hasOne(Salesmanager::class, 'tbl_user_idtbl_user', 'idtbl_user');
    }

    /**
     * Check if user has privilege for a specific menu and action
     * 
     * @param int $menuId Menu ID
     * @param string $action Action type: 'add', 'edit', 'statuschange', 'remove'
     * @return bool
     */
    public function hasPrivilege($menuId, $action)
    {
        $privileges = $this->getCachedFullPrivileges();
        $privilege = $privileges->get($menuId);

        if (!$privilege) {
            return false;
        }

        return (bool) $privilege->$action;
    }

    /**
     * Check if user has any access to a menu
     * 
     * @param int $menuId Menu ID
     * @return bool
     */
    // public function canAccessMenu($menuId)
    // {
    //     return $this->privileges()
    //         ->where('tbl_menu_list_idtbl_menu_list', $menuId)
    //         ->where('access_status', 1)
    //         ->where('status', 1)
    //         ->exists();
    // }

    public function canAccessMenu($menuId)
    {
        $privileges = $this->getCachedPrivileges();
        return in_array($menuId, $privileges);
    }

    /**
     * Get all privileges for a specific menu
     * 
     * @param int $menuId Menu ID
     * @return object|null
     */
    public function getMenuPrivileges($menuId)
    {
        $privileges = $this->getCachedFullPrivileges();
        return $privileges->get($menuId);
    }

    /**
     * Activity Log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user')
            ->logOnly([
                'idtbl_user',
                'name',
                'username',
                'email',
                'password',
                'imagepath',
                'status',
                'updatedatetime',
                'tbl_user_type_idtbl_user_type'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(
                fn($event) =>
                "User {$event}"
            );
    }

    public function getCachedPrivileges()
    {
        return Cache::remember("user_privileges_{$this->idtbl_user}", 3600, function () {
            return $this->privileges()
                ->where('access_status', 1)
                ->where('status', 1)
                ->pluck('tbl_menu_list_idtbl_menu_list')
                ->toArray();
        });
    }

    public function getCachedFullPrivileges()
    {
        return Cache::remember("user_full_privileges_{$this->idtbl_user}", 3600, function () {
            return $this->privileges()
                ->where('access_status', 1)
                ->where('status', 1)
                ->get()
                ->keyBy('tbl_menu_list_idtbl_menu_list');
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
