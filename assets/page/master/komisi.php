<?php
if (isset($tambah_komisi_post)){
	_direct("?page=komisi&mode=view_add&id=" .$id_karyawan);
}

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>MASTER KOMISI SALES</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-info">
                            <strong>Klik kolom pada tabel untuk detail.</strong>
                        </div>
                        <p align="right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                                Tambah Komisi</button>
                        </p>

                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Karyawan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT
    karyawan.id_karyawan
    , karyawan.nama_karyawan
FROM
    komisi
    INNER JOIN karyawan 
        ON (komisi.id_karyawan = karyawan.id_karyawan)
    INNER JOIN jabatan 
        ON (karyawan.id_jabatan = jabatan.id_jabatan) 
WHERE 
	jabatan.nama_jabatan='SALES' AND karyawan.status=1 
GROUP BY komisi.id_karyawan
ORDER BY id_komisi DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
	echo '			<tr>
						<td><a href="?page=komisi&mode=view_detail&id=' .$row['id_karyawan']. '">' .$i. '</a></td>
						<td><a href="?page=komisi&mode=view_detail&id=' .$row['id_karyawan']. '">' .$row['nama_karyawan']. '</a></td>
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

<!-- modal input -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Tambah Data Komisi</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="tambah_komisi_post" value="true">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-user fa-fw"></i><br>
                                <small>Karyawan</small>
                            </span>
                            <select
                                class="select2 form-control"
                                id="select_karyawan"
                                name="id_karyawan"
                                required="required">
                                <option value="" disabled="disabled" selected="selected">Pilih Karyawan</option>
                                <?php 
								$brg=mysqli_query($con, "SELECT
    karyawan.id_karyawan
    , karyawan.nama_karyawan
FROM
    karyawan 
    INNER JOIN jabatan 
        ON (karyawan.id_jabatan = jabatan.id_jabatan) 
WHERE jabatan.nama_jabatan='SALES' AND karyawan.status=1 AND id_karyawan NOT IN (SELECT DISTINCT id_karyawan FROM komisi)");
								while($b=mysqli_fetch_array($brg)){
							?>
                                <option value="<?php echo $b['id_karyawan']; ?>"><?php echo $b['nama_karyawan'];?></option>
                                <?php 
								}
							?>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
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