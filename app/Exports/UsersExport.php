<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\JadwalKelas;
use App\Kelas;
use App\Waktu;

class UsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        return view('download',[
            'day' => ["senin","selasa","rabu","kamis","jumat"],
            'list' => JadwalKelas::orderBy('id_kelas')->orderBy('jam_ke')->get(),
            'time' => Waktu::orderBy('jam_ke')->get(),
            'class' => Kelas::where('kelas','!=','umum')->orderBy('id')->get()
        ]);
    }
}
