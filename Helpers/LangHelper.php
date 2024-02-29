<?php
	class LangHelper {
       
        static public function getLanguage () {
           if (!isset($_SESSION['lang'])) {
                if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $_SESSION['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                else $_SESSION['lang'] = LANG_DEFAULT;
            }
            
            self::GetLangId($_SESSION['lang']);
        }
       
        static public function GetLangId ($code = '') {
            $_SESSION['lang'] = $code;
            $langId = DBClass::Instance()->select(
                'lang', 
                array('id'),
                'code = :code and status = :status',
                array('code' => $code, 'status' => 1),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
            
            if(!isset($langId['id'])) {
                if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                    $serverLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                    $code = htmlspecialchars(trim($serverLang));
                } else $code = htmlspecialchars(trim(LANG_DEFAULT));
                
                $langId = DBClass::Instance()->select('lang', array('id'), 'code = :code and status = :status', array('code' => $code, 'status' => 1), '', '','','','','1');
                
                if(!$langId) {
                    $code = htmlspecialchars(trim(LANG_DEFAULT));
                    
                    $langId = DBClass::Instance()->select('lang', array('id'), 'code = :code and status = :status', array('code' => $code, 'status' => 1), '', '','','','','1');
                    
                    $_SESSION['lid'] = $langId['id'];
                } else {
                    $_SESSION['lid'] = $langId['id'];
                }
            } else {
                $_SESSION['lid'] = $langId['id'];
            }
        }
	}
?>