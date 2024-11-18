<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi1 extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $table = 'transaksi1';

    protected $transaksis = ['kapasitas_produksi'=>'decimal:2'];

    protected $fillable = [
        'blth', 'kode', 'jam_operasional', 'liter', 'kapasitas_produksi', 
        'produksi', 'distribusi', 'flushing', 'spey'
    ];


    public function sumber() {
        return $this->belongsTo(Sumber::class, 'kode', 'kode');
    }
}
