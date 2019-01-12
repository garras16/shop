<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>PESAN</h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="alert alert-info">
                        <strong>Klik kolom pada tabel untuk detail.</strong>
                    </div>
                    <table id="table1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pesan</th>
                                <th>Judul</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$sql=mysqli_query($con, "SELECT * FROM pesan WHERE id_karyawan=" .$_SESSION['id_karyawan']. " ORDER BY id_pesan DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
if ($row['status_pesan']=='0'){$status='BELUM DIBACA'; $style='badge bg-red';}
if ($row['status_pesan']=='1'){$status='TERBACA'; $style='badge bg-green';}
	echo '<tr>
            <td align="center"><a href="?page=pesan&mode=pesan_detail&id=' .$row['id_pesan']. '"><div style="min-width:70px">' .$i. '</div></a></td>
            <td><a href="?page=pesan&mode=pesan_detail&id=' .$row['id_pesan']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row['tanggal'])). '</div></a></td>
            <td><a href="?page=pesan&mode=pesan_detail&id=' .$row['id_pesan']. '"><div style="min-width:70px">' .$row['judul']. '</div></a></td>
            <td><a href="?page=pesan&mode=pesan_detail&id=' .$row['id_pesan']. '"  class="' .$style. '"><div style="min-width:70px">' .$status. '</div></a></td>';
	echo '</tr>';
}
?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

</div>
</div>

<script>
$(document).ready(function () {});
</script>