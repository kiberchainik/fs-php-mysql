<?php 
	class DbConnect {
		private $server = 'localhost';
		private $dbname = 'urlpyrtf_fs';
		private $user = 'urlpyrtf_fs';
		private $pass = '62789242aLEX!';
        public  $db_pref = 'tori_';
        private $options = array(
                                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                    PDO::ATTR_PERSISTENT => true
                                );

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass, $this->options);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch (\Exception $e) {
				echo "Database Error: " . $e->getMessage();
			}
		}
	}
 ?>