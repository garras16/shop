<?php
$id_karyawan=$_SESSION['id_karyawan'];
?>
<style type="text/css">
    #table1 tr td {
        width: 150px;
    }
</style>
<div class="right_col loading" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6">
                            <h3>RIWAYAT PENAGIHAN</h3>
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

                    </div>
                        <!--<div class="col-xs-12" style="text-align:left">
                            <input
                                type="text"
                                id="datepicker"
                                placeholder="Bulan & Tahun Tagih"
                                style="width:150px"
                                value="<?php if (isset($_GET['tanggal'])) echo $_GET['tanggal'] ;?>"
                                readonly="readonly"></input>
                            <input
                                type="text"
                                id="cari_debt"
                                name="cari_debt"
                                placeholder="Debt Collector"
                                style="width:100px"
                                value="<?php if (isset($_GET['debt'])) echo $_GET['debt'] ;?>"></input>
                            <input
                                type="text"
                                id="cari_pelanggan"
                                name="cari_pelanggan"
                                placeholder="Pelanggan"
                                style="width:100px"
                                value="<?php if (isset($_GET['pelanggan'])) echo $_GET['pelanggan'] ;?>"></input>
                            <input type="button" id="cari" onclick="cari_debt_pelanggan()" value="Cari"></input>
                            <input type="button" id="reset" onclick="reset()" value="Reset"></input>
                        </div> -->
                        <div class="clearfix"></div><br>
                        <div class="table-responsive">
                            <table
                                id="table1"
                                class="table table-bordered table-striped"
                                style="min-width: 2050px;">
                                <thead>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>No Nota Jual</th>
                                        <th>Jumlah Jual</th>
                                        <th>Sales</th>
                                        <th>Driver</th>
                                        <th>Debt Collector</th>
                                        <th>Tgl Tagih</th>
                                        <th>Jumlah Tagih</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Sisa Piutang</th>
                                        <th>Tgl Kunjungan Berikutnya</th>
                                        <th>Status Bayar</th>
                                        <th>Status Kembali Nota</th>
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

// if (isset($_GET['pelanggan']) && $_GET['pelanggan']!=''){
// 	$val.=" AND pelanggan.nama_pelanggan LIKE '%" .$_GET['pelanggan']. "%'";
// }
// if (!isset($_GET['tanggal']) && !isset($_GET['debt']) && !isset($_GET['pelangan'])){
// 	$val=" AND tanggal_tagih BETWEEN NOW() - INTERVAL 3 MONTH AND NOW()";
// }
	$sql=mysqli_query($con, "SELECT *
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
WHERE penagihan.id_penagihan>0 $val
GROUP BY jual.id_jual");
while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT (qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    jual_detail
    INNER JOIN nota_siap_kirim_detail
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
$total_jual=0;
	while ($row2=mysqli_fetch_array($sql2)){
		$total_jual+=$row2['total'];
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
	if ($row['tgl_janji_next']!=''){
		$tglx1=strtotime($row['tgl_janji_next']);
		$tglx2=strtotime(date('Y-m-d'));
		($tglx1>=$tglx2 ? $color2='red' : $color2='black');
	} else {
		$color2='black';
	}
	$sql3=mysqli_query($con, "SELECT nama_karyawan FROM jual INNER JOIN karyawan ON (jual.id_karyawan = karyawan.id_karyawan) WHERE id_jual=" .$row['id_jual']);
	$row3=mysqli_fetch_array($sql3);
	$nama_sales=$row3['nama_karyawan'];
	$sql3=mysqli_query($con, "SELECT nama_karyawan FROM pengiriman INNER JOIN karyawan ON (pengiriman.id_karyawan = karyawan.id_karyawan) WHERE id_jual=" .$row['id_jual']);
	$row3=mysqli_fetch_array($sql3);
	$nama_driver=$row3['nama_karyawan'];

	echo '<tr>
			<td align="center" style="width: 400px;">' .$row['nama_pelanggan']. '</td>
			<td align="center" style="width: 300px;">' .$row['invoice']. '</td>
			<td align="center" style="width: 300px;" class="uang">' .$total_jual. '</td>
			<td align="center" style="width: 300px;">' .$nama_sales. '</td>
			<td align="center" style="width: 300px;">' .$nama_driver. '</td>
			<td align="center" style="width: 300px;">' .$row['nama_karyawan']. '</td>
			<td align="center" style="width: 200px;">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</td>
			<td align="center" style="width: 400px;" class="uang">' .$total_jual. '</td>
			<td align="center" style="width: 400px;" class="uang">' .$row['bayar']. '</td>
			<td align="center" style="width: 400px;" class="uang">' .($total_jual-$row['bayar']). '</td>
			<td align="center" style="color: ' .$color2. ' ;width: 700px;">' .$tgl_jb. '</td>
			<td align="center" style="color: ' .$color. ' ;width: 300px;">' .$status. '</td>
			<td align="center" style="width: 670px;">' .$status_nota. '</td>
		</tr>';
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
        var url = "?page=laporan&mode=lap_histori_penagihan&tanggal=" + tanggal + "&deb" +
                "t=" + debt + "&pelanggan=" + pelanggan;
        if (debt != '' || pelanggan != '' || tanggal != '')
            window.location = url;
        }
    function reset() {
        var url = "?page=laporan&mode=lap_histori_penagihan";
        window.location = url;
    }
    function submit() {
        window.location = "?page=laporan&mode=lap_histori_penagihan&dari=" + $('#tgl_dari').val() +
                "&sampai=" + $('#tgl_sampai').val() + "&pelanggan=" + $('#pelanggan').val() + "&debt=" + $('#debt').val();
    }
    function submittgl() {
        window.location = "?page=laporan&mode=lap_histori_penagihan&dari=" + $('#tgl_dari').val() +
                "&sampai=" + $('#tgl_sampai').val();
    }
    function submitpelanggan() {
        window.location = "?page=laporan&mode=lap_histori_penagihan&pelanggan=" + $('#pelanggan').val();
    }
    function submitdebt() {
        window.location = "?page=laporan&mode=lap_histori_penagihan&debt=" + $('#debt').val();
    }
    $(document).ready(function () {
        $('#datepicker').datepicker(
            {orientation: "bottom auto", format: "mm-yyyy", startView: 1, minViewMode: 1, autoclose: true}
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
