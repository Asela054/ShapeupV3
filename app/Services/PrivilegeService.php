<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPrivilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PrivilegeService
{
    /**
     * Check if the authenticated user has privilege for a menu and action
     *
     * @param int $menuId Menu ID
     * @param string $action Action: 'add', 'edit', 'statuschange', 'remove'
     * @return bool
     */
    public static function check($menuId, $action)
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasPrivilege($menuId, $action);
    }

    /**
     * Check if user can access a menu
     *
     * @param int $menuId Menu ID
     * @return bool
     */
    public static function canAccess($menuId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->canAccessMenu($menuId);
    }

    /**
     * Get all privileges for a menu
     *
     * @param int $menuId Menu ID
     * @return object|null
     */
    public static function getPrivileges($menuId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        return $user->getMenuPrivileges($menuId);
    }

    /**
     * Get privilege array for JavaScript/frontend use
     *
     * @param int $menuId Menu ID
     * @return array
     */
    public static function getPrivilegeArray($menuId)
    {
        $privileges = self::getPrivileges($menuId);

        if (!$privileges) {
            return [
                'add' => false,
                'edit' => false,
                'statuschange' => false,
                'remove' => false,
                'canAccess' => false
            ];
        }

        return [
            'add' => (bool) $privileges->add,
            'edit' => (bool) $privileges->edit,
            'statuschange' => (bool) $privileges->statuschange,
            'remove' => (bool) $privileges->remove,
            'canAccess' => true
        ];
    }

    /**
     * Get all menus the user has access to
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAccessibleMenus()
    {
        $user = Auth::user();
        
        if (!$user) {
            return collect([]);
        }

        return Cache::remember("user_menus_{$user->idtbl_user}", 3600, function () use ($user) {
            return $user->privileges()
                ->with('menu')
                ->where('access_status', 1)
                ->where('status', 1)
                ->get()
                ->pluck('menu')
                ->filter();
        });
    }

    /**
     * Authorize or fail
     *
     * @param int $menuId Menu ID
     * @param string|null $action Action to check (null means just access)
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public static function authorize($menuId, $action = null)
    {
        if ($action) {
            if (!self::check($menuId, $action)) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if (!self::canAccess($menuId)) {
                abort(403, 'Unauthorized access.');
            }
        }
    }

    /**
     * Check multiple actions at once
     *
     * @param int $menuId Menu ID
     * @param array $actions Array of actions to check
     * @return bool True if user has ALL specified actions
     */
    public static function checkMultiple($menuId, array $actions)
    {
        foreach ($actions as $action) {
            if (!self::check($menuId, $action)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if user has any of the specified actions
     *
     * @param int $menuId Menu ID
     * @param array $actions Array of actions to check
     * @return bool True if user has ANY of the specified actions
     */
    public static function checkAny($menuId, array $actions)
    {
        foreach ($actions as $action) {
            if (self::check($menuId, $action)) {
                return true;
            }
        }
        return false;
    }
}
