<?php
	class MainController extends Controller {
	   public function action_index() {
	       if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_main');
           
           $v->title = 'Центр управления палетами!';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->legal_u = PrivateModel::Instance()->getCountLegalUsers();
           $v->individual_u = PrivateModel::Instance()->getCountIndividualUsers();
           $v->portfolo_u = PrivateModel::Instance()->getCountPortfolioUsers();
           $v->adverts_u = PrivateModel::Instance()->getCountAdvertsUsers();
           $v->vacancies_u = PrivateModel::Instance()->getCountVacanciesUsers();
           $v->messages = PrivateModel::Instance()->getListMessages();
           $v->noteData = PrivateModel::Instance()->getNoteData();
           
           $v->vacancies = VacanciesModel::Instance()->getLisNewVacanciesForMain();
           
           if($this->post('saveNote')) {
                if ($this->post('noteId')) $id = $this->post('noteId');
                else $id = '';
                
                $data = array('id' => $id, 'noteText' => htmlspecialchars($this->post('note')));
                
                PrivateModel::Instance()->SaveNode($data, $id);
                $this->redirect(Url::local('main'));
            }
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_elfinder() {
	       if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_elfinder');
           
           $v->title = 'Центр управления палетами!';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $v->root = '/home5/urlpyrtf/public_html/Media/images/';
           $v->create_folder_here = 'Создать папку';
           $v->create_file_here = 'Создать файл';
           $v->upload_file_here = 'Загрузить файл';
           $v->zip_and_download_site = 'Скачать файл в формате zip';
           $v->general_settings = 'Настройки';
           $v->basename = basename($v->root); //Возвращает последний компонент имени из указанного пути
       
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_showtable () {
            if ($this->post('dir')) $dir = urldecode($this->post('dir')).'/';
            
            $table = '<table id="ab-list-pages"><thead>
                    	<tr>
                    		<th>'.basename($dir).'/</th>
                    		<th>Размер</th>
                    		<th>Путь</th>		
                    	</tr>
       	            </thead>';
                
                if( stream_resolve_include_path($dir)) {
                $files = scandir($dir);
                natcasesort($files);

                if( count($files) > 2 ) {
                
                    foreach( $files as $file ) {
                        if(stream_resolve_include_path($dir . $file) && $file != '.' && $file != '..' && filetype($dir . $file)=='dir') {
                            $foldersize = '<small>' . $this->formatBytes($this->foldersize($dir . '/' .$file)) . '</small>';
                            $folderpath = $this->slashes($dir . '/' .$file.'/');
                            $table .= '<tr class="lightgray"><td class="ab-tdfolder"><a href="'.$folderpath.'" class="closed">' . $file . '</a></td><td>'.$foldersize.'</td><td><a class="ab-btn red delete-directory" title="Удалить" href="'.$folderpath.'"><i class="fa fa-trash-o" aria-hidden="true"></i></a><button class="ab-btn blue renamefolder" title="Переименовать"><i class=" fa fa-random" aria-hidden="true"></i></button><a class="ab-btn asphalt downloadfolder" title="Скачать в zip архиве"  href="downloadfolder.php?file='.$folderpath.'"><i class="fa fa-download" aria-hidden="true"></i></a></td></tr>';
                        }
                    }
                
                    foreach( $files as $file ) {
                        if(stream_resolve_include_path($dir . $file) && $file != '.' && $file != '..' && filetype($dir . $file)!=='dir') {
                            $filepath = $this->slashes($dir . '/' .$file);
                            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            $current_url = $protocol . 'findsol.it';
                            $url = $current_url.str_replace('home5/urlpyrtf/public_html/', '', $filepath);//str_replace($_SERVER['DOCUMENT_ROOT'], $current_url, $filepath);
                            $ext = strtolower(preg_replace('/^.*\./', '', $file));
                            $size = '<small>'.$this->formatBytes(filesize($filepath)).'</small>';
                            
                            if(in_array($ext, array("jpg","jpeg","png","gif","ico","bmp"))){
                                $table .= '<tr class="white"><td class="ab-tdfile"><span class="ext-file ext-'.$ext.'">'.$file.'</span></td><td>'.$size.'</td><td><a href="'.$filepath.'" class="ab-btn red delete-file" title="Удалить"><i class="fa fa-trash-o" aria-hidden="true"></i></a><button class="ab-btn blue renamefile" title="Переименовать"><i class=" fa fa-random" aria-hidden="true"></i></button><a class="ab-btn asphalt downloadfile" title="Скачать в zip архиве"  href="downloadfile.php?file='.$filepath.'"><i class="fa fa-download" aria-hidden="true"></i></a><a class="ab-btn green zoom" href="'.$url.'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td></tr>';
                            } elseif (in_array($ext, $config['extensions_for_editor'])){
                                $table .= '<tr class="white"><td class="ab-tdfile"><span class="ext-file ext-'.$ext.'">'.$file.'</span></td><td>'.$size.'</td><td><a href="'.$filepath.'" class="ab-btn red delete-file" title="Удалить"><i class="fa fa-trash-o" aria-hidden="true"></i></a><button class="ab-btn blue renamefile" title="Переименовать"><i class=" fa fa-random" aria-hidden="true"></i></button><a class="ab-btn asphalt downloadfile" title="Скачать в zip архиве"  href="downloadfile.php?file='.$filepath.'"><i class="fa fa-download" aria-hidden="true"></i></a><a class="ab-btn violet ab-edit-file" href="editor.php?editfile='.$filepath.'" target="_blank" title="Редактировать"><i class=" fa fa-pencil" aria-hidden="true"></i></a></td></tr>';
                            } else	{
                                $table .= '<tr class="lightgray"><td class="ab-tdfile"><span class="ext-file ext-'.$ext.'">'.$file.'</span></td><td>' . $size . '</td><td><a href="'.$filepath.'" class="ab-btn red delete-file" title="Удалить"><i class="fa fa-trash-o" aria-hidden="true"></i></a><button class="ab-btn blue renamefile" title="Переименовать"><i class=" fa fa-random" aria-hidden="true"></i></button><a class="ab-btn asphalt downloadfile" title="Скачать в zip архиве"  href="downloadfile.php?file='.$filepath.'"><i class="fa fa-download" aria-hidden="true"></i></a></td></tr>';					
                            }				
                        }
                    }
                } else {
                    $table .= '<tr class="lightgray"><td>---</td><td>---</td><td>---</td></tr>';
                }
            } else {
                die('Not found - '.$dir);
            }
            $table .= '</table>';
            echo $table;
       }
       
        private function formatBytes($size){
            $sizes = array('b', 'kb', 'mb', 'gb', 'tb');
            $retstring = 0;
            if ($retstring === 0) { $retstring = '%01.2f %s'; }
            $lastsizestring = end($sizes);
            foreach ($sizes as $sizestring) {
                if ($size < 1024) { break; }
                if ($sizestring != $lastsizestring) { $size /= 1024; }
            }
            if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
            return sprintf($retstring, $size, $sizestring);	
        }
        
        private function foldersize($path){
            if (!file_exists($path)) return 0;
            if (is_file($path)) return filesize($path);
            $ret = 0;
            foreach(glob($path."/*") as $fn)
            $ret += $this->foldersize($fn);
            return $ret;
        }
        
        private function slashes($str){
            $pos = strpos($str,"//");
            while($pos != false){
                $str=str_replace("//", "/", $str);
                $pos=strpos($str, "//");
            }
            return $str;
        }
       
       public function action_sendMessageForUser () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
            $msg = '';
            
            $lang_message = $this->lang('messages');
            
            if (!$this->post('user_id')) $msg = 'Error user_id';
            if (!$this->post('user_email')) $msg = 'Error user_email';
            if ($this->post('user_post_id')) {
                $post = explode('_', $this->post('user_post_id'));
                $postDate = PrivateModel::Instance()->getPostDateForMessage($post[0], $post[1]);
                
                if($postDate) {
                    $message = $this->post('message').'<hr /><a href="'.SITE.'/'.$post[0].'/page/'.$postDate['seo'].'">'.$postDate['title'].'</a>';
                }
            } else $message = $this->post('message');
            if (!$this->post('subject')) $msg = 'Error subject';
            if (!$this->post('message')) $msg = 'Error message';
            
            if(empty($msg)) {
                $add = array(
                    'id_user' => $this->post('user_id'),
                    'subject' => $this->post('subject'),
                    'message' => $message,
                    'date_send' => time()
                );
                
                PrivateModel::Instance()->SendMessageFromAdmin($add);
                
                $message = $lang_message['messages_from_admin'].'<hr />'.$message;
                EmailTPLHelper::SendEmail($this->post('user_email'), $this->post('subject'), $message);
                $msg = 'Сообщение отправленно';
            }
            
            echo json_encode($msg);
        }
	}
?>