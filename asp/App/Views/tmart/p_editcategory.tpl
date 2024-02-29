<!-- Start BLog Area -->
<div class="htc__blog__area bg__white ptb--50">
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
                        <div class="col-xs-2">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-left">
                                <?php foreach($lang['data'] as $k => $v): ?>
                                <li class="<?=($k == '0')?'active':''?>"><a href="#lang<?=$v['id']?>" data-toggle="tab"><?=$v['title']?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <form id="demo-form2" class="col-xs-10 form-horizontal form-label-left" method="post" action="/category/edit/<?=$categoryData['id']?>" enctype="multipart/form-data">
                            <div class="tab-content">
                                <?php foreach($lang['data'] as $k => $v): ?>
                                <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Название</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="first-name" name="category_description[<?=$v['id']?>][title]" value="<?=$categoryData['category_description'][$v['id']]['title']?>" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" placeholder="<?=$v['title']?>" for="last-name">Краткое описание</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="last-name" name="category_description[<?=$v['id']?>][description]" value="<?=$categoryData['category_description'][$v['id']]['description']?>" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Ключевые слова</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="middle-name" name="category_description[<?=$v['id']?>][keywords]" value="<?=$categoryData['category_description'][$v['id']]['keywords']?>" class="form-control col-md-7 col-xs-12" placeholder="<?=$v['title']?>" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parent_id">Родительская категория</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="parent_id">
                                        <option value="0">- Выбор -</option>
                                        <?=$categoryList?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="seoTitle" class="control-label col-md-3 col-sm-3 col-xs-12">Seo название</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="seoTitle" value="<?=$categoryData['seo']?>" class="form-control col-md-7 col-xs-12" name="seoTitle" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="marker" class="control-label col-md-3 col-sm-3 col-xs-12">Метка категории</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="marker" value="<?=$categoryData['marker']?>" class="form-control col-md-7 col-xs-12" name="marker" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="col-xs-3">
                                        <?php if($categoryData['mediaSet'] == "image"): ?>
                                        <img style="height: 75px;" src="<?=SITE.$categoryData['imgicon']?>" />
                                        <?php endif ?>
                                    </div>
                                    <div class="col-xs-9">
                                        <table class="table">
                                            <tr>
                                                <td><input type="file" name="CategoryLogo" /></td>
                                                <td><input type="radio" name="CategoryImage" value="image" <?=($categoryData['mediaSet'] == "image")?'checked':''?> id="CategoryLogo" /> <label for="CategoryLogo">Показывать изображение</label></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="CatecoryIconCode"  class="form-control"  value="<?=($categoryData['mediaSet'] == "icon")?$categoryData['icon']:''?>" id="CatecoryIconCode" /></td>
                                                <td><input type="radio" name="CategoryImage" value="icon" <?=($categoryData['mediaSet'] == "icon")?'checked':''?> id="CatecoryIconCode" /> <label for="CatecoryIconCode">Показывать иконку</label></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="TypeId">Тип объявления</label>
                                    <select name="TypeId[]" id="TypeId" multiple="true" class="form-control" style="height: 200px; width: 100%;">
                                        <option value="0">- Выбрать тип -</option>
                                        <?php if(!empty($TypeId)): ?>
                                            <?php foreach($TypeId as $fg): ?>
                                                <?php $sel = ''; ?>
                                                <?php foreach ($TypesForCategory as $tfc): ?>
                                                    <?php if($fg['id_type'] == $tfc['id_type']): ?>
                                                        <?php $sel = 'selected'; ?>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                <option value="<?=$fg['id_type']?>" <?=(isset($sel))?$sel:''?>><?=$fg['name']?></option>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                        <option value="0">Групп нет!</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="advertFields">Группы полей</label>
                                    <select name="FieldsGoupId" id="FieldsGoupId" class="form-control" style="width: 100%;">
                                        <option value="0">- Выбрать группу -</option>
                                        <?php if(!empty($FieldsGroups)): ?>
                                            <?php foreach($FieldsGroups as $fg): ?>
                                                <?php $sel = ''; ?>
                                                <?php foreach ($FieldsGroupsForCategory as $fgfc): ?>
                                                    <?php if($fg['id'] == $fgfc['id_group']): ?>
                                                        <?php $sel = 'selected'; ?>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                <option value="<?=$fg['id']?>" <?=(isset($sel))?$sel:''?>><?=$fg['title']?></option>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                        <option value="0">Групп нет!</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="advertFields">Какие поля привязать к категориям:</label>
                                    <div class="col-xs-12">
                                        <select name="advertFields[]" id="advertFields" class="form-control" multiple="true" style="height: 200px; width: 100%;"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" value="<?=$categoryData['id']?>" id="id_cat" name="id_cat" />
                                <button type="submit" name="editcategory" class="btn btn-success">Сохранить</button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#FieldsGoupId").each(function() { //проверка после перезагрузки
            $('#advertFields').find('option').remove();
            if ($(this).val() != 0) {
                GetFields($(this).val());
            } else {
                $('#advertFields').append('<option value="0">Полей нет</option>')
            }
        });
            
        $("#FieldsGoupId").change(function() { //по клику
            $('#advertFields').find('option').remove();
            if ($(this).val() != 0) {
                GetFields($(this).val());
            } else {
                $('#advertFields').append('<option value="0">Полей нет</option>')
            }
        });
    });
    
    function GetFields (id_group) {
        
        $.ajax({
            url: '/category/getFieldsFromGroup',
            data: {
                id: id_group,
                id_group: $('#FieldsGoupId').val(),
                id_cat: $('#id_cat').val()
            },
            type: 'POST',
            success: function(data) {
                if (data != '') {
                    var sel;
                    var newData = JSON.parse(data);
                    $.each(newData.ListFieldsForGroup, function(index, lffg) {
                        sel = '';
                        $.each(newData.FieldsForCategory, function(i, ffg) {
                            if(lffg.id == ffg.id_field) {
                                sel = 'selected';
                            }
                        });
                        $('#advertFields').append('<option value="' + lffg.id + '" '+sel+'>' + lffg.placeholder + ' - ('+lffg.type+')</option>');
                    });
                } else {
                    $('#advertFields').append('<option value="0">Полей нет</option>')
                }
            }
        });
    }
</script>