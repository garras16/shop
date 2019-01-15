<?php
function limit_200($str){
    return substr($str, 0, 200);
}

function limit_text($str,$limit){
    return substr($str, 0, $limit). ' ...';
}

function tulis_log($log){
	$myfile = fopen("log.txt", "a") or die("Unable to open file!");
	fwrite($myfile, "\n". $log);
	fclose($myfile);
}
function strip_word_html($text, $allowed_tags = '<b><i><sup><sub><em><strong><u><br>')
    {
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if(mb_stripos($text, '/*') !== FALSE){
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if($num_matches){
              $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    } 
	
function _direct($to)
{
	echo "<script>window.location='".$to."'</script>";
}
function _alert($pesan)
{
	echo '<script>alert("' .$pesan. '")</script>';
	echo '<script>AndroidFunction.showToast("' .$pesan. '")</script>';
}
function _buat_pesan($pesan,$warna){
	$_SESSION['pesan']=$pesan;
	$_SESSION['warna']=$warna;
}
function _clearHistory()
{
	echo "<script>AndroidFunction.clearHistory();</script>";
}
function _clearAllHistory()
{
	echo "<script>AndroidFunction.clearAllHistory();</script>";
}

function format_uang($uang) {
	return number_format($uang, 2, ",", ".");
}
function format_angka($angka) {
	return number_format($angka, 0, ",", ".");
}
function format_bulan($angka) {
	$bulan="";
	switch($angka){
		case "01": $bulan="Januari"; break;
		case "02": $bulan="Februari"; break;
		case "03": $bulan="Maret"; break;
		case "04": $bulan="April"; break;
		case "05": $bulan="Mei"; break;
		case "06": $bulan="Juni"; break;
		case "07": $bulan="Juli"; break;
		case "08": $bulan="Agustus"; break;
		case "09": $bulan="September"; break;
		case "10": $bulan="Oktober"; break;
		case "11": $bulan="November"; break;
		case "12": $bulan="Desember"; break;
	}
	return $bulan;
}

function select_opsi($x, $y) {
	return ($x == $y ? 'selected' : '');
}

function get_real_ip() { 
    if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
        return $_SERVER["HTTP_X_FORWARDED"]; 
    } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_FORWARDED_FOR"]; 
    } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
        return $_SERVER["HTTP_FORWARDED"]; 
    } else {
        return $_SERVER["REMOTE_ADDR"]; 
    }
}

function getRef(){
	if (isset($_SERVER['HTTP_REFERER'])){
		$ref = $_SERVER['HTTP_REFERER'];
	} else {
		$ref = "UNKNOWN";
	}
	return $ref;
}

?>