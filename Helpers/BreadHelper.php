<?php
class BreadHelper {
	private static $_items = array();
 
	public static function add($url, $name) {
		self::$_items[] = array($url, $name);
	}
 
	public static function out() {
	   //return self::$_items;
		$res = '<div class="breadcrumb">
        			<span><a href="/">Home</a></span><span class="separator"> >> </span>';
 
		$i = 1;
        $total = count(self::$_items);
        $count = 0;
		foreach (self::$_items as $row) {
            $count++;
			if($count != $total) $res .= '<span class="breadcrumb_item"><a href="' . $row[0] . '">' . $row[1] . '</a></span><span class="separator"> >> </span>';
            else $res .= '<span class="breadcrumb_item"><a href="' . $row[0] . '">' . $row[1] . '</a></span>';
        }
		
        $res .= '</div>';
 
		return $res;
	}
}
?>