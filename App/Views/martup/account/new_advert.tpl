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
                <form method="post" id="addNewAdvert" action="/newadvert/addNewAdvert" enctype="multipart/form-data">
                    <?php if(!empty($filialList)): ?>
                    <div class="default-form-box">
                        <label for="filial_avdert"><?=$text_select_branch?></label>
                        <select name="filial_avdert" id="branch">
                            <option value="0">- <?=$text_select?> -</option>
                            <?php foreach($filialList as $fl): ?>
                            <?php if(!empty($branch_default) and $branch_default[0]['id'] == $fl['id']): ?>
                            <option value="<?=$fl['id']?>" selected><?=$fl['name_company']?></option>
                            <?php else: ?>
                            <option value="<?=$fl['id']?>"><?=$fl['name_company']?></option>
                            <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <?php endif ?>
                    <div class="default-form-box">
                        <label for="title"><?=$text_newadvert_title_advert?></label>
                        <input type="text" id="title" name="title" />
                    </div>
                    <div class="default-form-box">
                        <label for="keywords"><?=$text_newadvert_keywords?></label>
                        <input type="text" id="keywords" name="keywords" />
                    </div>
                    <div class="default-form-box">
                        <label for="category"><?=$text_newadvert_type?></label>
                        <div id="categoryWrap">
                            <input type="hidden" name="category_id" id="categoryIdInput" />
                            <select name="category" id="mainCategory" data-id="0">
                                <option value="0">- <?=$text_select?> -</option>
                                <?php foreach($categoryList as $cl): ?>
                                <option value="<?=$cl['id']?>"><?=$cl['title']?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div id="typeCategoryBlock" class="default-form-box"></div>
                    <div id="marker_page" class="default-form-box"></div>
                    <div class="default-form-box">
                        <label for="description"><?=$text_newadvert_description?></label>
                        <input type="text" id="description" name="description" />
                    </div>
                    <div class="input-radio">
                        <em><?=$text_newadvert_comments_permise?></em>
                        <span class="custom-radio"><input type="radio" id="comments" name="comments" value="yes" /> Yes</span>
                        <span class="custom-radio"><input type="radio" id="comments" name="comments" value="no" /> No</span>
                    </div>
                    <div class="default-form-box">
                        <label for="textAdvert"></label>
                        <textarea class="textAdvert fullTextAdvert" name="fullTextAdvert" id="editor" placeholder=""></textarea>
                    </div>
                    <div id="formElementsBlock" class="default-form-box"></div>
                    <div class="default-form-box">
                        <label for="images"><?=$text_images_advert?></label>
                        <input type="file" name="images_advert[]" id="input_file" class="input input_file" multiple="true" />
                    </div>
                    <div class="default-form-box" id="cover_img"></div>
                    <div class="review-btn">
                        <button type="submit" id="addPost" class="tn btn-sm btn-radius btn-default mb-4" name="addPost"><?=$text_save?></button>
                    </div>
                </form>
                <p class="addedSuccess"></p>
                <div id="loader"></div>
                <ul class="errorList"></ul>
            </div>
        </div>
    </div>
</div> 
<!-- ...:::: End Account Dashboard Section:::... -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/langs/<?=$_SESSION['lang']?>.min.js"></script>
<script type="text/javascript">
    $('textarea').trumbowyg({
        lang: '<?=$_SESSION["lang"]?>'
    });
