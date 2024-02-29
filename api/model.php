<?php 
	class Model {
		private $id;
		private $name;
		private $email;
		private $address;
		private $mobile;
		private $updatedBy;
		private $updatedOn;
		private $createdBy;
		private $createdOn;
		private $tableName;
		private $dbConn;
        private $db_pref;

		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setName($name) { $this->name = $name; }
		function getName() { return $this->name; }
		function setEmail($email) { $this->email = $email; }
		function getEmail() { return $this->email; }
		function setAddress($address) { $this->address = $address; }
		function getAddress() { return $this->address; }
		function setMobile($mobile) { $this->mobile = $mobile; }
		function getMobile() { return $this->mobile; }
		function setUpdatedBy($updatedBy) { $this->updatedBy = $updatedBy; }
		function getUpdatedBy() { return $this->updatedBy; }
		function setUpdatedOn($updatedOn) { $this->updatedOn = $updatedOn; }
		function getUpdatedOn() { return $this->updatedOn; }
		function setCreatedBy($createdBy) { $this->createdBy = $createdBy; }
		function getCreatedBy() { return $this->createdBy; }
		function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
		function getCreatedOn() { return $this->createdOn; }

		public function __construct() {
			$db = new DbConnect();
            $this->db_pref = $db->db_pref;
			$this->dbConn = $db->connect();
		}

		public function getAllCustomers() {
			$stmt = $this->dbConn->prepare("SELECT 
                                                u.id, 
                                                u.login,
                                                u.email, 
                                                ud.name, 
                                                ud.lastname, 
                                                ud.mobile, 
                                                ud.user_img 
                                            FROM 
                                                ".$this->db_pref."users as u, 
                                                ".$this->db_pref."user_date as ud 
                                            WHERE 
                                                ud.type_person = '5' AND 
                                                ud.user_id = u.id AND 
                                                u.validStatus = '1' AND 
                                                u.admin != '1'");
            $stmt->execute();
			$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
			return $customers;
		}
        
        public function getStatisticAgencies () {
            $privat_users = $this->dbConn->prepare("SELECT COUNT(id) as users FROM ".$this->db_pref."user_date WHERE type_person = 5");
            $privat_users->execute();
			$privat_users = $privat_users->fetch(PDO::FETCH_ASSOC);
            
            $users_portfolio = $this->dbConn->prepare("SELECT COUNT(id) as cv_creati FROM ".$this->db_pref."portfolio");
            $users_portfolio->execute();
			$users_portfolio = $users_portfolio->fetch(PDO::FETCH_ASSOC);
            
            $agency = $this->dbConn->prepare("SELECT agency.company_name as Agenzia, COUNT(vc.id_c) as Candidati FROM ".$this->db_pref."user_date AS agency LEFT JOIN ".$this->db_pref."vacancie_candidats AS vc ON (agency.user_id = vc.id_user) WHERE vc.id_user = agency.user_id GROUP BY agency.company_name ");
            $agency->execute();
			$agency = $agency->fetchAll(PDO::FETCH_ASSOC);
            
			return $result = array(
                'utenti_privati_registrati' => $privat_users['users'],
                'cv_creati' => $users_portfolio['cv_creati'],
                'candidati' => $agency
            );
        }

		public function getCustomerPortfolioById() {

			$sql = "SELECT 
						p.*
					FROM ".$this->db_pref."portfolio as p 
					WHERE 
						p.id_user = :customerId";

			$stmt = $this->dbConn->prepare($sql);
			$stmt->bindParam(':customerId', $this->id);
			$stmt->execute();
			$customer = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $assests = unserialize($customer['assests']);
            if($assests) {
                foreach ($assests as $ua) {
                   $stmt = $this->dbConn->prepare('
                        SELECT 
                            pa.name
                        FROM 
                            '.$this->db_pref.'portfolio_assests as pa, '.$this->db_pref.'portfolio_assests_val as pav
                        WHERE 
                            pav.val = :val and pav.id = pa.id_assests and pa.id_lang = 2');
                    
                    $stmt->bindParam(':val', $ua);
                    $stmt->execute();
        			$customer['portfolioAssests'][] = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
            
            $hobbi = unserialize($customer['hobbi']);
            if($hobbi) {
                foreach ($hobbi as $ua) {
                   $stmt = $this->dbConn->prepare('
                        SELECT 
                            pa.name
                        FROM 
                            '.$this->db_pref.'portfolio_hobbi as pa, '.$this->db_pref.'portfolio_hobbi_val as pav
                        WHERE 
                            pav.val = :val and pav.id = pa.id_hobbi and pa.id_lang = 2');
                    
                    $stmt->bindParam(':val', $ua);
                    $stmt->execute();
        			$customer['portfolioHobbi'][] = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
            
            $interests = unserialize($customer['interests']);
            if($interests) {
                foreach ($interests as $ua) {
                   $stmt = $this->dbConn->prepare('
                        SELECT 
                            pa.name
                        FROM 
                            '.$this->db_pref.'portfolio_interests as pa, '.$this->db_pref.'portfolio_interests_val as pav
                        WHERE 
                            pav.val = :val and pav.id = pa.id_interests and pa.id_lang = 2');
                    
                    $stmt->bindParam(':val', $ua);
                    $stmt->execute();
        			$customer['portfolioInterests'][] = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
            
			return $customer;
		}
        
        public function getAllCandidats () {
            $stmt = $this->dbConn->prepare("SELECT 
                                                vc.id,
                                                vc.date_add,
                                                v.title,
                                                u.login,
                                                u.email,
                                                p.name, 
                                                p.lastname, 
                                                p.mobile, 
                                                p.portfolio_img 
                                            FROM 
                                                ".$this->db_pref."vacancie_candidats as vc, 
                                                ".$this->db_pref."portfolio as p, 
                                                ".$this->db_pref."vacancies as v, 
                                                ".$this->db_pref."users as u 
                                            WHERE 
                                                vc.id_user = :id AND 
                                                vc.id_p = p.id AND
                                                vc.id_v = v.id AND
                                                p.id_user = u.id");
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
			$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $customers;
        }
        
        public function getCategoryVacancyData ($lang) {
            $stmt = $this->dbConn->prepare("SELECT 
                                                cv.id,
                                                cvd.title
                                            FROM 
                                                ".$this->db_pref."lang as l,
                                                ".$this->db_pref."categoryvacancies as cv, 
                                                ".$this->db_pref."categoryvacancies_description as cvd
                                            WHERE 
                                                l.code = :code AND cvd.lang_id = l.id AND cv.id = cvd.category_id");
            $stmt->bindParam(':code', $lang);
            $stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function getBranchListData ($id_user) {
            $stmt = $this->dbConn->prepare("SELECT id, name_company, adres FROM ".$this->db_pref."branch WHERE id_user = :id_user");
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();
			$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
        
        public function addNewBranch ($data) {
            $query = "INSERT INTO ".$this->db_pref."branch (";
                
            foreach ($data as $fields => $value) {
                $query .= "`".$fields."`,";
            }
            
            $query = substr($query, 0, -1);
            $query .= ") VALUES (";
            
            foreach ($data as $fields => $value) {
                $query .= ":$fields, ";
            }
            
            $query = substr($query, 0, -2);
            $query .= ')';
            //return $query;
            $result = $this->dbConn->prepare($query);
            $result->execute($data);
        }
        
        public function getBranchDataById ($id_user, $id) {
            $stmt = $this->dbConn->prepare("SELECT * FROM ".$this->db_pref."branch WHERE id_user = :id_user AND id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function updBranch ($data, $where) {
            $table_name = $this->config['db_pref'].$table_name;
            $query = "UPDATE ".$this->db_pref."branch SET ";
            
            foreach ($data as $fields => $value) {
                $query .= "`$fields` = :$fields, ";
            }
            $query = substr($query, 0, -2);
            
            $query .= " WHERE $where";
            //return $query;
            $result = $this->dbConn->prepare($query);
            $result->execute($data);
        }
        
        public function deleteBranch ($where) {
            $whereParams = '';
            foreach ($where as $key => $val) {
                $whereParams .= '`'.$key.'` = :'.$key.' AND ';
            }
            $whereParams = substr($whereParams, 0, -5);
            
            $sth = $this->dbConn->prepare('DELETE FROM '.$this->db_pref.'branch'.' WHERE '.$whereParams);
            $sth->execute($where);
            
            return $sth->errorInfo();
        }
        
        public function ifBranchExist ($user_id){
            $prepare = $this->dbConn->prepare('SELECT COUNT(id) as count FROM '.$this->db_pref.'branch WHERE id_user = :id_user');
            $prepare->execute(array('id_user' => $user_id));
            return $prepare->fetch();
            
            if($count['count'] == '0') return true;
            else return false;
        }
        
        public function ifVacancyExist ($seo){
            $prepare = $this->dbConn->prepare('SELECT id FROM '.$this->db_pref.'vacancies WHERE seo = :seo');
            $prepare->execute(array('seo' => $seo));
            return $prepare->fetch();
        }
        
        public function getCountryList($lang){
            $stmt = $this->dbConn->prepare("SELECT c.id, cl.name
                                            FROM 
                                                ".$this->db_pref."lang as l,
                                                ".$this->db_pref."country as c, 
                                                ".$this->db_pref."country_other_lang as cl
                                            WHERE 
                                                l.code = :code AND cl.id_lang = l.id AND c.id = cl.id_country");
            $stmt->bindParam(':code', $lang);
            $stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function getRegionList($lang, $c_id){
            $stmt = $this->dbConn->prepare("SELECT r.id, rl.name
                                            FROM 
                                                ".$this->db_pref."lang as l,
                                                ".$this->db_pref."region as r, 
                                                ".$this->db_pref."region_other_lang as rl
                                            WHERE 
                                                l.code = :code AND rl.id_lang = l.id AND r.id = rl.id_region AND r.id_country = :c_id
                                            ORDER BY name");
            $stmt->bindParam(':code', $lang);
            $stmt->bindParam(':c_id', $c_id);
            $stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function getProvincesList($lang, $c_id, $r_id){
            $stmt = $this->dbConn->prepare("SELECT p.id, pl.name
                                            FROM 
                                                ".$this->db_pref."lang as l,
                                                ".$this->db_pref."provinces as p, 
                                                ".$this->db_pref."provinces_other_lang as pl
                                            WHERE 
                                                l.code = :code AND pl.id_lang = l.id AND p.id = pl.id_province AND p.id_country = :c_id AND p.id_region = :r_id
                                            ORDER BY name");
            $stmt->bindParam(':code', $lang);
            $stmt->bindParam(':c_id', $c_id);
            $stmt->bindParam(':r_id', $r_id);
            $stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function addNewVacancy ($data) {
            $query = "INSERT INTO ".$this->db_pref."vacancies (";
                
            foreach ($data as $fields => $value) {
                $query .= "`".$fields."`,";
            }
            
            $query = substr($query, 0, -1);
            $query .= ") VALUES (";
            
            foreach ($data as $fields => $value) {
                $query .= ":$fields, ";
            }
            
            $query = substr($query, 0, -2);
            $query .= ')';
            //echo $query;
            $result = $this->dbConn->prepare($query);
            $result->execute($data);
        }
        
        public function getVacancyListData ($id_user) {
            $stmt = $this->dbConn->prepare("SELECT * FROM ".$this->db_pref."vacancies WHERE id_user = :id_user");
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();
			$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        }
        
        public function getVacancyDataById ($id_user, $id) {
            $stmt = $this->dbConn->prepare("SELECT * FROM ".$this->db_pref."vacancies WHERE id_user = :id_user AND id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function updVacancy ($data, $where) {
            $table_name = $this->config['db_pref'].$table_name;
            $query = "UPDATE ".$this->db_pref."vacancies SET ";
            
            foreach ($data as $fields => $value) {
                $query .= "`$fields` = :$fields, ";
            }
            $query = substr($query, 0, -2);
            
            $query .= " WHERE $where";
            //return $query;
            $result = $this->dbConn->prepare($query);
            $result->execute($data);
        }
        
        public function deleteVacancy ($where) {
            $whereParams = '';
            foreach ($where as $key => $val) {
                $whereParams .= '`'.$key.'` = :'.$key.' AND ';
            }
            $whereParams = substr($whereParams, 0, -5);
            
            $sth = $this->dbConn->prepare('DELETE FROM '.$this->db_pref.'vacancies'.' WHERE '.$whereParams);
            $sth->execute($where);
            
            return $sth->errorInfo();
        }
	}
 ?>