<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JadwalKelas extends Model
{
    protected $fillable = ['id','jam_ke','id_kelas','hari','nama_guru','matpel'];

    public static function scheduleList(){
    	return DB::table('jadwal_kelas')
            ->distinct()
            ->select('jadwal_kelas.*','kode_nama','nama','kode_matpel')
            ->join('gurus','nama_guru','=','nama')
            ->whereColumn('jadwal_kelas.matpel','gurus.matpel')
            ->get();
    }
    public static function classSchedule($id){
    	return DB::table('jadwal_kelas')
            ->select('jadwal_kelas.*','waktus.waktu_pelajaran')
            ->join('waktus','waktus.jam_ke','=','jadwal_kelas.jam_ke')
            ->where('id_kelas', $id)
            ->orderBy('jadwal_kelas.jam_ke')
            ->get();
    }
}

/*
    select distinct jadwal_kelas.matpel as matpel, kode, nama
    from jadwal_kelas
    join gurus
        on nama_guru = nama
    where jadwal_kelas.matpel = gurus.matpel
        and hari = 'senin'
        and jam_ke = 1
        and jadwal_kelas.id_kelas = 1;
*/