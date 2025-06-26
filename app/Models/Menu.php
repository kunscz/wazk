<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Menu extends Model
{
    protected $fillable = ['name', 'route', 'icon', 'parent_id', 'permission_id', 'order'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_role');
    }
}