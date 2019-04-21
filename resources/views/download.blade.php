<!DOCTYPE html>
<html>
<head>
	<title>Proses..</title>
	<style type="text/css">
		body{ font-family: calibri;position: absolute;width: 1750px }
		.tavel{ border-collapse: collapse }
		.tavel tr:first-child{ font-weight: bold;padding: 5px }
		.tavel tr{ text-align: center }
	</style>
</head>
<body>
	<table class="tavel" border="1">
		<tr>
			<td rowspan="2">Jam Ke</td>
			<td rowspan="2">Waktu</td>
			@foreach($class as $key)
				<td colspan="2">{{ $key->kelas }}</td>
			@endforeach
		</tr>
		<tr>
			@for($i = 0;$i < $class->count();$i++)
				<td>Matpel</td>
				<td>Guru</td>
			@endfor
		</tr>
		@foreach($day as $arrayDay)
			<tr>
				<td colspan="{{ $class->count()*2+2 }}" style="text-align: left;padding-left: 45px"><b>{{ $arrayDay }}</b></td>
			</tr>
				@foreach($time as $arrayTime)
					<tr>
						<td>{{ $arrayTime->jam_ke }}</td>
						<td>{{ $arrayTime->waktu_pelajaran }}</td>
						@foreach($class as $keyCheck)
							@forelse($list->where('hari',$arrayDay)->where('jam_ke',$arrayTime->jam_ke)->where('id_kelas',$keyCheck->id) as $schedule)
								<td>{{ $schedule->matpel }}</td>
								<td>{{ $schedule->nama_guru }}</td>
							@empty
								<td></td>
								<td></td>
							@endforelse
						@endforeach
					</tr>
					@if($arrayDay=="jumat" && $arrayTime->jam_ke == 6)
						@break
					@elseif($arrayTime->jam_ke == 4)
						<tr><td colspan="{{ $class->count()*2+2 }}">Istirahat</td></tr>
					@elseif($arrayTime->jam_ke == 8)
						<tr><td colspan="{{ $class->count()*2+2 }}">Sholat Dzuhur</td></tr>
					@endif
				@endforeach
		@endforeach
	</table>
</body>
</html>