<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessPolicy
{
   use HandlesAuthorization;

   public function viewMenu(User $user, Menu $menu)
   {
      // RBAC: Check if user has role-based access to menu
      if (!$user->hasRole($menu->roles->pluck('name')->toArray())) {
         return false;
      }

      // ABAC: Additional attribute-based checks
      if ($menu->route === 'department.specific' && $user->department !== 'specific_department') {
         return false;
      }

      return true;
   }
}