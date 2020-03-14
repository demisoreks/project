<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class Project extends Model
{
    use HasHashSlug;
    
    protected $table = "projects";
    
    protected $guarded = [];
    
    public function contractor() {
        return $this->belongsTo('App\Contractor');
    }
    
    public function components() {
        return $this->hasMany('App\Component');
    }
    
    public function expenses() {
        return $this->hasMany('App\Expense');
    }
    
    public function updates() {
        return $this->hasMany('App\Update');
    }
}
