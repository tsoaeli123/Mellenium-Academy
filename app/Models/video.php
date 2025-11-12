<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class video extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','subject','title', 'path','thumbnail'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
