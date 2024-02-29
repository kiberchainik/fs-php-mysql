<?php
	class PrivateMenuModule extends Controller {
	   public function action_index() {
	       $v = new View('p_mainmenu');
           if(AuthClass::instance()->isAuth()) $v->u_date = AuthClass::instance()->getUser();
	       $this->response($v);
	   }
	}
?>