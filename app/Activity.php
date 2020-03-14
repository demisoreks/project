<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class Activity extends Model
{
    use HasHashSlug;
    
    protected $table = "activities";
    
    protected $guarded = [];
}
