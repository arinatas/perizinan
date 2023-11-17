<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atasan extends Model
{
    use HasFactory;

    protected $table = 'devisi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_devisi',
        'id_atasan'
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Definisikan relasi dengan model Akun
    public function atasanUser()
    {
        return $this->belongsTo(Akun::class, 'id_atasan', 'id');
    }
}

