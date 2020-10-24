<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'name','en_name','icon', "user_id"
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
