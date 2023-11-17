<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormLembur extends Model
{
    use HasFactory;

    protected $table = 'lembur';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'id_devisi',
        'nama',
        'jabatan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'durasi_lembur',
        'keterangan_pekerjaan',
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

