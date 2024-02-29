<?php
	class DBClass {
       public $dbPDO;
       private $name, $table = NULL, $tables;
       private $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                PDO::ATTR_PERSISTENT => true);
                                
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
        
       public $config;
       
       //connect to data base;
       public function __construct() {
            $this->config = DBConfig::load('DB/DBConfig');
            try {
                 $this->dbPDO = new PDO("mysql:host=".$this->config['host'].";dbname=".$this->config['dbname'], $this->config['user'], $this->config['pass'], $this->options);
                 $this->dbPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(LPTFLogFile $lptf) {
                 $lptf->LPTFLogFileWrite();
            }
       }
       
       //general select from data base;
       public function select ($table_name, $fields = array(), $where = '', $params = array(), $like = '', $order = '', $up = false, $limit = '', $offset = '', $col_num = '') {
            //try {
                //select fields
                foreach ($fields as $v) {
                    if ((strpos($v, "(") === false) && ($v != "*")) $v = "`".$this->config['db_pref'].$v."`";
                }
                $fields = implode(",", $fields);
                
                //from tables
                $exp_table_name = explode(',', $table_name);
                foreach ($exp_table_name as $key => $val) {
                    $exp_table_name[$key] = $this->config['db_pref'].trim($val);
                }
                $table_name = implode(', ', $exp_table_name);
                
                $query = 'SELECT '.$fields.' FROM '.$table_name.' ';
                
                if(!$order) $order = "ORDER BY `id`";
    			else {
                    if (is_array($order)) {
                        $order_tabs = explode(', ', $order[0]);
                        $sort_by = explode(', ', $order[1]);
                        $order = "ORDER BY ";
                        
                        foreach ($order_tabs as $key => $val) {
                            $order .= ' `'.$val.'` '.$sort_by[$key].', ';
                        }
                        $order = substr($order, 0, -2);
                    } else {
                        if($order != "RAND()") {
        			         $order = "ORDER BY `$order`";
                             if(!$up) $order .= " DESC";
        					 else $order .= " ASC";
                        } else $order = "ORDER BY $order";
                    }
                }
                if ($limit != '') $limit = "LIMIT $limit";
                if ($offset != '') $offset = "OFFSET $offset";
                
                if ($where) {
                    $query .= " WHERE $where $order $limit $offset";
                    //echo $query;
                    $prepare = $this->dbPDO->prepare($query);
                    $prepare->execute($params);
                } else {
                    $query .= " $limit $offset";
                    $prepare = $this->dbPDO->prepare($query);
                    $prepare->execute();
                }
                
                if ($col_num == '1') return $prepare->fetch();
                else return $prepare->fetchAll();
                
            /*} catch(LPTFLogFile $lptf) {
                $lptf->LPTFLogFileWrite();
            }*/
       }
       
       public function search_like ($query, $params) {
            $prepare = $this->dbPDO->prepare($query);
            $prepare->execute($params);
            return $prepare->fetchAll();
       }
       
       //insert to data base
       public function insert ($table_name, $new_values) {
            try {
                $table_name = $this->config['db_pref'].$table_name;
                
                $query = "INSERT INTO $table_name (";
                
                foreach ($new_values as $fields => $value) {
                    $query .= "`".$fields."`,";
                }
                
                $query = substr($query, 0, -1);
                $query .= ") VALUES (";
                
                foreach ($new_values as $fields => $value) {
                    $query .= ":$fields, ";
                }
                
                $query = substr($query, 0, -2);
                $query .= ')';
                //echo $query;
                $result = $this->dbPDO->prepare($query);
                $result->execute($new_values);
            } catch (LPTFLogFile $lptf) {
                $lptf->LPTFLogFileWrite();
            }
       }
       
       public function update ($table_name, $upd_fields, $where) {
            try {
                $table_name = $this->config['db_pref'].$table_name;
                $query = "UPDATE $table_name SET ";
                
                foreach ($upd_fields as $fields => $value) {
                    $query .= "`$fields` = :$fields, ";
                }
                $query = substr($query, 0, -2);
                
                $query .= " WHERE $where";
                //return $query;
                $result = $this->dbPDO->prepare($query);
                $result->execute($upd_fields);
            } catch (LPTFLogFile $lptf) {
                $lptf->LPTFLogFileWrite();
            }
       }
       
       public function deleteElement ($table_name, $where = array(), $limit = '') {
            try {
                $table_name = $this->config['db_pref'].$table_name;
                
                if (!empty($where)) {
                    $whereParams = '';
                    foreach ($where as $key => $val) {
                        $whereParams .= '`'.$key.'` = :'.$key.' AND ';
                    }
                    $whereParams = substr($whereParams, 0, -4);
                    
                    $sth = $this->dbPDO->prepare('DELETE FROM '.$table_name.' WHERE '.$whereParams);
                    $sth->execute($where);
                } else {
                    $sth = $this->dbPDO->prepare('DELETE FROM '.$table_name);
                    $sth->execute();
                }
            } catch (LPTFLogFile $lptf) {
                $lptf->LPTFLogFileWrite();
            }
       }
       
       public function getLastId() {
           return $this->dbPDO->lastInsertId();
       }
       
       public function getCount ($table_name, $where = '', $param = array(), $count = 'id') {
            try {
                $table_name = $this->config['db_pref'].$table_name;
                
                $sql = 'SELECT COUNT('.$count.') as numCount FROM '.$table_name;
                
                if($where) {
                    $sql .= ' WHERE '.$where;
                    $prepare = $this->dbPDO->prepare($sql);
                    $prepare->execute($param);
                } else {
                    $prepare = $this->dbPDO->prepare($sql);
                    $prepare->execute();
                }
                //echo $sql;
                return $prepare->fetch();
            } catch (LPTFLogFile $lptf) {
                $lptf->LPTFLogFileWrite();
            }
       }
       
       public function DBAdmin ($query) {
            $prepare = $this->dbPDO->prepare($query);
            $prepare->execute();
            
            $error = $prepare->errorInfo();
            
            if ($error[0] == '0000') return $prepare->fetchAll();
            else return $error[2];
       }
       
       // закрытие соединения
       public function __destruct () {
            return $this->dbPDO = null;
       }
}
?>