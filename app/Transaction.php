<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    protected $table = 'transactions';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['date', 'user_id', 'transaction_type_id', 'amount', 'status', 'currency'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function transactionType(){
        return $this->belongsTo('App\TransactionType');
    }


}
