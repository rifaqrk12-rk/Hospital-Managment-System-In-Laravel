<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    protected $fillable = ['name','email','password','phone','address','role'];

    public function appointments(){
        return $this->hasMany(appointment::class,'patient_id','id');
    }
}
