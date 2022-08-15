<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationPhone extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;

    public function setting()
    {
        return $this->belongsTo(Information::class);
    }
}
