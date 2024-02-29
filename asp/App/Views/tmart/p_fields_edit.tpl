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
                        <form action="/fields/p_fields_edit/<?=$fieldDate['id']?>" method="post" id="demo-form2">
                            <div class="col-xs-2">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-left">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <li class="<?=($k == '0')?'active':''?> lang" data-id="<?=$v['id']?>" data-title="<?=$v['title']?>"><a href="#lang<?=$v['id']?>" data-toggle="tab"><?=$v['title']?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="col-xs-10">
                                <div class="tab-content">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="placeholder_<?=$v['id']?>">Название</label>
                                            <div class="col-md-12 col-sm-6 col-xs-12">
                                                <input id="placeholder_<?=$v['id']?>" placeholder="<?=$v['title']?>" name="placeholder[<?=$v['id']?>][name]" value="<?=$fieldDate[0]['placeholder'][$v['id']]['name']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                                <div style="height: 10px;"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="id_group">Группа поля</label>
                                    <div class="col-xs-12">
                                        <select name="id_group[]" multiple="true" id="id_group" class="form-control col-xs-12">
                                            <?php if(!empty($FieldsGroupList)):?>
                                                <?php foreach($FieldsGroupList as $fgl): ?>
                                                    <?php $selected = ''; ?>
                                                    <?php foreach ($getFieldsGroupForField as $fgff): ?>
                                                        <?php if ($fgl['id'] == $fgff['id_fieldsgroup']): ?>
                                                            <?php $selected = 'selected'; ?>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                    <option value="<?=$fgl['id']?>" <?=(isset($selected))?$selected:''?>><?=$fgl['title']?> - <?=$fgl['description']?></option>
                                                <?php endforeach ?>
                                            <?php else: ?>
                                                <option value="0">Нужно создать группы!</option>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div style="height: 10px;"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="typeCategory">Тип объявления</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="typeCategory[]" multiple="" style="height: 200px !important;" class="form-control col-md-7 col-xs-12">
                                            <option value="0">- Выбрать -</option>
                                            <?php foreach($TypeList as $tl): ?>
                                                <?php $sel = ''; ?>
                                                <?php foreach($getFieldsForTypeList as $gfftl):?>
                                                <?php if($gfftl['id_type'] == $tl['id_type']) $sel = 'selected'?>
                                                <?php endforeach ?>
                                                <option value="<?=$tl['id_type']?>" <?=$sel;?> ><?=$tl['name']?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                    <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="typefield">Тип поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="typefield" class="form-control col-md-7 col-xs-12">
                                            <option value="0">- Выбрать -</option>
                                            <option value="text" <?=($fieldDate['type'] == 'text')?'selected':''?>>Text</option>
                                            <option value="textarea" <?=($fieldDate['type'] == 'textarea')?'selected':''?>>Textarea</option>
                                            <option value="password" <?=($fieldDate['type'] == 'password')?'selected':''?>>Password</option>
                                            <option value="select" <?=($fieldDate['type'] == 'select')?'selected':''?>>Select</option>
                                            <option value="time" <?=($fieldDate['type'] == 'time')?'selected':''?>>Time</option>
                                            <option value="date" <?=($fieldDate['type'] == 'date')?'selected':''?>>Date</option>
                                            <option value="dateTime" <?=($fieldDate['type'] == 'dateTime')?'selected':''?>>Date and Time</option>
                                            <option value="checkBox" <?=($fieldDate['type'] == 'checkBox')?'selected':''?>>CheckBox</option>
                                            <option value="radio" <?=($fieldDate['type'] == 'radio')?'selected':''?>>Radio</option>
                                            <option value="hidden" <?=($fieldDate['type'] == 'hidden')?'selected':''?>>Hidden</option>
                                        </select>
                                        <div id="btn-addvalue"><a class="new_field_value_group">+</a></div>
                                    </div>
                                </div>
                                <div id="addfields">
                                    <?php if(isset($fieldDate[0]['field_value'])): ?>
                                        <?php foreach($fieldDate[0]['field_value'] as $k => $block_field_values): ?>
                                        <div class="fieldvalue-group" data="<?=$k?>">
                                            <?php foreach ($block_field_values as $id_lang => $v): ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12"><input type="text" id="valuefield_<?=$id_lang?>" name="valuefield[<?=$k?>][<?=$id_lang?>][name]" value="<?=$v['name']?>" class="form-control col-md-7 col-xs-12" /></div>
                                            <?php endforeach ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 12px;"><a class="delete_field_value_group" data="<?=$k?>">x</a></div>
                                        </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="namefield">Имя поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="namefield" name="namefield" value="<?=$fieldDate['name']?>" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                    <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_stylefield">ИД поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="id_stylefield" name="id_stylefield" value="<?=$fieldDate['id_style']?>" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                    <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_stylefield">Класс поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="class_stylefield" name="class_stylefield" value="<?=$fieldDate['class_style']?>" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                    <div class="clearfix"></div>
                                <div class="form-group">
                                    <button type="submit" name="editfield" class="btn btn-success" style="margin: 10px 0px 0px 20px;">Сохранить</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#typefield").change(function(){
            var typefield = $('#typefield').val();
            if (typefield == 'select' || typefield == 'checkBox' || typefield == 'radio'){
                $('#addfields').html(addFields());                
            } else {
                $('#btn-addvalue').empty();
                $('#addfields').empty();
            }
        });
        
        $('#btn-addvalue').on('click', 'a.new_field_value_group', function (){
            $('#addfields').append(addFields());
        });
        
        $('#addfields').on('click', 'a.delete_field_value_group', function (){
            var btn_id = $(this).attr('data');
            $('div[data='+btn_id+']').remove();
        });
        
        function getLang () {
            var lang_id_arr = [];
            $('.lang').each(function (index, value) {
                lang_id_arr.push({
                    id: $(this).attr('data-id'), 
                    title:  $(this).attr('data-title')
                });
            });
            
            return lang_id_arr;
        }
        
        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        }
        
        function addFields () {
            var data = getRandomInt(1, 100);
            var field = '<div class="fieldvalue-group" data="'+data+'">';
            $.each(getLang(), function (k, lang) {
                field += '<div class="col-md-12 col-sm-12 col-xs-12"><input type="text" id="valuefield_'+lang.id+'" name="valuefield['+data+']['+lang.id+'][name]" placeholder="'+lang.title+'" class="form-control col-md-7 col-xs-12" /></div>';
            });
            field += '<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 12px;"><a class="delete_field_value_group" data="'+data+'">x</a></div>';
            field += '</div>';
            
            return field;
        }
    });
</script>