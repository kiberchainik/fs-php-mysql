<?php
	class PortfolioModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
        public function getPortfolioPage ($pagenum, $const = 5, $subCatId = '') {
            
            $offset = (int)($pagenum-1)*$const;
            $offset = ($offset == 0)?1:$offset;
            
            if($offset < $const) $offset = '';
            
            if(!empty($subCatId)){
                $from = ', categori_portfolio as cp';
                $subCatIdWhere = ' and cp.id_category = :id_category and cp.id_portfolio = p.id';
                $params = array('id_category' => $subCatId);
            } else {
                $from = '';
                $subCatIdWhere = '';
                $params = array();
            }
            
            return DBClass::Instance()->select(
                'portfolio as p, users as u'.$from,
                array('p.id, p.id_user, p.name, p.adresResident, p.lastname, p.portfolio_img, p.search_status, u.login'), 
                'p.search_status = \'0\' and p.id_user = u.id'.$subCatIdWhere,
                $params, 
                '', 
                'name', 
                true,
                $const,
                $offset,
                '2'
            );
        }
        
        public function getPortfolioCount ($const = 5, $subCatId = '') {
            if(!empty($subCatId)){
                $from = ', '.DBClass::Instance()->config['db_pref'].'categori_portfolio as cp';
                $subCatIdWhere = ' and cp.id_category = :id_category and cp.id_portfolio = p.id';
                $params = array('id_category' => (int)$subCatId);
            } else {
                $from = '';
                $subCatIdWhere = '';
                $params = array();
            }
            
            $count = DBClass::Instance()->getCount(
                'portfolio as p'.$from,
                'p.search_status = 0 '.$subCatIdWhere,
                $params,
                'p.id'
            );
            
            return ceil($count['numCount']/$const);
       }
        
        public function GetAllPortfolioFromCategory ($cat, $limit = '') { //$start, $num
            return DBClass::Instance()->select(
                'portfolio as p, categori_portfolio as cp',
                array('p.id, p.id_user, p.name, p.adresResident, p.lastname, p.portfolio_img, p.search_status'), 
                'p.search_status = \'0\' and cp.id_category = :id_category and cp.id_portfolio = p.id',
                array('id_category' => (int)$cat), 
                '', 
                'name', 
                true,
                $limit,
                '',
                '2'
            );
        }
        
        public function GetPortfolioData ($user) {
	       return DBClass::Instance()->select(
                'portfolio as p, users as u',
                array('p.*, u.login'), 
                '(u.login = :id_user or u.id = :id_user) and u.id = p.id_user and p.search_status = \'0\'', 
                array('id_user' => $user), 
                '', 
                '', 
                '', 
                '',
                '',
                '1'
            );
	   }
       
       public function getAllPortfolioForMain ($limit = '') {
    	   return DBClass::Instance()->select(
                'portfolio as p, users as u',
                array('p.id, p.id_user, p.name, p.adresResident, p.lastname, p.portfolio_img, p.search_status, u.login'), 
                'p.search_status = \'0\' and p.id_user = u.id',
                array(), 
                '', 
                'name', 
                true, 
                $limit,
                '', 
                '2'
            );
        }
       
       public function getAssests () {
            return DBClass::Instance()->select(
                'portfolio_assests as PA, portfolio_assests_val as PAV',
                array('PAV.id as PAV_id, PAV.val, PA.*'),
                'PAV.id = PA.id_assests and id_lang = :id_lang',
                array('id_lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
       }

       public function getHobbi () {
            return DBClass::Instance()->select(
                'portfolio_hobbi as PA, portfolio_hobbi_val as PAV',
                array('PAV.id as PAV_id, PAV.val, PA.*'),
                'PAV.id = PA.id_hobbi and id_lang = :id_lang',
                array('id_lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
       }

       public function getInterests () {
            return DBClass::Instance()->select(
                'portfolio_interests as PA, portfolio_interests_val as PAV',
                array('PAV.id as PAV_id, PAV.val, PA.*'),
                'PAV.id = PA.id_interests and id_lang = :id_lang',
                array('id_lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                '2'
            );
       }
       
       public function GetUserPortfolio ($id_user) {
	       return DBClass::Instance()->select(
                'portfolio as p, users as u',
                array('p.*, u.login'),
                'p.id_user = :id_user or (u.login = :id_user and u.id = p.id_user)',
                array('id_user' => $id_user),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
	   }
       
       public function GetUserPortfolio_computer ($id_user) {
	       return DBClass::Instance()->select('portfolio_computer', array('*'), 'id_user = :id_user', array('id_user' => (int)$id_user), '', '', '', '', '', '2');
	   }
       
       public function GetUserPortfolio_educations ($id_user) {
	       return DBClass::Instance()->select('portfolio_educations', array('*'), 'id_user = :id_user', array('id_user' => (int)$id_user), '', '', '', '', '','2');
	   }
       
       public function GetUserPortfolio_languages ($id_user) {
	       return DBClass::Instance()->select('portfolio_languages', array('*'), 'id_user = :id_user', array('id_user' => (int)$id_user), '', '', '', '', '', '2');
	   }
       
       public function GetUserPortfolio_work_post ($id_user) {
	       return DBClass::Instance()->select('portfolio_work_post', array('*'), 'id_user = :id_user', array('id_user' => (int)$id_user), '', '', '', '', '', '2');
	   }
       
       public function GetNameAssests ($val) {
            return DBClass::Instance()->select(
                'portfolio_assests as pa, portfolio_assests_val as pav',
                array('pa.name'),
                'pav.val = :val and pav.id = pa.id_assests and pa.id_lang = :lang',
                array('val' => (int)$val, 'lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function GetNameHobbi ($val) {
            return DBClass::Instance()->select(
                'portfolio_hobbi as ph, portfolio_hobbi_val as phv',
                array('ph.name'),
                'phv.val = :val and phv.id = ph.id_hobbi and ph.id_lang = :lang',
                array('val' => (int)$val, 'lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function GetNameInterests ($val) {
            return DBClass::Instance()->select(
                'portfolio_interests as pi, portfolio_interests_val as piv',
                array('pi.name'),
                'piv.val = :val and piv.id = pi.id_interests and pi.id_lang = :lang',
                array('val' => (int)$val, 'lang' => (int)$_SESSION['lid']),
                '',
                'name',
                '',
                '',
                '',
                 '',
                '1'
            );
       }
       
       public function SelectCategoryPotrfolio ($portfolio_id) {
            return DBClass::Instance()->select(
                'categori_portfolio',
                array('*'),
                'id_portfolio = :portfolio_id',
                array('portfolio_id' => $portfolio_id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function AddMessageForUserFromGuest ($data) {
            return DBClass::Instance()->insert('messages_for_users', $data);
       }
       
       public function SaveCategoryPotrfolio ($addData) {
            return DBClass::Instance()->insert('categori_portfolio', $addData);

            //$this->dbPDO->getLastId();
       }
       
       public function UPDCategoryPotrfolio ($addData) {
            return DBClass::Instance()->update('categori_portfolio', $addData, 'id_portfolio = :id_portfolio');
       }
       
       public function NewEducations ($addData) {
            DBClass::Instance()->insert('portfolio_educations', $addData);

            return $type_id = DBClass::Instance()->getLastId();
       }
       
       public function UPDEducation ($addData) {
            DBClass::Instance()->update('portfolio_educations', $addData, 'id = :id');
       }
       
       public function deleteTREducation ($id) {
            return DBClass::Instance()->deleteElement('portfolio_educations', array('id' => (int)$id));
       }
       
       public function NewEducation_languages ($addData) {
            DBClass::Instance()->insert('portfolio_languages', $addData);

            return $type_id = DBClass::Instance()->getLastId();
       }
       
       public function UPDEducation_languages ($addData) {
            DBClass::Instance()->update('portfolio_languages', $addData, 'id = :id');
       }
       
       public function deleteTREducation_languages ($id) {
            return DBClass::Instance()->deleteElement('portfolio_languages', array('id' => (int)$id));
       }
       
       public function NewKnowledge_of_computer_programs ($addData) {
            DBClass::Instance()->insert('portfolio_computer', $addData);

            return $type_id = DBClass::Instance()->getLastId();
       }
       
       public function UPDKnowledge_of_computer_programs ($addData) {
            DBClass::Instance()->update('portfolio_computer', $addData, 'id = :id');
       }
       
       public function deleteTRKnowledge_of_computer_programs ($id) {
            return DBClass::Instance()->deleteElement('portfolio_computer', array('id' => (int)$id));
       }
       
       public function NewWork_post ($addData) {
            DBClass::Instance()->insert('portfolio_work_post', $addData);

            return $type_id = DBClass::Instance()->getLastId();
       }
       
       public function UPDWork_post ($addData) {
            return DBClass::Instance()->update('portfolio_work_post', $addData, 'id = :id');
       }
       
       public function deleteTRWork_post ($id) {
            return DBClass::Instance()->deleteElement('portfolio_work_post', array('id' => (int)$id));
       }
       
       public function AddNewPortfolio ($data) {
            DBClass::Instance()->insert('portfolio', $data);
            return DBClass::Instance()->getLastId();
       }
       
       public function UPDPortfolio ($data) {
            DBClass::Instance()->update('portfolio', $data, 'id = :id');
       }
       
       public function AddReviewForUser ($data) {
            return DBClass::Instance()->insert('review', $data);
       }
        
        public function getPortfolioId ($id_user) {
	       return DBClass::Instance()->select(
                'portfolio as p, users as u',
                array('p.id'),
                'p.id_user = :id_user or (u.login = :id_user and u.id = p.id_user)',
                array('id_user' => $id_user),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
	   }
       
       public function ifCandidatExist ($id_vac, $portfolio_id, $id_user) {
	       return DBClass::Instance()->select(
                'vacancie_candidats',
                array('*'),
                'id_v = :id_vac and (id_p = :portfolio_id or id_c = :id_user)',
                array('id_vac' => (int)$id_vac, 'portfolio_id' => $portfolio_id, 'id_user' => $id_user),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
	   }
       
       public function AddCandidatura ($data) {
            return DBClass::Instance()->insert('vacancie_candidats', $data);
        }
       
        public function AddNewDocsForPortfolio ($data) {
            return DBClass::Instance()->insert('portfolio_docs', $data);
        }
        
        public function GetDocumentsForPortfolio ($user_to) {
            return DBClass::Instance()->select(
                'portfolio_docs',
                array('*'),
                'id_user = :id_user',
                array('id_user' => (int)$user_to),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function trashDocsForPortfolio ($id) {
            return DBClass::Instance()->deleteElement('portfolio_docs', array('id' => (int)$id));
       }
        
        public function GetReviewForUser ($id_from, $user_to) {
            return DBClass::Instance()->select(
                'review',
                array('id'),
                'id_user_from = :id_from and id_user_to = :id_user_to',
                array('id_from' => (int)$id_from, 'id_user_to' => (int)$user_to),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function selectAutoPotrfolio ($user) {
	       return DBClass::Instance()->select(
                'autocandidat',
                array('*'), 
                'id_user = :id', 
                array('id' => (int)$user), 
                '', 
                '', 
                '', 
                '',
                '',
                '1'
            );
	   }
       
       public function selectAllAutoPotrfolio () {
	       return DBClass::Instance()->select(
                'autocandidat',
                array('*'), 
                '', 
                array(), 
                '', 
                '', 
                '', 
                '',
                '',
                '2'
            );
	   }
       
       public function saveAutoPotrfolio ($data) {
            return DBClass::Instance()->insert('autocandidat', $data);
       }
       
       public function updAutoPotrfolio ($addData) {
            return DBClass::Instance()->update('autocandidat', $addData, 'id = :id');
       }
       
       public function deleteAutoPortfolio ($id) {
            return DBClass::Instance()->deleteElement('autocandidat', array('id_user' => (int)$id));
       }
	}
?>