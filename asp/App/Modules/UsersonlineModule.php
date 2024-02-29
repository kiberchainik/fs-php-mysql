<?php
	class UsersonlineModule extends Controller {
	   public function action_index() {           
           $v = new View('p_users_online');
           $settings = MainModel::Instance()->GetSettings();
           if(AuthClass::instance()->isAuth()) {
				$profile_data = AuthClass::instance()->getUser();
                $v->profile_logo = ($profile_data['user_img'])?$profile_data['user_img']:'Media/images/no_avatar.png';
				$v->auth = $profile_data['u_id'];
			} else $v->auth = false;
            
            $wine = 300; // точность он-лайн (секунды); время, в течении которого пользователя, зашедшего на страничку, мы считаем находящимся на сайте

            // удаляем всех, кто уже пробыл $wine секунд или у кого ИП текущий
            $v->sql_update = UsersonlineModel::Instance()->sql_update($wine, HTMLHelper::getIP());
            
            // вставляем свою запись
            $v->sql_insert = UsersonlineModel::Instance()->sql_insert(HTMLHelper::getIP());
            
            // считаем уников он-лайн
            $v->sql_sel = UsersonlineModel::Instance()->sql_sel();
            
            $online_people = count($v->sql_sel); // кол-во On-Line пользователей 
            $online_people = (string) $online_people; // приводим к строковому типу (так надо.. см. дальше)
            
            $rain = strlen($online_people) - 1; // номер последнего символа в числе on-line юзеров
            
            // форматирование вывода (я все сделал за вас =)
            if($online_people[$rain]==2||$online_people[$rain]==3
            ||$online_people[$rain]==4
            ||(strlen($online_people)!=1&&$online_people[strlen($online_people)-2]!=1))
            $line = " человека"; else $line = " человек"; // $line - переменная, определяющая формат вывода
            
            // возвращем результат
            $v->count = "На сайте <strong>".$online_people."</strong>$line";           
           
	       $this->response($v);
	   }
	}
?>