</script>
<script>
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
                    $('#typeCategory').remove();
                    $('#fieldsAdvert').remove();
                    if (data != '') {
                        var $newSelect = $('<select name="subCategory[]" class="subCategory" data-id="' + category_id + '"/>');
                        $newSelect.append('<option value="0">- <?=$text_select?> -</option>')
                
                        $.map(data, function(v) {
                            $newSelect.append('<option value="' + v.id + '" marker='+v.marker+'>' + v.title + '</option>')
                        });
                        $categoryWrap.append($newSelect);
                    }
                }
            });
        });
    });
    
    $(function() {
            $('#categoryWrap').on('change', '.subCategory:last', function () {
        
            var $this = $(this),
                subCategory_id = this.value;
            
            if(subCategory_id == '0') {
                $('#fieldsAdvert').remove();
                return false;
            }
            
            /*if($('option:selected',this).attr('marker') == 'promo_page') {
                $('#marker_page').html('<div id="as_promo_page"><label for="as_promo">Оформить как промо страницу</label><input type="checkbox" id="as_promo" name="as_promo" value="'+$('option:selected',this).attr('marker')+'" /></div>');
                $('#cover_img').html('<label for="images">Cover Image</label><input type="file" name="cover_image" id="input_file" class="input input_file" />');
            } else {
                $('#marker_page').empty();
                $('#cover_img').empty();
            }*/
            
            $.ajax({
                url: '/newadvert/typesOfCategory',
                data: {
                    id_cat: subCategory_id,
                    lang: <?=$_SESSION['lid']?>
                },
                type: 'POST',
                success: function(data) {
                        $('#fieldsAdvert').remove();
                        if (data != '') {
                            var $typeDiv = $('<div id="typeCategory"><?=$text_typeAdvert?></div>');
                            var $typeSelect = $('<select name="typeCategory" id="selecttypeCategory"/>');
                            $typeSelect.append('<option value="0">- <?=$text_select?> -</option>');
                            
                            $.map(data, function(v) {
                                $typeSelect.append('<option value="' + v.id_type + '">' + v.name + '</option>')
                                
                            });
                    
                        $typeDiv.append($typeSelect);
                        $('#typeCategoryBlock').html($typeDiv);
                    }
                }
            });
        });
    });
    
    $(function() {
            $('#typeCategoryBlock').on('change', '#selecttypeCategory', function () {

            var $this = $(this),
                typeCategory_id = this.value;
            
            if(typeCategory_id == '0') {
                $('#fieldsAdvert').remove();
                return false;
            }
            
            $.ajax({
                url: '/newadvert/getFieldsCategoryList',
                data: {
                    id_cat: $('#categoryIdInput').val(),
                    lang: <?=$_SESSION['lid']?>,
                    id_type: typeCategory_id
                },
                type: 'POST',
                success: function(data) {
                    $('#fieldsAdvert').remove();
                    if (data != 'data') {
                        var $fieldsAdvert = $('<div id="fieldsAdvert"></div>');
                        
                        $('<input/>', {
                            type: 	'hidden',
                            name: 	'id_fields_group',
                            value:  data[0].id_group,
                            field: 'fieldsAdvert'
                        }).appendTo($fieldsAdvert);
                        
                        $.map(data, function(v) {
                            $('<input/>', {
                                type: 	'hidden',
                                name: 	v.name+'_id',
                                value:  v.id,
                                field: 'fieldsAdvert'
                            }).appendTo($fieldsAdvert);
                            switch (v.type) {
                                case 'text':
                                    $('<input/>', {
                                        id:     v.id_style,
                                        class:  v.class_style,
                                        data_id: v.id,
                                        type: 	v.type,
                                        name: 	v.name,
                                        value:  '',
                                        placeholder: 	v.placeholder,
                                        field: 'fieldsAdvert'
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
                                        value:  '',
                                        placeholder: 	v.placeholder
                                    }).appendTo($fieldsAdvert);
                                break;
                                case 'select':
                                    var myselect = $('<select/>', { id: v.id_style, class: v.class_style, name: v.name, field: 'fieldsAdvert'});
                                    //Наполняем список
                                    $('<option/>', {
                                		val:  '0',
                                		text: v.placeholder
                                	}).appendTo(myselect);
                                    $.each(v.field_value,function(i, sv) {
                                    	$('<option/>', {
                                    		val:  sv.id_value,
                                    		text: sv.value
                                    	}).appendTo(myselect);
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
                                    	$('<label />', {'for': 'cb'+item.id_value, text: item.value}).append(
                                    		$('<input/>', {
                                    			type: 'checkbox',
                                    			name: v.name+'[]',
                                                id:   'cb'+item.id_value,
                                    			val:   item.id_value
                                    		})
                                    	).append(v.field_value).appendTo(mycheckBoxdiv);
                                    });
                                break;
                                case 'radio':
                                    var myradiodiv = $('<div/>', {
                                        id:     v.name,
                                        class:  v.class_style+' input-radio'
                                    }).appendTo($fieldsAdvert);
                                    
                                    $.each(v.field_value, function(i,item) {
                                    	$('<label />', {'for': 'cb'+item.id_value, text: item.value}).append(
                                    		$('<input/>', {
                                    			type: 'radio',
                                    			name: v.name,
                                                id:   'cb'+item.id_value,
                                    			val:  item.id_value
                                    		})
                                    	).append(v.field_value).appendTo(myradiodiv);
                                    });
                                break;
                                case 'hidden':
                                    $('<input/>', {
                                        id:     v.id_style,
                                        class:  v.class_style,
                                        data_id: v.id,
                                        type: 	v.type,
                                        name: 	v.name,
                                        value:  v.field_value,
                                        placeholder: 	v.placeholder,
                                        field: 'fieldsAdvert'
                                    }).appendTo($fieldsAdvert);
                                break;
                                default:
                                    return 'Type of field not found';
                            }
                        });
                        
                        $('#formElementsBlock').html($fieldsAdvert);
                    }
                }
            });
        });
    });
    
    $(function() {
        $('button#addPost').bind('click', function (e) {
            e.preventDefault();
            
            $.ajax({                             
                url: '/newadvert/addNewAdvert',
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
                    $('.error_list_icon').remove();
                    
                    if(result.errors.length != 0) {
                        $.map(result.errors, function(i, item) {
                          $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                          $('select[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                          $('textarea[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('#loader').empty();
                        $('.addedSuccess').css('display','block');
                        $('.addedSuccess').html(result.success);
                    }
                }
            });
        });
    });
</script>