<?php
	class HTMLHelper {
	   public static function css ($name) {
	       return '<link href="'.Url::local('Media/css/'.$name.'.css').'" rel="stylesheet" type="text/css" />';
	   }
       
       public static function js ($name) {
	       return '<script href="'.Url::local('Media/js/'.$name.'.js').'" type="text/javascript"></script>';
	   }
       
       public static function anchor($url, $content, $class = NULL, $id = NULL) {
            $class = $class === NULL ? "":" class='{$class}'";
            $id = $id === NULL ? "":" id='{$id}'";
            return "<a href='{$url}' {$id} {$class}>{$content}</a>";
       }
       
       public static function __callStatic($name, $args){
            $rez = "<{$name} ";
            //echo '<pre>';var_dump($args[1]);echo '</pre>';
            if (isset($args[1])) $attrs = @$args[1];
            if (isset($args[0])) $content = @$args[0];
            
            if(isset($attrs) and is_array($attrs)) foreach($attrs as $k => $v) $rez .= " {$k} = '{$v}'";
            $rez .= ">{$content}</{$name}>";
            return $rez; 
       }
       
       public static function pagination($page, $count, $base_url) {
            $rez = '<div class="col-12 pagination"><ul>';
            /*if($page > 1) $rez .= self::anchor('#', 'first');
            if($page > 2) $rez .= self::anchor('#', $page-2);
            if($page > 1) $rez .= self::anchor('#', $page-1);
            $rez .= self::anchor('#', $page, 'active');
            if($page < $count) $rez .= self::anchor('#', $page+1);
            if($page < $count - 1) $rez .= self::anchor('#', $page+2);
            if($page < $count) $rez .= self::anchor('#', 'last');*/
            
            if($page > 1) $rez .= self::li(self::anchor("{$base_url}/1", 'first'));
            if($page > 2) $rez .= self::li(self::anchor("{$base_url}/".($page-2), $page-2));
            if($page > 1) $rez .= self::li(self::anchor("{$base_url}/".($page-1), $page-1));
            $rez .= self::li(self::anchor("", $page), ['class' => 'active']);
            if($page < $count) $rez .= self::li(self::anchor("{$base_url}/".($page+1), $page+1));
            if($page < $count - 1) $rez .= self::li(self::anchor("{$base_url}/".($page+2), $page+2));
            if($page < $count) $rez .= self::li(self::anchor("{$base_url}/".($count), 'last'));
            return $rez .= '</ul></div>';
       }
       
       //проверка логина на спец. симвоолы и длинну
        public static function validLogin ($login) {
            if (preg_match("/^[a-zA-Z0-9._-]+$/", $login)) return true;
        }
        
        public static function validEmail ($email) {
            if(preg_match("/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u", $email)) return true;
        }
        
        public static function isOnlyLetters ($string) {
            if (preg_match('/^[a-zA-Zа-яА-Я-.!"\s]+$/u', $string)) return true;
        }
        
        public static function isRuLetters ($string) {
            if (preg_match('/[\p{Cyrillic}]/u', $string)) return true;
            else return false;
        }
        
        public static function isOnlyNumbers ($num) {
            if (preg_match("/^[0-9]+$/", $num)) return true;
        }
        
        public static function validLinks ($url) {
            // Remove all illegal characters from a url
            $url = filter_var($url, FILTER_SANITIZE_URL);
            
            // Validate url
            if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
                return true;
            } else {
                return false;
            }
        }
        
        public static function isNumbersTel ($num) {
            if (preg_match("/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/", $num)) return true;
        }

        public static function isDate ($date) {
            if (preg_match("/^[0-9]{4}/(0[1-9]|1[012])/(0[1-9]|1[0-9]|2[0-9]|3[01])$/", $date)) return true;
        }
        
        public static function TranslistLetterRU_EN ($word) {
            $translit = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'j',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'x',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
                'ь' => '',  'ы' => 'y',   'ъ' => '',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
                ' ' => '_',
      
                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'J',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
                'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'SHh',
                'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
                'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            );
      
            return strtr($word, $translit); // транслитерация. Переменная $word получит значение 'prochee'
            //$word = strtr('prochee', array_flip($translit)); // обратная транслитерация. Переменная $word получит значение 'прочее'
        }
        
        public static function TranslistLetterEN_RU ($word) {
            $translit = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'j',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'x',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
                'ь' => '',  'ы' => 'y',   'ъ' => '',
                'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
                ' ' => '_',
      
                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'J',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
                'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
                'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
                'Э' => 'E',   'Ю' => 'YU',  'Я' => 'YA',
            );
      
            //$transWord = strtr($word, $translit); // транслитерация. Переменная $word получит значение 'prochee'
            return strtr($word, array_flip($translit)); // обратная транслитерация. Переменная $word получит значение 'прочее'
        }
        
        public static function getIP(){
            if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                $ip=$_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip=$_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
	}
?>