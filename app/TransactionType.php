<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionType extends Model
{
    protected $table = "transaction_types";
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'description'];

}
