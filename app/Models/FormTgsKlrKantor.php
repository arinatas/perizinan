<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTgsKlrKantor extends Model
{
    use HasFactory;

    protected $table = 'tugas_keluar_kantor';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'id_devisi',
        'nama',
        'jabatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'no_hp',
        'keperluan',
        'bukti_pendukung',
        'approve_atasan',
        'approve_sdm'
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Define a relationship with the Atasan model
    public function devisi()
    {
        return $this->belongsTo(Atasan::class, 'id_devisi', 'id');
    }
}

