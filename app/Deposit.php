<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    protected $table = 'deposits';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['date', 'user_id', 'amount', 'number_per_day','status', 'currency'];

    public function user(){
        return $this->belongsTo('App\User');
    }

}
