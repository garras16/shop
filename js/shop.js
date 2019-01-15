function format_uang(n) {
	return "Rp " + Number(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
function format_angka(n) {
	return Number(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");;
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
		"bPaginate": false,
		"bLengthChange": false,
//		"ordering": false,
		"scrollX": true
	});
	$(".select2").select2({
		placeholderOption: "first",
		width: '100%'
	});
	$('.modal').on('hidden.bs.modal', function(e){
		$(".select2").val($(".select2 option:first-child").val()).trigger('change');
		$("input[type='text']").val('');
		$("input[type='number']").val('');
		$("input[type='tel']").val('');
		$(".select").val('');
		$(".tagsinput .tag").remove();
		$("#tagsinput input").val();	
	});
	$(document).on('focus', ':input', function() {
		$(this).attr('autocomplete', 'off');
	});
});