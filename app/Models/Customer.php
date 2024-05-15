<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
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
        'telp',
    ];

    public static function getLastKode()
    {
        $lastCustomer = Customer::orderBy('kode', 'desc')->first();
        if (!$lastCustomer) {
            return 'C000';
        }
        return $lastCustomer->kode;
    }

    public static function generateKode()
    {
        $lastKode = self::getLastKode();
        $number = intval(substr($lastKode, 1)) + 1;
        return 'C' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
