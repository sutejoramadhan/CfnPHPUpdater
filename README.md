# CfnPHPUpdater
PHP System Updater atau PHP Auto Updater, untuk membuat fitur Update pada aplkasi/sistem berbasis PHP

## INSTALASI
- Download [CfnPHPUpdater](https://github.com/sutejoramadhan/CfnPHPUpdater/archive/master.zip)
- Extract ke folder htdocs atau www atau public_html (folder web server anda)

## CONTOH

## Server
Buat file yang berfungsi sebagai service untuk cek info tentang update yang available, seperti berikut :

```php
<?php
/**
 * @Author: ramadhansutejo
 * @Date:   2016-09-29 11:16:09
 * @Last Modified by:   ramadhansutejo
 * @Last Modified time: 2016-09-29 18:49:37
 */

$releaseDir = 'http://your-server/dir/file';
$appName = 'demo-app-';
$appVersion = '1.1';

$updateVar = array(
	'update_status' => TRUE,
	'php_recruitment' => '5.4.45',
	'db_update' => FALSE, 
	'update_link' => $releaseDir.'/'.$appName.$appVersion.'.zip',
	'update_version' => $appVersion,
	'file_name' => $appName.$appVersion.'.zip',
);

echo json_encode($updateVar);
```

## Client
Jika sudah mengikuti tahap instalasi di atas, kamu hanya perlu menyesuaikan parameter pada file system_update.php. Inti dari fitur sederhana ini ada pada class CfnPHPUpdater.php. Penggunaannya :

```php
require_once 'CfnPHPUpdater.php';
$do_update = new CfnPHPUpdater;
$do_update->doUpdate(1, 2, 3, 4, 5);
```
1. Nama file update-an yang sudah di kompresi (zip)
2. Link download update
3. waktu jeda tiap proses pada class (mikro detik)
4. string-string pesan yang akan muncul untuk tiap proses updating (array)
5. string error yang akan muncul ketika proses updating gagal (array) 

## Catatan
Fitur simpel ini belum sepeuhnya sempurna, dan mungkin ada yang perlu disesuaikan dari segi kebutuhan ataupun teknologi yang digunakan (read: framework, client/server OS). Dengan senang hati jika ada yang bersedia untuk berkontribusi.
