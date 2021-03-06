<?php
if (isset($tambah_beli_detail_post)){
	$sql=mysqli_query($con, "INSERT INTO beli_detail VALUES(null,$id,$id_barang_supplier,$qty,$harga,0,$diskon_persen,$diskon_rp)");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=pembelian&mode=view_detail&id=" .$id);
}
if (isset($edit_beli_detail_post)){
	$sql=mysqli_query($con, "UPDATE beli_detail SET qty=$qty,harga=$harga,diskon_persen=$diskon_persen,diskon_rp=$diskon_rp WHERE id_beli_detail=$id_beli_detail");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=pembelian&mode=view_detail&id=" .$id);
}
if (isset($edit_diskon_nota_beli)){
	$sql=mysqli_query($con, "UPDATE beli SET diskon_all_persen=$diskon_all_persen WHERE id_beli=$id");
	_direct("?page=pembelian&mode=view_detail&id=" .$id);
}
$sql3=mysqli_query($con, "SELECT
    SUM((beli_detail.harga-beli_detail.diskon_rp) * barang_masuk_rak.qty_di_rak) AS total_datang
FROM
    beli_detail
    INNER JOIN beli 
        ON (beli_detail.id_beli = beli.id_beli)
    LEFT JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE beli.id_beli=$id");
$s=mysqli_fetch_array($sql3);
$sql2=mysqli_query($con, "SELECT diskon_all_persen,ppn_all_persen FROM beli WHERE id_beli=$id");
$row2=mysqli_fetch_array($sql2);
$diskon_all_persen=$row2['diskon_all_persen'];
$ppn_all_persen=$row2['ppn_all_persen'];
	$sql=mysqli_query($con, "SELECT *
FROM
    beli
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
    LEFT JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi) WHERE id_beli=$id");
	$row=mysqli_fetch_array($sql);
	$id_supplier=$row['id_supplier'];
	$diskon_nota=$row['diskon_all_persen']/100;
?>

<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>RINCIAN NOTA PEMBELIAN</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-info">
                            <strong>Klik kolom pada tabel untuk ubah.</strong>
                        </div>
                        <a href="?page=pembelian&mode=pembelian">
                            <button class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>
                                Kembali</button>
                        </a>
                        <div class="clearfix"></div><br/>

                        <form action="" method="post">
                            <input type="hidden" name="edit_pembelian_post" value="true">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw"></i>
                                    </span>
                                    <input
                                        class="form-control"
                                        id="tanggal"
                                        name="tanggal"
                                        type="date"
                                        value="<?php echo $row['tanggal']; ?>"
                                        readonly="readonly">
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-file fa-fw"></i>
                                    </span>
                                    <input
                                        id="no_nota"
                                        name="no_nota"
                                        class="form-control"
                                        placeholder="No Nota Beli"
                                        value="<?php echo $row['no_nota_beli']; ?>"
                                        maxlength="15"
                                        readonly="readonly">
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-building fa-fw"></i>
                                    </span>
                                    <input
                                        id="nama_supplier"
                                        name="nama_supplier"
                                        class="form-control"
                                        placeholder="Nama Supplier"
                                        value="<?php echo $row['nama_supplier']; ?>"
                                        readonly="readonly">
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="clearfix"></div><br/>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-truck fa-fw"></i>
                                    </span>
                                    <input
                                        id="nama_ekspedisi"
                                        name="nama_ekspedisi"
                                        class="form-control"
                                        placeholder="Nama Ekspedisi"
                                        value="<?php echo $row['nama_ekspedisi']; ?>"
                                        readonly="readonly">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-balance-scale fa-fw"></i>
                                    </span>
                                    <input
                                        class="form-control"
                                        placeholder="Berat Ekspedisi (gr)"
                                        value="<?php echo format_angka($row['berat_ekspedisi']); ?> gr"
                                        readonly="readonly">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-balance-scale fa-fw"></i>
                                    </span>
                                    <input
                                        class="form-control"
                                        placeholder="Volume Ekspedisi (cm3)"
                                        value="<?php echo format_angka($row['volume_ekspedisi']); ?> cm3"
                                        readonly="readonly">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-money fa-fw"></i>
                                    </span>
                                    <input
                                        class="form-control"
                                        placeholder="Tarif Ekspedisi (Rp)"
                                        value="Rp <?php echo format_uang($row['tarif_ekspedisi']); ?>"
                                        readonly="readonly">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <?php
					if ($_SESSION['posisi']=="DIREKSI" or $_SESSION['posisi']=="OWNER"){
						echo '<p align="right"><a data-toggle="modal" data-target="#myModal" data-id-beli="<?php echo $id ?>" data-id-supplier="<?php echo $id_supplier ?>" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah Data</a></p>';
					}
					?>
                        <div class="table responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Qty Beli</th>
                                        <th>Berat (gr)</th>
                                        <th>Volume (cm3)</th>
                                        <th>Harga Modal (Rp)</th>
                                        <th>Tot. Seb. Diskon (Rp)</th>
                                        <th>Diskon (%)</th>
                                        <th>Diskon (Rp)</th>
                                        <th>Tot. Set. Diskon (Rp)</th>
                                        <th>Tgl Datang</th>
                                        <th>Qty Datang</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT
    beli_detail.id_beli_detail
    , beli_detail.qty
    , beli_detail.harga
    , beli_detail.diskon_persen
    , beli_detail.diskon_rp
	, beli_detail.status_barang
    , barang_masuk.tgl_datang
	, barang_masuk.berat
    , barang_masuk.volume
	, SUM(barang_masuk_rak.qty_di_rak) AS qty_di_rak
    , barang.nama_barang
    , satuan.nama_satuan
FROM
    beli_detail
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
    LEFT JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail) 
	LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE
	beli_detail.id_beli=$id AND barang.status=1 
