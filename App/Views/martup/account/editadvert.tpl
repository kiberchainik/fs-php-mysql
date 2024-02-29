<link rel="stylesheet" href="/Media/martup/assets/css/plugins/trumbowyg.css" />
<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <form method="post" id="addNewAdvert" action="/adverts/saveedit/<?=$AdvertData['id']?>" enctype="multipart/form-data">
                    <?php if(!empty($filialList)): ?>
                    <div class="default-form-box">
                        <label for="filial_avdert"><?=$text_select_branch?></label>
                        <select name="filial_avdert" >
                            <option value="0">- <?=$text_select?> -</option>
                            <?php foreach($filialList as $fl): ?>
                            <?php if($fl['id'] == $AdvertData['id_filial']): ?>
                            <option value="<?=$fl['id']?>" selected><?=$fl['name_company']?></option>
                            <?php else: ?>
                            <option value="<?=$fl['id']?>"><?=$fl['name_company']?></option>
                            <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <?php endif ?>
                    <div class="default-form-box">
                        <label for="title"><?=$text_title?></label>
                        <input type="text" id="title" value="<?=$AdvertData['title']?>" name="title" />
                    </div>
                    <div class="default-form-box">
                        <label for="keywords"><?=$text_keywords?></label>
                        <input type="text" id="keywords" value="<?=$AdvertData['keywords']?>" name="keywords" />
                    </div>
                    <div class="default-form-box">
                        <label for="category"><?=$text_type?></label>
                        <div id="categoryWrap">
                            <select name="category" id="mainCategory" data-id="0">
                                <option value="0">- <?=$text_select?> -</option>
                                <?php foreach($CategoryList as $cl): ?>
                                <option value="<?=$cl['id']?>" <?=($AdvertData['mainCategory'] == $cl['id'])?'selected':''?>><?=$cl['title']?></option>
                                <?php endforeach ?>
                            </select>
                            <?php if(!empty($subSelects)): ?>
                                <?php foreach($subSelects as $v): ?>
                                    <select name="subCategory[]" class="subCategory" data-id="<?=$v['parent']?>">
                                    <option value="0">- <?=$text_select?> -</option>
                                    <?php foreach($v as $k => $sub): ?>
                                        <?php $sel = ''; ?>
                                        <?php if(is_numeric($k)): ?>
                                            <?php foreach($AdvertData['subCategory'] as $sub_id): ?>
                                                <?php if($sub['id'] == $sub_id['id_category']): ?>
                                                    <?php $sel = 'selected'; $id = $sub_id['id_category']; ?>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            <option value="<?=$sub['id']?>" <?=$sel?>><?=$sub['title']?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    </select>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                        <input type="hidden" name="category_id" id="categoryIdInput" value="<?=$id?>" />
                        <input type="hidden" name="adv_id" id="advertIdInput" value="<?=$AdvertData['id']?>" />
                    </div>
                    <div id="typeCategoryBlock" class="default-form-box"></div>
                    <div class="default-form-box">
                        <label for="description"><?=$text_description?></label>
                        <input type="text" value="<?=$AdvertData['description']?>" id="description" name="description" />
                    </div>
                    <div class="input-radio">
                        <em><?=$text_comments?></em>
                        <span class="custom-radio"><input type="radio" id="comments" name="comments" value="yes" <?php if($AdvertData['comments_permission'] == 'yes'): ?>checked<?php endif ?> /> Yes</span>
                        <span class="custom-radio"><input type="radio" id="comments" name="comments" value="no" <?php if($AdvertData['comments_permission'] == 'no'): ?>checked<?php endif ?> /> No</span>
                    </div>
                    <div class="default-form-box">
                        <label for="textAdvert"></label>
                        <textarea class="textAdvert fullTextAdvert" id="editor" name="fullTextAdvert" placeholder=""><?=$AdvertData['textAdvert']?></textarea>
                    </div>
                    <div id="formElementsBlock" class="default-form-box"></div>
                    <div class="col-sm-12" style="margin: 10px 0px;">
                        <label for="images"><?=$text_images_advert?></label>
                        <input type="file" name="images_advert[]" id="images" multiple="true" />
                    </div>
                    <div class="col-sm-12 imageList">
                        <?php if(!empty($AdvertData['imgs'])): ?>
                            <?php foreach ($AdvertData['imgs'] as $k => $v): ?>
                                <div id="<?=$v['name_img_file']?>">
                                    <a href="/adverts/deleteimg/<?=$AdvertData['id']?>/<?=$v['name_img_file']?>/<?=$AdvertData['seo']?>" data="<?=$v['name_img_file']?>" class="btnDeleteImg" title="<?=$text_delete?>"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="" /></a>
                                    <img src="/<?=$v['src']?>" alt="<?=$AdvertData['seo']?>" class="image img-responsive" title="<?=$AdvertData['title']?>" />
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    <button type="submit" id="addPost" class="tn btn-sm btn-radius btn-default mb-4" name="editPost"><?=$text_save?></button>
                </form>
                <p class="addedSuccess"></p>
                <div id="loader"></div>
                <ul class="errorList"></ul>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/langs/<?=$_SESSION['lang']?>.min.js"></script>
