<?php
if (isset($edit_barang_post)){
	$sql=mysqli_query($con, "UPDATE barang SET barcode='$barcode',nama_barang='$nama',satuan='$satuan',no_ijin='$ijin',min_order='$min_order',stok_minimal=$stok_minimal,status='$status' WHERE id_barang='$id'");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("index.php?page=master&mode=barang");
}
	$sql=mysqli_query($con, "SELECT * FROM barang WHERE id_barang=$id");
	$row=mysqli_fetch_array($sql);
?>

<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <h3>UBAH BARANG</h3>
            <?php
			if (isset($pesan)){
				echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
			}
			?>
            <a href="?page=barang" class="btn btn-danger">
                <i class="fa fa-arrow-left"></i>
                Kembali</a>
            <form action="" method="post">
                <input type="hidden" name="edit_barang_post" value="true">
                <div class="form-group col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-bookmark fa-fw"></i>
                        </span>
                        <input
                            class="form-control"
                            id="nama_barang"
                            name="nama_barang"
                            value="<?php echo $row['nama_barang']; ?>"
                            maxlength="100"
                            required="required">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-barcode fa-fw"></i>
                        </span>
                        <input
                            id="barcode"
                            name="barcode"
                            class="form-control"
                            placeholder="Barcode"
                            value="<?php echo $row['barcode']; ?>"
                            maxlength="30"
                            required="required">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-tag fa-fw"></i>
                        </span>
                        <select
                            class="form-control"
                            id="select_satuan"
                            name="satuan"
                            required="required">
                            <?php 
							$brg=mysqli_query($con, "select * from satuan");
							while($b=mysqli_fetch_array($brg)){
						?>
                            <option
                                value="<?php echo $b['nama_satuan']; ?>"
                                <?php echo ($b['nama_satuan'] == $row['satuan'] ? 'selected' : '') ?>><?php echo $b['nama_satuan'];?></option>
                            <?php 
							}
						?>
                        </select>
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-warning fa-fw"></i>
                        </span>
                        <input
                            id="min_order"
                            name="min_order"
                            class="form-control"
                            placeholder="Minimal Jual"
                            min="1"
                            onkeypress="if(this.value.length==3) return false;"
                            value="<?php echo $row['min_order']; ?>"
                            type="number"
                            required="required">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-warning fa-fw"></i>
                        </span>
                        <input
                            id="min_order"
                            name="stok_minimal"
                            class="form-control"
                            placeholder="Stok Minimal"
                            min="1"
                            onkeypress="if(this.value.length==3) return false;"
                            value="<?php echo $row['min_order']; ?>"
                            type="number"
                            required="required">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-certificate fa-fw"></i>
                        </span>
                        <input
                            id="ijin"
                            name="ijin"
                            class="form-control"
                            placeholder="No. Ijin"
                            value="<?php echo $row['no_ijin']; ?>"
                            maxlength="25"
                            required="required">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-flag fa-fw"></i>
                        </span>
                        <select
                            class="form-control"
                            id="select_status"
                            name="status"
                            required="required">
                            <option value="" disabled="disabled">Pilih Status</option>
                            <option value="0" <?php echo ($row['status'] == 0 ? 'selected' : '') ?>>NON AKTIF</option>
                            <option value="1" <?php echo ($row['status'] == 1 ? 'selected' : '') ?>>AKTIF</option>
                        </select>
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="post_jual" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>