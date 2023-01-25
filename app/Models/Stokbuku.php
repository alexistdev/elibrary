<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stokbuku extends Model
{
    use HasFactory;

    protected $fillable =[
        'code','buku_id','status'
    ];


    public function buku(){
        return $this->belongsTo(Buku::class);
    }
}
