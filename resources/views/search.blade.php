@extends('layout')
@section('head')
	<title>Result Search</title>
@endsection
@section('content')
	<div class="px-1 pb-1">
		<div class="container-fluid konten">
			<h1 align="center">Hasil Pencarian<br>{{ $result }}</h1>
			@if($data->count() > 0)
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th>Nama Guru</th>
							<th>Mata Pelajaran</th>
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
			@else
				<h2 align="center">Tidak ada</h2>
			@endif
		</div>
	</div>
@endsection