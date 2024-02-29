<!-- Start BLog Area -->
<div class="htc__blog__area bg__white ptb--60">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="blod-details-left-sidebar mrg-blog">
                    <!-- Start Tag -->
                    <?=$p_menu?>
                    <!-- End Tag -->
                </div>
            </div>
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="private_wrapp">
                        <form method="post" id="addNewAdvert" action="/adverts/saveedit/<?=$AdvertData['id']?>" enctype="multipart/form-data">
                            <div class="single-checkout-box">
                                <label for="title">Название</label>
                                <input type="text" id="title" value="<?=$AdvertData['title']?>" name="title" />
                            </div>
                            <div class="single-checkout-box">
                                <label for="keywords">Ключевые сова</label>
                                <input type="text" id="keywords" value="<?=$AdvertData['keywords']?>" name="keywords" />
                            </div>
                            <div class="single-checkout-box">
                                <label for="category">Категория</label>
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
                            <div id="typeCategoryBlock" class="single-checkout-box"></div>
                            <div class="single-checkout-box">
                                <label for="description">Краткое описание</label>
                                <input type="text" value="<?=$AdvertData['description']?>" id="description" name="description" />
                            </div>
                            <div class="single-checkout-box">
                                <label for="comments">Разрешить комментировать</label>
                                <input type="radio" id="comments" name="comments" value="yes" <?php if($AdvertData['comments_permission'] == 'yes'): ?>checked<?php endif ?> /> Да
                                <input type="radio" id="comments" name="comments" value="no" <?php if($AdvertData['comments_permission'] == 'no'): ?>checked<?php endif ?> /> Нет
                            </div>
                            <div class="single-checkout-box">
                                <label for="textAdvert">Полное описание</label>
                                <textarea class="textAdvert fullTextAdvert" id="editor" name="fullTextAdvert" placeholder=""><?=$AdvertData['textAdvert']?></textarea>
                            </div>
                            <div id="formElementsBlock" class="single-checkout-box"></div>
                            <div class="col-sm-12" style="margin: 10px 0px;">
                                <label for="images">Изображения</label>
                                <input type="file" name="images_advert[]" id="images" multiple="true" />
                            </div>
                            <div class="col-sm-12 ">
                                <?php if(!empty($AdvertData['imgs'])): ?>
                                    <?php foreach ($AdvertData['imgs'] as $k => $v): ?>
                                        <div class="imageList" id="<?=$v['name_img_file']?>">
                                            <a href="/adverts/deleteimg/<?=$AdvertData['id']?>/<?=$v['name_img_file']?>/<?=$AdvertData['seo']?>" class="btnDeleteImg" title="Удалить"><span class="ti-trash"></span></a>
                                            <img src="https://findsol.it/<?=$v['src']?>" alt="<?=$AdvertData['seo']?>" class="image img-responsive" title="<?=$AdvertData['title']?>" />
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                            <button type="submit" id="addPost" name="editPost">Применить</button>
                        </form>
                        <p class="addedSuccess"></p>
                        <div id="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/Media/tmart/js/ckeditor.js"></script>
<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} );
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
                url: '/advert/subcategory',
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
                        $newSelect.append('<option value="0">- Выбрать -</option>')
                
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
            url: '/advert/typesOfCategory',
            data: {
                id_cat: subCategory_id,
                lang: <?=$_SESSION['lid']?>
            },
            type: 'POST',
            success: function(data) {
                    $('#fieldsAdvert').remove();
                    $('#typeCategory').remove();
                    if (data != '') {
                        var $typeDiv = $('<div id="typeCategory">Тип объявления</div>');
                        var $typeSelect = $('<select name="typeCategory" id="selecttypeCategory"/>');
                        $typeSelect.append('<option value="0">- Выбрать -</option>');
                        
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
                url: '/advert/getFieldsCategoryListEdit',
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
                                    var items = v.field_value.split(', ');
                                    //Наполняем список
                                    $('<option/>', {
                                		val:  '0',
                                		text: v.placeholder
                                	}).appendTo(myselect);
                                    $.each(items,function(index, svalue) {
                                        index++;
                                    	if (index == v.val_inter_sel) {
                                    	    $('<option/>', {
                                        		val:  index+'_'+svalue,
                                        		text: svalue,
                                                selected: ''
                                        	}).appendTo(myselect);
                                    	} else {
                                    	    $('<option/>', {
                                        		val:  index+'_'+svalue,
                                        		text: svalue
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
                                        id:     'advertCheckBox'
                                    }).appendTo($fieldsAdvert);
                                    var items = v.field_value.split(', ');
                                    $.each(items, function(i,item) {
                                        i++;
                                        if(i == v.val_inter_sel) {
                                        	$('<label/>').append(
                                        		$('<input/>', {
                                        			type: 'checkbox',
                                        			name: 'mycheckbox[]',
                                        			val: i+'_'+item,
                                                    checked: ''
                                        		})
                                        	).append(item).appendTo(mycheckBoxdiv);
                                         } else {
                                            $('<label/>').append(
                                        		$('<input/>', {
                                        			type: 'checkbox',
                                        			name: 'mycheckbox[]',
                                        			val: i+'_'+item
                                        		})
                                        	).append(item).appendTo(mycheckBoxdiv);
                                         }
                                    });
                                break;
                                case 'radio':
                                    var myradiodiv = $('<div/>', {
                                        id:     v.name
                                    }).appendTo($fieldsAdvert);
                                    var items = v.field_value.split(', ');
                                    $.each(items, function(i,item) {
                                        i++;
                                    	if(i == v.val_inter_sel) {
                                            $('<label/>').append(
                                                $('<input/>', {
                                        			type: v.type,
                                        			name: v.name,
                                        			val: 	i+'_'+item,
                                                    checked: ''
                                        		})
                                    	   ).append(item).appendTo(myradiodiv);
                                        } else {
                                            $('<label/>').append(
                                                $('<input/>', {
                                        			type: v.type,
                                        			name: v.name,
                                        			val: 	i+'_'+item
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
            
            $('textarea#editor').val($('div[role="textbox"]').text());
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
                    $('#loader').html("<i class='fa fa-spinner fa-spin fa-3x fa-fw'></i>");
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
                        $('#loader').remove();
                    }
                }
            });
        });
    });
</script>