<?php
	class UploadHelper {

        protected $path;
        protected $tmp_path;
        protected $types;
        protected $size;

        public static function UploadOneImage ($folder, $file_array = array(), $filename = '') {
            $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm", ".txt", ".zip", ".rar", ".css");
            foreach ($blacklist as $item) {
                if(preg_match("/$item\$/i", $file_array['name'])) return 'Error image format';
            }

            $type = $file_array['type'];
            $size = $file_array['size'];
            
            $extension = pathinfo($file_array['name'], PATHINFO_EXTENSION);
            if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png") && $extension != 'pdf') return false;
            if ($size > 20480000) return 'Error image size';

            if (!file_exists("Media/images/".$folder."/")) mkdir("Media/images/".$folder."/");
            
            if ($extension == 'pdf') $format = '.pdf';
            else $format = '.jpg';
            
            if($filename != '') $filename = $filename.$format;
            else $filename = $file_array['name'].$format;
            //$apend = date('YmdHis').rand(100,1000).'.png';
            
            $images = "Media/images/".$folder."/".$filename;
            
            move_uploaded_file($file_array['tmp_name'], $images);
            
            if ($extension != 'pdf') {
                $webp = self::webpConvert2($images);
                return $webp;
            } else return $images;
            /*if(move_uploaded_file($file_array['tmp_name'], $images)){
                self::resize_photo("Media/images/".$folder."/", $filename, $file_array['size'], $file_array['type'], $file_array['tmp_name']);
            }*/
        }

        public static function UploadMoreImages ($folder, $file_array = array()) {
            if (isset($file_array)) {
                $images = array();

                if (!file_exists("Media/images/".$folder."/")) mkdir("Media/images/".$folder."/");

                foreach ($file_array['name'] as $k=>$v) {
                    $uploaddir = "Media/images/".$folder."/";
                    $apend = date('YmdHis').rand(100,1000).'.png';
                    $uploadfile = $uploaddir.$apend;

                    if($file_array['type'][$k] == "image/gif" || $file_array['type'][$k] == "image/png" ||
                    	$file_array['type'][$k] == "image/jpg" || $file_array['type'][$k] == "image/jpeg") {
                        $blacklist = array(".php", ".phtml", ".php3", ".php4");

                        foreach ($blacklist as $item) {
                            if(preg_match("/$item\$/i", $file_array['name'][$k])) {
                            return 'Error black list';
                            }
                        }
                        
                        move_uploaded_file($file_array['tmp_name'][$k], $uploadfile);
                        $images[] = $this->webpConvert2($uploadfile);
                        
                        /*if(move_uploaded_file($file_array['tmp_name'][$k], $uploadfile)) {
                            self::resize_photo($uploaddir, $apend, $file_array['size'][$k], $file_array['type'][$k], $file_array['tmp_name'][$k]);
                        } else return 'Error problem upload';*/
                    } else return 'Error image format';
                }
                return serialize($images);
            }
        }

        public static function uploadImgDoc ($folder, $file_array = array()) {

            $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm", ".txt", ".zip", ".rar");
            foreach ($blacklist as $item) {
                if(preg_match("/$item\$/i", $file_array['name'])) return 'Error image format';
            }

            $type = $file_array['type'];
            $size = $file_array['size'];

            if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png") && ($type != "application/pdf")) return 'Error image type';
            if ($size > 20480000) return 'Error image size';

            if (!file_exists("Media/images/users/".$folder."/")) mkdir("Media/images/users/".$folder."/");

            $images = "Media/images/users/".$folder."/".$file_array['name'];
            if(move_uploaded_file($file_array['tmp_name'], $images)){
                //$this->resize_photo("images/users/".$folder."/", $file_array['name'], $file_array['size'], $file_array['type'], $file_array['tmp_name']);
            }

            return '<a href="/'.$images.'">'.$file_array['name'].'</a>';
        }

        private static function resize_photo($path,$filename,$filesize,$type,$tmp_name){
            // ���������, ���������� �� ����: ���� ���������� - �������� ���
            if(file_exists($path.$filename))
            {
                $height = 230; //�������� ������ ������
                $width = 270; //�������� ������ ������
                $rgb = 0xffffff; //���� ������� �������������� 0xFFFFFF - �����
                $size = getimagesize($path.$filename);//������ ������� �������� (���� ��� ���c�� size)
                //���������� ��� �����
                $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
                $icfunc = "imagecreatefrom" . $format;   //����������� ������� �������������� ���� �����

                //���� ��� ����� ������� ���������� ������ �������
                if (!function_exists($icfunc)) return false;
                $x_ratio = $width / $size[0]; //��������� ������ �������� ������
                $y_ratio = $height / $size[1]; //��������� ������ �������� ������
                $ratio       = min($x_ratio, $y_ratio);
                $use_x_ratio = ($x_ratio == $ratio); //����������� ������ � ������
                $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio); //������ ������
                $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio); //������ ������
                //����������� � ��������� ����������� �� ������
                $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
                //����������� � ��������� ����������� �� ������
                $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
                //������� ��������������� ����������� ���������������� ������
                $img = imagecreatetruecolor($width,$height);
                imagefill($img, 0, 0, $rgb); //�������� ���
                $photo = $icfunc($path.$filename); //������� ��� ��������

                imagecopyresampled($img, $photo, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]); //�������� �� ���� ���� ������ � ������ �����������

                //$func = 'image'.$format;
                switch($type) {
                    case 'gif':
                        imagegif($img, $path.$filename); // �������� �������� �� ������������
                        break;
                    case 'jpg':
                        imagejpeg($img, $path.$filename, 45); // �������� �������� ��������� $quality = 0...100, 100 = ������������ �������� ��������
                        break;
                    case 'png':
                        imagepng($image, $filename, 5);
                }
                //$func($img, $path.$filename, $quality, PNG_NO_FILTER); //��������� ��������� (������ ��������)
                // ������� ������ ����� ���������� �������
                imagedestroy($img);
                imagedestroy($photo);
            }
        }
        
        private static function webpConvert2($file, $compression_quality = 80) {
            // check if file exists
            if (!file_exists($file)) {
                return false;
            }
            
            $path_parts = pathinfo($file);
            $new_name = $path_parts['dirname'].'/'.$path_parts['filename'];
            $file_type = exif_imagetype($file);
            $output_file =  $new_name . '.webp';
            
            if (file_exists($output_file)) {
                return $output_file;
            }
            
            if (function_exists('imagewebp')) {
                switch ($file_type) {
                    case '1': //IMAGETYPE_GIF
                        $image = imagecreatefromgif($file);
                        break;
                    case '2': //IMAGETYPE_JPEG
                        $image = imagecreatefromjpeg($file);
                        break;
                    case '3': //IMAGETYPE_PNG
                            $image = imagecreatefrompng($file);
                            imagepalettetotruecolor($image);
                            imagealphablending($image, true);
                            imagesavealpha($image, true);
                            break;
                    case '6': // IMAGETYPE_BMP
                        $image = imagecreatefrombmp($file);
                        break;
                    case '15': //IMAGETYPE_Webp
                       return false;
                        break;
                    case '16': //IMAGETYPE_XBM
                        $image = imagecreatefromxbm($file);
                        break;
                    default:
                        return false;
                }
                // Save the image
                $result = imagewebp($image, $output_file, $compression_quality);
                if (false === $result) {
                    return false;
                }
                // Free up memory
                imagedestroy($image);
                return $output_file;
            } elseif (class_exists('Imagick')) {
                $image = new Imagick();
                $image->readImage($file);
                if ($file_type === "3") {
                    $image->setImageFormat('webp');
                    $image->setImageCompressionQuality($compression_quality);
                    $image->setOption('webp:lossless', 'true');
                }
                $image->writeImage($output_file);
                return $output_file;
            }
            return false;
        }
        
        public static function removeDirectory($path) {
            // ���� ���� ���������� � ��� �����
            $path = $_SERVER['DOCUMENT_ROOT'].'/Media/images/'.$path;
            //return $path;
            if ( file_exists( $path ) AND is_dir( $path ) ) {
                // ��������� �����
                $dir = opendir($path);
                while ( false !== ( $element = readdir( $dir ) ) ) {
                    // ������� ������ ���������� �����
                    if ( $element != '.' AND $element != '..' )  {
                        $tmp = $path . '/' . $element;
                        chmod( $tmp, 0777 );
                        // ���� ������� �������� ������, ��
                        // ������� ��� ��������� ���� ������� RDir
                        if ( is_dir( $tmp ) ) {
                            $this->removeDirectory( $tmp );
                        // ���� ������� �������� ������, �� ������� ����
                        } else {
                            unlink( $tmp );
                        }
                    }
                }
                // ��������� �����
                closedir($dir);
                // ������� ���� �����
                if ( file_exists( $path ) ) {
                    rmdir( $path );
                    return 'Deleted';
                } else return 'Delete error';
            }
        }
	}
?>
