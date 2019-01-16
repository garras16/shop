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
                            <h3>HISTORI PENAGIHAN</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-xs-12" style="text-align:left">
                            <input
                                type="text"
                                id="datepicker"
                                placeholder="Bulan & Tahun"
                                style="width:100px"
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
                        </div>
                        <div class="clearfix"></div><br>
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tgl Tagih</th>
                                        <th>Total Nilai Tagihan (Rp)</th>
                                        <th>Debt Collector</th>
                                        <th>Total Bayar (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
									$val="";
									if (isset($_GET['tanggal']) && $_GET['tanggal']!=''){
										$tgl = explode("-", $_GET['tanggal']);
										$bln = $tgl[0];	$thn = $tgl[1];
										$val.=" AND MONTH(tanggal_tagih)=$bln AND YEAR(tanggal_tagih)=$thn";
									}
									if (isset($_GET['debt']) && $_GET['debt']!=''){
										$val.=" AND karyawan.nama_karyawan LIKE '%" .$_GET['debt']. "%'";
									}
									if (isset($_GET['pelanggan']) && $_GET['pelanggan']!=''){
										$val.=" AND pelanggan.nama_pelanggan LIKE '%" .$_GET['pelanggan']. "%'";
									}
									if (!isset($_GET['tanggal']) && !isset($_GET['debt']) && !isset($_GET['pelangan'])){
										$val="AND status_tagih<>2";
									}
									$sql=mysqli_query($con, "SELECT *,SUM(bayar) AS bayar
									FROM
								    	penagihan
								    INNER JOIN karyawan 
								        ON (penagihan.id_karyawan = karyawan.id_karyawan)
								    INNER JOIN penagihan_detail 
								        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
									INNER JOIN jual 
								        ON (penagihan_detail.id_jual = jual.id_jual)
									INNER JOIN pelanggan 
								        ON (pelanggan.id_pelanggan = jual.id_pelanggan)
									WHERE penagihan.id_penagihan>0 $val
									GROUP BY penagihan.id_penagihan");

									while ($row=mysqli_fetch_array($sql)){
										($row['status_konfirm']>=0 && $row['status_konfirm']<=4 ? $tipe="dalam_kota" : $tipe="canvass");
									
										if ($tipe=="dalam_kota"){
											$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp)) AS total
											FROM
								    			penagihan
										    INNER JOIN penagihan_detail 
										        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
										    INNER JOIN jual_detail 
										        ON (penagihan_detail.id_jual = jual_detail.id_jual)
										    INNER JOIN nota_siap_kirim_detail 
										        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
											WHERE penagihan.id_penagihan=" .$row['id_penagihan']);
										} else {
											$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp)) as total
											FROM
								    			penagihan
										    INNER JOIN penagihan_detail 
										        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
										    INNER JOIN jual_detail 
										        ON (penagihan_detail.id_jual = jual_detail.id_jual)
										    INNER JOIN canvass_siap_kirim_detail 
										        ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail);
											WHERE penagihan.id_penagihan=" .$row['id_penagihan']);
										}
										$total_jual=0;
										while ($row2=mysqli_fetch_array($sql2)){
											$total_jual+=$row2['total'];
										}
										$tgl_jt=date('Y/m/d',strtotime($row["tgl_nota"]. '+' .$row['tenor']. ' days'));
										($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
										echo '<tr>
												<td align="center"><a href="?page=laporan&mode=lap_histori_penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</div></a></td>
												<td align="center"><a href="?page=laporan&mode=lap_histori_penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px" class="uang">' .$total_jual. '</div></a></td>
												<td align="center"><a href="?page=laporan&mode=lap_histori_penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
												<td align="center"><a href="?page=laporan&mode=lap_histori_penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px" class="uang">' .$row['bayar']. '</div></a></td>
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
    $(document).ready(function () {
        $('.uang').inputmask('currency', {
            prefix: "Rp ",
            autoGroup: true,
            allowMinus: false,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#datepicker').datepicker(
            {orientation: "bottom auto", format: "mm-yyyy", startView: 1, minViewMode: 1, autoclose: true}
        );
    })
</script>