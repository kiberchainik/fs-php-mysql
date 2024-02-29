<?php
	class StatsusersModule extends Controller {
	   public function action_index() {
            $visitor_ip = getenv("REMOTE_ADDR");
            $date = date("Y-m-d");
            $site_referer = getenv("HTTP_REFERER");
            $user_agent = getenv("HTTP_USER_AGENT");
            
            // Узнаем, были ли посещения за сегодня
            $count_visits_today = StatsusersModel::Instance()->countVisitsToday($date);
            
            // Если сегодня еще не было посещений
            if ($count_visits_today['numCount'] == '0') {
                // Очищаем таблицу ips
                StatsusersModel::Instance()->ClearTableIPS();
                
                // Заносим в базу IP-адрес текущего посетителя
                $ip_data = array(
                    'ip_address' => $visitor_ip,
                    'user_agent' => $user_agent,
                    'site_referer' => $site_referer
                );
                StatsusersModel::Instance()->insertNewIP($ip_data);
                
                // Заносим в базу дату посещения и устанавливаем кол-во просмотров и уник. посещений в значение 1
                $user_data = array(
                    'date' => $date,
                    'hosts' => 1,
                    'views' => 1
                );
                StatsusersModel::Instance()->insertNewUserData($user_data);
            } else { // Если посещения сегодня уже были
                $current_user = StatsusersModel::Instance()->selectCurentUser($date);
                // Проверяем, есть ли уже в базе IP-адрес, с которого происходит обращение
                $current_ip = StatsusersModel::Instance()->countIfVisitsExists($visitor_ip);
                
                // Если такой IP-адрес уже сегодня был (т.е. это не уникальный посетитель)
                if ($current_ip['numCount'] == '1') {
                    // Добавляем для текущей даты +1 просмотр (хит)
                    $upd_visits = array(
                        'date' => $date,
                        'views' => $current_user['views']+1
                    );
                    StatsusersModel::Instance()->updateVisits($upd_visits);
                } else { // Если сегодня такого IP-адреса еще не было (т.е. это уникальный посетитель)
                    // Заносим в базу IP-адрес этого посетителя
                    $ip_data = array('ip_address' => $visitor_ip);
                    StatsusersModel::Instance()->insertNewIP($ip_data);
                    
                    // Добавляем в базу +1 уникального посетителя (хост) и +1 просмотр (хит)
                    $upd_visits = array(
                        'date' => $date,
                        'hosts' => $current_user['hosts']+1,
                        'views' => $current_user ['views']+1
                    );
                    StatsusersModel::Instance()->updateVisits($upd_visits);
                }
            }
	   }
	}
?>