GROUP BY 
	beli_detail.id_beli_detail");
$berat=0;
$volume=0;
$jumlah=0;
while($row=mysqli_fetch_array($sql)){
$id_beli_detail=$row['id_beli_detail'];
$berat+=$row['berat'];
$volume+=$row['volume'];
$jumlah+=$row['qty']*($row['harga']-$row['diskon_rp']);

$val1="";$val2="";
($row['qty']!=$row['qty_di_rak'] ? $tgl_datang="BELUM LENGKAP" : $tgl_datang=date("d-m-Y", strtotime($row['tgl_datang'])));
($row['qty']!=$row['qty_di_rak'] ? $val="color: red; font-weight:bold" : $val="");
$sql2=mysqli_query($con, "SELECT * FROM barang_masuk WHERE id_beli_detail=$id_beli_detail");
	echo '			<tr>
						<td><div style="min-width:70px; ' .$val. '">' .$row['nama_barang']. '</div></td>';
	(mysqli_num_rows($sql2) > 0 ? $ada="1" : $ada="0");
	($row['qty_di_rak']=='' ? $datang='0' : $datang=$row['qty_di_rak']);
	
	if ($_SESSION['posisi']=="DIREKSI" or $_SESSION['posisi']=="OWNER" OR isset($tambah_pembelian_post)){
		echo '		<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_angka($row['qty']). ' ' .$row['nama_satuan']. '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_angka($row['berat']). '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_angka($row['volume']). '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_uang($row['harga']). '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_uang($row['qty']*$row['harga']). '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_uang($row['diskon_persen']). '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_uang($row['diskon_rp']). '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_uang($row['qty']*($row['harga']-$row['diskon_rp'])). '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .$tgl_datang. '</div></a></td>
					<td><a data-toggle="modal" data-target="#myModal2" data-qty="' .$row['qty']. '" data-sat="' .$row['nama_satuan']. '" data-ada="' .$ada. '" data-id="' .$row['id_beli_detail']. '" data-harga="' .$row['harga']. '" data-diskon="' .$row['diskon_persen']. '" data-datang="' .$datang. '"><div style="min-width:70px; ' .$val. '">' .format_angka($row['qty_di_rak']). ' ' .$row['nama_satuan']. '</div></a></td>';
	} else {
		echo '		<td><div style="min-width:70px; ' .$val. '">' .format_angka($row['qty']). ' ' .$row['nama_satuan']. '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_angka($row['berat']). '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_angka($row['volume']). '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_uang($row['harga']). '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_uang($row['qty']*$row['harga']). '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_angka($row['diskon_persen']). '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_uang($row['diskon_rp']). '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_uang($row['qty']*($row['harga']-$row['diskon_rp'])). '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .$tgl_datang. '</div></td>
					<td><div style="min-width:70px; ' .$val. '">' .format_angka($row['qty_di_rak']). ' ' .$row['nama_satuan']. '</div></td>';
	}
	
	if (mysqli_num_rows($sql2) > 0){
		echo '<td></td>';
	} else {
		if ($_SESSION['posisi']=="DIREKSI" or $_SESSION['posisi']=="OWNER" OR isset($tambah_pembelian_post)){
			echo '<td><a class="label label-warning" onClick="deleteRow(this,' .$row['id_beli_detail']. ')" ><i class="fa fa-trash"></i> HAPUS</a></td>';
		} else {
			echo '<td></td>';
		}
	}
	echo '				</tr>';
}
$ppn_all_rp=$jumlah*($ppn_all_persen/100);
$diskon_all_rp=$jumlah*($diskon_all_persen/100);
$jumlah=$jumlah+$ppn_all_rp;
?>

                                </tbody>
                            </table>
                            <div class="col-md-12">
                                <div class="col-md-6"></div>

                                <div class="col-md-6 text-right">
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width:200px;text-align:left;color:#000">
                                            <small>Berat Datang (gr)</small>
                                        </span>
                                        <input
                                            class="form-control"
                                            id="berat_2"
                                            name="berat"
                                            value="<?php echo format_angka($berat) ?>"
                                            readonly="readonly">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width:200px;text-align:left;color:#000">
                                            <small>Volume Datang (cm3)</small>
                                        </span>
                                        <input
                                            class="form-control"
                                            id="volume_2"
                                            name="volume"
                                            value="<?php echo format_angka($volume) ?>"
                                            readonly="readonly">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width:200px;text-align:left;color:#000">
                                            <small>Diskon Nota Beli (Rp)</small>
                                            <a title="Tidak mempengaruhi harga modal">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                        </span>
                                        <input
                                            class="form-control"
                                            id="diskon"
                                            name="total"
                                            value="<?php echo format_uang($diskon_all_rp) ?>"
                                            readonly="readonly">
                                        <span class="input-group-btn">
                                            <a data-toggle="modal" data-target="#myModal3" class="btn btn-primary">
                                                <span class="fa fa-edit"></span></a>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width:200px;text-align:left;color:#000">
                                            <small>PPN (Rp)</small>
                                        </span>
                                        <input
                                            class="form-control"
                                            id="diskon"
                                            name="total"
                                            value="<?php echo format_uang($ppn_all_rp) ?>"
                                            readonly="readonly">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width:200px;text-align:left;color:#000">
                                            <small>Tot. N.Beli Set. Disc & PPN (Rp)</small>
                                        </span>
                                        <input
                                            class="form-control"
                                            id="total_2"
                                            name="total"
                                            value="<?php echo format_uang($jumlah) ?>"
                                            readonly="readonly">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width:200px;text-align:left;color:#000">
                                            <small>Tot. Datang Set. Disc & PPN (Rp)</small>
                                        </span>
                                        <input
                                            class="form-control"
                                            id="total_2"
                                            name="total"
                                            value="<?php echo format_uang($s['total_datang']) ?>"
                                            readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dummy"></div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Tambah Data Detail Pembelian</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="tambah_beli_detail_post" value="true">
                    <div id="add_beli_detail" class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-archive fa-fw"></i>
                            </span>
                            <select
                                id="select_barang"
                                class="form-control select2"
                                name="id_barang_supplier"
                                required="required">
                                <option value="" disabled="disabled" selected="selected">Pilih Barang</option>
                                <?php
