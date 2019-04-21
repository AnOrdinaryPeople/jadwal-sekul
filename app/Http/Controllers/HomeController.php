<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalKelas;
use App\Kelas;
use App\Waktu;
use App\Guru;

class HomeController extends Controller
{
    private function classInfo(){
        return Kelas::where('kelas','!=','umum')->get();
    }
    public function home(){
        return redirect('/home');
    }
    public function index($data = "",$day = ""){
        if(!empty($data)){
            $id = Kelas::where('kelas',$data)->pluck('id');
            $info = [
                'kelasKet' => $this->classInfo(),
                'list' => JadwalKelas::scheduleList(),
                'infoKelas' => $data,
                'id_kelas' => $id,
                'jam_ke' => Waktu::all(),
                'guru' => Guru::teacherName($id),
                'kode' => Guru::getCode(),
                'kodeMatpel' => Guru::getLessonCode(),
            ];
            if(empty($day)){
                return view('master', $info);
            }else{
                $info['day'] = $day;
                return $info;
            }
        }
    	return view('master', ['kelasKet' => $this->classInfo()]);
    }
    public function day($data,$day){
        return view('master',$this->index($data,$day));
    }
    public function teacher(){
        return view('teacher',[
            'data' => Guru::paginate(),
            'kelasKet' => $this->classInfo(),
            'no' => 2
        ]);
    }
    public function list($data = ""){
        if(!empty($data)){
            $id = Kelas::where('kelas',$data)->pluck('id');
            return view('list', [
                'kelasKet' => $this->classInfo(),
                'day' => ["senin","selasa","rabu","kamis","jumat"],
                'list' => JadwalKelas::classSchedule($id),
                'class' => $data
            ]);
        }else{
            return view('list', ['kelasKet' => $this->classInfo(),'class' => 'a']);
        }
    }
    public function download(){
        return view('download');
    }
}
