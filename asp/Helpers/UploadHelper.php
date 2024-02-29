<?php
	class UploadHelper {

        protected $path;
        protected $tmp_path;
        protected $types;
        protected $size;

        public static function UploadOneImage ($file_array, $folder) {
            $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm", ".txt", ".zip", ".rar");
            foreach ($blacklist as $item) {
                if(preg_match("/$item\$/i", $file_array['name'])) return 'Error image format';
            }

            $type = $file_array['type'];
            $size = $file_array['size'];

            if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png")) return false;
            if ($size > 20480000) return 'Error_size';

            if (!file_exists("/home5/urlpyrtf/public_html/Media/images/".$folder."/")) mkdir("/home5/urlpyrtf/public_html/Media/images/".$folder."/");
            //$apend = date('YmdHis').rand(100,1000).'.png';
            $images = "Media/images/".$folder."/".$file_array['name'];
            if(move_uploaded_file($file_array['tmp_name'], '/home5/urlpyrtf/public_html'.$images)){
                self::resize_photo("/home5/urlpyrtf/public_html/Media/images/".$folder."/", $file_array['name'], $file_array['size'], $file_array['type'], $file_array['tmp_name']);
            } else return false;

            return $images;
        }

        public static function UploadMoreImages ($file_array, $folder) {
            if (isset($file_array)) {
                $images = array();

                if (!file_exists("/home5/urlpyrtf/public_html/Media/images/".$folder."/")) mkdir("/home5/urlpyrtf/public_html/Media/images/".$folder."/");

                foreach ($file_array['name'] as $k=>$v) {
                    $uploaddir = "/home5/urlpyrtf/public_html/Media/images/".$folder."/";
                    $apend = date('YmdHis').rand(100,1000).'.png';
                    $uploadfile = $uploaddir.$apend;

                    if($file_array['type'][$k] == "image/gif" || $file_array['type'][$k] == "image/png" ||
                    	$file_array['type'][$k] == "image/jpg" || $file_array['type'][$k] == "image/jpeg") {
                        $blacklist = array(".php", ".phtml", ".php3", ".php4");

                        foreach ($blacklist as $item) {
                            if(preg_match("/$item\$/i", $file_array['name'][$k])) {
                            exit;
                            }
                        }
                        $images[] = $uploadfile;
                        if(move_uploaded_file($file_array['tmp_name'][$k], $uploadfile)) {
                            self::resize_photo($uploaddir, $apend, $file_array['size'][$k], $file_array['type'][$k], $file_array['tmp_name'][$k]);
                        }
                    }
                }
                return serialize($images);
            }
        }

        public static function uploadImgDoc ($file_array, $folder) {

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
                $height = 480; //�������� ������ ������
                $width = 640; //�������� ������ ������
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
