<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id','kategori_id','name','tahun_terbit'
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }

    public function stok(){
        return $this->hasMany(Stokbuku::class);
    }
}
