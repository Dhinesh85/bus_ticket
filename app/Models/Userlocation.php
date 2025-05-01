<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userlocation extends Model
{
    use HasFactory;

    // app/Models/Location.php
public function user()
{
    return $this->belongsTo(User::class);
}

}
