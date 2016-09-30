<?php
require_once 'app_info.php';

// Lakukan CURL untuk get data dari server/API
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, 'http://your-server/service_to/update_information'); //ex: http://myapp.id/update
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1); 
$response = curl_exec($curl_handle);
curl_close($curl_handle);

// Tampung response kedalam variable result
$result = json_decode($response);

// Lakukan preg_replace untuk mengabaikan karakter selain angka, untuk yang berhubungan dengan penomoran versi agar perbandingan kedua versi pas
$php_recruitment = preg_replace('/[^0-9.].*/', '', $result->php_recruitment);
$php_version = preg_replace('/[^0-9.].*/', '', $appInfo['php_version']);
$update_version = preg_replace('/[^0-9.].*/', '', $result->update_version);
$curent_version = preg_replace('/[^0-9.].*/', '', $appInfo['curent_version']);

// Lakukan pengecekan, dengan rekruitmen utama yaitu status update pada server tersedia/available (bernilai TRUE)
if ($result->update_status == TRUE) 
{
	// Cek versi minimum php yang dibutuhkan dari versi updetan
	if ($php_recruitment > $php_version) 
	{
		echo "Versi terbaru ditemukan, namun membutuhkan php versi ".$result->php_recruitment.". Upgrade versi php anda";
	}

	if ($update_version == $curent_version) 
	{
		echo "Aplikasi/Sistem sudah dalam versi terbaru";
	}
	else
	{
		echo "Update sistem tersedia, versi sistem saat ini: ".$appInfo['curent_version'].". Update ke versi ".$result->update_version."<br><br>";
		echo '
			<form action="system_update.php" method="POST">
			<input name="file_name" type="hidden" value="'.$result->file_name.'">
			<button type="submit" name="update" value="'.$result->update_link.'">Update</button>
			<form>
		';
	}
} 
else 
{
	echo "Update tidak tersedia";
}

?>