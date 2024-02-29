<?php
	class CommentsModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function NewCommForAdvFromGuest ($data) {
            return DBClass::Instance()->insert('comments_advert', $data);
        }
       
       public function getCommentsForAdverts ($adv_id) {
            $comments = DBClass::Instance()->select(
                'comments_advert as ca left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ca.user_id = ud.user_id', 
                array('ca.*, ud.user_img'), 
                'ca.advert_id = :id and ca.moderation = 1', 
                array('id' => $adv_id),
                '',
                'date',
                '',
                '',
                '',
                '2'
            );
            
            $comments_num = count($comments);
            $comm = array();
            
        	for ($i = 0; $i < $comments_num; $i ++) {
        	   $comm[$comments[$i]['id']] = $comments[$i];
        	}
            return $comm;
       }
       
       public function getAllCommentsForUserAdverts ($u_id) {
            return DBClass::Instance()->select(
                'adverts as a, comments_advert as ca left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ca.user_id = ud.user_id', 
                array('ca.*, ud.user_img, a.seo, a.title'), 
                'ca.advert_id = a.id and a.idUser = :id and ca.moderation = 1', 
                array('id' => $u_id),
                '',
                'date',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function countCommentsForUser ($id) {
            return DBClass::Instance()->getCount(
                'comments_advert as ca, '.DBClass::Instance()->config['db_pref'].'adverts as a',
                'ca.advert_id = a.id and a.idUser = :id and ca.moderation = 1',
                array('id' => (int)$id),
                'ca.id'
            );
       }
    }
?>