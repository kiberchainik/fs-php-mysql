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
                        <form action="/fields/p_fields_new" method="post" id="demo-form2">
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
                                                <input id="placeholder_<?=$v['id']?>" placeholder="<?=$v['title']?>" name="placeholder[<?=$v['id']?>][name]" class="form-control col-md-7 col-xs-12" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                    <div class="clearfix"></div>
                                </div>
                                <div style="height: 10px;"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="typefield">Группа поля</label>
                                    <div class="col-xs-12">
                                        <select name="id_group[]" multiple="true" class="form-control col-xs-12">
                                            <?php if(!empty($FieldsGroupList)):?>
                                                <?php foreach($FieldsGroupList as $fgl): ?>
                                                    <option value="<?=$fgl['id']?>"><?=$fgl['title']?> - <?=$fgl['description']?></option>
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
                                            <option value="<?=$tl['id_type']?>"><?=$tl['name']?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="typefield">Тип поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="typefield" id="typefield" class="form-control col-md-7 col-xs-12">
                                            <option value="0">- Выбрать -</option>
                                            <option value="text">Text</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="password">Password</option>
                                            <option value="select">Select</option>
                                            <option value="time">Time</option>
                                            <option value="date">Date</option>
                                            <option value="dateTime">Date and Time</option>
                                            <option value="checkBox">CheckBox</option>
                                            <option value="radio">Radio</option>
                                            <option value="hidden">Hidden</option>
                                        </select>
                                        <div id="btn-addvalue"></div>
                                    </div>
                                </div>
                                <div id="addfields"></div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="namefield">Имя поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="namefield" name="namefield" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_stylefield">ИД поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="id_stylefield" name="id_stylefield" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_stylefield">Класс поля</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="class_stylefield" name="class_stylefield" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <button type="submit" name="addfield" class="btn btn-success" style="margin: 10px 0px 0px 20px;">Добавить</button>
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
                $('#btn-addvalue').html('<a class="new_field_value_group">+</a>');                
            } else {
                $('#btn-addvalue').empty();
                $('#addfields').empty();
            }
        });
        
        $('#btn-addvalue').on('click', 'a.new_field_value_group', function (){
            $('.fieldvalue-group:last').after(addFields());
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