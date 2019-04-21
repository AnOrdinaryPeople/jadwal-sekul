<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use App\Guru;

class AjaxController extends Controller
{
    public function list($data, Request $request){
        $id = Kelas::where('kelas', $data)->pluck('id');

        return view('dapetJadwal',['query' => Guru::ajax($id,$request->get('nama'))]);
    }
}
