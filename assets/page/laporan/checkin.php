<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>LAPORAN CHECK IN</h3>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Pukul</th>
						<th>Karyawan</th>
						<th>Pelanggan</th>
						<th>GPS</th>
						<th>Kota</th>
						<th>Akurasi</th>
						<th><div style="min-width:50px" rel="tooltip" title="Fake GPS">Mock <i class="fa fa-exclamation-circle"></i></div></th>
						<th><div style="min-width:50px" rel="tooltip" title="Beda jarak saat check in">Distance <i class="fa fa-exclamation-circle" ></i></div></th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT
    checkin.tanggal
    , checkin.jam
    , checkin.gps
    , checkin.kota
    , checkin.akurasi
    , checkin.mock
    , checkin.distance
    , pelanggan.nama_pelanggan
    , karyawan.nama_karyawan
FROM
    checkin
    INNER JOIN karyawan 
        ON (checkin.id_karyawan = karyawan.id_karyawan)
    INNER JOIN pelanggan 
        ON (checkin.id_pelanggan = pelanggan.id_pelanggan)");
while($row=mysql_fetch_array($sql)){
($row['mock']=='1' ? $mock='YA' : $mock='TIDAK');
	echo '			<tr>
						<td>' .date("d-m-Y",strtotime($row['tanggal'])). '</td>
						<td>' .$row['jam']. '</td>
						<td>' .$row['nama_karyawan']. '</td>
						<td>' .$row['nama_pelanggan']. '</td>
						<td>' .$row['gps']. '</td>
						<td>' .$row['kota']. '</td>
						<td>' .$row['akurasi']. ' meter</td>
						<td>' .$mock. '</td>
						<td>' .format_angka($row['distance']). ' meter</td>
					</tr>';
}
?>
					
				</tbody>
			</table>
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>