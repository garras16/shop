function format_uang(n) {
	return Number(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
function get_global_tanggal(tanggal){
	var tgl=tanggal.split("-")[0];
	var bln=tanggal.split("-")[1];
	var thn=tanggal.split("-")[2];
	return thn + "-" + bln + "-" + tgl;
}

$(document).ready(function(){
    $("#table1").DataTable({
		"pageLength": 30,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false,
		"ordering": true,
		"scrollX": false,
		"aaSorting": []
	});
	$("#table2").DataTable({
		"pageLength": 30,
		"bPaginate": true,
		"bLengthChange": false,
		"responsive": true
	});
	//mobile
	$("#table3").DataTable({
		"pageLength": 30,
		"bPaginate": true,
		"bLengthChange": false,
		"autoWidth": true,
//		"ordering": false,
		"scrollX": true
	});
	$(".select2").select2({
		placeholderOption: "first",
		width: '100%'
	});
});