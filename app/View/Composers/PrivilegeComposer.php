<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Services\PrivilegeService;

/**
 * Privilege View Composer
 * 
 * Automatically provides privilege checking functions to all views
 * Register in AppServiceProvider
 */
class PrivilegeComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Make user's accessible menus available to all views
        $accessibleMenus = auth()->check() 
            ? PrivilegeService::getAccessibleMenus() 
            : collect([]);

        $view->with('accessibleMenus', $accessibleMenus);

        // Optional: Make current user's type available
        $userType = auth()->check() 
            ? auth()->user()->tbl_user_type_idtbl_user_type 
            : null;

        $view->with('currentUserType', $userType);
    }
}
