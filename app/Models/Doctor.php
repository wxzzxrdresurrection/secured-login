<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable =[
        "name",
        "last_name",
        "specialty_id"
    ];

    public function specialty(){
        $this->hasOne(Specialty::class);
    }
}
