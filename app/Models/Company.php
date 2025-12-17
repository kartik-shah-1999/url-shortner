<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'created_by'];

    public function companyUser(){
        return $this->hasMany(UserCompany::class,'company_id','id');
    }
}
