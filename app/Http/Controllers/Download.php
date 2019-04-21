<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class Download extends Controller
{
    public function export(){
    	return Excel::download(new UsersExport,'jadwal kelas.xlsx');
    }
}
