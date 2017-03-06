<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'phone','date_of_birth','country','city'
    ];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public static function rules($user_id = 0) {
        $rules = [
            'name' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'email' => 'email|required|unique:users,email,' . $user_id,

        ];
        return $rules;
    }
}
