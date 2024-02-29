<?php
	class StatisticsModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function getStatisticAgencies () {
            $privat_users = DBClass::Instance()->getCount('user_date', 'type_person = 5');
            $users_portfolio = DBClass::Instance()->getCount('portfolio');
            $agency = DBClass::Instance()->DBAdmin('SELECT agency.company_name as Agenzia, COUNT(vc.id_c) as Candidati FROM '.DBClass::Instance()->config['db_pref'].'user_date AS agency LEFT JOIN '.DBClass::Instance()->config['db_pref'].'vacancie_candidats AS vc ON (agency.user_id = vc.id_user) WHERE vc.id_user = agency.user_id GROUP BY agency.company_name ');
            
			return $result = array(
                'utenti_privati_registrati' => $privat_users['numCount'],
                'cv_creati' => $users_portfolio['numCount'],
                'candidati' => $agency
            );
        }
	}
?>