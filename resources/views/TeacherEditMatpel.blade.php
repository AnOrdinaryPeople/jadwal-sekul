@extends('layout')
@section('head')
	<title>Edit Matpel</title>
@endsection
@section('content')
	<div class="px-1 pb-1">
		<div class="container-fluid konten">
			<h2 align="center">Edit Guru {{ $data->nama }}</h2>
			<form method="post" action="{{ url('/home/teacher/edit/'.$data->id.'/process/matpel') }}">
				@csrf
				<input type="hidden" name="id" value="{{ $data->id }}">
				<input type="hidden" name="hidden_mat" value="{{ $data->matpel }}">
				<div class="row">
					<div class="col">
						<label>Mata Pelajaran</label>
						<input class="form-control" type="text" name="matpel" value="{{ $data->matpel }}" required>
					</div>
					<div class="col">
						<label>Kode Matpel</label>
						<input class="form-control" type="text" name="kode_matpel" value="{{ $data->kode_matpel }}" required>
					</div>
				</div>
				<div class="form-check">
					<label class="form-check-label">Kelas</label><br>
					@php($j=0)
					@php($no=3)
					@foreach($allClass as $array)
						<input type="radio" name="id_kelas" value="{{ $array->id }}" {{ $array->id === $data->id_kelas ? 'checked' : '' }}>{{ $array->kelas === 'umum' ? 'semua kelas' : $array->kelas }}
						@if($array->id==0)
							<br>
						@elseif($j==$no)
							<br>
							@php($no+=3)
						@endif
						@php($j++)
					@endforeach
				</div>
				<button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="edit">
					<i class="material-icons">edit</i>
				</button>
			</form>
		</div>
	</div>
@endsection