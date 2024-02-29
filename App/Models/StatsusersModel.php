<?php
	class StatsusersModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function countVisitsToday ($date) {
            return DBClass::Instance()->getCount(
                'visits',
                'date = :date',
                array('date' => $date),
                'id'
            );
       }
       
       public function ClearTableIPS () {
            return DBClass::Instance()->deleteElement('ips');
       }
       
       public function insertNewIP ($data) {
            return DBClass::Instance()->insert('ips', $data);
       }
       
       public function insertNewUserData ($data) {
            return DBClass::Instance()->insert('visits', $data);
       }
       
       public function countIfVisitsExists ($ip_address) {
            return DBClass::Instance()->getCount(
                'ips',
                'ip_address = :ip_address',
                array('ip_address' => $ip_address),
                'id'
            );
       }
       
       public function selectCurentUser ($date) {
            return DBClass::Instance()->select(
                'visits',
                array('hosts, views'),
                'date = :date',
                array('date' => $date),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
       }
       
       public function updateVisits ($fields) {
            return DBClass::Instance()->update(
                'visits',
                $fields,
                'date = :date'
            );
       }
	}
?>