<?php
	class SaveportfolioModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function SaveportfolioForUser ($id_p, $id_user) {
            return DBClass::Instance()->insert('save_portfolio_for_user', array('id_user' => $id_user, 'id_portfolio' => $id_p));
        }
        
        public function getNumProfessionalsOfUser ($u_id) {
            return DBClass::Instance()->getCount('save_portfolio_for_user', 'id_user = :id', array('id' => $u_id));
        }
        
        public function SavedPortfolio ($id) {
            return DBClass::Instance()->select(
                'save_portfolio_for_user',
                array('*'),
                'id_user = :id',
                array('id' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function ifIssetSavedPortfolio ($id_p, $id_u) {
            return DBClass::Instance()->select(
                'save_portfolio_for_user',
                array('id'),
                'id_portfolio = :id_p and id_user = :id_u',
                array('id_p' => (int)$id_p, 'id_u' => $id_u),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getListSavedPortfolioForProfile ($id) {
            return DBClass::Instance()->select(
                'save_portfolio_for_user as spfu, portfolio as p, users as u',
                array('p.id_user, p.portfolio_img, p.name, p.lastname, u.login'),
                'u.id = p.id_user and spfu.id_portfolio = p.id_user and spfu.id_user = :user_id',
                array('user_id' => (int)$id),
                '',
                'name',
                true,
                '',
                '',
                '2'
            );
        }
        
        public function trashSavedPortfolio ($id_p, $id_u) {
            return DBClass::Instance()->deleteElement('save_portfolio_for_user', array('id_portfolio' => (int)$id_p, 'id_user' => (int)$id_u), '');
        }
	}
?>