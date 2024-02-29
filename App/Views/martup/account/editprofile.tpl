<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="col-md-12 col-sm-12">
                    <div class="col-md-6 profile_data_edit">
                        <form method="post" id="edit_profile_form" action="/profile/save_user_data" enctype="multipart/form-data">
                            <div class="default-form-box">
                                <label><?=$text_name?></label>
                                <input type="text" id="author" name="name" value="<?=$userDate['name']?>" />
                            </div>
                            <div class="default-form-box">
                                <label><?=$text_lastname?></label>
                                <input type="text" id="author" name="lastname" value="<?=$userDate['lastname']?>" />
                            </div>
                            <div class="default-form-box">
                                <label><?=$text_email?></label>
                                <input type="email" id="email" name="email" value="<?=$userDate['email']?>" />
                            </div>
                            <div class="default-form-box">
                                <label><?=$text_number_mobile?></label>
                                <input type="text" id="phone" class="customer_phone" name="mobile" value="<?=$userDate['mobile']?>" />
                            </div>
                            <?php if($userDate['type_person'] == '4'):?>
                            <div class="default-form-box" id="type_company">
                                <input type="hidden" name="person" value="<?=$userDate['type_person']?>" />
                                <?php if(!empty($type_company)): ?>
                                <select name="type_company" id="type_company">
                                    <option value="0">-Select-</option>
                                    <?php foreach($type_company as $tc): ?>
                                    <option value="<?=$tc['id']?>" <?=($tc['id'] == $userDate['idTypeCompany'])?'selected':''?>><?=$tc['name']?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php endif ?>
                            </div>
                            <div class="default-form-box">
                                <label></label>
                                <input type="text" name="p_iva" id="p_iva" value="<?=$userDate['patent']?>" placeholder="<?=$text_p_iva?>" class="g_user" />
                            </div>
                            <div class="default-form-box">
                                <label></label>
                                <input type="text" name="company_name" id="company_name" value="<?=$userDate['company_name']?>" placeholder="<?=$text_company_name?>" class="g_user" />
                            </div>
                            <div class="default-form-box">
                                <label></label>
                                <input type="text" name="company_link" id="company_link" value="<?=$userDate['company_link']?>" placeholder="<?=$text_company_link?>" class="g_user" />
                            </div>
                            <?php endif ?>
                            <div class="default-form-box">
                                <label><?=$text_field_about?></label>
                                <input type="text" name="about" value="<?=htmlspecialchars_decode($userDate['about'])?>" />
                            </div>
                            <div class="default-form-box">
                                <label for="input__file"><?=$text_field_img_logo?></label>
                                <input type="file" name="profile_logo" />
                            </div>
                            <div class="default-form-box">
                                <button name="submit" class="btn btn-sm btn-radius btn-default mb-4"><?=$text_save?></button>                             
                            </div>
                            <ul id="ajax_result"></ul>
                          </form>
                    </div>
                    <div class="col-md-6 profile_settings_site">
                        <h2><?=$text_edit_profile_settings_site?></h2>
                        <form method="post" action="/profile/save_site_settings" id="save_settings_acc">
                            <div class="input-radio">
                                <em><?=$text_edit_profile_settings_subscript_news?></em>
                                <span class="custom-radio"><input type="radio" name="subscript_news" checked <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['subscription_news'] == 'yes')?'checked':''?> value="yes" id="subscript_news_yes" /> <?=$text_yes?></span>
                                <span class="custom-radio"><input type="radio" name="subscript_news" <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['subscription_news'] == 'no')?'checked':''?> value="no" id="subscript_news_no" /> <?=$text_no?></span>
                            </div>
                            <div class="input-radio">
                                <em><?=$text_edit_profile_settings_subscript_update_site?></em>
                                <span class="custom-radio"><input type="radio" name="subscript_update_site" checked <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['subscription_site_update'] == 'yes')?'checked':''?> value="yes" id="subscript_update_site_yes" /> <?=$text_yes?></span>
                                <span class="custom-radio"><input type="radio" name="subscript_update_site" <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['subscription_site_update'] == 'no')?'checked':''?> value="no" id="subscript_update_site_on" /> <?=$text_no?></span>
                            </div>
                            <div class="input-radio">    
                                <em><?=$text_edit_profile_settings_online_status?></em>
                                <span class="custom-radio"><input type="radio" name="online_status" checked <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['show_online_status'] == 'yes')?'checked':''?> value="yes" id="online_status_yes" /> <?=$text_yes?></span>
                                <span class="custom-radio"><input type="radio" name="online_status" <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['show_online_status'] == 'no')?'checked':''?> value="no" id="online_status_no" /> <?=$text_no?></span>
                            </div>
                            <div class="input-radio">    
                                <em><?=$text_edit_profile_settings_message_status?></em>
                                <span class="custom-radio"><input type="radio" name="message_status" checked <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['message_status'] == 'yes')?'checked':''?> value="yes" id="message_status_yes" /> <?=$text_yes?></span>
                                <span class="custom-radio"><input type="radio" name="message_status" <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['message_status'] == 'no')?'checked':''?> value="no" id="message_status_no" /> <?=$text_no?></span>
                            </div>
                            <div class="input-radio">    
                                <em><?=$text_edit_profile_settings_adverts_status?></em>
                                <span class="custom-radio"><input type="radio" name="adverts_status" checked <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['subscription_new_adverts'] == 'yes')?'checked':''?> value="yes" id="message_status_yes" /> <?=$text_yes?></span>
                                <span class="custom-radio"><input type="radio" name="adverts_status" <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['subscription_new_adverts'] == 'no')?'checked':''?> value="no" id="message_status_no" /> <?=$text_no?></span>
                            </div>
                            <div class="input-radio">    
                                <em><?=$text_edit_profile_settings_chat_message?></em>
                                <span class="custom-radio"><input type="radio" name="chat_message" checked <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['chat_message'] == 'yes')?'checked':''?> value="yes" id="message_status_yes" /> <?=$text_yes?></span>
                                <span class="custom-radio"><input type="radio" name="chat_message" <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['chat_message'] == 'no')?'checked':''?> value="no" id="message_status_no" /> <?=$text_no?></span>
                            </div>
                            <div class="input-radio">    
                                <em><?=$text_edit_profile_settings_comments_permission?></em>
                                <span class="custom-radio"><input type="radio" name="comments_permission" checked <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['comments_permission'] == 'yes')?'checked':''?> value="yes" id="message_status_yes" /> <?=$text_yes?></span>
                                <span class="custom-radio"><input type="radio" name="comments_permission" <?=(isset($userSettingsSite[0]) and $userSettingsSite[0]['comments_permission'] == 'no')?'checked':''?> value="no" id="message_status_no" /> <?=$text_no?></span>
                            </div>
                            <div class="mt-20">
                                <button type="submit" name="save_settings_acc" class="btn btn-sm btn-radius btn-default mb-4"><?=$text_save?></button>
                            </div>
                            <ul id="ajax_result_settings"></ul>
                        </form>
                        <form method="post" action="/ajax/change_password" id="change_password">
                            <h3>Change password</h3>
                            <div class="default-form-box"><input type="password" name="old_pass" /></div>
                            <div class="default-form-box"><input type="password" name="new_pass" /></div>
                            <div class="mt-20"><input type="submit" name="change" id="btn_change" class="btn btn-sm btn-radius btn-default mb-4" value="Change" /></div>
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="delete_account">
                        <a href="/profile/delete_account" class="btn btn-danger"><?=$text_btn_delete_account?></a>
                        <span id="atention_text"><?=$text_atention_text_delete?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script>
    $(document).ready(function() {
        $('#edit_profile_form').on('submit', function (e){
            e.preventDefault();
                        
            $.ajax({
                url: $(this).attr('action'),
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($(this).get(0)),
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    $('span#loader').css('display', 'block');
                    $('#save_edit_btn').after('<span class="ti-wand"></span>');
                },
                error: function(req, text, error){
                    //console.error('РЈРїСЃ! РћС€РёР±РѕС‡РєР°: ' + text + ' | ' + error);
                  },                
                success: function (result) {
                    $('span#loader').css('display', 'none');
                    $('#ajax_result').empty();
                    $('.error_list_icon').remove();
                    if(result.errors.length > 0) {
                        $.map(result.errors, function(i, item) {
                          $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                          $('div[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('#ajax_result').html('<li class="addedSuccess">' + result.success + '</li>');
                        $('#save_edit_btn').remove();
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $('#save_settings_acc').on('submit', function (e){
            e.preventDefault();
                        
            $.ajax({
                url: $(this).attr('action'),
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($(this).get(0)),
                dataType: 'json',
                cache: false,
                success: function (result) {
                    $('span#loader').css('display', 'none');
                    $('.error_list_icon').remove();
                    
                    if(result.errors.length != 0) {
                        $.map(result.errors, function(i, item) {
                            $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('#ajax_result_settings').html('<li class="addedSuccess">' + result.success + '</li>');
                    }
                }
            });
        });
    });
    
    $(document).ready(function() {
        $('#btn_change').click(function (e){
            e.preventDefault();
            $('p.error_list_icon').remove();
            $('p.addedSuccess').remove();
            $.ajax({
                url: '/ajax/change_password',
                type:'post',
                data: {old_pass: $('input[name=old_pass]').val(), new_pass: $('input[name=new_pass]').val()},
                dataType: 'json',
                success: function (result) {
                    $('#btn_change').before(result);
                }
            });
        });
    });
</script>