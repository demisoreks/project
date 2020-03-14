<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class Expense extends Model
{
    use HasHashSlug;
    
    protected $table = "expenses";
    
    protected $guarded = [];
    
    public function project() {
        return $this->belongsTo('App\Project');
    }
}
