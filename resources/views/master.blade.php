@extends('layout')
@section('head')
    <title>Tambah Jadwal</title>
    @php
        $listHari = ['senin','selasa','rabu','kamis','jumat'];
        if(isset($infoKelas)){
            $kelaz = $infoKelas;
        }else{
            $kelaz = "belum dipilih";
        }
        if(isset($day)){
            $dayInfo = $day;
        }else{
            $dayInfo = 'senin';
        }
    @endphp
    <script type="text/javascript">
        $(document).ready(function(){
            $('#guru').change(function(){
                $.ajax({
                    type: "POST",
                    url: "{{ url('/home/'.$kelaz.'/list') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "nama": $(this).val()
                    },
                    success: function(hasil){
                        $('#jadwal').html(hasil);
                    }
                });
            });
        });
    </script>
@endsection
@section('content')
    <div class="px-1 pb-1">
        <div class="container-fluid konten">
            <h1>Kelas {{ $kelaz }}</h1>
            @if(isset($infoKelas))
                <form method="post" action="{{ url('/process/add') }}">
                    @csrf
                    @foreach($id_kelas as $id)
                        <input type="hidden" name="id_kelas" value="{{ $id }}">
                    @endforeach
                    @if(null !== Session::get('error'))
                        <div class="alert alert-danger" role="alert">
                            {!! Session::get('error') !!}
                        </div>
                    @endif
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="hari">Hari</label>
                        </div>
                        <select id="hari" name="hari" class="custom-select">
                            @foreach($listHari as $aaaa)
                                <option {{ $aaaa === $dayInfo ? 'selected' : '' }} value="{{ $aaaa }}">{{ $aaaa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="jam_ke">Jam Ke</label>
                        </div>
                        <select id="jam_ke" name="jam_ke" class="custom-select">
                            <option value=""></option>
                            @foreach($jam_ke as $jam)
                                <option value="{{ $jam->jam_ke }}">{{ $jam->jam_ke }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="lamaMengajar">Lama mengajar</label>
                        </div>
                        <select id="lamaMengajar" name="lamaMengajar" class="custom-select">
                            <option value=""></option>
                            @for($i=1;$i<=4;$i++)
                                <option value='{{$i}}'>{{$i}} jam</option>
                            @endfor
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="guru">Nama Guru</label>
                        </div>
                        <select id="guru" name="nama_guru" class="custom-select">
                            <option value=""></option>
                            @foreach($guru as $name)
                                <option value="{{ $name->nama }}">{{ $name->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="jadwal">Mata Pelajaran</label>
                        </div>
                        <select id="jadwal" name="matpel" class="custom-select"></select>
                    </div>
                    <div class="btn-group">
                        <div class="dropdown">
                            <button id="submitorder" class="btn btn-primary" type="submit">Proses</button>
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Kode Guru
                            </a>
                            <div class="dropdown-menu p-4 scrollable-menu" aria-labelledby="dropdownMenuButton">
                                <table class="table table-striped">
                                @foreach($kode as $teacherCode)
                                    <tr>
                                        <td>{{ $teacherCode->nama }}</td>
                                        <td>{{ $teacherCode->kode_nama }}</td>
                                    </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Kode Matpel
                            </a>
                            <div class="dropdown-menu p-4 scrollable-menu" aria-labelledby="dropdownMenuButton">
                                <table class="table table-striped">
                                @foreach($kodeMatpel as $teacherCode)
                                    <tr>
                                        <td>{{ $teacherCode->matpel }}</td>
                                        <td>{{ $teacherCode->kode_matpel }}</td>
                                    </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container-fluid konten">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            @foreach($listHari as $day)
                                <li class="nav-item">
                                    <a class="nav-link {{ $day == $dayInfo ? 'active' : '' }}" href="{{ url('/home/'.$kelaz.'/'.$day) }}">{{ $day }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
                <table class="tabel">
                    <thead align="center">
                        <tr>
                            <th rowspan="2">Jam Ke</th>
                            <th rowspan="2">Waktu Mengajar</th>
                            @foreach($kelasKet as $classList)
                                <th colspan="2">{{ $classList->kelas }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($kelasKet as $classCount)
                                <th>Matpel</th>
                                <th>Nama</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($jam_ke as $timeList)
                            <tr>
                                <td>{{ $timeList->jam_ke }}</td>
                                <td>{{ $timeList->waktu_pelajaran }}</td>
                                @foreach($kelasKet as $classCheck)
                                    @forelse($list->where('hari',$dayInfo)->where('jam_ke',$timeList->jam_ke)->where('id_kelas',$classCheck->id) as $key)
                                        @if($key->kode_matpel == null)
                                            <td>{{ $key->matpel }}</td>
                                        @else
                                            <td class="text-success" data-toggle="tooltip" title="{{ $key->matpel }}">{{ $key->kode_matpel }}</td>
                                        @endif
                                        @if($key->kode_nama == null)
                                            <td>{{ $key->nama_guru }}</td>
                                        @else
                                            <td class="text-primary" data-toggle="tooltip" title="{{ $key->nama_guru }}">{{ $key->kode_nama }}</td>
                                        @endif
                                    @empty
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection