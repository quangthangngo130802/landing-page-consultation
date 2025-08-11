<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationSurvey extends Model
{
    use HasFactory;

    protected $table = 'consultation_surveys';
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'position',
        'region',
        'business_field',
        'tax_id',
        'challenges',
        'other_challenge',
        'biggest_challenge',
    ];

    protected $casts = [
        'challenges' => 'array', // Chuyển đổi mảng JSON thành mảng PHP
    ];

    public $timestamps = true;
}
