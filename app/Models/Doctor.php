<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['dept_id','doctor_name','email','phone','specialization','qualification','experience_years','consultation_fee'];

        public function department(){

            return $this->belongsTo(department::class,'dept_id','id');

        }


    }
