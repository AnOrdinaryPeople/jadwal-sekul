@extends('layout')
@section('head')
	<title>Jadwal Pelajaran</title>
@endsection
@section('content')
	<div class="px-1 pb-1">
		<div class="container-fluid konten">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						@foreach($kelasKet as $arai)
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/home/list/'.$arai->kelas) }}">{{ $arai->kelas }}</a>
							</li>
						@endforeach
					</ul>
				</div>
			</nav>
			@if(isset($list))
				<h1 align="center">{{ $class }}</h1>
				@foreach($day as $arrayDay)
					<p class="alert alert-primary" align="center">{{ $arrayDay }}</p>
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th>Jam Ke</th>
								<th>Jam Pelajaran</th>
								<th>Nama Guru</th>
								<th>Mata Pelajaran</th>
							</tr>
						</thead>
						@foreach($list->where('hari', $arrayDay) as $key)
							<tr>
								<td>{{ $key->jam_ke }}</td>
								<td>{{ $key->waktu_pelajaran }}</td>
								<td>{{ $key->nama_guru }}</td>
								<td>{{ $key->matpel }}</td>
							</tr>
						@endforeach
					</table>
				@endforeach
			@else
				<h1 align="center">Kelas belum dipilih</h1>
			@endif
		</div>
	</div>
@endsection