<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tahunajaran(){
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
