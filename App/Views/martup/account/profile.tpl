<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <?php foreach($message_from_admin as $mfa): ?>
                <div class="messages_from_admin<?=($mfa['read_status'] == '0')?' active':''?>" id="msg_<?=$mfa['id']?>">
                    <div class="message_header">
                        <h2><?=$mfa['subject']?></h2>
                        <a href="#" data="<?=$mfa['id']?>" class="btn_close_msg">x</a>
                    </div>
                    <div class="message_content"><?=$mfa['message']?></div>
                    <div class="message_footer"><?=date('D, d M y H:i', $mfa['date_send'])?></div>
                </div>
                <?php endforeach ?>
                <div class="profile_live_search our-blog-tag">
                    <div class="category-search-area account_login_form">
                        <form method="post" action="/profile/autosearch">
                            <div class="default-form-box mb-20">
                                <label><?=$text_autosearch?></label>
                                <input placeholder="Search......" name="searchkeywords" type="text" value="<?=($autosearch)?$autosearch['keywords']:''?>" />
                                <button class="life-search-btn"><img src="/Media/martup/assets/images/icons/icon-search.svg" alt="" /></button>
                            </div>
                            <div class="form_autosearch_footer">
                            <span class="example"><?=$text_choose?></span>
                                <?php if(!empty($category_autosearch)): ?>
                                    <?php foreach($tables as $t => $v): ?>
                                        <label class="checkbox-default" for="offer" for="<?=$t?>">
                                            <?php if(in_array($t, $category_autosearch)): ?>
                                            <input type="checkbox" name="category_autosearch[]" id="<?=$t?>" value="<?=$t?>" checked="" id="offer" />
                                            <?php else: ?>
                                            <input type="checkbox" name="category_autosearch[]" id="<?=$t?>" value="<?=$t?>" id="offer" />
                                            <?php endif ?>
                                            <span><?=$v?></span>
                                        </label>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <?php foreach($tables as $t => $v): ?>
                                        <label class="checkbox-default" for="offer" for="<?=$t?>">
                                            <input type="checkbox" name="category_autosearch[]" id="<?=$t?>" value="<?=$t?>" id="offer" />
                                            <span><?=$v?></span>
                                        </label>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if(!empty($autosearch_result)): ?>
                <div class="col-sm-12 autosearch_result">
                    <?php foreach($autosearch_result as $ar => $v): ?>
                        <fieldset>
                        <legend><h2 class="autosearch_category"><?=$v['key_main_array']?></h2></legend>
                        <?php foreach($v as $key => $val): ?>
                            <?php if(is_array($val) and !empty($val)): ?>
                                <h5 class="keywords"><?=$key?></h5>
                                <div class="autosearch_result">
                                <?php foreach($val as $r): ?>
                                    <?php if($ar == 'vacancies'): ?>
                                    <p><a href="/vacancies/page/<?=$r['id']?>" title="<?=$r['short_desc']?>"><?=$r['title']?></a></p>
                                    <?php endif ?>
                                    
                                    <?php if($ar == 'portfolio'): ?>
                                    <p><a href="/portfolio/user/<?=$r['id']?>" title="<?=$r['about']?>"><?=$r['name']?> <?=$r['lastname']?></a></p>
                                    <?php endif ?>
                                    
                                    <?php if($ar == 'company'): ?>
                                    <p><a href="/company/page/<?=$r['id']?>" title="<?=$r['about']?>"><?=$r['name']?> <?=$r['lastname']?></a></p>
                                    <?php endif ?>
                                    
                                    <?php if($ar == 'adverts'): ?>
                                    <p><a href="/adverts/page/<?=$r['id']?>" title="<?=$r['description']?>"><?=$r['title']?></a></p>
                                    <?php endif ?>
                                <?php endforeach?>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                        </fieldset>
                    <?php endforeach ?>
                </div>
                <?php endif ?>
                <div class="col-sm-12 table_page table-responsive" style="margin-top: 40px;">
                    <?php if(!empty($profile_adverts)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Trash</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($profile_adverts as $pa): ?>
                            <tr>
                                <td><a href="/adverts/page/<?=$pa['id']?>" target="_blank"><?=$pa['title']?></a></td>
                                <td><a href="/adverts/page/<?=$pa['id']?>" target="_blank"><img src="/Media/martup/assets/images/icons/view.svg" alt="" /></a></td>
                                <td><a href="/adverts/edit/<?=$pa['id']?>"><img src="/Media/martup/assets/images/icons/edit.svg" alt="" /></a></td>
                                <td><a href="/adverts/delete/<?=$pa['id']?>"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="" /></a></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <h4 class="contact-title spc"><?=$text_adverts_dont_found?></h4>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script>
    $(function(e) {
        $('a.btn_close_msg').click(function(e){
            e.preventDefault();
            var id = $('a.btn_close_msg').attr('data');
            
            $.ajax({
                url: '/ajax/updStatusMessage',
                data: {
                    id_msg: id,
                    read_status: '1'
                },
                type: 'POST',
                success: function(data) {
                    if (data == 1) {
                        $('#msg_'+id).remove();
                    }
                }
            });
        });
        
    });
</script>