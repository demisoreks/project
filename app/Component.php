<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class Component extends Model
{
    use HasHashSlug;
    
    protected $table = "components";
    
    protected $guarded = [];
    
    public function project() {
        return $this->belongsTo('App\Project');
    }
}
