<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSakit extends Model
{
    use HasFactory;

    protected $table = 'sakit';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'id_devisi',
        'nama',
        'jabatan',
        'tanggal',
        'jumlah_izin',
        'no_hp',
        'keterangan',
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

