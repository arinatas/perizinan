<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisCuti;

class FormCuti extends Model
{
    use HasFactory;

    protected $table = 'cuti';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'id_devisi',
        'nama',
        'jabatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_cuti',
        'alamat',
        'no_hp',
        'keperluan',
        'jenis_cuti',
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

    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class, 'jenis_cuti', 'id');
    }
}

