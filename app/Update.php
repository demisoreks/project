<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class Update extends Model
{
    use HasHashSlug;
    
    protected $table = "updates";
    
    protected $guarded = [];
    
    public function project() {
        return $this->belongsTo('App\Project');
    }
}
