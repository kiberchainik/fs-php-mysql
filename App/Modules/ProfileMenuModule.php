<?php
	class ProfileMenuModule extends Controller {
	   public function action_index() {
	       $v = new View('account/profilemenu');
           $profilemenu = $this->lang('profilemenu');
           $v->u_date = '';
           if(AuthClass::instance()->isAuth()) {
               $v->u_date = AuthClass::instance()->getUser();
               $v->nunMessage = MessagesModel::Instance()->countMessagesForUser($v->u_date['u_id']);
               $v->numComments = CommentsModel::Instance()->countCommentsForUser($v->u_date['u_id']);
               $v->numCandidats = ProfileModel::Instance()->countCandidatsForUser($v->u_date['u_id']);
               
               $v->numAdverts = AdvertsModel::Instance()->getNumAdvertsOfUser($v->u_date['u_id']);
               $v->vacancies = VacanciesModel::Instance()->getNumVacanciesOfUser($v->u_date['u_id']);
               $v->candidati = SaveportfolioModel::Instance()->getNumProfessionalsOfUser($v->u_date['u_id']);
           }
           
           $v->text_profile = $profilemenu['profile'];
           $v->text_numAdverts = $profilemenu['numAdverts'];
           $v->text_numvacancies = $profilemenu['numvacancies'];
           $v->text_numcandidati = $profilemenu['numcandidati'];
           $v->text_profile_edit = $profilemenu['profile_edit'];
           $v->text_addnews = $profilemenu['addnews'];
           $v->text_public_edit = $profilemenu['public_edit'];
           $v->text_promo_page = $profilemenu['promo_page'];
           $v->text_saved_news = $profilemenu['saved_news'];
           $v->text_news_dont_active = $profilemenu['news_dont_active'];
           $v->text_messages_btn = $profilemenu['messages_btn'];
           $v->text_portfolio = $profilemenu['portfolio'];
           $v->text_review = $profilemenu['review'];
           $v->text_autosearch = $profilemenu['autosearch'];
           $v->text_saved_portfolio = $profilemenu['saved_portfolio'];
           $v->text_adverts = $profilemenu['adverts'];
           $v->text_comments = $profilemenu['comments'];
           $v->text_vacancies = $profilemenu['vacancies'];
           $v->text_candidatura = $profilemenu['candidatura'];
           $v->text_branch = $profilemenu['branch'];
           $v->text_logout = $profilemenu['logout'];
           
	       $this->response($v);
	   }
	}
?>