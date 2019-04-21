<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- id="header-menu" -->
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tambah Jadwal</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					@foreach($kelasKet as $arai)
						<a class="dropdown-item" href="{{ url('/home/'.$arai->kelas) }}">{{ $arai->kelas }}</a>
					@endforeach
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ url('/home/teacher') }}">Daftar Guru</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ url('/home/list') }}">Jadwal</a>
			</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/home/download') }}">Unduh Jadwal</a>
				</li>
		</ul>
		<form class="form-inline my-2 my-lg-0" method="post" action="{{ url('/process/teacher/search') }}">
			@csrf
			<input class="form-control mr-sm-2" type="text" name="search" @if(!empty($result)) value="{{ $result }}" @endif placeholder="cari guru / matpel..">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="material-icons">search</i></button>
		</form>
	</div>
</nav>
<div id="back-top" class="tumval">
	<i id="#top" class="material-icons">keyboard_arrow_up</i>
</div>