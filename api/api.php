<?php
	class Api extends Rest {
		private $model;
		
		public function __construct() {
			parent::__construct();
            $this->model = new Model;
		}
        
        private function passHash($pass, $salt) {
            $h1 = hash('sha256', $salt.$pass.$salt);
            $h2 = hash('sha256', $pass.$salt.$pass);
            $res = hash('sha256', $h1.$h2);
            
            return substr_replace($res, $salt, 12, 10);
       }
       
       private function repairSalt ($hash) {
            return substr($hash, 12, 10);
       }
       
       private function validPass ($pass, $hash) {
            $salt = $this->repairSalt($hash);
            $hash2 = $this->passHash($pass, $salt);
            
            return $hash === $hash2;
       }

		public function generateToken() {
			$email = $this->validateParameter('email', $this->param['email'], STRING);
			$pass = $this->validateParameter('pass', $this->param['pass'], STRING);
            $secret_key = $this->validateParameter('secret_key', $this->param['secret_key'], STRING);
			
            try {
                if(!is_array($user)) {
					$this->returnResponse(INVALID_USER_PASS, "secret_key is incorrect.");
				}
                
				$stmt = $this->dbConn->prepare("
                SELECT aa.email, aa.pass, aa.secret_key, aa.user_id, u.validStatus, ud.type_person 
                    FROM 
                        tori_users as u, 
                        tori_api_access as aa, 
                        tori_user_date as ud 
                    WHERE aa.email = :email AND aa.user_id = ud.user_id AND aa.user_id = u.id AND aa.secret_key = :secret_key
                ");
				$stmt->bindParam(":email", $email);
				$stmt->bindParam(":secret_key", $secret_key);
				$stmt->execute();
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				
                if(!is_array($user)) {
					$this->returnResponse(INVALID_USER_PASS, "Email is incorrect.");
				}

				if( $user['validStatus'] !== '1' and $user['type_persone'] !== '4') {
					$this->returnResponse(USER_NOT_ACTIVE, "Access is denied");
				}
                
                if(!$this->validPass($pass, $user['pass'])) {
                    $this->returnResponse(INVALID_USER_PASS, "Password is incorrect.");
                }

				$paylod = [
					'iat' => time(),
					'iss' => 'localhost',
					'exp' => time() + 604800,
					'userId' => $user['user_id']
				];
                
				$token = JWT::encode($paylod, $secret_key);
				
				$data = ['token' => $token];
				$this->returnResponse(SUCCESS_RESPONSE, $data);
			} catch (Exception $e) {
				$this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
			}
		}
        
        public function AllCustomers () {
			$customers = $this->model->getAllCustomers();
			$response = array();
            
            if(!is_array($customers)) {
				$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Customers not found.']);
			}
            
            foreach ($customers as $cust) {
                $response[$cust['login']] = array(
                    'customerId' 	   => $cust['id'],
        			'customerEmail'    => $cust['email'],
                    'customerName'	   => $cust['name'],
                    'customerLastname' => $cust['lastname'],
        			'customerMobile'   => $cust['mobile'],
        			'customerAvatar'   => $cust['user_img']
                );
            }
			
            $this->returnResponse(SUCCESS_RESPONSE, $response);
        }

		public function getCustomerPortfolio() {
			$customerId = $this->validateParameter('customerId', $this->param['customerId'], INTEGER);

			$this->model->setId($customerId);
			$customer = $this->model->getCustomerPortfolioById();
			
            if(!is_array($customer)) {
				$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Customer details not found.']);
			}

			$response['portfolioId']             = $customer['id'];
			$response['portfolioName'] 	         = $customer['name'];
			$response['portfolioLastname'] 	     = $customer['lastname'];
			$response['portfolioBirthDate']      = $customer['birthDate'];
			$response['portfolioNacional'] 	     = $customer['nacional'];
			$response['portfolioMobile'] 	     = $customer['mobile'];
			$response['portfolioEmail'] 	     = $customer['email'];
            $response['portfolioFiscalCode']     = $customer['fiscalCode'];
			$response['portfolioDocument'] 	     = htmlspecialchars_decode($customer['document']);
			$response['portfolioAdresResident']  = $customer['adresResident'];
            
			if ($customer['adresDomicilio'] != '0') $response['portfolioAdresDomicilio'] = $customer['adresDomicilio'];

            $response['portfolioPatent'] 		 = unserialize($customer['patent']);
			$response['portfolioMarital_status'] = ($customer['marital_status'] == '0')?'No family':'Have a family';
			$response['portfolioAbout'] 	     = htmlspecialchars_decode($customer['about']);
            
            $response['portfolioAssests']        = $customer['portfolioAssests'];
			$response['portfolioInterests'] 	 = $customer['portfolioInterests'];
			$response['portfolioHobbi'] 		 = $customer['portfolioHobbi'];
            
			$response['portfolioSearch_status']  = ($customer['search_status'] == '0')?'Resume is open to the public':'The user has disabled his resume from public access for personal reasons';
			
            $this->returnResponse(SUCCESS_RESPONSE, $response);
		}
        
        public function getCustomerCandidats () {
            $this->model->setId($this->userId);
			$customers = $this->model->getAllCandidats();
			$response = array();
            
            if(!is_array($customers)) {
				$this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Candidats not found.']);
			}
            
            foreach ($customers as $cust) {
                $response[$cust['login']] = array(
                    'customerCandidatId'   => $cust['id'],
        			'customerEmail'        => $cust['email'],
                    'customerName'	       => $cust['name'],
                    'customerLastname'     => $cust['lastname'],
        			'customerMobile'       => $cust['mobile'],
                    'customerTitleVacance' => $cust['title'],
        			'customerDate'         => $cust['date_add'],
        			'customerAvatar'       => $cust['portfolio_img']
                );
            }
			
            $this->returnResponse(SUCCESS_RESPONSE, $response);
        }
        
        public function getCategoryVacancy () {
            if(!isset($this->param['language'])) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Insert language code. Example it - Italiano, en - English'); exit;
            } else $lang = $this->validateParameter('language', $this->param['language'], STRING);
            
			$category_date = $this->model->getCategoryVacancyData($lang);
            
            if($category_date) $this->returnResponse(SUCCESS_RESPONSE, $category_date);
            else $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Category not found.']);
        }
        
        public function getBranchList () {
			$branch_list = $this->model->getBranchListData($this->userId);
            
            if($branch_list) $this->returnResponse(SUCCESS_RESPONSE, $branch_list);
            else $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Branch not found.']);
        }
        
        public function newBranch () {
            $insertData = array();
            if(is_array($this->param['branch'])) {
                foreach($this->param['branch'] as $k => $branch) {
                    $name_company = $this->validateParameter('name_company', $branch['name_company'], STRING);
                    $adres = $this->validateParameter('adres', $branch['adres'], STRING);
                    $phone = $this->validateParameter('phone', $branch['phone'], STRING);
                    $email = $this->validateParameter('email', $branch['email'], STRING);
                    $url_company = $this->validateParameter('url_company', $branch['url_company'], STRING);
                    $img = $this->validateParameter('img', $branch['img'], STRING);
                    
                    $insertData['id_user'] = $this->userId;
                    if($branch['name_company'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert name of filial!'); exit;
                    } else $insertData['name_company'] = $this->validateParameter('name_company', $branch['name_company'], STRING);
                    
                    if($branch['adres'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert adres!'); exit;
                    } else $insertData['adres'] = $this->validateParameter('adres', $branch['adres'], STRING);
                    
                    if($branch['phone'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert phone!'); exit;
                    } else $insertData['phone'] = $this->validateParameter('phone', $branch['phone'], STRING);
                    
                    if($branch['email'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert email!'); exit;
                    } else $insertData['email'] = $this->validateParameter('email', $branch['email'], STRING);
                    
                    if ($branch['url_company'] == '') $insertData['url_company'] = '';
                    else $insertData['url_company'] = $this->validateParameter('url_company', $branch['url_company'], STRING);
                    
                    if ($branch['img'] == '') $insertData['img'] = '';
                    else $insertData['img'] = $this->validateParameter('img', $branch['img'], STRING);
                    
                    $this->model->addNewBranch($insertData);
                }
            } else {
                $insertData['id_user'] = $this->userId;
                if($this->param['name_company'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert name of filial!'); exit;
                } else $insertData['name_company'] = $this->validateParameter('name_company', $this->param['name_company'], STRING);
                
                if($this->param['adres'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert adres!'); exit;
                } else $insertData['adres'] = $this->validateParameter('adres', $this->param['adres'], STRING);
                
                if($this->param['phone'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert phone!'); exit;
                } else $insertData['phone'] = $this->validateParameter('phone', $this->param['phone'], STRING);
                if($this->param['email'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert email!'); exit;
                } else $insertData['email'] = $this->validateParameter('email', $this->param['email'], STRING);
                
                if ($this->param['url_company'] == '') $insertData['url_company'] = '';
                else $insertData['url_company'] = $this->validateParameter('url_company', $this->param['url_company'], STRING);
                
                if ($this->param['img'] == '') $insertData['img'] = '';
                else $insertData['img'] = $this->validateParameter('img', $this->param['img'], STRING);
                
                $this->model->addNewBranch($insertData);
            }
            $this->returnResponse(SUCCESS_RESPONSE, 'Branch added!');
        }
        
        public function updateBranch() {
            $indertData = array();
            if(is_array($this->param['branch'])) {
                foreach($this->param['branch'] as $k => $branch) {
                    $indertData['id_user'] = $this->userId;
                    if($branch['id'] != '') {
                        $indertData['id'] = $this->validateParameter('id', $branch['id'], INTEGER);
                        $branch_data = $this->model->getBranchDataById($this->userId, $indertData['id']);
                    } elseif(!isset($branch['id']) or $branch['id'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert branch id!'); exit;
                    }
                
                    if($branch['name_company'] == '' and $branch_data['name_company'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert name of company'); exit;
                    } else {
                        $indertData['name_company'] = $this->validateParameter('name_company', $branch['name_company'], STRING);
                    }
                
                    if($branch['adres'] == '' and $branch_data['adres'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert adres'); exit;
                    } else {
                        $indertData['adres'] = $this->validateParameter('adres', $branch['adres'], STRING);
                    }
                
                    if($branch['phone'] == '' and $branch_data['phone'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert phone'); exit;
                    } else {
                        $indertData['phone'] = $this->validateParameter('phone', $branch['phone'], STRING);
                    }
                
                    if($branch['email'] == '' and $branch_data['email'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert email'); exit;
                    } else {
                        $indertData['email'] = $this->validateParameter('email', $branch['email'], STRING);
                    }
                    
                    if($branch['url_company'] == '' and $branch_data['url_company'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert url of company'); exit;
                    } else {
                        $indertData['url_company'] = $this->validateParameter('url_company', $branch['url_company'], STRING);
                    }
                
                    if($branch['img'] == '' and $branch_data['img'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert logo'); exit;
                    } else {
                        $indertData['img'] = $this->validateParameter('img', $branch['img'], STRING);
                    }
                    
                    $r = $this->model->updBranch($indertData, 'id = :id AND id_user = :id_user');
                }
            } else {
                $indertData['id_user'] = $this->userId;
                if($this->param['id'] != '') {
                    $indertData['id'] = $this->validateParameter('id', $this->param['id'], INTEGER);
                    $branch_data = $this->model->getBranchDataById($this->userId, $indertData['id']);
                } elseif(!isset($this->param['id'])) {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert branch id!'); exit;
                }
            
                if(!isset($this->param['name_company']) and $branch_data['name_company'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert name of company'); exit;
                } else {
                    $indertData['name_company'] = $this->validateParameter('name_company', $this->param['name_company'], STRING);
                }
            
                if(!isset($this->param['adres']) and $branch_data['adres'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert adres'); exit;
                } else {
                    $indertData['adres'] = $this->validateParameter('adres', $this->param['adres'], STRING);
                }
            
                if(!isset($this->param['phone']) and $branch_data['phone'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert phone'); exit;
                } else {
                    $indertData['phone'] = $this->validateParameter('phone', $this->param['phone'], STRING);
                }
            
                if(!isset($this->param['email']) and $branch_data['email'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert email'); exit;
                } else {
                    $indertData['email'] = $this->validateParameter('email', $this->param['email'], STRING);
                }
                
                if(!isset($this->param['url_company']) and $branch_data['url_company'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert url of company'); exit;
                } else {
                    $indertData['url_company'] = $this->validateParameter('url_company', $this->param['url_company'], STRING);
                }
            
                if(!isset($this->param['img']) and $branch_data['img'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert logo'); exit;
                } else {
                    $indertData['img'] = $this->validateParameter('img', $this->param['img'], STRING);
                }
                
                $this->model->updBranch($indertData, 'id = :id AND id_user = :id_user');
            }
            
		    $this->returnResponse(SUCCESS_RESPONSE, 'Branch updated!');
		}
        
        public function trashBranch () {
            if(is_array($this->param['branch'])) {
                foreach($this->param['branch'] as $k => $branch) {
                    if($branch['branchId'] == '' or !isset($branch['branchId'])){
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert id of filial'); exit;
                    } else $branchId = $this->validateParameter('branchId', $branch['branchId'], INTEGER);
                    
                    $where = array(
                        'id' => $branchId,
                        'id_user' => $this->userId
                    );
        			$delete_branch = $this->model->deleteBranch($where);
                }
                $this->returnResponse(SUCCESS_RESPONSE, 'Branch is deleted');
            } else {
                if($this->param['branchId'] == '' or !isset($this->param['branchId'])){
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert id of filial'); exit;
                } else $branchId = $this->validateParameter('branchId', $this->param['branchId'], INTEGER);
                
                $where = array(
                    'id' => $branchId,
                    'id_user' => $this->userId
                );
    			$delete_branch = $this->model->deleteBranch($where);
                $this->returnResponse(SUCCESS_RESPONSE, 'Branch is deleted');
            }
        }
        
        public function countryList () {
            if(!isset($this->param['language'])) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Insert language code. Example it - Italiano, en - English'); exit;
            } else $lang = $this->validateParameter('language', $this->param['language'], STRING);
            
			$countryList = $this->model->getCountryList($lang);
            
            if($countryList) $this->returnResponse(SUCCESS_RESPONSE, $countryList);
            else $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Country not found.']);
        }
        
        public function regionList () {
            if(!isset($this->param['country_id'])) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Insert Country Id, integer type'); exit;
            } else $c_id = $this->validateParameter('country_id', $this->param['country_id'], INTEGER);
            
            if(!isset($this->param['language'])) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Insert language code. Example it - Italiano, en - English'); exit;
            } else $lang = $this->validateParameter('language', $this->param['language'], STRING);
            
			$regionList = $this->model->getRegionList($lang, $c_id);
            
            if($regionList) $this->returnResponse(SUCCESS_RESPONSE, $regionList);
            else $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Regions not found.']);
        }
        
        public function provincesList () {
            if(!isset($this->param['country_id'])) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Insert Country Id, integer type'); exit;
            } else $c_id = $this->validateParameter('country_id', $this->param['country_id'], INTEGER);
            
            if(!isset($this->param['region_id'])) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Insert Region Id, integer type'); exit;
            } else $r_id = $this->validateParameter('region_id', $this->param['region_id'], INTEGER);
            
            if(!isset($this->param['language'])) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Insert language code. Example it - Italiano, en - English'); exit;
            } else $lang = $this->validateParameter('language', $this->param['language'], STRING);
            
			$provincesList = $this->model->getProvincesList($lang, $c_id, $r_id);
            
            if($provincesList) $this->returnResponse(SUCCESS_RESPONSE, $provincesList);
            else $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Provinces not found.']);
        }
        
        public function newVacancy() {
            $indertData = array();
            if(is_array($this->param['vacancy'])) {
                foreach($this->param['vacancy'] as $k => $vacancy) {
                    $id_category = $this->validateParameter('id_category', $vacancy['id_category'], INTEGER);
                    $title = $this->validateParameter('title', $vacancy['title'], STRING);
                    $seo = $this->validateParameter('seo', $vacancy['seo'], STRING);
                    $tags = $this->validateParameter('tags', $vacancy['tags'], STRING);
                    $short_desc = $this->validateParameter('short_desc', $vacancy['short_desc'], STRING);
                    $full_desc = $this->validateParameter('full_desc', $vacancy['full_desc'], STRING);
                    $country = $this->validateParameter('country', $vacancy['country'], INTEGER);
                    $region = $this->validateParameter('region', $vacancy['region'], INTEGER);
                    $provinces = $this->validateParameter('provinces', $vacancy['provinces'], INTEGER);
                    $location = $this->validateParameter('location', $vacancy['location'], STRING);
                    
                    $ifBranchExist = $this->model->ifBranchExist($this->userId);
                    
                    if($id_category == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert ID of category'); exit;
                    }
                    
                    if(!$ifBranchExist and $this->param['id_filial'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert filial id!');
                        exit;
                    } elseif(!$ifBranchExist) {
                        $id_filial = $this->validateParameter('id_filial', $this->param['id_filial'], INTEGER);
                        $indertData['id_filial'] = NULL;
                    }
                    if($title == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert title'); exit;
                    }
                    
                    if($seo == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert seo title'); exit;
                    }
                    
                    if($tags == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert tags separated by commas'); exit;
                    }
                    
                    if($short_desc == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert short description'); exit;
                    }
                    
                    if($full_desc == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert full text'); exit;
                    }
                    
                    if($location == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert location'); exit;
                    }
                    
                    if($country == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert country'); exit;
                    }
                    
                    if($region == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert region'); exit;
                    }
                    
                    if($provinces == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert provinces'); exit;
                    }
                    
                    $ifVacancyExist = $this->model->ifVacancyExist($seo);
                    if(empty($ifVacancyExist)) {
                        $indertData['id_user'] = $this->userId;
                        $indertData['id_category'] = $id_category;
                        $indertData['title'] = $title;
                        $indertData['tags'] = $tags;
                        $indertData['seo'] = $seo;
                        $indertData['short_desc'] = $short_desc;
                        $indertData['full_desc'] = $full_desc;
                        $indertData['country'] = $country;
                        $indertData['region'] = $region;
                        $indertData['provinces'] = $provinces;
                        $indertData['location'] = $location;
                        $indertData['date_add'] = time();
                        
            			$this->model->addNewVacancy($indertData);
                    } else {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Change the seo title!'); exit;
                    }
                }
                $this->returnResponse(SUCCESS_RESPONSE, 'Vacancy inserted!'); exit;
            } else {
                $id_category = $this->validateParameter('id_category', $this->param['id_category'], INTEGER);
                $title = $this->validateParameter('title', $this->param['title'], STRING);
                $seo = $this->validateParameter('seo', $this->param['seo'], STRING);
                $tags = $this->validateParameter('tags', $this->param['tags'], STRING);
                $short_desc = $this->validateParameter('short_desc', $this->param['short_desc'], STRING);
                $full_desc = $this->validateParameter('full_desc', $this->param['full_desc'], STRING);
                $country = $this->validateParameter('country', $this->param['country'], INTEGER);
                $region = $this->validateParameter('region', $this->param['region'], INTEGER);
                $provinces = $this->validateParameter('provinces', $this->param['provinces'], INTEGER);
                $location = $this->validateParameter('location', $this->param['location'], STRING);
                
                $ifBranchExist = $this->model->ifBranchExist($this->userId);
                
                if($id_category == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert ID of category'); exit;
                    }
                    
                    if(!$ifBranchExist and $this->param['id_filial'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert filial id!');
                        exit;
                    } elseif(!$ifBranchExist) {
                        $id_filial = $this->validateParameter('id_filial', $this->param['id_filial'], INTEGER);
                        $indertData['id_filial'] = NULL;
                    }
                    if($title == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert title'); exit;
                    }
                    
                    if($seo == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert seo title'); exit;
                    }
                    
                    if($tags == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert tags separated by commas'); exit;
                    }
                    
                    if($short_desc == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert short description'); exit;
                    }
                    
                    if($full_desc == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert full text'); exit;
                    }
                    
                    if($country == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert country'); exit;
                    }
                    
                    if($region == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert region'); exit;
                    }
                    
                    if($provinces == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert provinces'); exit;
                    }
                    
                    if($location == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert location'); exit;
                    }
                
                $ifVacancyExist = $this->model->ifVacancyExist($seo);
                if($ifVacancyExist) {
                    $indertData['id_user'] = $this->userId;
                    $indertData['id_category'] = $id_category;
                    $indertData['title'] = $title;
                    $indertData['tags'] = $tags;
                    $indertData['seo'] = $seo;
                    $indertData['short_desc'] = $short_desc;
                    $indertData['full_desc'] = $full_desc;
                    $indertData['country'] = $country;
                    $indertData['region'] = $region;
                    $indertData['provinces'] = $provinces;
                    $indertData['location'] = $location;
                    $indertData['date_add'] = time();
                    
        			$this->model->addNewVacancy($indertData);
                    
    			    $this->returnResponse(SUCCESS_RESPONSE, 'Vacancy inserted!');
                } else {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Change the seo title!'); exit;
                }
            }
		}
        
        public function getVacancyList () {
			$vacancy_list = $this->model->getVacancyListData($this->userId);            
            if($vacancy_list) $this->returnResponse(SUCCESS_RESPONSE, $vacancy_list);
            else $this->returnResponse(SUCCESS_RESPONSE, ['message' => 'Vacancy not found.']);
        }
        
        public function updateVacancy() {
            $indertData = array();
            
            if(is_array($this->param['vacancy'])) {
                foreach($this->param['vacancy'] as $k => $vacancy) {
                    if($vacancy['id'] != '') {
                        $indertData['id'] = $this->validateParameter('id', $vacancy['id'], INTEGER);
                        $vacancy_data = $this->model->getVacancyDataById($this->userId, $indertData['id']);
                    } elseif(!isset($vacancy['id'])) {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert vacancy id!'); exit;
                    }
                    
                    if(!isset($vacancy['id_category']) or $vacancy_data['id_category'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert category id!'); exit;
                    } else {
                        $indertData['id_category'] = $this->validateParameter('id_category', $vacancy['id_category'], INTEGER);
                    }
                    
                    if($vacancy['id_filial'] != '') {
                        $indertData['id_filial'] = $this->validateParameter('id_filial', $vacancy['id_filial'], INTEGER);
                    } elseif(!isset($vacancy['id_filial'])) {
                        if(!$this->model->ifBranchExist($this->userId) and $vacancy_data['id_filial'] == '') {
                            $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert branch id!'); exit;
                        } else $indertData['id_filial'] = $vacancy_data['id_filial'];
                    }
                    
                    if(!isset($vacancy['title']) and $vacancy_data['title'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert title'); exit;
                    } else {
                        $indertData['title'] = $this->validateParameter('title', $vacancy['title'], STRING);
                    }
                    
                    if(!isset($vacancy['seo']) and $vacancy_data['seo'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert seo title'); exit;
                    } else {
                        $indertData['seo'] = $this->validateParameter('seo', $vacancy['seo'], STRING);
                    }
                    
                    if(!isset($vacancy['tags']) and $vacancy_data['tags'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert tags separated by commas'); exit;
                    } else {
                        $indertData['tags'] = $this->validateParameter('tags', $vacancy['tags'], STRING);
                    }
                    
                    if(!isset($vacancy['short_desc']) and $vacancy_data['short_desc'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert short description'); exit;
                    } else {
                        $indertData['short_desc'] = $this->validateParameter('short_desc', $vacancy['short_desc'], STRING);
                    }
                    
                    if(!isset($vacancy['full_desc']) and $vacancy_data['full_desc'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert full text'); exit;
                    } else {
                        $indertData['full_desc'] = $this->validateParameter('full_desc', $vacancy['full_desc'], STRING);
                    }
                    
                    if(!isset($vacancy['country']) and $vacancy_data['country'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert country'); exit;
                    } else {
                        $indertData['country'] = $this->validateParameter('country', $vacancy['country'], INTEGER);
                    }
                    
                    if(!isset($vacancy['region']) and $vacancy_data['region'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert region'); exit;
                    } else {
                        $indertData['region'] = $this->validateParameter('region', $vacancy['region'], INTEGER);
                    }
                    
                    if(!isset($vacancy['provinces']) and $vacancy_data['provinces'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert provinces'); exit;
                    } else {
                        $indertData['provinces'] = $this->validateParameter('provinces', $vacancy['provinces'], INTEGER);
                    }
                    
                    if(!isset($vacancy['location']) and $vacancy_data['location'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert location'); exit;
                    } else {
                        $indertData['location'] = $this->validateParameter('location', $vacancy['location'], STRING);
                    }
                    
                    $ifVacancyExist = $this->model->ifVacancyExist($indertData['seo']);
                    if($ifVacancyExist['id'] == $vacancy['id']) {
                        $indertData['id_user'] = $this->userId;
            			$this->model->updVacancy($indertData, 'id = :id AND id_user = :id_user');
                    } else {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Change the seo title!');
                    }
               }
               $this->returnResponse(SUCCESS_RESPONSE, 'Vacancy updated!');
            } else {
                if($this->param['id'] != '') {
                    $indertData['id'] = $this->validateParameter('id', $this->param['id'], INTEGER);
                    $vacancy_data = $this->model->getVacancyDataById($this->userId, $indertData['id']);
                } elseif(!isset($this->param['id'])) {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert vacancy id!'); exit;
                }
                
                if(!isset($this->param['id_category']) or $vacancy_data['id_category'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert category id!'); exit;
                } else {
                    $indertData['id_category'] = $this->validateParameter('id_category', $this->param['id_category'], INTEGER);
                }
                
                if($this->param['id_filial'] != '') {
                    $indertData['id_filial'] = $this->validateParameter('id_filial', $this->param['id_filial'], INTEGER);
                } elseif(!isset($this->param['id_filial'])) {
                    if(!$this->model->ifBranchExist($this->userId) and $vacancy_data['id_filial'] == '') {
                        $this->returnResponse(SUCCESS_RESPONSE, 'Insert branch id!'); exit;
                    }
                }
                
                if(!isset($this->param['title']) and $vacancy_data['title'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert title'); exit;
                } else {
                    $indertData['title'] = $this->validateParameter('title', $this->param['title'], STRING);
                }
                
                if(!isset($this->param['seo']) and $vacancy_data['seo'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert seo title'); exit;
                } else {
                    $indertData['seo'] = $this->validateParameter('seo', $this->param['seo'], STRING);
                }
                
                if(!isset($this->param['tags']) and $vacancy_data['tags'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert tags separated by commas'); exit;
                } else {
                    $indertData['tags'] = $this->validateParameter('tags', $this->param['tags'], STRING);
                }
                
                if(!isset($this->param['short_desc']) and $vacancy_data['short_desc'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert short description'); exit;
                } else {
                    $indertData['short_desc'] = $this->validateParameter('short_desc', $this->param['short_desc'], STRING);
                }
                
                if(!isset($this->param['full_desc']) and $vacancy_data['full_desc'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert full text'); exit;
                } else {
                    $indertData['full_desc'] = $this->validateParameter('full_desc', $this->param['full_desc'], STRING);
                }
                    
                if(!isset($this->param['country']) and $vacancy_data['country'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert country'); exit;
                } else {
                    $indertData['country'] = $this->validateParameter('country', $this->param['country'], INTEGER);
                }
                
                if(!isset($this->param['region']) and $vacancy_data['region'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert region'); exit;
                } else {
                    $indertData['region'] = $this->validateParameter('region', $this->param['region'], INTEGER);
                }
                
                if(!isset($this->param['provinces']) and $vacancy_data['provinces'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.': Insert provinces'); exit;
                } else {
                    $indertData['provinces'] = $this->validateParameter('provinces', $this->param['provinces'], INTEGER);
                }
                
                if(!isset($this->param['location']) and $vacancy_data['location'] == '') {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Insert location'); exit;
                } else {
                    $indertData['location'] = $this->validateParameter('location', $this->param['location'], STRING);
                }
                
                $ifVacancyExist = $this->model->ifVacancyExist($indertData['seo']);
                if($ifVacancyExist['id'] == $this->param['id']) {
                    $indertData['id_user'] = $this->userId;
        			$this->model->updVacancy($indertData, 'id = :id AND id_user = :id_user');
    			    $this->returnResponse(SUCCESS_RESPONSE, 'Vacancy updated!');
                } else {
                    $this->returnResponse(SUCCESS_RESPONSE, 'Change the seo title!');
                }
            }
		}
        
        public function trashVacancy() {
            if(is_array($this->param['vacancy'])) {
                foreach($this->param['vacancy'] as $k => $vacancy) {
                    if($vacancy['vacancyId'] == '' or !isset($vacancy['vacancyId'])){
                        $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert id of filial'); exit;
                    } else $vacancyId = $this->validateParameter('vacancyId', $vacancy['vacancyId'], INTEGER);
                    
                    $where = array(
                        'id' => $vacancyId,
                        'id_user' => $this->userId
                    );
        			$delete_branch = $this->model->deleteVacancy($where);
                }
                $this->returnResponse(SUCCESS_RESPONSE, 'Vacancy is deleted');
           } else {
                if($this->param['vacancyId'] == '' or !isset($this->param['vacancyId'])){
                    $this->returnResponse(SUCCESS_RESPONSE, 'Array number '.$k.' Insert id of filial'); exit;
                } else $vacancyId = $this->validateParameter('vacancyId', $this->param['vacancyId'], INTEGER);
            
                $where = array(
                    'id' => $vacancyId,
                    'id_user' => $this->userId
                );
    			$delete_branch = $this->model->deleteVacancy($where);
                
                $this->returnResponse(SUCCESS_RESPONSE, 'Vacancy is deleted');
           }
		}
        
        public function shortStatisticAgencies () {
            $result = $this->model->getStatisticAgencies();
            
            $this->returnResponse(SUCCESS_RESPONSE, $result);
        }

		/*public function updateCustomer() {
			$customerId = $this->validateParameter('customerId', $this->param['customerId'], INTEGER);
			$name = $this->validateParameter('name', $this->param['name'], STRING, false);
			$addr = $this->validateParameter('addr', $this->param['addr'], STRING, false);
			$mobile = $this->validateParameter('mobile', $this->param['mobile'], INTEGER, false);

			$cust = new Customer;
			$cust->setId($customerId);
			$cust->setName($name);
			$cust->setAddress($addr);
			$cust->setMobile($mobile);
			$cust->setUpdatedBy($this->userId);
			$cust->setUpdatedOn(date('Y-m-d'));

			if(!$cust->update()) {
				$message = 'Failed to update.';
			} else {
				$message = "Updated successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}

		public function deleteCustomer() {
			$customerId = $this->validateParameter('customerId', $this->param['customerId'], INTEGER);

			$cust = new Customer;
			$cust->setId($customerId);

			if(!$cust->delete()) {
				$message = 'Failed to delete.';
			} else {
				$message = "deleted successfully.";
			}

			$this->returnResponse(SUCCESS_RESPONSE, $message);
		}*/
	}
	
 ?>