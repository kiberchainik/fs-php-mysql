<?php
	class CommentsModule extends Controller {
	   public function action_index($id) {
	       $v = new View('site/comments');
           
           $commentsAdvert = CommentsModel::Instance()->getCommentsForAdverts($id);
           $commTree = $this->getTree($commentsAdvert);
           $v->comments = $this->showComments($commTree);           
            /*echo '<pre>';
            print_r($commTree);
            echo '</pre>';*/
	       $this->response($v, true);
	   }
       
       private function getTree($dataset) {
        	$tree = array();

        	foreach ($dataset as $id => &$node) {
        		//Если нет вложений
        		if (!$node['parent_id']){
        			$tree[$id] = &$node;
        		}else{ 
        			//Если есть потомки то перебераем массив
                    $dataset[$node['parent_id']]['childs'][$id] = &$node;
        		}
        	}
        	return $tree;
        }
        
        private function tplComments($array, $ans){
    		$comm = '';
            
            $comm .= '<!-- Start Single Review -->
                <div class="pro__review '.$ans.'">
                    <div class="review__thumb">';
                        if(empty($array['user_img'])) {
                            $comm .= '<img src="/Media/images/no_avatar.png" class="user_portfolio_avatar" alt="review images" />';
                        } else {
                            $comm .= '<img src="'.$array['user_img'].'" class="user_portfolio_avatar" alt="review images" />';
                        }
                    $comm .= '</div>
                    <div class="review__details">
                        <div class="review__info">';
                            if($array['user_id'] == '0') $comm .= '<h4>'.$array['name'].'</h4>';
                            else $comm .= '<h4><a href="/users/page/'.$array['user_id'].'" target="_blank">'.$array['name'].'</a></h4>';
                            $comm .= '<div class="rating__send">
                                <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                                <a href="#"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                        <div class="review__date">
                            <span>'.date('D, d M y H:i', $array['date']).'</span>
                        </div>
                        <p>'.$array['message'].'</p>
                    </div>
                </div>
                <!-- End Single Review -->';
    		if(isset($array['childs'])){
    			$comm .= ''.$this->showComments($array['childs'], 'ans');
    		}
        	return $comm;
        }
        
        /*Рекурсивно считываем наш шаблон*/
        private function showComments($data, $ans = ''){
        	$string = '';
        	foreach($data as $item){
        		$string .= $this->tplComments($item, $ans);
        	}
        	return $string;
        }
	}
?>