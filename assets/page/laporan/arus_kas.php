<?php
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0]; $bln_sql=$bln;
	$thn = $tgl[1]; $thn_sql=$thn;
	$bulan_ini=$thn .'-'. $bln . "-01";
} else {
	$bln = date("m"); $bln_sql="MONTH(CURRENT_DATE())";
	$thn = date("Y"); $thn_sql="YEAR(CURRENT_DATE())";
	$bulan_ini=date("Y-m") . "-01";
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
                <div class="x_panel">
					<div class="x_content">
						<div class="col-xs-12" style="text-align:right">
							<input type="text" id="datepicker" PlaceHolder="Bulan & Tahun" style="width:100px" readonly></input>
							<input type="button" id="cari" onClick="cari()" value="Cari"></input>
							<input type="button" id="reset" onClick="reset()" value="Reset"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>LAPORAN ARUS KAS</h3>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
			<div class="table responsive">
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Komponen</th>
						<th>Keterangan</th>
						<th>Uang Masuk (Rp)</th>
						<th>Uang Keluar (Rp)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_masuk=0;$jumlah_keluar=0;
					$sql=mysqli_query($con, "SELECT * FROM kas_kecil WHERE jenis='KELUAR' AND MONTH(tanggal)=$bln_sql AND YEAR(tanggal)=$thn_sql");
					if (mysqli_num_rows($sql)>0) 
						echo '<tr style="background: red">
								<td colspan="6"><font color="white">PENGELUARAN</font></td>
							</tr>';
					while($row=mysqli_fetch_array($sql)){
					$jumlah_keluar+=$row['jumlah'];
						echo '<tr>
								<td><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal'])). '</div></td>
								<td><div style="min-width:70px">' .$row['komponen']. '</div></td>
								<td><div style="min-width:70px">' .$row['keterangan']. '</div></td>
								<td align="right"><div style="min-width:70px">-</div></td>
								<td align="right"><div style="min-width:70px">' .format_uang($row['jumlah']). '</div></td>
							</tr>';
					}

					$sql2=mysqli_query($con, "SELECT * FROM kas_kecil WHERE jenis='MASUK' AND MONTH(tanggal)=$bln_sql AND YEAR(tanggal)=$thn_sql");
					if (mysqli_num_rows($sql2)>0)
						echo '<tr style="background: blue">
								<td colspan="6"><font color="white">PEMASUKAN</font></td>
							</tr>';
					while($row2=mysqli_fetch_array($sql2)){
					$jumlah_masuk+=$row2['jumlah'];
						echo '<tr>
								<td><div style="min-width:70px">' .date("d-m-Y",strtotime($row2['tanggal'])). '</div></td>
								<td><div style="min-width:70px">' .$row2['komponen']. '</div></td>
								<td><div style="min-width:70px">' .$row2['keterangan']. '</div></td>
								<td align="right"><div style="min-width:70px">' .format_uang($row2['jumlah']). '</div></td>
								<td align="right"><div style="min-width:70px">-</div></td>
							</tr>';
					}
					if (mysqli_num_rows($sql)>0 || mysqli_num_rows($sql2)>0) {
						echo '<tr style="background: aqua">
								<td colspan="3"><b>TOTAL</b></td>
								<td align="right">' .format_uang($jumlah_masuk). '</td>
								<td align="right">' .format_uang($jumlah_keluar). '</td>
							  </tr>';
					}
					?>
				</tbody>
			</table>
			</div>
		</div>
		<!-- /page content -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function cari(){
	var tanggal = $('#datepicker').val();
	var url = "?page=laporan&mode=arus_kas&cari=" + tanggal;
	if (tanggal!='') window.location=url;
}
function reset(){
	var url = "?page=laporan&mode=arus_kas";
	window.location=url;
}
$(document).ready(function(){
	$('#datepicker').datepicker({
		orientation: "bottom auto",
		format: "mm-yyyy",
		startView: 1,
		minViewMode: 1,
		autoclose: true
	});
});
</script>