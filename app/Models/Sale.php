<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'cust_id',
        'tgl',
        'jumlah_barang',
        'subtotal',
        'diskon',
        'ongkir',
        'total_bayar',
    ];

    public static function getLastKode()
    {
        $lastCustomer = Sale::orderBy('kode', 'desc')->first();
        if (!$lastCustomer) {
            return '000';
        }
        return $lastCustomer->kode;
    }

    public static function generateKode()
    {
        $lastKode = self::getLastKode();
        $number = intval(substr($lastKode, 1)) + 1;
        return str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function saledets()
    {
        return $this->hasMany(Saledet::class, 'sales_id', 'id');
    }
}
