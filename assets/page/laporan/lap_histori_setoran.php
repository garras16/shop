<?php
$id_karyawan=$_SESSION['id_karyawan'];
?>
<div class="right_col loading" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6">
                            <h3>RIWAYAT SETORAN</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="col-md-12">
                        <?php
                        if(isset($_GET['sampai']) || isset($_GET['dari']) || isset($_GET['pelanggan']) || isset($_GET['debt'])) {
                         ?>
                         <div class="col-md-3" style="overflow:hidden;">Cari Tanggal :<br>
                         <input
                             class="form-control"
                             style="width:100px; float: left"
                             id="tgl_dari"
                             type="text"
                             value="<?php if(isset($_GET['dari'])) { echo $_GET['dari']; } ?>"
                             placeholder="Tanggal"
                             readonly="readonly">
                             <span style="float:left;">&nbsp; - &nbsp;</span>
                         <input
                             class="form-control"
                             style="width:100px; float:left;"
                             id="tgl_sampai"
                             type="text"
                             value="<?php if(isset($_GET['sampai'])) { echo $_GET['sampai']; } ?>"
                             placeholder="Tanggal"
                             readonly="readonly">
                             <br><a class="btn btn-primary" style="font-size:12px; margin-top:10px;" id="btn_dari_sampai" onclick="submittgl();">
                               <i class="fa fa-search">Cari Tanggal</i>
                           </a></div>
                         <!-- <td>&nbsp;&nbsp;</td> -->
                         <div class="col-md-3">Pelanggan :<br><input
                             class="form-control"
                             id="pelanggan"
                             type="text"
                             value="<?php if(isset($_GET['pelanggan'])) { echo $_GET['pelanggan']; } ?>"
                             placeholder="Pelanggan"><br>
                             <a class="btn btn-primary" id="btn_dari_sampai" style="font-size: 12px; margin-top: -10px;" onclick="submitpelanggan();">
                                 <i class="fa fa-search">Cari Pelanggan</i>
                             </a>
                           </div>
                         <!--<td>&nbsp;&nbsp;</td>-->
                         <div class="col-md-3">Debtcollector :<br><input
                             class="form-control"
                             id="debt"
                             type="text"
                             value="<?php if(isset($_GET['debt'])) { echo $_GET['debt']; } ?>"
                             placeholder="Debtcollector">
                           <br><a class="btn btn-primary" style="font-size:12px; margin-top: -10px;" id="btn_dari_sampai" onclick="submitdebt();">
                               <i class="fa fa-search">Cari dept</i>
                           </a>
                         </div>
                         <!-- <td>&nbsp;&nbsp;</td> -->
                         <div class="col-md-3">
                             <a class="btn btn-primary" style="font-size:12px; margin-top: 20px;" id="btn_dari_sampai" onclick="submit();">
                                 <i class="fa fa-search">Cari Semua</i>
                             </a>
                         </div>
                        <?php }else{ ?>
                          <!--<table>
                              <tr>
                                  <td-->
                                  <div class="col-md-3" style="overflow:hidden;">Cari Tanggal :<br>
                                  <input
                                      class="form-control"
                                      style="width:100px; float: left"
                                      id="tgl_dari"
                                      type="text"
                                      value="01-01-2000"
                                      placeholder="Tanggal"
                                      readonly="readonly">
                                      <span style="float:left;">&nbsp; - &nbsp;</span>
                                  <input
                                      class="form-control"
                                      style="width:100px; float:left;"
                                      id="tgl_sampai"
                                      type="text"
                                      value=""
                                      placeholder="Tanggal"
                                      readonly="readonly">
                                      <br><a class="btn btn-primary" style="font-size:12px; margin-top:10px;" id="btn_dari_sampai" onclick="submittgl();">
                                        <i class="fa fa-search">Cari Tanggal</i>
                                    </a></div>
                                  <!-- <td>&nbsp;&nbsp;</td> -->
                                  <div class="col-md-3">Pelanggan :<br><input
                                      class="form-control"
                                      id="pelanggan"
                                      type="text"
                                      value=""
                                      placeholder="Pelanggan"><br>
                                      <a class="btn btn-primary" id="btn_dari_sampai" style="font-size: 12px; margin-top: -10px;" onclick="submitpelanggan();">
                                          <i class="fa fa-search">Cari Pelanggan</i>
                                      </a>
                                    </div>
                                  <!--<td>&nbsp;&nbsp;</td>-->
                                  <div class="col-md-3">Debtcollector :<br><input
                                      class="form-control"
                                      id="debt"
                                      type="text"
                                      value=""
                                      placeholder="Debtcollector">
                                    <br><a class="btn btn-primary" style="font-size:12px; margin-top: -10px;" id="btn_dari_sampai" onclick="submitdebt();">
                                        <i class="fa fa-search">Cari dept</i>
                                    </a>
                                  </div>
                                  <!-- <td>&nbsp;&nbsp;</td> -->
                                  <div class="col-md-3">
                                      <a class="btn btn-primary" style="font-size:12px; margin-top: 20px;" id="btn_dari_sampai" onclick="submit();">
                                          <i class="fa fa-search">Cari Semua</i>
                                      </a>
                                  </div>
                              <!-- </tr>
                          </table> -->
                        <?php } ?>
                      </div>
                        <div class="clearfix"></div><br>
                        <div class="table-responsive">
                            <table
                                id="table1"
                                class="table table-bordered table-striped"
                                style="min-width: 2300px;">
                                <thead>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>No Nota Jual</th>
                                        <th>Jumlah Jual</th>
                                        <th>Debt Collector</th>
                                        <th>Tgl Tagih</th>
                                        <th>Jml Tagih</th>
                                        <th>Jml Bayar</th>
                                        <th>Sisa Piutang</th>
                                        <th>Tgl Kunjungan Berikutnya</th>
                                        <th>Status Bayar</th>
                                        <th>Status Kembali Nota</th>
                                        <th>Setor</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 13px;">
                                <?php
