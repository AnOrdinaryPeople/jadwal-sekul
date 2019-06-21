@extends('layout')
@section('head')
	<title>Daftar Guru</title>
@endsection
@section('content')
	<div class="px-1 pb-1">
		<div class="container-fluid konten">
			<h2>Tambah Guru</h2>
			@if(null !== Session::get('error'))
				<div class="alert alert-danger" role="alert">
					{{ Session::get('error') }}
				</div>
			@elseif(null !== Session::get('info'))
				<div class="alert alert-success" role="alert">
					{{ Session::get('info') }}
				</div>
			@endif
			<form id="form1" method="post" action="{{ url('/process/addTeacher') }}">
				@csrf
				<div class="form-group">
					<label>Nama Guru</label>
					<input class="form-control" type="text" name="nama" required>
				</div>
				<div class="form-group">
					<label>Mata Pelajaran</label>
					<input class="form-control" type="text" name="matpel" required>
				</div>
				<div class="form-check">
					<label class="form-check-label">Mengajar dikelas</label><br>
					<input id="oemoem" type="checkbox" name="id_kelas[]" value="0" onclick="$('.celas').toggle();">semua kelas
					<script type="text/javascript">
						$('#oemoem').click(function(){
							$('[type=checkbox]:not(#oemoem)').prop('checked',false);
						});
					</script>
					<br>
					@php($j=0)
					<p class="celas">
						@foreach($kelasKet as $array)
							<input type="checkbox" name="id_kelas[]" value="{{ $array->id }}">{{ $array->kelas }}
							@if($j==$no)
								<br>
								@php($no+=3)
							@endif
							@php($j++)
						@endforeach
					</p>
				</div>
				<button class="btn btn-primary" type="submit">Tambah</button>
			</form>
			<h1 align="center">Daftar Guru SMK BPI</h1>
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
						<th>Nama Guru</th>
						<th>Mata pelajaran</th>
						<th colspan="3">Tindakan</th>
					</tr>
				</thead>
				@foreach($data as $key)
					<tr>
						<td>{{ $key->nama }}</td>
						<td>{{ $key->matpel }}</td>
						<td>
							<form method="post" action="{{ url('process/delete/teacher/name/lesson') }}">
								@csrf
								<input type="hidden" name="info" value="asLesson">
								<input type="hidden" name="nama" value="{{ $key->nama }}">
								<input type="hidden" name="matpel" value="{{ $key->matpel }}">
								<button class="btn btn-danger" onClick="return confirm('hapus {{ $key->nama }} yang mengajar {{ $key->matpel }} ?')" data-toggle="tooltip" data-placement="top" title="hapus matpel {{ $key->matpel }}">
									<i class="material-icons">delete_forever</i>
								</button>
							</form>
						</td>
						<td>
							<form method="post" action="{{ url('process/delete/teacher/name') }}">
								@csrf
								<input type="hidden" name="info" value="asName">
								<input type="hidden" name="nama" value="{{ $key->nama }}">
								<button class="btn btn-danger" onClick="return confirm('hapus guru {{ $key->nama }} ?')" data-toggle="tooltip" data-placement="top" title="hapus guru {{ $key->nama }}">
									<i class="material-icons">delete_outline</i>
								</button>
							</form>
						</td>
						<td>
							<a class="btn btn-info" href="{{ url('home/teacher/edit/'.$key->id) }}" data-toggle="tooltip" data-placement="top" title="edit"><i class="material-icons">edit</i></a>
						</td>
					</tr>
				@endforeach
			</table>
			{{ $data->links() }}
		</div>
	</div>
@endsection