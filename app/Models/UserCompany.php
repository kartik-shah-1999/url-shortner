<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $fillable = ['user_id','company_id', 'assignee'];

    public function userCompany(){
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
