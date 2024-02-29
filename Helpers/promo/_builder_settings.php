<?php
foreach ($pathToAssets as $thePath) {
    /* Create recursive directory iterator */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($thePath), RecursiveIteratorIterator::LEAVES_ONLY
        );
    foreach ($files as $name => $file) {
        if ($file->getFilename() != '.' && $file->getFilename() != '..') {
            /* Get real path for current file */
            $filePath = $file->getRealPath();
            $temp = explode("/", $name);
            array_shift($temp);
            $newName = implode("/", $temp);
            /* Add current file to archive */
            $zip->addFile($filePath, $newName);
        }
    }
}
foreach ($_POST['pages'] as $page => $content) {
    $html_header = htmlspecialchars(file_get_contents('/home5/urlpyrtf/public_html/Helper/promo/elements/fs-files/header.html'));
    $html_footer = htmlspecialchars(file_get_contents('/home5/urlpyrtf/public_html/Helper/promo/elements/fs-files/footer.html'));
    /* SEO Meta values */
    $fox_b_seo_meta = $_POST['fox_b_seo'][$page];
    if ($fox_b_seo_meta) {
        $fox_b_seo = explode('1_@_2_@', $fox_b_seo_meta);
        $meta_keys = array('FSBuilder', 'seodesc', 'seokeywords', 'seoauthor', '&quot;', '&lt;', '&gt;');
        $meta_values = array($fox_b_seo[0], $fox_b_seo[1], $fox_b_seo[2], $fox_b_seo[3], '"', '<', '>');
        $meta_seo_values = str_replace($meta_keys, $meta_values, $html_header);
    } else {
        $meta_keys = array('FSBuilder', 'seodesc', 'seokeywords', 'seoauthor', '&quot;', '&lt;', '&gt;');
        $meta_values = array('FSBuilder', 'seodesc', 'seokeywords', 'seoauthor', '"', '<', '>');
        $meta_seo_values = str_replace($meta_keys, $meta_values, $html_header);
    }

    /* End SEO Meta values */
    $fox_b_html_array = array('&quot;','%20','contact-submit');
    $fox_b_html_keys = array("'","","fox_b_submit");
    $fox_b_html_content = str_replace($fox_b_html_array, $fox_b_html_keys, $content);
    $fox_b_footer_keys = array('&lt;','&gt;');
    $fox_b_footer_values = array('<','>');
    $fox_b_html_footer = str_replace($fox_b_footer_keys, $fox_b_footer_values, $html_footer);
    $fox_b_content = $meta_seo_values . stripslashes($fox_b_html_content).$fox_b_html_footer;
    $zip->addFromString($page . ".html", stripslashes($fox_b_content));
}
foreach ($_POST['pages'] as $page => $img_content) {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($img_content);
    $dom->preserveWhiteSpace = false;
    $tags_videos = $dom->getElementsByTagName('video');
    foreach($dom->getElementsByTagName('img') as $all_tags_img)
    {
        $images[] = $all_tags_img->getAttribute('src');
    }
    foreach($tags_videos as $all_tags_video)
    {
        $videos[] = $all_tags_video;
    }
    $files = glob('/home5/urlpyrtf/public_html/Helpers/promo/elements/img/*.{jpg,jpeg,png,gif,PNG,JPG,JPEG,GIF}', GLOB_BRACE);
    foreach($files as $file) {
        $img_folder[] = explode('/', $file);
    }
    $bg_reg = '/url\(([\'\"]?.*[\'\"]?)\)/i';
    preg_match_all($bg_reg, $img_content,$matches);
    foreach($matches[1] as $mat_value) {
        $bg_mat_img[] = $mat_value;
    }
}
if(empty($videos))
{
    $folder_video_delete = 'video/';
    for ($i = 0; $i < $zip->numFiles; $i++){
        $video_info = $zip->statIndex($i);
        if (substr($video_info["name"], 0, strlen($folder_video_delete)) == $folder_video_delete){
            $zip->deleteIndex($i);
        }
    }
}
if(!empty($bg_mat_img))
{
    foreach($bg_mat_img as $value) {
        $char_val = array("&quot;","'");
        $bg_value = str_replace($char_val,"",$value);
        $bg_img = explode('/', $bg_value);
        $bg_ex_img[] = $bg_img[2];
         
        $bg_files = glob('/home5/urlpyrtf/public_html/Helpers/promo/elements/img/bg-image/*.{jpg,jpeg,png,gif,PNG,JPG,JPEG,GIF}', GLOB_BRACE);
        foreach ($bg_files as $bg_file) {
            $bg_folder = explode('/', $bg_file);
            $bg_folder_img[] = $bg_folder[3];
        }
    }
    if(!empty($bg_ex_img))
    {
        $bg_results = array_diff($bg_folder_img,$bg_ex_img);
        foreach ($bg_results as $bg_res) 
        {
            $bg_img_path = 'img/bg-image/' . $bg_res;
            $zip->deleteName($bg_img_path);
        }
    }else{
        $bg_files = glob('/home5/urlpyrtf/public_html/Helpers/promo/elements/img/bg-image/*.{jpg,jpeg,png,gif,PNG,JPG,JPEG,GIF}', GLOB_BRACE);
        foreach ($bg_files as $bg_file) {
            $bg_folder = explode('/', $bg_file);
            $bg_img_path = 'img/bg-image/' . $bg_folder[3];
            $zip->deleteName($bg_img_path);
        } 
    }
}else{
       
        $bg_files = glob('/home5/urlpyrtf/public_html/Helpers/promo/elements/img/bg-image/*.{jpg,jpeg,png,gif,PNG,JPG,JPEG,GIF}', GLOB_BRACE);
        foreach ($bg_files as $bg_file) {
            $bg_folder = explode('/', $bg_file);
            $bg_img_path = 'img/bg-image/' . $bg_folder[3];
            $zip->deleteName($bg_img_path);
        } 
}
if(!empty($images))
{
    foreach($images as $img) 
    {
        $img_ex = explode('/', $img);
        
        if(empty($img_ex[2]))
        {
           $temp_img[] = $img_ex[1];
        }else{
           $temp_img[] = $img_ex[2];
        }
        
        foreach ($img_folder as $zip_folder) {
            $exp_img[] = $zip_folder[2];
        }
    }
    $result = array_diff($exp_img, $temp_img);
    foreach ($result as $res) 
    {
        $img_path = 'img/' . $res;
        $zip->deleteName($img_path);
    }
}else{
    foreach($img_folder as $zip_folder) 
    {
        $img_path = 'img/' . $zip_folder[2];
        $zip->deleteName($img_path);        
    }
}
if(!empty($bg_ex_img) && !empty($temp_img))
{
    $all_img = array_merge($bg_ex_img,$temp_img);
}elseif(!empty($bg_ex_img)){
    $all_img = $bg_ex_img;
}else if(!empty($temp_img)){
    $all_img = $temp_img;
}
if(!empty($all_img))
{
    $upload_files = glob('/home5/urlpyrtf/public_html/Helpers/promo/elements/img/uploads/*.{jpg,jpeg,png,gif,PNG,JPG,JPEG,GIF}', GLOB_BRACE);
    foreach ($upload_files as $upload_file) {
        $upload_folder = explode('/', $upload_file);
        $up_folder_img[] = $upload_folder[3];
    }
    if(!empty($up_folder_img))
    {
        $upload_results = array_diff($up_folder_img, $all_img);
        foreach ($upload_results as $up_res) 
        {
            $upload_folder = explode('/', $up_res);
            $up_img_path = 'img/uploads/' . $up_res;
            $zip->deleteName($up_img_path);
        }
    }
}else{
    $upload_files = glob('/home5/urlpyrtf/public_html/Helpers/promo/elements/img/uploads/*.{jpg,jpeg,png,gif,PNG,JPG,JPEG,GIF}', GLOB_BRACE);
    foreach ($upload_files as $upload_file) {
        $upload_folder = explode('/', $upload_file);
        $up_img_path = 'img/uploads/' . $upload_folder[3];
        $zip->deleteName($up_img_path);
    }
}
$folder_to_delete = 'img/thumbs/';
for ($i = 0; $i < $zip->numFiles; $i++) {
    $image_info = $zip->statIndex($i);
    if (substr($image_info["name"], 0, strlen($folder_to_delete)) == $folder_to_delete) {
        $zip->deleteIndex($i);
    }
}