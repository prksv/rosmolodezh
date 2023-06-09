<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'information';
    protected $guarded = false;
    protected $with = [
        'emails',
        'phones'
    ];

    public function emails()
    {
        return $this->hasMany(InformationEmail::class);
    }
    public function phones()
    {
        return $this->hasMany(InformationPhone::class);
    }
    public function telegrams()
    {
        return $this->hasMany(InformationTelegram::class);
    }
}
