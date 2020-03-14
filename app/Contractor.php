<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class Contractor extends Model
{
    use HasHashSlug;
    
    protected $table = "contractors";
    
    protected $guarded = [];
    
    public function contacts() {
        return $this->hasMany('App\Contact');
    }
    
    public function projects() {
        return $this->hasMany('App\Project');
    }
}
