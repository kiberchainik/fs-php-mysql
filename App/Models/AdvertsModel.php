<?php
	class AdvertsModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function getAdvertDataForView ($arg) {
            return DBClass::Instance()->select(
                'adverts as ad left join '.DBClass::Instance()->config['db_pref'].'users as u on ad.idUser = u.id left join '.DBClass::Instance()->config['db_pref'].'user_date as ud on ad.idUser = ud.user_id left join '.DBClass::Instance()->config['db_pref'].'branch as ub on ud.user_id = ub.id_user and ub.id = ad.id_filial',
                array('ad.*, u.login, u.email, ud.name, ud.patent, ud.company_name, ud.company_link, ud.lastname, ud.mobile, ud.user_img, ud.address, ud.type_person, ub.name_company as filial_name, ub.adres as filial_address, ub.phone as filial_phone, ub.email as filial_email, ub.url_company as filial_url_company, ub.img as filial_img, (SELECT tori_user_type_description.name FROM tori_adverts, tori_user_date, tori_user_type_description WHERE tori_adverts.id = ad.id AND tori_user_date.type_person = tori_user_type_description.id_user_type AND tori_user_type_description.id_lang = :lang AND tori_user_date.user_id = tori_adverts.idUser ) as type_user'),
                'ad.seo = :ad_id or ad.id = :ad_id',
                array('ad_id' => $arg, 'lang' => (int)$_SESSION['lid']),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getNumAdvertsOfUser ($u_id) {
            return DBClass::Instance()->getCount('adverts', 'idUser = :id', array('id' => $u_id));
        }
        
        public function getFieldsForAdvert ($id) {
            return DBClass::Instance()->select(
                'adverts_fields as af
                LEFT JOIN '.DBClass::Instance()->config['db_pref'].'fields_data ON af.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id 
                LEFT JOIN '.DBClass::Instance()->config['db_pref'].'fields_placeholder ON '.DBClass::Instance()->config['db_pref'].'fields_placeholder.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id and '.DBClass::Instance()->config['db_pref'].'fields_placeholder.id_lang = :lang
                LEFT JOIN '.DBClass::Instance()->config['db_pref'].'fields_value ON '.DBClass::Instance()->config['db_pref'].'fields_value.id_field = '.DBClass::Instance()->config['db_pref'].'fields_data.id and '.DBClass::Instance()->config['db_pref'].'fields_value.id_value = af.field_value and '.DBClass::Instance()->config['db_pref'].'fields_value.id_lang = :lang',
                array('af.field_name, af.id_field, af.field_value, af.id_field_group, af.id_advert, '.DBClass::Instance()->config['db_pref'].'fields_data.type, '.DBClass::Instance()->config['db_pref'].'fields_placeholder.placeholder, '.DBClass::Instance()->config['db_pref'].'fields_value.value as f_value'),
                'af.id_advert = :id_adv',
                array('id_adv' => $id, 'lang' => (int)$_SESSION['lid']),
                '',
                'id_field',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getListImagesAdvert ($id) {
            $listImgsAdvert = array();
            
            $listImgsAdvert['list'] = DBClass::Instance()->select(
                'advert_imgs as ai',
                array('*'),
                'ai.id_adv = :id_adv',
                array('id_adv' => (int)$id),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
            
            $listImgsAdvert['count'] = DBClass::Instance()->getCount('advert_imgs', 'id_adv = :id_adv', array('id_adv' => (int)$id));
            
            return $listImgsAdvert;
        }
        
        public function GetNewAdvertsForMain ($limit) {
            return DBClass::Instance()->select(
                'adverts as ad, category_advert as ca, category as c, category_description as cd',
                array('ad.id, ad.add_date, ad.title, ad.seo, ad.description, ad.views, c.id as category_id, c.seo as category_seo, cd.title as category_title'),
                'ad.validate = 1 and ad.id = ca.id_advert and ca.mainCategoryAdvert = 1 and ca.id_category = c.id and ca.id_category = cd.category_id and cd.lang_id = :lang',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'add_date',
                '',
                $limit,
                '',
                '2'
            );
        }
        
        public function UpdViewsAdvert ($views, $id) {
            DBClass::Instance()->update('adverts', array('views' => (int)$views, 'id' => (int)$id), 'id = :id');
        }
        
        public function GetPopularAdvertsForMain ($limit) {
            return DBClass::Instance()->select(
                'adverts as ad, category_advert as ca, category as c, category_description as cd',
                array('ad.id, ad.title, ad.seo, ad.description, ad.views, ad.add_date, c.id as category_id, c.seo as category_seo, cd.title as category_title'),
                'ad.validate = 1 and ad.id = ca.id_advert and ca.mainCategoryAdvert = 1 and ca.id_category = c.id and ca.id_category = cd.category_id and cd.lang_id = :lang',
                array('lang' => (int)$_SESSION['lid']),
                '',
                'views',
                '',
                $limit,
                '',
                '2'
            );
        }
        
        public function getAdvertFolderImages ($id_adv) {
            return DBClass::Instance()->select(
                'adverts',
                array('seo'),
                'id = :id',
                array('id' => (int)$id_adv),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getTypeOfAdvert ($id, $id_adv) {
            return DBClass::Instance()->select(
                'type_adverts as ta, type_adverts_description as tad, adverts as a', 
                array('tad.name'), 
                'a.id_type = :id_type and a.id = :id_adv and a.id_type = tad.id_type and tad.id_lang = :id_lang and ta.active = :active and ta.id =  a.id_type', 
                array('id_lang' => (int)$_SESSION['lid'], 'id_adv' => (int)$id_adv, 'active' => 1, 'id_type' => (int)$id),
                '',
                'name',
                'false',
                '',
                '',
                '1'
            );
        }
        
        public function ifAuthuserIsAuthor ($user_auth_id, $adv_id) {
            return DBClass::Instance()->select(
                'adverts',
                array('id'),
                'id = :id_adv and idUser = :idUser',
                array('id_adv' => (int)$adv_id, 'idUser' => $user_auth_id),
                '',
                '',
                '',
                '',
                '',
                '1'
            );
        }
        
        public function getListAdvertsProfile ($id_user) {
            return DBClass::Instance()->select(
                'adverts as ad',
                array('ad.id, ad.title, ad.seo'),
                'ad.idUser = :user_id',
                array('user_id' => (int)$id_user),
                '',
                '',
                false,
                '',
                '',
                '2'
            );
        }
        
        public function getFilterAdverts ($subCat, $data) {
            $params = array('id_cat' => $subCat);
            $where = '';
            foreach($data as $k => $v){
                $where .= 'AND  exists( select 1 from '.DBClass::Instance()->config['db_pref'].'adverts_fields af where a.id = af.id_advert and  af.field_name = :'.$k.' AND af.field_value = :v_'.$v.') ';
                $params[$k] = $k;
                $params['v_'.$v] = $v;
            }
            
            return DBClass::Instance()->select(
                'category as c, category_advert as ca, adverts as a join '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai on a.id = ai.id_adv AND ai.main = 1',
                array('a.id, a.title, a.seo, ai.name_img_file, ai.src, ai.title as img_title'),
                '(c.seo = :id_cat or c.id = :id_cat) and c.id = ca.id_category and ca.id_advert = a.id and 1 = 1 '.$where,
                $params,
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function getAllAdvertsForCategory ($subCat) {
            return DBClass::Instance()->select(
                'category as c, category_advert as ca, adverts as a join '.DBClass::Instance()->config['db_pref'].'advert_imgs as ai on a.id = ai.id_adv AND ai.main = 1',
                array('a.id, a.title, a.seo, ai.name_img_file, ai.src, ai.title as img_title'),
                '(c.seo = :id_cat or c.id = :id_cat) and c.id = ca.id_category and ca.id_advert = a.id',
                array('id_cat' => $subCat),
                '',
                'title',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function ifTitleExist ($title) {
            return DBClass::Instance()->getCount(
                'adverts as ad',
                'ad.title = :title',
                array('title' => $title)
            );
        }
        
        public function editAdverts ($data) {
            DBClass::Instance()->update('adverts', $data['data'], 'id = :id');
            
            DBClass::Instance()->deleteElement('category_advert', array('id_advert' => (int)$data['data']['id']));
            DBClass::Instance()->insert('category_advert', array('id_category' => $data['mainCategory'], 'id_advert' => (int)$data['data']['id'], 'mainCategory' => 1));
            if(count($data['subCategory']) > 1) {
                // Функция array_values() делает все ключи в виде цифр и упорядочивает их
                // Последний ключ
                $lastSubCategory = count(array_values($data['subCategory']))-1;
                
                foreach ($data['subCategory'] as $k => $v) {
                    if ($k != $lastSubCategory) DBClass::Instance()->insert('category_advert', array('id_category' => (int)$v, 'id_advert' => (int)$data['data']['id']));
                    else DBClass::Instance()->insert('category_advert', array('id_category' => (int)$v, 'id_advert' => (int)$data['data']['id'], 'mainCategoryAdvert' => 1));
                }
            } else DBClass::Instance()->insert('category_advert', array('id_category' => (int)$data['subCategory'][0], 'id_advert' => (int)$data['data']['id'], 'mainCategoryAdvert' => 1));
            
            if(isset($data['imgs'])) {
                $img = unserialize($data['imgs']);
                //DBClass::Instance()->deleteElement('advert_imgs', array('id_adv' => (int)$data['data']['id']));
                foreach ($img as $k => $v) {
                    if($k == 0) DBClass::Instance()->insert('advert_imgs', array('id_adv' => (int)$data['data']['id'], 'name_img_file' => substr($v, -21, -4), 'src' => $v, 'main' => '1'));
                    else DBClass::Instance()->insert('advert_imgs', array('id_adv' => (int)$data['data']['id'], 'name_img_file' => substr($v, -21, -4), 'src' => $v));
                }
            }
        }
        
        public function editsAdvertFields ($data, $id) {
            DBClass::Instance()->deleteElement('adverts_fields', array('id_advert' => (int)$id));
            foreach ($data as $a) {
                DBClass::Instance()->insert('adverts_fields', $a);
            }
        }
        
        public function statusSavedAdvert ($id_user_auth, $id_adv) {
            return DBClass::Instance()->select(
                'save_adverts_for_user',
                array('id'),
                'id_user = :id_user and id_adv = :id_adv',
                array('id_user' => (int)$id_user_auth, 'id_adv' => (int)$id_adv),
                '',
                '',
                '',
                '',
                '',
                '2'
            );
        }
        
        public function UpdRecommendAdvert ($recommend, $id) {
            DBClass::Instance()->update('adverts', array('recommend' => (int)$recommend, 'id' => (int)$id), 'id = :id');
        }
        
        public function deleteImageFromAdvert ($id, $file_name) {
            DBClass::Instance()->deleteElement('advert_imgs', array('id_adv' => (int)$id, 'name_img_file' => $file_name));
        }
        
        public function deleteAdvert ($id) {
            DBClass::Instance()->deleteElement('adverts', array('id' => (int)$id));
            DBClass::Instance()->deleteElement('adverts_fields', array('id_advert' => (int)$id));
            DBClass::Instance()->deleteElement('save_adverts_for_user', array('id_adv' => (int)$id));
            DBClass::Instance()->deleteElement('category_advert', array('id_advert' => (int)$id));
            DBClass::Instance()->deleteElement('advert_imgs', array('id_adv' => (int)$id));
            DBClass::Instance()->deleteElement('comments_advert', array('advert_id' => (int)$id));
        }
	}
?>