<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\JadwalKelas;
use App\Kelas;
use App\Guru;
use App\Waktu;
use App\Sibuk;

class ProcessController extends Controller
{
    public function listProcess(){
    	$checkBusy = Sibuk::where('nama', Input::get('nama_guru'))
    		->where('hari', Input::get('hari'))
    		->get();
        $a = [
            'jam_ke' => (int)Input::get('jam_ke'),
            'id_kelas' => Input::get('id_kelas'),
            'hari' => Input::get('hari'),
            'nama_guru' => Input::get('nama_guru'),
            'matpel' => Input::get('matpel')
        ];

    	if($a['hari']=="jumat" && $a['jam_ke']>=7){
    		return back()->with(['error' => 'hari jumat hanya sampai jam ke 6!']);
    	}else if($checkBusy->count()>0){
    		foreach ($checkBusy as $key) {
    			if($a['jam_ke']==$key->jam_ke){
    				return back()->with(['error' => "guru $a[nama_guru] sibuk pada hari $a[hari] pada jam ke $a[jam_ke]"]);
    			}
    		}
    		if(empty($info)){
    			return back()->with(['error' => "guru $a[nama_guru] sibuk pada hari $a[hari]"]);
    		}
    	}
    	foreach (JadwalKelas::all() as $key) {
			if($a['jam_ke']==$key->jam_ke && $a['hari']==$key->hari && $a['nama_guru']==$key->nama_guru){
				$kelas = Kelas::find($key->id_kelas);
				return back()->with(['error' => "jam ke $a[jam_ke] hari ".$key->hari." sudah dipakai di kelas ".$kelas->kelas."<br>nama guru ".$key->nama_guru]);
			}else if($a['jam_ke']==$key->jam_ke && $a['hari']==$key->hari && $a['id_kelas']==$key->id_kelas){
                $kelas = "guru $a[nama_guru] pada jam ke $a[jam_ke]<br>sudah dipakai di hari ".$key->hari." oleh ".$key->nama_guru;
                return back()->with(['error' => $kelas]);
			}else if($a['jam_ke']==$key->jam_ke && $a['hari']==$key->hari && $a['matpel']==$key->matpel && $a['id_kelas']==$key->id_kelas){
                $kelas = "pelajaran $a[matpel] sudah dipakai pada hari ".$key->hari." jam ke $a[jam_ke]";
                return back()->with(['error' => $kelas]);
			}
		}
        if(empty($kelas)){
    		for($i=0;$i<Input::get('lamaMengajar');$i++){
    			JadwalKelas::create($a);
    			$a['jam_ke']++;
    		}
    		return back();
        }
    	
    }
    public function addTeacher(){
        foreach (Input::all() as $key => $value) {
            $a[$key] = Input::get($key);
        }
        $guru = Guru::addValidate($a);
        $i = 0;
        if($guru->count() > 0){
            foreach ($guru as $key) {
                if($a['nama']==$key->nama && $a['matpel']==$key->matpel && $a['id_kelas'][$i]==$key->id_kelas){
                    $kelas = Kelas::find($a['id_kelas'][$i]);
                    return back()->with([ 'error' => "guru $a[nama] dengan matpel $a[matpel] dengan kelas ".$kelas->kelas." sudah ada" ]);
                }
                $i++;
            }
        }else{
            foreach ($a['id_kelas'] as $array => $value) {
                Guru::create([
                    'nama' => $a['nama'],
                    'matpel' => $a['matpel'],
                    'id_kelas' => $value
                ]);
            }
            return back()->with([
                'info' => "guru $a[nama] dengan matpel $a[matpel] berhasil ditambah"
            ]);
        }
    }
    public function delete($id){
        JadwalKelas::destroy($id);
        return back();
    }
    public function deleteAsName($nama,$id,$hari){
        JadwalKelas::where('nama_guru',$nama)
            ->where('id_kelas',$id)
            ->where('hari',$hari)
            ->delete();
        return back();
    }
}
