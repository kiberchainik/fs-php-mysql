<?php
    class RegionModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
	   public function getRegionList () {
	       return DBClass::Instance()->select(
                'country as c, country_other_lang as cl, region as r, region_other_lang as rl',
                array('cl.name as c_name, r.id, rl.name as r_name'),
                'c.id = r.id_country and rl.id_lang = :lang and cl.id_lang = :lang and r.id = rl.id_region',
                array('lang' => 1),
                '',
                'r_name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function AddNewRegion ($data, $r_name) {
            DBClass::Instance()->insert('region', $data);
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($r_name as $k => $v){
                DBClass::Instance()->insert(
                    'region_other_lang',
                    array(
                        'id_region' => (int)$last_id,
                        'id_lang' => (int)$k,
                        'name' => $v['name']
                    )
                );
            }
        }
        
        public function GetRegionData($id) {
            $r_data = DBClass::Instance()->select(
                'region',
                array('*'),
                'id = :id',
                array('id' => $id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
            
            $query = DBClass::Instance()->select(
                'lang LEFT JOIN '.DBClass::Instance()->config['db_pref'].'region_other_lang ON '.DBClass::Instance()->config['db_pref'].'region_other_lang.id_region = :id',
                array(DBClass::Instance()->config['db_pref'].'region_other_lang.name, '.DBClass::Instance()->config['db_pref'].'region_other_lang.id_lang'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and '.DBClass::Instance()->config['db_pref'].'region_other_lang.id_lang = '.DBClass::Instance()->config['db_pref'].'lang.id',
                array('id' => (int)$id, 'lang_status' => '1'),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
            
            foreach($query as $k => $v) {
                $rezult[$v['id_lang']] = array(
                    'name' => $v['name']
                );
            }
            
            $r_data['r_data'] = $rezult;
            return $r_data;
       }
       
       public function UpdateRegion ($data, $id, $r_data) {
            DBClass::Instance()->update('region', $data, 'id = :id');
            
            DBClass::Instance()->deleteElement('region_other_lang', array('id_region' => (int)$id));
            foreach($r_data as $k => $v){
                DBClass::Instance()->insert('region_other_lang', array('id_region'  => (int)$id, 'id_lang' => (int)$k, 'name' => $v['name']));
            }
        }
        
        public function deleteRegion ($id) {
            DBClass::Instance()->deleteElement('region', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('region_other_lang', array('id_region' => (int)$id));
        }
    }
?>