$sql=mysqli_query($con, "SELECT
    barang_supplier.id_barang_supplier
    , barang.nama_barang
	, satuan.nama_satuan
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang) 
	INNER JOIN satuan
		ON (satuan.id_satuan=barang.id_satuan)
WHERE 
	barang_supplier.id_supplier=$id_supplier");
								while($row=mysqli_fetch_array($sql)){
									echo '<option data-satuan="' .$row['nama_satuan']. '" value="' .$row['id_barang_supplier']. '">' .$row['nama_barang']. '</option>';
								}
							?>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-shopping-cart fa-fw"></i>
                            </span>
                            <input
                                id="qty_2"
                                name="qty"
                                type="text"
                                class="form-control"
                                placeholder="Qty Beli"
                                required="required">
                            <span class="input-group-addon" id="satuan"></span>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-dollar fa-fw"></i>
                            </span>
                            <input
                                class="form-control"
                                id="harga_2"
                                name="harga"
                                type="text"
                                placeholder="Harga Modal (Rp)"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div style="min-width:70px;text-align:left">Diskon Barang (%)</div>
                            </span>
                            <input
                                class="form-control"
                                id="diskon_persen_2"
                                name="diskon_persen"
                                type="text"
                                placeholder="Diskon"
                                value="0"
                                required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="myModal2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Ubah Data Detail Pembelian</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" onsubmit="return cek_valid()">
                    <input type="hidden" name="edit_beli_detail_post" value="true">
                    <input type="hidden" id="id_beli_detail" name="id_beli_detail" value="">
                    <input type="hidden" id="ada" value="">
                    <input type="hidden" id="datang" value="">
                    <div id="add_beli_detail" class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-shopping-cart fa-fw"></i>
                            </span>
                            <input
                                id="qty"
                                name="qty"
                                type="text"
                                class="form-control"
                                placeholder="Qty Beli"
                                required="required">
                            <span class="input-group-addon" id="satuan_2"></span>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-dollar fa-fw"></i>
                            </span>
                            <input
                                class="form-control"
                                id="harga"
                                name="harga"
                                type="text"
                                placeholder="Harga Modal (Rp)"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div style="min-width:18px;text-align:left">%</div>
                            </span>
                            <input
                                class="form-control"
                                id="diskon_persen"
                                name="diskon_persen"
                                type="text"
                                placeholder="Diskon"
                                value="0"
                                required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal input -->
