<?php
require_once 'CfnPHPUpdater.php';

if (isset($_POST['update'])) 
{
	$message_update = array(
		'downloading_message' => 'Mendownload versi terbaru', 
		'error_downloading_message' => 'Gagal mendownload versi terbaru', 
		'extracting_message' => 'Mengekstrak dan menginstall', 
		'error_extracting_message' => 'Terjadi kesalahan saat meng-ekstrak file', 
		'success_update_message' => 'Berhasil update ke versi terbaru', 
	);

	$message_no_update = array(
		'error' => 'Gagal melakukan update', 
	);

	$do_update = new CfnPHPUpdater;

	$do_update->doUpdate($_POST['file_name'], $_POST['update'], 500000, $message_update, $message_no_update);
} 
else 
{
	echo 'Forbidden!!';
}

