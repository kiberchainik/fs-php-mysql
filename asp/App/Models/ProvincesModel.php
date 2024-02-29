<?php
    class ProvincesModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
	   public function getProvincesList () {
            return DBClass::Instance()->select(
                'country as c, country_other_lang as cl, region as r, region_other_lang as rl, provinces as p, provinces_other_lang as pl',
                array('cl.name as c_name, rl.name as r_name, pl.name as p_name, p.id'),
                'p.id = pl.id_province and pl.id_lang = :lang and cl.id_lang = :lang and cl.id_country = p.id_country and c.id = cl.id_country and rl.id_lang = :lang and rl.id_region = p.id_region and r.id = rl.id_region',
                array('lang' => 1),
                '',
                'p_name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function AddNewProvinces ($data, $p_name) {
            DBClass::Instance()->insert('provinces', $data);
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($p_name as $k => $v){
                DBClass::Instance()->insert(
                    'provinces_other_lang',
                    array(
                        'id_province' => (int)$last_id,
                        'id_lang' => (int)$k,
                        'name' => $v['name']
                    )
                );
            }
        }
        
        public function getRegionListOfCountry ($id) {
            return DBClass::Instance()->select(
                'country as c, region as r, region_other_lang as rl',
                array('r.id, rl.name'),
                'c.id = r.id_country and rl.id_lang = :lang and c.id = :id and r.id = rl.id_region',
                array('lang' => 1, 'id' => $id),
                '',
                'name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function GetProvincesData($id) {
            $p_data = DBClass::Instance()->select(
                'provinces',
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
                'lang LEFT JOIN '.DBClass::Instance()->config['db_pref'].'provinces_other_lang ON '.DBClass::Instance()->config['db_pref'].'provinces_other_lang.id_province = :id',
                array(DBClass::Instance()->config['db_pref'].'provinces_other_lang.name, '.DBClass::Instance()->config['db_pref'].'provinces_other_lang.id_lang'),
                DBClass::Instance()->config['db_pref'].'lang.status = :lang_status and '.DBClass::Instance()->config['db_pref'].'provinces_other_lang.id_lang = '.DBClass::Instance()->config['db_pref'].'lang.id',
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
            
            $p_data['p_data'] = $rezult;
            return $p_data;
       }
       
       public function UpdateProvinces ($data, $id, $r_data) {
            DBClass::Instance()->update('provinces', $data, 'id = :id');
            
            DBClass::Instance()->deleteElement('provinces_other_lang', array('id_province' => (int)$id));
            foreach($r_data as $k => $v){
                DBClass::Instance()->insert('provinces_other_lang', array('id_province'  => (int)$id, 'id_lang' => (int)$k, 'name' => $v['name']));
            }
        }
        
        public function deleteProvinces ($id) {
            DBClass::Instance()->deleteElement('provinces', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('provinces_other_lang', array('id_province' => (int)$id));
        }
    }
?>