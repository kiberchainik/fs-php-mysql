<?php
	class DbeditorController extends Controller {
        /*----- FQ DataBase Edition -----*/
        public function action_index () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_dbadm');
           
           $v->title = 'ЦУП: Редактирование языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
            $v->DBNames = PrivateModel::Instance()->DBNames();
            
            $v->useTemplate();
            $this->response($v);
        }
        
        public function action_dbname () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
	       } else $this->redirect(Url::local('login'));
           
           $v = new View('p_dbadm');
           
           $v->title = 'ЦУП: Редактирование языка';
           $v->description = '';
           $v->keywords = '';
           
           $v->header = $this->module('Header');
           $v->p_menu = $this->module('PrivateMenu');
           $v->footer = $this->module('Footer');
           
           $dbname = Router::getUriParam(2);
                      
            $v->DBNames = PrivateModel::Instance()->DBNames();
            
            $v->dbname = $dbname;
            $v->Tables = PrivateModel::Instance()->DBTables($dbname);
            
            if(isset($_POST['tableName'])) {
                echo(json_encode($_POST));
            }
            
            $v->useTemplate();
            $this->response($v);
        }
        
        public function action_gettables () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
            
            $dbname = Router::getUriParam(2);
            $Tables = PrivateModel::Instance()->DBTables($dbname);
            
            if($this->post('tableName')) {
                $TableColumns = PrivateModel::Instance()->DBTablesColumns($this->post('tableName'));
                
                echo(json_encode($TableColumns));
            }
            
            if($this->post('listrecords')) {
                $listrecords = PrivateModel::Instance()->DBTablesListrecords($this->post('listrecords'));
                
                echo(json_encode($listrecords));
            }
            
            if($this->post('tableColumns')) {
                $TableColumns = PrivateModel::Instance()->DBTablesColumns($this->post('tableColumns'));
                
                $fields = array();
                
                foreach($TableColumns as $k => $v) {
                    $fields[] = $v['Field'];
                }
                
                echo(json_encode($fields));
            }
            
            if($this->post('newRecord')) {
                $addres = PrivateModel::Instance()->addNewRecord($this->post('bdtable'), $this->post('newRecord'));
                
                echo(json_encode(array('err' => '', 'ok' => 'ok')));
            }
            
            if($this->post('deleteRecord')) {
                $addres = PrivateModel::Instance()->deleteRecord($this->post('nameTable'), $this->post('deleteRecord'));
                
                echo(json_encode(array('err' => '', 'ok' => 'ok')));
            }
            
            if($this->post('columnData')) {
                $nameTable = $this->post('columnData')['nameTable'];
                
                $msg = array('err' => array());
                
                if (!$this->post('columnData')['name']) $msg['err'][] = 'Название поля обязательно';
                else $nameColumn = $this->post('columnData')['name'];
                
                if (!$this->post('columnData')['type']) $msg['err'][] = 'Тип поля обязателен';
                else $typeColumn = $this->post('columnData')['type'];
                
                if (!$this->post('columnData')['length']) $msg['err'][] = 'Длина поля обязательна';
                else $lengthColumn = $this->post('columnData')['length'];
                
                $commentColumn = $this->post('columnData')['comment'];
                $defaultColumn = $this->post('columnData')['default'];
                $aiColumn = $this->post('columnData')['AUTO_INCREMENT'];
                
                if (!empty($msg['err'])) {
                    echo(json_encode(array('err' => $msg['err'], 'ok' => '')));
                } else {
                    PrivateModel::Instance()->addNewColumn($nameTable, $nameColumn, $typeColumn, $lengthColumn, $commentColumn, $defaultColumn, $aiColumn);
                    echo(json_encode(array('err' => '', 'ok' => 'ok')));
                }
            }
            
            if($this->post('deleteColumn')) {
                PrivateModel::Instance()->deleteColumn($this->post('nameTable'), $this->post('deleteColumn'));
                
                echo(json_encode(array('err' => '', 'ok' => 'ok')));
            }
        }
        
        public function action_newtables () {
            if(AuthClass::instance()->isAuth()) {
	           $u_date = AuthClass::instance()->getUser();
               if ($u_date['admin'] != '1' and $u_date['userType'] != '1') $this->redirect(Url::local('profile'));
	       } else $this->redirect(Url::local('login'));
           
           print_r($_POST);
           
           echo(json_encode(array('err' => '', 'ok' => 'ok')));
        }
    }
?>