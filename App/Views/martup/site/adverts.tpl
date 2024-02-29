<link rel="stylesheet" href="/Media/martup/assets/css/bootstrap-datetimepicker.min.css" />
<div class="product-gallery-info-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="product-gallery-info-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-8 col-lg-6">
                        <!-- Start Product Gallert - Tab Style -->
                        <div class="product-gallery product-gallery--style-tab">
                            <div class="row flex-md-row flex-column-reverse">
                                <div class="col-md-3">
                                    <!-- Start Product Thumbnail -->
                                    <ul class="product-thumbnail-image nav">
                                        <?php $i = 0; ?>
                                        <?php foreach($ListImagesAdvert['list'] as $img): ?>
                                        <?php $i++; ?>
                                        <li class="nav-item">
                                            <button class="nav-link <?=($i == '1')?'active':''?>" data-bs-toggle="tab" data-bs-target="#img-<?=$i?>" type="button">
                                                <span class="thumb">
													<img class="img-fluid" src="/<?=$img['src']?>" alt="<?=$img['name_img_file']?>" />
												</span>
                                            </button>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                    <!-- End Product Thumbnail -->
                                </div>
                                <div class="col-md-9">
                                    <!-- Start Product Large Image -->
                                    <div class="product-large-image tab-content">
                                        <?php $i = 0; ?>
                                        <?php foreach($ListImagesAdvert['list'] as $img): ?>
                                        <?php $i++; ?>
                                        <div class="tab-pane fade <?=($i == '1')?'active show':''?>" id="img-<?=$i?>" role="tabpanel">
                                            <div class="image">
                                                <img class="img-fluid" src="/<?=$img['src']?>" alt="<?=$img['name_img_file']?>" />
                                            </div>
                                        </div>
                                        <?php endforeach ?>
                                    </div>
                                    <!-- End Product Large Image -->
                                </div>
                            </div>
                        </div>
                        <!-- End Product Gallert - Tab Style -->
                    </div>
                    <div class="col-xxl-4 col-lg-6">
                        <!-- Start Product Content -->
                        <div class="product-content">
                            <?php if($advertData['id_type']): ?>
                                <p><b><?=$text_adverttype?>:</b> <a href="/advert/type/<?=$advertData['id_type']?>"><span class="catagory"><?=$typesOfAdvert['name']?></span></a></p>
    						<?php endif ?>
                            <h2 class="title"><?=$advertData['title']?></h2>
                            <div class="product-variables">
                                <!-- Start Product Single Variable -->
                                <div class="product-variable-color">
                                    <div class="pro__dtl__rating">
                                        <?php if($auth and $u_id['u_id'] != $advertData['idUser']): ?>
                                            <span class="rat__qun">
                                                <?php if(!empty($status_saved)): ?>
                                                    <p><?=$text_saved?></p>
                                                <?php else: ?>
                                                    <a id="btn_save" class="fv-btn"><img src="/Media/martup/assets/images/icons/icon-heart-light.svg" /></a>
                                                <?php endif ?>
                                            </span>
                                        <?php endif ?>
                                        <span class="rat__qun"><img src="/Media/martup/assets/images/icons/icon-thumbs-up.png" width="24" height="24" /> <?=$advertData['klass']?></span>
                                        <span class="rat__qun"><img src="/Media/martup/assets/images/icons/view.svg" width="24" height="24" /> <?=$advertData['views']?></span>
                                        <span class="rat__qun"><img src="/Media/martup/assets/images/icons/icon-calendar-app.svg" /> <?=date('D, d M y H:i', $advertData['add_date'])?></span>
                                    </div>
                                </div>
                                <!-- End Product Single Variable -->
                                <?php if(!empty($fieldsAdvert)): ?>
                                    <?php foreach($fieldsAdvert as $v): ?>
                                        <div class="field" <?=($v['type'] == 'hidden' or empty($v['id_field']))?'style="display:none"':''?>><span class="title__5"><?=(!empty($v['placeholder']))?$v['placeholder'].':':""?></span><span class="field_value"><?=htmlspecialchars_decode($v['field_value'])?></span></div>
                                    <?php endforeach ?>
                                <?php endif ?>
                                <?php if($test_drive == '1'): ?>
                                    <div class="col-lg-12 col-md-12">
                                        <form action="#">
                                            <h3><a href="#testdrive" class="btn btn-sm btn-radius btn-default mb-4" rel="nofollow">Richiesta test-drive</a></h3>
                                            <div class="popup animated" id="testdrive">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="default-form-box">
                                                            <label>Nome e Cognome<span>*</span></label>
                                                            <input type="text" name="user_name" value="<?=(isset($u_id['name']))?$u_id['name'].' '.$u_id['lastname']:''?>" />
                                                            <input type="hidden" name="adv_id" value="<?=$advertData['idUser']?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="default-form-box">
                                                            <label>Email <span>*</span></label>
                                                            <input type="email" name="user_email" value="<?=(isset($u_id['email']))?$u_id['email']:''?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="default-form-box">
                                                            <label>Telefono <span>*</span></label>
                                                            <input type="text" name="telefono" value="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="default-form-box">
                                                            <label>Provincia</label>
                                                            <input type="text" name="provincia" placeholder="Provincia" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="default-form-box">
                                                            <label>Data desiderata <span>*</span></label>
                                                            <div class="input-group date" id="datetimepicker">
                                                                <input type="text" name="date_request" />
                                                                <span class="input-group-addon" style="margin-top: 4px;">
                                                                    <img src="/Media/martup/assets/images/icons/icon-calendar-app.svg" />
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="default-form-box">
                                                            <label>Fascia oraria desiderata <span>*</span></label>
                                                            <select name="request_time" >
                                                                <option value="0">- Select -</option>
                                                                <option value="08:30 - 10:30">08:30 - 10:30</option>
                                                                <option value="10:30 - 12:30">10:30 - 12:30</option>
                                                                <option value="14:30 - 16:30">14:30 - 16:30</option>
                                                                <option value="16:30 - 18:30">16:30 - 18:30</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <div class="order-notes">
                                                            <label for="message">Message</label>
                                                            <textarea id="message" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="default-form-box">
                                                            <input type="submit" name="send_request" id="send_request" class="btn btn-sm btn-radius btn-default" value="Invia" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="default-form-box">
                                                            <p id="requiest_respond"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a rel="nofollow" class="close" href="#close"></a>
                                            </div>
                                        </form>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            $("#datetimepicker").datetimepicker({
                                                minDate: moment(),
                                                format: 'DD.MM.YYYY',
                                                locale: '<?=$_SESSION["lid"]?>'
                                            });
                                        });
                                    </script>
                                <?php endif ?>
                                <?php if($checkBox): ?>
                                    <span class="placeholder"><?=(!empty($checkBox['placeholder']))?$checkBox['placeholder'].':':""?></span>
                                    <?php foreach($checkBox['field_value'] as $cbv):?>
                                    <span class="checkBox"><?=$cbv?></span>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                            <div class="pro_author_box">
                                <div class="u_img"><a href="<?=$link.$advertData['idUser']?>"><img src="/<?=$advertData['user_img']?>" alt="<?=$advertData['login']?>" title="<?=$advertData['name']?> <?=$advertData['lastname']?>" /></a></div>
                                <div class="u_date_box">
                                    <div class="u_name"><a href="<?=$link.$advertData['login']?>"><?=$advertData['company_name']?></a></div>
                                    <p id="online<?=$advertData['idUser']?>"></p>
                                    <div id="online" val="<?=$advertData['idUser']?>"></div>
                                    <div class="u_tel"><?=$advertData['mobile']?></div>
                                    <div class="u_email"><?=$advertData['email']?></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Product Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-description-section  section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="product-description-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="product-description-content">
                            <h6 class="title">Description</h6>
                            <p><?=htmlspecialchars_decode($advertData['textAdvert'])?></p>

                            <div class="social-links">
                                <div class="items">
                                    <div class="fb-share-button" data-href="https://findsol.it<?=$_SERVER['REQUEST_URI']?>" data-layout="button_count"></div>
                                    <div class="twitter-button" style="margin-top: 7px;"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/Media/martup/assets/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/Media/martup/assets/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(function() {
        $('button#sendmessage').bind('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/advert/sendmessage',
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($('#messageForAuthor').get(0)),
                dataType: 'json',
                cache: false,
                success: function (result) {
                    $('.errorList li').remove();
                    $('.addedSuccess').remove();

                    if(result.errors.length > 0) {
                        $.map(result.errors, function(item) {
                          $('.errorList').append('<li>' + item + '</li>');
                        });
                    } else {
                        $('.errorList').append('<p class="addedSuccess">' + result.success + '</p>');
                        document.getElementById('messageForAuthor').reset();
                    }
                }
            });
        });
    });
    
    $(function() {
        $('.fv-btn').bind('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/comments/new',
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($('#commentForAdv').get(0)),
                dataType: 'json',
                cache: false,
                success: function (result) {
                    $('.errorListComm li').remove();
                    $('.addedComSuccess').remove();

                    if(result.errors.length > 0) {
                        $.map(result.errors, function(item) {
                          $('.errorListComm').append('<li>' + item + '</li>');
                        });
                    } else {
                        $('.errorListComm').append('<p class="addedComSuccess">' + result.success + '</p>');
                        //$('#commentForAdv').reset();
                    }
                }
            });
        });
    });

    $(function() {
        $('#btn_save').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: '/savednews/save',
                type:'post',
                data: {advid: "<?=$advertData['id']?>", u_id: "<?=$advertData['idUser']?>"},
                dataType: 'json',
                success: function (data) {
                    if(data.error.length != '') {
                        $('#btn_save').html(data.error);
                        setTimeout(function() {
                            $('#btn_save').html('Save');
                        }, 2000);
                    } else {
                        $('#btn_save').replaceWith('<p><?=$text_saved?></p>');
                    }
                }
            });
        });
    });
    
    $(function () {
        $('.btn_class').bind('click', function() {
            e.preventDefault();

            $.ajax({
                url: '/ajax/btn_class',
                type:'post',
                data: {id_adv: "<?=$advertData['id']?>"},
                dataType: 'json',
                cache: false,
                success: function (result) {
                    if(result.errors.length > 0) {
                        alert(result.errors);
                    } else {
                        alert(result.success);
                        $('.recommend > num').text(result.tottalKlass);
                    }
                }
            });
        });
    });
    
    $(function() {
        $('#send_request').bind('click', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/ajax/request_test_drive',
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($('#test_drive_form').get(0)),
                dataType: 'json',
                cache: false,
                success: function (result) {
                    if(result.error.length != 0) {
                        $.map(result.error, function(item) {
                          $('#requiest_respond').append('<li>' + item + '</li>');
                        });
                    } else {
                        $('#requiest_respond').html(result.success);
                        document.getElementById('test_drive_form').reset();
                    }
                }
            });
        });
    });
</script>