<script type="text/javascript">
    $('textarea').trumbowyg({
        lang: '<?=$_SESSION["lang"]?>'
    });
</script>
<script>
    $(function() {
        $('section.awSlider .carousel').carousel({
            pause: "hover",
            interval: 50000
        });
        
        if($('.item').length == 0) {
            $('#left_right').css('display','none');
        }
        var startImage = $('section.awSlider .item.active > img').attr('src');
        $('section.awSlider').append('<img src="' + startImage + '">');

        if($('.item').length == 0) {
            $('section.awSlider .carousel').on('slid.bs.carousel', function () {
                var bscn = $(this).find('.item.active > img').attr('src');
                $('section.awSlider > img').attr('src',bscn);
            });
        }
    });

    $(function() {
        $('section.awSlider').on('click', 'a.btnDeleteImg', function(e){
            e.preventDefault();
            var id = '#'+$(this).attr('data');
            $.get(
                $(this).attr('href'),
                '',
                function(data) {
                    $('.login-form').append('<p class="addedSuccess">' + data + '</p>').delay(3000).show(function() {
                        $('.addedSuccess').remove();
                        $(id).remove();
                        $('.item:first').addClass('active');
                        
                        if($('.item').length == 0) {
                            $('section.awSlider').css('display','none');
                            $('#left_right').css('display','none');
                            $('section.awSlider .item.active > img').remove();
                        }
                    });
                }
            );
        });
    });

    $(function() {
        var $categoryWrap = $('#categoryWrap');
        
        $categoryWrap.on('change', 'select', function () {
            var $this = $(this),
                category_id = this.value;
            
            $('#categoryIdInput').val(category_id);
            $this.nextAll().remove();
            
            if(category_id == '0') {
                $('#typeCategory').remove();
                $('#fieldsAdvert').remove();
                $('#selecttypeCategory').remove();
                return false;
            }
        
            $.ajax({
                url: '/newadvert/subcategory',
                data: {
                    id_cat: category_id,
                    lang: <?=$_SESSION['lid']?>
                },
                type: 'POST',
                success: function(data) {
                    $('#selecttypeCategory').remove();
                    $('#typeCategory').remove();
                    $('#fieldsAdvert').remove();
                    if (data != '') {
                        var $newSelect = $('<select name="subCategory[]" class="subCategory" data-id="' + category_id + '"/>');
                        $newSelect.append('<option value="0">- <?=$text_select?> -</option>')
                
                        $.map(data, function(v) {
                            $newSelect.append('<option value="' + v.id + '">' + v.title + '</option>')
                        });
                        $categoryWrap.append($newSelect);
                    }
                }
            });
        });
    });
    
    $(function() {
        var $categoryWrap = $('#categoryWrap');
        $categoryWrap.on('change', '.subCategory:last', function () {
            typeCategoryBlock();
        });
        
        $('.subCategory:last').each(function () {
            typeCategoryBlock();
        });
    });
    
    function typeCategoryBlock () {
        var $this = $(this),
            subCategory_id = $('#categoryIdInput').val();
        
        if(subCategory_id == '0') {
            $('#fieldsAdvert').remove();
            $('#typeCategory').remove();
            return false;
        }
        
        $.ajax({
            url: '/newadvert/typesOfCategory',
            data: {
                id_cat: subCategory_id,
                lang: <?=$_SESSION['lid']?>
            },
            type: 'POST',
            success: function(data) {
                    $('#fieldsAdvert').remove();
                    $('#typeCategory').remove();
                    
                    if (data != '') {
                        var $typeDiv = $('<div id="typeCategory"><?=$text_typeAdvert?></div>');
                        var $typeSelect = $('<select name="typeCategory" id="selecttypeCategory"/>');
                        $typeSelect.append('<option value="0">- <?=$text_select?> -</option>');
                        
                        $.map(data, function(v) {
                            if(v.id_type == <?=$AdvertData['id_type']?>) $typeSelect.append('<option value="' + v.id_type + '" selected>' + v.name + '</option>')
                            else $typeSelect.append('<option value="' + v.id_type + '">' + v.name + '</option>')
                    });
                
                    $typeDiv.append($typeSelect);
                    $('#typeCategoryBlock').html($typeDiv);
                    if ($('#selecttypeCategory')) { 
                        selecttypeCategory($('#selecttypeCategory').val());
                    }
                }
            }            
        });
    }
    
    function selecttypeCategory (typeCategory_id) {
            if(typeCategory_id == '0') {
                $('#fieldsAdvert').remove();
                return false;
            }
            
            $.ajax({
                url: '/newadvert/getFieldsCategoryListEdit',
                data: {
                    id_cat: $('#categoryIdInput').val(),
                    id_adv: $('#advertIdInput').val(),
                    lang: <?=$_SESSION['lid']?>,
                    id_type: typeCategory_id
                },
                type: 'POST',
                success: function(data) {
                    $('#fieldsAdvert').remove();
                    if (data != '') {
                        var $fieldsAdvert = $('<div id="fieldsAdvert"></div>');
                        
                        $.map(data, function(v) {
                            $('<input/>', {
                                type: 	'hidden',
                                name: 	v.name+'_id',
                                value:  v.id
                            }).appendTo($fieldsAdvert);
                            $('<input/>', {
                                type: 	'hidden',
                                name: 	'id_fields_group',
                                value:  v.id_group
                            }).appendTo($fieldsAdvert);
                            switch (v.type) {
                                case 'text':
                                    $('<input/>', {
                                        id:     v.id_style,
                                        class:  v.class_style,
                                        type: 	v.type,
                                        name: 	v.name,
                                        value:  v.advert_field_value,
                                        placeholder: 	v.placeholder
                                    }).appendTo($fieldsAdvert);
                                break;
                                case 'textarea':
                                    
                                break;
                                case 'password':
                                    $('<input/>', {
                                        id:     v.id_style,
                                        class:  v.class_style,
                                        type: 	'password',
                                        name: 	v.name,
                                        value:  v.field_value,
                                        placeholder: 	v.placeholder
                                    }).appendTo($fieldsAdvert);
                                break;
                                case 'select':
                                    var myselect = $('<select/>', { id: v.id_style, class: v.class_style, name: v.name});
                                    $('<option/>', {
                                		val:  '0',
                                		text: v.placeholder
                                	}).appendTo(myselect);
                                    $.each(v.field_value,function(index, svalue) {
                                    	if (svalue.id_value == v.advert_field_value) {
                                    	    $('<option/>', {
                                        		val:  svalue.id_value,
                                        		text: svalue.value,
                                                selected: ''
                                        	}).appendTo(myselect);
                                    	} else {
                                    	    $('<option/>', {
                                        		val:  svalue.id_value,
                                        		text: svalue.value
                                        	}).appendTo(myselect);
                                    	}
                                    });
                                    $fieldsAdvert.append(myselect);
                                break;
                                case 'time':
                                    
                                break;
                                case 'date':
                                    
                                break;
                                case 'dateTime':
                                    
                                break;
                                case 'checkBox':
                                    var mycheckBoxdiv = $('<div/>', {
                                        id:     'advertCheckBox',
                                        class:  v.class_style+' input-radio',
                                        field: 'fieldsAdvert'
                                    }).appendTo($fieldsAdvert);
                                    
                                    $.each(v.field_value, function(i,item) {
                                        if(item.id_value == v.advert_field_value) {
                                        	$('<label/>', {'for': 'cb'+item.id_value, text: item.value}).append(
                                        		$('<input/>', {
                                        			type: 'checkbox',
                                        			name: v.name+'[]',
                                                    id:   'cb'+item.id_value,
                                        			val:   item.id_value,
                                                    checked: ''
                                        		})
                                        	).append(item).appendTo(mycheckBoxdiv);
                                         } else {
                                            $('<label/>', {'for': 'cb'+item.id_value, text: item.value}).append(
                                        		$('<input/>', {
                                        			type: 'checkbox',
                                        			name: v.name+'[]',
                                                    id:   'cb'+item.id_value,
                                        			val:   item.id_value
                                        		})
                                        	).append(item).appendTo(mycheckBoxdiv);
                                         }
                                    });
                                break;
                                case 'radio':
                                    var myradiodiv = $('<div/>', {
                                        id:     v.name,
                                        class: 'input-radio'
                                    }).appendTo($fieldsAdvert);
                                    $.each(v.field_value, function(i,item) {
                                    	if(item.id_value == v.advert_field_value) {
                                            $('<label />', {'for': 'cb'+item.id_value, text: item.value}).append(
                                                $('<input/>', {
                                        			type: 'radio',
                                        			name: v.name,
                                        			val: 	item.id_value,
                                                    id:   'cb'+item.id_value,
                                                    checked: ''
                                        		})
                                    	   ).append(item).appendTo(myradiodiv);
                                        } else {
                                            $('<label />', {'for': 'cb'+item.id_value, text: item.value}).append(
                                                $('<input/>', {
                                        			type: 'radio',
                                        			name: v.name,
                                                    id:   'cb'+item.id_value,
                                        			val: 	item.id_value
                                        		})
                                    	   ).append(item).appendTo(myradiodiv);
                                        }
                                    });
                                break;
                                case 'hidden':
                                    
                                break;
                                default:
                                    return 'Type of field not found';
                            }
                        });
                        
                        $('#formElementsBlock').html($fieldsAdvert);
                    }
                }
            });
    }
    
    $(function() {
        $('button#addPost').bind('click', function (e) {
            e.preventDefault();
            
            var id_adv = $('#advertIdInput').val();
            
            $.ajax({                             
                url: $('form#addNewAdvert').attr('action'),
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($('#addNewAdvert').get(0)),
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    $('#loader').css('display', 'block');
                    $('#loader').html("<span class='ti-import'></span>");
                },
                success: function (result) {
                    $('.errorList li').remove();
                    $('#loader').css('display', 'none');
                    if(result.errors.length != 0) {
                        $.map(result.errors, function(i, item) {
                          $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                          $('select[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                          $('textarea[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('.addedSuccess').css('display','block');
                        $('.addedSuccess').html(result.success);
                    }
                }
            });
        });
    });
</script>