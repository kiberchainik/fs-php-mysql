<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <?php if(!empty($branchList)): ?>
                        <?php foreach($branchList as $b): ?>
                        <div class="branch_box">
                            <!--div class="branch_box-header img-responsive">
                                <img class="img-profile logo_branch" src="/<?=$b['img']?>" alt="<?=$b['name_company']?>" title="<?=$b['name_company']?>" />
                            </div-->
                            <div class="branch_box-body" id="branch<?=$b['id']?>">
                                <p class="name_company"><?=$b['name_company']?></p>
                                <p class="address"><img src="/Media/martup/assets/images/icons/icons-address-16.png" /> <?=$b['adres']?></p>
                                <p class="phone"><img src="/Media/martup/assets/images/icons/icons-call-16.png" /> <?=$b['phone']?></p>
                                <p class="email"><img src="/Media/martup/assets/images/icons/icons-mail-16.png" /> <?=$b['email']?></p>
                                <p class="url_company"><img src="/Media/martup/assets/images/icons/icons-website-16.png" /> <?=$b['url_company']?></p>
                             </div>
                             <div class="branch_box-footer">
                                <?php if($b['default_br'] == 0): ?>
                                    <span class="branch_default" data-user="<?=$b['id_user']?>" data="<?=$b['id']?>"><img src="/Media/martup/assets/images/icons/icons-check.png" /></span>
                                <?php else: ?>
                                    <span id="checked"><img src="/Media/martup/assets/images/icons/icons-checked.png" /></span>
                                <?php endif ?>
                                <span><a href="#" class="branch_edit" data="<?=$b['id']?>"><img src="/Media/martup/assets/images/icons/icon-edit.svg" /></a></span> 
                                <span class="branch_delete"><a href="/branch/delete/<?=$b['id']?>"><img src="/Media/martup/assets/images/icons/icon-trash.svg" /></a></span> 
                            </div>
                        </div>
                        <?php endforeach ?>
					<?php else: ?>
                		<p><?=$text_non_branch?></p>
					<?php endif ?>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h3 id="title_branch_block"><?=$text_add_new?></h3>
                        <form action="/branch/NewBranch" method="post" id="branch_form" class="login-form new_branch_block" enctype="multipart/form-data">
                        <div class="col-12">
                            <div class="default-form-box">
                                <label><?=$text_name_company?></label>
                                <input type="text" name="name_company" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="default-form-box">
                                <label><?=$text_address?></label>
                                <input type="text" name="address" id="address" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="default-form-box">
                                <label><?=$text_phone?></label>
                                <input type="text" name="phone" class="customer_phone" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="default-form-box">
                                <label><?=$text_email?></label>
                                <input type="email" name="email" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="default-form-box">
                                <label><?=$text_url_company?></label>
                                <input type="text" name="url_company" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="default-form-box">
                                <label><?=$text_img?></label>
                                <input type="file" name="img" />
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="errorsAdd"></ul>
                            <button type="button" id="save" class="btn btn-sm btn-radius btn-default mb-4"><?=$text_add_new?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script>
    $(document).ready(function(){
        $('span.branch_default').click(function() {
            var id_filial = $(this).attr('data');
            var id_user = $(this).attr('data-user');
            
            $.ajax({
            url: '/ajax/branch_default',
            type:'post',
            data: {id_branch: id_filial, id_usr: id_user},
            dataType: 'text',
            success: function (result) {
                if(result == 'ok') {
                    $('span.branch_default[data='+id_filial+']').html('<span id="checked"><img src="/Media/martup/assets/images/icons/icons-checked.png" /></span>');
                }
            }
            });
        });
    });
    
    $(function() {
        $('.branch_edit').bind('click', function (e) {
            e.preventDefault();
            
            var id_branch = $(this).attr('data');
            $('#branch_form').attr('action', '/branch/edit/'+id_branch);
            $('input[name=name_company]').val($('#branch'+id_branch+' > p.name_company').text());
            $('input[name=address]').val($('#branch'+id_branch+' > p.address').text());
            $('input[name=phone]').val($('#branch'+id_branch+' > p.phone').text());
            $('input[name=email]').val($('#branch'+id_branch+' > p.email').text());
            $('input[name=url_company]').val($('#branch'+id_branch+' > p.url_company').text());
            
            $('#title_branch_block').text('<?=$text_title_branch_block?>'+$('#branch'+id_branch+' > p.name_company').text());
            $('button#save').text('<?=$text_save_edit?>');
        });
    });
    
    $(function() {
        $('button#save').bind('click', function (e) {
            e.preventDefault();
            //var id = $(this).attr('data');
            branch($('#branch_form').attr('action'), $('#branch_form'), $('.errorsAdd'), $('#edit_branch'));
        });
    });
    
    function branch (url, form, error, loader) {
        $.ajax({
            url: url,
            type:'post',
            contentType: false,
            processData: false,
            data: new FormData(form.get(0)),
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                loader.css('display', 'block');
                loader.html("<i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i>");
            },
            success: function (result) {
                error.empty();
                $('.addedSuccess').remove();
                
                if(result.errors.length > 0) {
                    $.map(result.errors, function(item) {
                      error.append('<li>' + item + '</li>');
                    });
                } else {
                    form.append('<p class="addedSuccess">' + result.success + '</p>');
                    document.querySelector('#branch_form').reset()
                    loader.empty();
                }
            }
        });
    }
</script>