<?php
	class EmailTPLHelper {
        public static function SendEmail ($to_user, $subject, $message, $email_msg_without_html = '') {
            
            require 'PHPMailer/PHPMailer.php';
            require 'PHPMailer/SMTP.php';
            require 'PHPMailer/Exception.php';
            
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            
            try {
                $mail->ContentType = 'text/plain';
                $mail->ContentType = 'text/html';
                $mail->IsHTML(true);
                $mail->isSMTP();   
                $mail->CharSet = "UTF-8";
                $mail->SMTPAuth   = true;
                $mail->SMTPDebug = 2;
                $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};
            
                // Настройки вашей почты
                $mail->Host       = 'neth219.shneider-host.ru'; // SMTP сервера вашей почты
                $mail->Username   = 'support@findsol.it'; // Логин на почте
                $mail->Password   = '62789242alex'; // Пароль на почте
                $mail->SMTPSecure = '';
                $mail->SMTPAuth = false;
                $mail->Port       = 25;
                $mail->setFrom('support@findsol.it', 'FindSolution'); // Адрес самой почты и имя отправителя
            
                // Получатель письма
                $mail->addAddress($to_user);
                $mail->addCustomHeader("List-Unsubscribe",'<support@findsol.it>, <https://findsol.it/unsubscribe/email/'.$to_user.'>');
                //$mail->addAttachment();PHPMailer
                // Прикрипление файлов к письму
                /*if (!empty($file['name'][0])) {
                    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
                        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
                        $filename = $file['name'][$ct];
                        if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
                            $mail->addAttachment($uploadfile, $filename);
                            $rfile[] = "Файл $filename прикреплён";
                        } else {
                            $rfile[] = "Не удалось прикрепить файл $filename";
                        }
                    }
                }*/
                
                // Отправка сообщения
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->isHTML(true);
                $mail->AltBody = $email_msg_without_html;
            
                // Проверяем отравленность сообщения
                if ($mail->send()) return true;
                else return $mail->ErrorInfo;
            
            } catch (Exception $e) {
                $result = false;
                return "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
            }
            /*$to = $to_user;
            $subject = "=?utf-8?b?".base64_encode($subject)."?=";
            
            $mailheaders = "Content-type:text/html;charset=utf-8\r\n";
            $mailheaders .= "From: SiteRobot <".ROBOT_EMAIL.">\r\n";
            $mailheaders .= "Reply-To: ".ROBOT_EMAIL."\r\n";  
            
            if (mail($to, $subject, $message, $mailheaders)) return true;
            else return false;*/
        }
	}
?>