<div id="myModal3" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Ubah Data Diskon Nota Beli</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="edit_diskon_nota_beli" value="true">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-cut fa-fw"></i>
                        </span>
                        <input
                            type="number"
                            id="diskon_nota_persen"
                            name="diskon_all_persen"
                            class="form-control"
                            placeholder="Diskon Nota Beli (%)"
                            title="Diskon Nota Beli (%)"
                            value="<?php echo $diskon_nota*100 ?>"
                            min="0"
                            max="100">
                        <span class="input-group-addon">%</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-cut fa-fw"></i>
                        </span>
                        <input
                            id="diskon_nota_rp"
                            class="form-control"
                            placeholder="Diskon Nota Beli (Rp)"
                            title="Diskon Nota Beli (Rp)"
                            value="<?php echo $diskon_all_rp ?>"
                            readonly="readonly">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteRow(r, ID) {
        $('#dummy').load(
            'assets/page/pembelian/del-beli-detail.php?id-beli=<?php echo $id ?>&id=' +
            ID + '&mode=<?php echo $_GET['mode'] ?>'
        );
        // var i = r.parentNode.parentNode.rowIndex;
        // document.getElementById("table1").deleteRow(i);
    }
    function cek_valid() {
        var qty = Number($('#qty').val());
        var ada = $('#ada').val();
        var datang = Number($('#datang').val());
        if (ada == '1') {
            if (qty >= datang) {
                return true;
            } else {
                alert("Qty Beli tidak boleh kurang dari Qty Datang");
                return false;
            }
        } else {
            return true;
        }
    }
    $(document).ready(function () {
        $('#ekspedisi').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#qty').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#berat').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#volume').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#harga').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#qty_2').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#harga_2').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#diskon_persen').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#diskon_persen_2').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#diskon_nota_rp').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $(".select2").select2(
            {placeholderOption: "first", allowClear: true, width: '100%'}
        );
        $('#select_barang').on('change', function () {
            var sat = $(this)
                .find(":selected")
                .data('satuan');
            $('#satuan').html(sat);
        })
        $('#myModal2').on('show.bs.modal', function (e) {
            var qty = $(e.relatedTarget).data('qty');
            var ada = $(e.relatedTarget).data('ada');
            var datang = $(e.relatedTarget).data('datang');
            var sat = $(e.relatedTarget).data('sat');
            var id = $(e.relatedTarget).data('id');
            var harga = $(e.relatedTarget).data('harga');
            var diskon = $(e.relatedTarget).data('diskon');
            $('#qty').val(qty);
            $('#ada').val(ada);
            $('#datang').val(datang);
            $('#satuan_2').html(sat);
            $('#id_beli_detail').val(id);
            $('#harga').val(harga);
            $('#diskon_persen').val(diskon);
        })
        $('#diskon_nota_persen').on('input', function () {
            rp = Number($('#diskon_nota_persen').val() / 100 * <?php echo $jumlah ?>);
            $('#diskon_nota_rp').val(rp);
        });
    });
</script>