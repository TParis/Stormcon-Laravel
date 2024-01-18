<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bmp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'uses',
        'inspection_schedule',
        'maintenance',
        'installation_schedule',
        'considerations',
        'interim_or_permanent',
    ];

    /**
     * @return string[]
     */
    public static function getInterimOrPermanentChoices(): array
    {
        return [
            'interim'   => 'Interim',
            'permanent' => 'Permanent',
            '', => ''
        ];
    }
}