$val="";
if (!isset($_GET['dari']) && !isset($_GET['sampai']) && !isset($_GET['pelanggan']) && !isset($_GET['debt'])){
	$val.="AND tanggal_tagih BETWEEN NOW() - INTERVAL 3 MONTH AND NOW()";
}
if (isset($_GET['dari']) && isset($_GET['sampai']) && !isset($_GET['pelangan']) && !isset($_GET['debt'])){
  $dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
  $val = "AND penagihan.tanggal_tagih BETWEEN '$dari' AND '$sampai'";
  //$val.=" AND karyawan.nama_karyawan LIKE '%" .$_GET['debt']. "%'";
}
if(isset($_GET['dari']) && isset($_GET['sampai']) && isset($_GET['pelangan']) && isset($_GET['debt'])) {
  $dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
  if($_GET['pelanggan'] == NULL) {
    $val = "AND penagihan.tanggal_tagih BETWEEN '$dari' AND '$sampai' AND karyawan.nama_karyawan LIKE '%" .$_GET['debt']. "%'";
  }else if($_GET['debt'] == NULL) {
    $val = "AND penagihan.tanggal_tagih BETWEEN '$dari' AND '$sampai' AND pelanggan.nama_pelanggan LIKE '%" .$_GET['pelanggan']. "%'";
  }else{
    $val = "AND penagihan.tanggal_tagih BETWEEN '$dari' AND '$sampai' AND pelanggan.nama_pelanggan LIKE '%" .$_GET['pelanggan']. "%' AND karyawan.karyawan LIKE '%" .$_GET['debt']. "%'";
  }
}
if(isset($_GET['pelanggan'])) {
  $val = "AND pelanggan.nama_pelanggan LIKE '%" .$_GET['pelanggan']. "%'";
}
if(isset($_GET['debt'])) {
  $val = "AND karyawan.nama_karyawan LIKE '%" .$_GET['debt']. "%'";
}
// if (isset($_GET['tanggal']) && $_GET['tanggal']!=''){
// 	$tgl = explode("-", $_GET['tanggal']);
// 	$bln = $tgl[0];	$thn = $tgl[1];
// 	$val.=" AND MONTH(tanggal_tagih)=$bln AND YEAR(tanggal_tagih)=$thn";
// }
// if (isset($_GET['debt']) && $_GET['debt']!=''){
// 	$val.=" AND karyawan.nama_karyawan LIKE '%" .$_GET['debt']. "%'";
// }
// if (isset($_GET['pelanggan']) && $_GET['pelanggan']!=''){
// 	$val.=" AND pelanggan.nama_pelanggan LIKE '%" .$_GET['pelanggan']. "%'";
// }
// if (!isset($_GET['tanggal']) && !isset($_GET['debt']) && !isset($_GET['pelangan'])){
// 	$val="AND status_tagih<>2";
// }
	$sql=mysqli_query($con, "SELECT *, SUM(bayar) as bayar
FROM
    penagihan
    INNER JOIN karyawan
        ON (penagihan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN penagihan_detail
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
    INNER JOIN jual
        ON (penagihan_detail.id_jual = jual.id_jual)
    INNER JOIN pelanggan
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN jual_detail
        ON (jual.id_jual = jual_detail.id_jual)
WHERE penagihan.status_tagih<>2 $val
GROUP BY jual.id_jual");

	while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT SUM(bayar) as bayar
FROM
    penagihan
    INNER JOIN penagihan_detail
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
WHERE id_jual=" .$row['id_jual']);
	$row2=mysqli_fetch_array($sql2);
	$total_bayar=$row2['bayar'];
	$total_jual=0;
if ($row['status_konfirm']>=5){
	$sql2=mysqli_query($con, "SELECT (qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    jual_detail
    INNER JOIN canvass_siap_kirim_detail
        ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
	while ($row2=mysqli_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
} else {
	$sql2=mysqli_query($con, "SELECT (qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    jual_detail
    INNER JOIN nota_siap_kirim_detail
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
	while ($row2=mysqli_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
}


	$status='';
	if ($row['status_bayar']=='0') {$status='Belum Bayar'; $color='red';}
	if ($row['status_bayar']=='1') {$status='Sedang Mengangsur'; $color='red';}
	if ($row['status_bayar']=='2') {$status='Lunas'; $color='black';}
	if ($row['status_bayar']=='3') {$status='Belum Tagih'; $color='black';}
	if ($row['status_nota_kembali']=='0') $status_nota='Dibawa Debt Collector';
	if ($row['status_nota_kembali']=='1') $status_nota='Diterima Admin';
	if ($row['status_nota_kembali']=='2') $status_nota='Lunas';
	($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
	($row['status_nota_kembali']=='2' ? $cmd='Setor' : $cmd='Scan Nota');
	if ($row['tgl_janji_next']!=''){
		$tglx1=strtotime($row['tgl_janji_next']);
		$tglx2=strtotime(date('Y-m-d'));
		($tglx1>=$tglx2 ? $color2='red' : $color2='black');
	} else {
		$color2='black';
	}
	echo '<tr>
			<td align="center" style="width: 120px;">' .$row['nama_pelanggan']. '</td>
			<td align="center" style="width: 120px;">' .$row['invoice']. '</td>
			<td align="center" style="width: 120px;" class="uang">' .$total_jual. '</td>
			<td align="center" style="width: 100px;">' .$row['nama_karyawan']. '</td>
			<td align="center" style="width: 100px;">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</td>
			<td align="center" style="width: 120px;" class="uang">' .$total_jual. '</td>
			<td align="center" style="width: 120px;" class="uang">' .$total_bayar. '</td>
			<td align="center" style="width: 130px;" class="uang">' .($total_jual-$total_bayar). '</td>
			<td align="center" style="color: ' .$color2. '; width: 105px;">' .$tgl_jb. '</td>
			<td align="center" style="color: ' .$color. '; width: 100px;">' .$status. '</td>
			<td align="center" style="width: 120px;">' .$status_nota. '</td>';
  if($row['setor'] != NULL) {
    echo '<td align="center" style="width: 110px;" class="uang">' .$row['setor']. '</td>
  </tr>';
  }else{
      echo '<td align="center" style="width: 110px;">' .$row['setor']. '</td>
		</tr>';
  }
}
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="dummy"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function validasi() {
        var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
        var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
        if (startDate > endDate) {
            $('#tgl_dari').val('');
            $('#tgl_sampai').val('');
            $('#btn_dari_sampai').attr('style', 'display:none');
            alert("Terjadi kesalahan penulisan tanggal");
            AndroidFunction.showToast("Terjadi kesalahan penulisan tanggal");
        } else {
            $('#btn_dari_sampai').removeAttr('style');
        }
    }
    function cari_debt_pelanggan() {
        var debt = $('#cari_debt').val();
        var pelanggan = $('#cari_pelanggan').val();
        var tanggal = $('#datepicker').val();
        var url = "?page=laporan&mode=lap_histori_setoran&tanggal=" + tanggal +
                "&debt=" + debt + "&pelanggan=" + pelanggan;
        if (debt != '' || pelanggan != '' || tanggal != '')
            window.location = url;
        }
    function reset() {
        var url = "?page=laporan&mode=lap_histori_setoran";
        window.location = url;
    }
    function submit() {
        window.location = "?page=laporan&mode=lap_histori_setoran&dari=" + $('#tgl_dari').val() +
                "&sampai=" + $('#tgl_sampai').val() + "&pelanggan=" + $('#pelanggan').val() + "&debt=" + $('#debt').val();
    }
    function submittgl() {
        window.location = "?page=laporan&mode=lap_histori_setoran&dari=" + $('#tgl_dari').val() +
                "&sampai=" + $('#tgl_sampai').val();
    }
    function submitpelanggan() {
        window.location = "?page=laporan&mode=lap_histori_setoran&pelanggan=" + $('#pelanggan').val();
    }
    function submitdebt() {
        window.location = "?page=laporan&mode=lap_histori_setoran&debt=" + $('#debt').val();
    }
    $(document).ready(function () {
        $('#datepicker').datepicker(
            {orientation: "bottom auto", format: "dd-mm-yyyy", startView: 1, minViewMode: 1, autoclose: true}
        );
        $('.uang').inputmask('currency', {
            prefix: "Rp ",
            autoGroup: true,
            allowMinus: false,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#tgl_dari').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true,
        });
        $('#tgl_sampai').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true
        });
        $("#tgl_dari").on('change', function () {
            validasi();
        });
        $("#tgl_sampai").on('change', function () {
            validasi();
        });
    })
</script>
