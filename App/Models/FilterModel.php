<?php
	class FilterModel extends Model {
	   private function __construct(){}
       private static $instance = NULL;
       
       public static function Instance() {
            return self::$instance === NULL?self::$instance = new self():self::$instance;
       }
       
       public function getFilter ($category) {
            $fields = DBClass::Instance()->select(
                'filter as f, filter_fields as ff, category_filter as cf, category as c, fields_data as fd, fields_placeholder as fp',
                array('f.sort, fd.id, fd.type, fd.name, fp.placeholder'),
                'c.seo = :category and c.id = cf.id_category and cf.id_filter = ff.id_filter and ff.id_field = fd.id and ff.id_field = fp.id_field and id_lang = :lang and cf.id_filter = f.id',
                array('category' => $category, 'lang' => $_SESSION['lid']),
                '',
                'sort',
                true,
                '',
                '',
                '2'
            );
            
            foreach($fields as $k => $v) {
                $fields[$k]['value'] = DBClass::Instance()->select(
                    'fields_value',
                    array('id_value, value'),
                    'id_field = :id and id_lang = :lang',
                    array('id' => $v['id'], 'lang' => $_SESSION['lid']),
                    '',
                    '',
                    '',
                    '',
                    '',
                    '2'
                );
            }
            
            return $fields;
       }
    }
?>