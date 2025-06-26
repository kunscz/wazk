<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    protected $fillable = ['menu_id', 'name', 'route', 'order'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'submenu_role');
    }
}