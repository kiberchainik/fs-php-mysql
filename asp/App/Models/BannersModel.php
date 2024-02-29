<?php
	class BannersModel extends Model {
        private function __construct(){}
        private static $instance = NULL;
        
        public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
        }
        
        public function getBannersCount ($const = 5) {
            $count = DBClass::Instance()->getCount(
                'banners',
                '',
                array(),
                'id'
            );
            
            return ceil($count['numCount']/$const);
       }
       
       public function GetBannerList () {
            return DBClass::Instance()->select(
                'banners as b, banners_description as bd',
                array('b.id as b_id, b.link, b.img_src, bd.title'),
                'b.id = bd.id_banner and id_lang = :lang',
                array('lang' => 1),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function getBannerDataForEdit ($id) {
            $query = DBClass::Instance()->select(
                'banners',
                array('*'),
                'id = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
            
            $desc = DBClass::Instance()->select(
                'banners_description',
                array('*'),
                'id_banner = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
            
            foreach($desc as $k => $v) {
                $rezult[$v['id_lang']] = array(
                    'title' => $v['title'],
                    'text' => $v['text']
                );
            }
            $query['desc'] = $rezult;
            return $query;
       }
       
       public function addBannerData ($banner, $bd) {
            DBClass::Instance()->insert('banners', $banner, 'id = :id');
            $last_id = DBClass::Instance()->getLastId();
            
            foreach($bd as $k => $v){
                DBClass::Instance()->insert('banners_description', array('id_banner' => (int)$last_id, 'id_lang' => (int)$k, 'title' => $v['title'], 'text' => $v['text']));
            }
            
            return $last_id;
        }
        
        public function updBannerImage($src) {
            DBClass::Instance()->update('banners', $src, 'id = :id');
        }
       
       public function seveBannerData ($banner, $bd) {
            DBClass::Instance()->update('banners', $banner, 'id = :id');
            
            DBClass::Instance()->deleteElement('banners_description', array('id_banner' => (int)$banner['id']));
            foreach($bd as $k => $v){
                DBClass::Instance()->insert('banners_description', array('id_banner' => (int)$banner['id'], 'id_lang' => (int)$k, 'title' => $v['title'], 'text' => $v['text']));
            }
        }
        
        public function deletebanner ($id) {
            DBClass::Instance()->deleteElement('banners', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('banners_description', array('id_banner' => (int)$id));
        }
	}
?>