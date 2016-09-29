<?php
/**
 * Update file pada aplikasi/sistem berbasis php
 * 
 * @author: Ramadhan Sutejo
 * @version: 1.0
 * @http://blog.binadarma.ac.id/ramadhansutejo
 * 
 * @ate:   2016-09-29 17:07:33
 * @Last Modified by:   ramadhansutejo
 * @Last Modified time: 2016-09-29 18:59:22
 */

class CfnPHPUpdater extends ZipArchive
{
	/**
	 * The constructor for the class
	 *
	 */

	function __construct()
	{
		$this->path = getcwd() . "/";
	}

	/**
	 * Fungsi download file update
	 *
	 * @param string $download_link
	 * @param string $local_file_name
	 * @param string $downloading_message
	 * @return downloaded, message
	 */

	private function downloading($download_link, $local_file_name, $downloading_message)
	{
		$file_data = file_get_contents($download_link);		 
		$handle = fopen($local_file_name, 'w');
		fclose($handle);		 
		$downloaded = file_put_contents($local_file_name, $file_data);

		$returnData = array(
			'downloaded' => $downloaded, 
			'message' => $downloading_message.'...<br>', 
		);

		return $returnData;
	}

	/**
	 * Fungsi ekstrak dan install file update
	 *
	 * @param int $downloaded
	 * @param string $local_file_name
	 * @param string $error_downloading_message
	 * @param string $extracting_message
	 * @param string $error_extracting_message
	 * @return status, message
	 */

	private function installing($downloaded, $local_file_name, $error_downloading_message, $extracting_message, $error_extracting_message)
	{
		if ($downloaded > 0) 
		{
			if ($this->open($local_file_name) === TRUE) 
			{
				$path = str_replace("\\","/",$this->path);
				for ($i=0; $i < $this->numFiles; $i++) 
				{
					$this->extractTo($path, array($this->getNameIndex($i)));
				}
				$this->close();
				$status = TRUE;
				$message = $extracting_message;
			}
			else 
			{
				$status = FALSE;
				$message = $error_extracting_message;
			}
		}
		else 
		{
			$status = FALSE;
			$message = $error_downloading_message;
		}
		

		$returnData = array(
			'status' => $status, 
			'message' => $message.'...<br>', 
		);

		return $returnData;
	}

	/**
	 * Fungsi utama, untuk melakukan updating file
	 *
	 * @param string $local_file_name
	 * @param string $download_link
	 * @param int $usleep
	 * @param string $message_update
	 * @param string $message_no_update
	 * @return message
	 */

	public function doUpdate($local_file_name, $download_link, $usleep, $message_update, $message_no_update)
	{
		// Proses Download
		$downloading = $this->downloading($download_link, $local_file_name, $message_update['downloading_message']);
		echo $downloading['message'];
		usleep($usleep);

		// Proses Install
		$installing = $this->installing($downloading['downloaded'], $local_file_name, $message_update['error_downloading_message'], $message_update['extracting_message'], 
			$message_update['error_extracting_message']);
		echo $installing['message'];
		usleep($usleep);

		// Proses Finishing & Cleaning file update
		if ($installing['status'] == FALSE) 
		{
			echo $message_no_update['error'].'...<br>';
			usleep($usleep);
		} 
		else 
		{
			unlink($local_file_name);
			echo $message_update['success_update_message'];
			usleep($usleep);
		}
	}
}