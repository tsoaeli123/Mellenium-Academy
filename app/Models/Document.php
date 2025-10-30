<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','subject','title','filename', 'path'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
