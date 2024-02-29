<?php
	class DelHelper {
	   public static function DeleteImages ($name_catalog) {
	       $path = SITEMAIN.'Media/images/'.$name_catalog.'/';
            //return $path;
            if ( file_exists( $path ) AND is_dir( $path ) ) {

                $dir = opendir($path);
                while ( false !== ( $element = readdir( $dir ) ) ) {
                    if ( $element != '.' AND $element != '..' )  {
                        $tmp = $path . '/' . $element;
                        chmod( $tmp, 0777 );
                        if ( is_dir( $tmp ) ) {
                            DelHelper::DeleteImages( $tmp );
                        } else {
                            unlink( $tmp );
                        }
                    }
                }
                closedir($dir);
                if ( file_exists( $path ) ) {
                    rmdir( $path );
                    return true;
                } else return false;
            }
	   }
       
       public static function DeleteFile ($name) {
	       $path = '/home5/urlpyrtf/public_html/Media/images/'.$name;
            if ( file_exists( $path )) {
                if(unlink($path)) return true;
                else return false;
            }
	   }
	}
?>