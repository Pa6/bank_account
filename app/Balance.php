<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{
    protected $table = 'balances';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['balance_money','user_id'];

    //balance belongs to users(customers)
    public function user(){
        return $this->belongsTo('App\User');
    }
}
