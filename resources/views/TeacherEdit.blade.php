@extends('layout')
@section('head')
	<title>Edit Guru</title>
@endsection
@section('content')
	<div class="px-1 pb-1">
		<div class="container-fluid konten">
			<h2 align="center">Edit Guru {{ $data->nama }}</h2>
			@if(null !== Session::get('error'))
				<h4 align="center">{{ Session::get('error') }}</h4>
			@endif
			<form method="post" action="{{ url('/home/teacher/edit/'.$data->id.'/name') }}">
				@csrf
				<input type="hidden" name="id" value="{{ $data->id }}">
				<input type="hidden" name="oldName" value="{{ $data->nama }}">
				<input type="hidden" name="lesson" value="{{ $data->matpel }}">
				<div class="form-group">
					<label>Nama</label>
					<input class="form-control" type="text" name="nama" value="{{ $data->nama }}" required>
				</div>
				<div class="row">
					<div class="col">
						<label>Kode Nama</label>
						<input class="form-control" type="text" name="kode_nama" value="{{ $data->kode_nama }}">
						<small class="form-text text-muted">Kedua kode ini untuk mempersingkat tampilan di tambah jadwal</small>
					</div>
					<div class="col">
						<label>Kode Matpel</label>
						<input class="form-control" type="text" name="kode_matpel" value="{{ $data->kode_matpel }}">
						<small class="form-text text-muted">Mata pelajaran {{ $data->matpel }}</small>
					</div>
				</div>
				<div class="btn-group mt-4">
					<button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="edit">
						<i class="material-icons">edit</i>
					</button>
					<a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#exampleModal">Hari Sibuk</a>
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Hari Sibuk</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
			                        <table class="table table-striped">
										<thead class="thead-dark">
											<tr>
												<th>Hari</th>
												<th>Jam Ke</th>
												<th>Tindakan</th>
											</tr>
										</thead>
										<tr>
											<form class="px-4 py-3" method="post" action="{{ url('/home/teacher/edit/'.$data->id.'/addBusy') }}">
												@csrf
												<input type="hidden" name="id" value="{{ $data->id }}">
												<input type="hidden" name="nama" value="{{ $data->nama }}">
												<td><select class="custom-select" name="hari">
													@foreach($day as $arrayDay)
														<option value="{{ $arrayDay }}">{{ $arrayDay }}</option>
													@endforeach
												</select></td>
												<td><select class="custom-select" name="jam_ke">
													<option value="null">-tidak ada-</option>
													@foreach($time as $arrayTime)
														<option value="{{ $arrayTime->jam_ke }}">{{ $arrayTime->jam_ke }}</option>
													@endforeach
												</select></td>
												<td>
													<button class="btn btn-info btn-sm" type="submit" data-toggle="tooltip-test" title="tambah">
														<i class="material-icons">add_box</i>
													</button>
												</td>
											</form>
										</tr>
										@foreach($busy->where('nama',$data->nama) as $arrayBusy)
											<tr>
												<td>{{ $arrayBusy->hari }}</td>
												<td>{{ $arrayBusy->jam_ke }}</td>
												<td>
													<form method="post" action="{{ url('/home/teacher/edit/'.$data->id.'/deleteBusy') }}">
														@csrf
														<input type="hidden" name="id" value="{{ $arrayBusy->id }}">
														<input type="hidden" name="hidden_id" value="{{ $data->id }}">
														<button class="btn btn-danger btn-sm" type="submit" onClick="return confirm('hapus kesibukan dihari {{ $arrayBusy->hari }}?')" data-toggle="tooltip-test" title="hapus {{ $arrayBusy->hari }}">
															<i class='material-icons'>delete</i>
														</button>
													</form>
												</td>
											</tr>
										@endforeach
									</table>
								</div>
							</div>
	                    </div>
					</div>
				</div>
			</form>
			<table class="table table-striped mt-4">
				<thead class="thead-dark">
					<tr>
						<th>Mata Pelajaran</th>
						<th>Kelas</th>
						<th colspan="2">Tindakan</th>
					</tr>
				</thead>
				@foreach($matpel->where('nama',$data->nama)->get() as $key)
					<tr>
						<td>{{ $key->matpel }}</td>
						<td>{{ $key->kelas === 'umum' ? 'semua kelas' : $key->kelas }}</td>
						<td><a class="btn btn-info" href="{{ url('home/teacher/edit/'.$key->id.'/matpel') }}" data-toggle="tooltip" data-placement="top" title="edit">
							<i class="material-icons">edit</i>
						</a></td>
						<td><a class="btn btn-secondary" href="{{ url('home/teacher/edit/'.$key->id) }}" data-toggle="tooltip" data-placement="top" title="ganti matpel">
							<i class="material-icons">refresh</i>
						</a></td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
@endsection