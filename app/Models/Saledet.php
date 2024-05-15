<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saledet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sales_id',
        'barang_id',
        'harga_bandrol',
        'qty',
        'diskon_pct',
        'diskon_nilai',
        'harga_diskon',
        'total_harga',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = ['sales_id', 'barang_id'];

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the primary key for the model.
     *
     * @return string|array
     */
    public function getKey()
    {
        return $this->primaryKey;
    }

    /**
     * Get the key for cached model index.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'id'; // Jika Anda perlu menggunakan nama kolom 'id' untuk kunci unik
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
