<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    protected $fillable = ['doctor_id','patient_id','appointment_date','start_time','end_time','status'];

    public function patients(){

        return $this->belongsTo(patient::class,'patient_id','id');

    }
    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }
}
