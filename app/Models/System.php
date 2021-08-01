<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;
    protected $table = 'System';
    protected $fillable = ['key'];
    public $timestamps = false;

    protected $casts = [
        'key' => 'encrypted',
    ];
}
