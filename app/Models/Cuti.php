<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'master_cuti';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'tahun',
        'jumlah_cuti'
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function user()
    {
        return $this->belongsTo(Akun::class, 'id_user', 'id');
    }
}

