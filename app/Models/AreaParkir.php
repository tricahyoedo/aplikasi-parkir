<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaParkir extends Model
{
    use HasFactory;

    protected $table = 'tb_area_parkir';
    protected $primaryKey = 'id_area';
    protected $fillable = ['nama_area', 'kapasitas', 'terisi'];

    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class, 'id_area', 'id_area');
    }
}
