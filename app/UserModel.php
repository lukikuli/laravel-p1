<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class UserModel extends Model
{

	use Notifiable, HasRoles;
    protected $table = 'users';
}
