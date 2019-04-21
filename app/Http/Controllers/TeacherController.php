<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\JadwalKelas;
use App\Guru;
use App\Kelas;
use App\Sibuk;
use App\Waktu;

class TeacherController extends Controller
{
	public function search(){
        return view('search', [
            'kelasKet' => Kelas::where('kelas','!=','umum')->get(),
            'result' => Input::get('search'),
            'data' => Guru::search(Input::get('search'))
        ]);
    }
    public function delete(Request $request){
    	switch ($request->get('info')) {
    		case 'asField':
    			Guru::destroy('id',$request->get('id'));
    			break;
    		case 'asName':
    			Guru::where('nama', $request->get('nama'))->delete();
    			break;
    		case 'asLesson':
	    		Guru::where('nama', $request->get('nama'))
	    			->where('matpel', $request->get('matpel'))
	    			->delete();
    			break;
    		default:
    			return redirect('/home/teacher');
                break;
    	}
    	return redirect('/home/teacher');
    }
    public function editView($data){
        return view('TeacherEdit', [
            'kelasKet' => Kelas::where('kelas','!=','umum')->get(),
            'data' => Guru::find($data),
            'matpel' => Guru::editView(),
            'day' => ['senin','selasa','rabu','kamis','jumat'],
            'time' => Waktu::all(),
            'busy' => Sibuk::all()
        ]);
    }
    public function editName(){
        if(empty(Input::get('kode_matpel'))){
            Guru::where('nama', Input::get('oldName'))->update([
                'nama' => Input::get('nama'),
                'kode_nama' => Input::get('kode_nama')
            ]);
        }else if(empty(Input::get('kode_nama'))){
            Guru::where('matpel', Input::get('matpel'))->update(['kode_matpel' => Input::get('kode_matpel')]);
        }else{
            Guru::where('nama', Input::get('oldName'))->update([
                'nama' => Input::get('nama'),
                'kode_nama' => Input::get('kode_nama')
            ]);
            Guru::where('matpel', Input::get('lesson'))->update(['kode_matpel' => Input::get('kode_matpel')]);
        }
        JadwalKelas::where('nama_guru', Input::get('oldName'))->update(['nama_guru' => Input::get('nama')]);

        return redirect('/home/teacher/edit/'.Input::get('id'));
    }
    public function editMatpel($data){
        return view('TeacherEditMatpel',[
            'kelasKet' => Kelas::where('kelas','!=','umum')->get(),
            'allClass' => Kelas::all(),
            'data' => Guru::find($data),
            'matpel' => Guru::editView()
        ]);
    }
    public function updateMatpel(){
        Guru::where('id', Input::get('id'))
            ->update([
                'matpel' => Input::get('matpel'),
                'id_kelas' => Input::get('id_kelas')
            ]);
        Guru::where('matpel', Input::get('hidden_mat'))->update(['kode_matpel' => Input::get('kode_matpel')]);
        JadwalKelas::where('matpel', Input::get('hidden_mat'))->update(['matpel' => Input::get('matpel')]);
        
        return redirect('/home/teacher/edit/'.Input::get('id'));
    }
    public function addBusy(){
        if(Sibuk::where('hari',Input::get('hari'))->count() > 0){
            return redirect('/home/teacher/edit/'.Input::get('id'))->with(['error' => 'hari '.Input::get('hari').' sudah ada']);
        }else{
            if(Input::get('jam_ke') == 'null'){
                $a = null;
            }else{
                $a = Input::get('jam_ke');
            }
            DB::table('sibuks')->insert([
                'nama' => Input::get('nama'),
                'hari' => Input::get('hari'),
                'jam_ke' => $a
            ]);
        }
        return redirect('/home/teacher/edit/'.Input::get('id'))->with(['error' => 'hari '.Input::get('hari').' berhasil ditambah']);
    }
    public function deleteBusy(){
        Sibuk::destroy(Input::get('id'));
        return redirect('/home/teacher/edit/'.Input::get('hidden_id'));
    }
}
