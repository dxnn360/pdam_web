<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sumber extends Model
{
    use HasFactory;

    protected $table = 'sumber';
    
    protected $fillable = ['nama_sumber', 'kode', 'status'];

    public $timestamps = false;

    public function transaksi(){
        return $this->hasMany(Transaksi1::class, 'kode', 'kode');
    }
}
