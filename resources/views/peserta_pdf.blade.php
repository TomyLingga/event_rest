<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Data Kehadiran Peserta Event Anda</h4>
	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Status Kehadiran</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tickets as $p)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{$p->name}}</td>
				<td>{{$p->email}}</td>
				<td> @if($p->kehadiran === 1)
                            Hadir
                        @endif

                    </td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>