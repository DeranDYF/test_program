<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'nama',
        'harga',

    ];

    public static function getLastKode()
    {
        $lastBarang = Barang::orderBy('kode', 'desc')->first();
        if (!$lastBarang) {
            return 'C000';
        }
        return $lastBarang->kode;
    }

    public static function generateKode()
    {
        $lastKode = self::getLastKode();
        $number = intval(substr($lastKode, 1)) + 1;
        return 'B' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
