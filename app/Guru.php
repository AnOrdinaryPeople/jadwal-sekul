<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Guru extends Model
{
    protected $fillable = ['id','nama','matpel','id_kelas'];

    public static function ajax($id,$nama){
    	return DB::table('gurus')
            ->select('matpel')
            ->where('nama', $nama)
            ->whereIn('id_kelas',[$id,0])
            ->distinct()
            ->get();
    }
    public static function teacherName($id){
    	return DB::table('gurus')
	        ->select('nama')
	        ->whereIn('id_kelas', [$id,0])
	        ->distinct()
	        ->orderBy('nama')
	        ->get();
    }
    public static function paginate(){
    	return DB::table('gurus')
            ->select('id','nama','matpel')
            ->groupBy('matpel')
            ->orderBy('nama')
            ->paginate(10); //20
    }
    public static function addValidate($a){
    	return DB::table('gurus')
            ->where('nama', $a['nama'])
            ->where('matpel', $a['matpel'])
            ->whereIn('id_kelas',[$a['id_kelas']])
            ->get();
    }
    public static function search($data){
    	return DB::table('gurus')
            ->select('id','nama','matpel')
            ->where('nama','like', '%'.$data.'%')
            ->orWhere('matpel','like', '%'.$data.'%')
            ->groupBy('matpel')
            ->orderBy('nama')
            ->paginate(10);
    }
    public static function editView(){
    	return DB::table('gurus')
            ->select('gurus.id','matpel','kelas')
            ->join('kelas','kelas.id','=','gurus.id_kelas');
    }
    public static function getCode(){
        return DB::table('gurus')
            ->distinct()
            ->select('nama','kode_nama')
            ->get();
    }
    public static function getLessonCode(){
        return DB::table('gurus')
            ->distinct()
            ->select('matpel','kode_matpel')
            ->get();
    }
}
