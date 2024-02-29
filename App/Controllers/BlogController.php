<?php
	class BlogController extends Controller {
	   public function action_index() {
	       $v = new View('site/blog');
           $lang_blog = $this->lang('blog');
           
           $v->title = $lang_blog['title'];
           $v->description = $lang_blog['description'];
           $v->keywords = '';
           $v->og_img = '';
           
           $v->text_search = $lang_blog['search'];
           $v->text_latest_post = $lang_blog['latest_post'];
           $v->text_by = $lang_blog['by'];
           $v->text_views = $lang_blog['views'];
           /*$v->text_ = $lang_blog[''];
           $v->text_ = $lang_blog[''];
           $v->text_ = $lang_blog[''];
           $v->text_ = $lang_blog[''];*/
           
           $v->header = $this->module('Header');
           $v->mainmenu = $this->module('MainMenu');
           $v->blogMenu = $this->module('BlogMenu');
           $v->footer = $this->module('Footer');
           
           $page = Router::getUriParam('page');
           $count = BlogModel::Instance()->getArticlesCount(3);
           
           if($page < 1 or $page > $count) throw new RouteException('Invalide num page {'.$page.'}', 404);
           
           $v->lastArticles = BlogModel::Instance()->GetLastArticles(5);
           
           $v->ArticlesList = BlogModel::Instance()->GetListArticles($page, 3);
           $v->pagination = HTMLHelper::pagination($page, $count, Url::local('blog'));
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_category() {
           $v = new View('site/blog');
           $lang_blog = $this->lang('blog');
           
           $v->title = $lang_blog['title'];
           $v->description = $lang_blog['description'];
           $v->keywords = $lang_blog['keywords'];
           $v->og_img = '';
           
           $v->text_search = $lang_blog['search'];
           $v->text_latest_post = $lang_blog['latest_post'];
           $v->text_by = $lang_blog['by'];
           $v->text_views = $lang_blog['views'];
           
           $v->header = $this->module('Header');
           $v->blogMenu = $this->module('BlogMenu');
           $v->mainmenu = $this->module('MainMenu');
           $v->footer = $this->module('Footer');
           
           $page = (int)Router::getUriParam('page');
           $subCat = Router::getUriParam(2);;           
           $count = BlogModel::Instance()->getArticlesCount(3, $subCat);
           
           if ($count == '0') {
               $v->ArticlesList = 'This category don\'t have articles';
           } else {
               if($page < 1 or $page > $count) throw new RouteException('Invalide num page {'.$page.'}', 404);
            
               $v->lastArticles = BlogModel::Instance()->GetLastArticles(5);
           
               $v->ArticlesList = BlogModel::Instance()->GetListArticles($page, 3, $subCat);
               $v->pagination = HTMLHelper::pagination($page, $count, Url::local('blog'));
           }
           
           $v->useTemplate();
	       $this->response($v);
	   }
       
       public function action_article(){
           $v = new View('site/blog_article');
           $lang_blog = $this->lang('blog');
           
           $v->text_search = $lang_blog['search'];
           $v->text_latest_post = $lang_blog['latest_post'];
           $v->text_by = $lang_blog['by'];
           $v->text_views = $lang_blog['views'];
           
           $v->header = $this->module('Header');
           $v->footer = $this->module('Footer');
           $v->blogMenu = $this->module('BlogMenu');
           
           $p_page = Router::getUriParam(2);
           $v->article = BlogModel::Instance()->getDataArticle($p_page);
           
           $v->lastArticles = BlogModel::Instance()->GetLastArticles(5);
           
           if(!$v->article) {
                $this->redirect(Url::local('blog'));
           } else {
                $v->og_img = $v->article['logo'];
                $v->title = $v->article['title'];
                $v->description = $v->article['description'];
                $v->keywords = $v->article['keywords'];
                $v->og_img = $v->article['logo'];
           
                if(!empty($v->article['tags'])) {
                    $v->tags = explode(',', $v->article['keywords']);
                }
           }
           $v->vews = $v->article['vews'] + 1;
           //$v->article['vews'] = 1+$vews;
           BlogModel::Instance()->UpdViewsBlog($v->vews, $v->article['id']);
           
           $v->useTemplate();
	       $this->response($v);
       }
    }
?>