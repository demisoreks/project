<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class Contact extends Model
{
    use HasHashSlug;
    
    protected $table = "contacts";
    
    protected $guarded = [];
    
    public function contractor() {
        return $this->belongsTo('App\Contractor');
    }
}
