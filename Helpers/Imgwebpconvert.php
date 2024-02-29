<?php
	/* Путь до корневой директории сайта */
$base_dir = __DIR__;
 
if (!empty($_SERVER['REQUEST_URI']) && !is_file($base_dir . $_SERVER['REQUEST_URI'])) {
	/* Разбор полученного URL */
	$url = explode('?', trim($_SERVER['REQUEST_URI'], '/'));
	$new = $base_dir . '/' . $url[0]; 
	$file = preg_replace('/\.webp$/', '', $new); 
 
	// Поиск оригинального файла (png или jpg), с учетом регистра.
	$src = '';
	foreach (array('PNG', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG', 'png') as $row) {
		if (is_file($file . '.' . $row)) {
			$src = $file . '.' . $row;
			break;
		}
	}
 
	// Преобразование
	if (!empty($src)) {
		$img = false;
		$info = getimagesize($src);
		switch ($info[2]) { 				
			case 2: 	
				$img = imageCreateFromJpeg($src);
				imageWebp($src, $new, 100);
				imagedestroy($img);
				break;
			case 3:
				$img = imageCreateFromPng($src);
				imagepalettetotruecolor($img);
				imagealphablending($img, true);
				imagesavealpha($img, true);
				imageWebp($img, $new, 100);
				imagedestroy($img);		
				break;
		}
 
 
		if ($img) {
			//fix for corrupted WEBPs
			if (filesize($new) % 2 == 1) {
				file_put_contents($new, "\0", FILE_APPEND);
			}	
			
			// Вывод webp в браузер
			header('Content-Length: ' . filesize($new));
			readfile($new);	
			exit();
		}
	}
}
 
header('HTTP/1.0 404 Not Found');
exit();
?>