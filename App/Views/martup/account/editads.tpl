<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <ul class="errorList">
                <?php if(isset($message['errors'])):?>
                    <?php foreach($message['errors'] as $m):?>
                    <li><?=$m?></li>
                    <?php endforeach ?>
                <?php endif ?>
                </ul>
                <form method="post" id="addNewAds" action="/adscompany/save" enctype="multipart/form-data">
                    <input type="hidden" name="adsId" value="<?=$adsData['id']?>" />
                    <div class="default-form-box">
                        <label for="title"><?=$text_title?></label>
                        <input type="text" id="title" name="title" value="<?=$adsData['title']?>" />
                    </div>
                    <div class="default-form-box">
                        <label for="keywords"><?=$text_keywords?></label>
                        <input type="text" id="keywords" name="keywords" value="<?=$adsData['keywords']?>" />
                    </div>
                    <div class="default-form-box">
                        <label for="description"><?=$text_description?></label>
                        <input type="text" id="description" name="description" value="<?=$adsData['short_desc']?>" />
                    </div>
                    <div class="default-form-box">
                        <label for="textAdvert"></label>
                        <div class="row">
                            <div class="col-lg-5">
                                <label for="link_company"><?=$text_link_company?></label>
                                <input type="text" id="link_company" name="link_company" value="<?=$adsData['company_url']?>" />
                            </div>
                            <div class="col-lg-1">
                                <h3 class="or" id="or"><?=$text_or?></h3>
                            </div>
                            <div class="col-lg-5">
                                <label for="advert_vacance"><?=$text_select_advert_vacance?></label>
                                <select id="advert_vacance" name="advert_vacance">
                                    <option value="0"> -<?=$text_select?>- </option>
                                    <?php if(!empty($advertsOfUser)):?>
                                        <optgroup label="<?=$text_select_advert?>">
                                            <?php foreach($advertsOfUser as $v):?>
                                            <option value="/adverts/page/<?=$v['seo']?>" <?=('/advert/view/'.$v['seo'] == $adsData['seo_publication'])?'selected':''?>><?=$v['title']?></option>
                                            <?php endforeach ?>
                                        </optgroup>
                                    <?php endif ?>
                                    <?php if(!empty($vacanceOfUser)):?>
                                        <optgroup label="<?=$text_select_vacance?>">
                                            <?php foreach($vacanceOfUser as $v):?>
                                            <option value="/vacancies/full/<?=$v['seo']?>" <?=('/vacancies/full/'.$v['seo'] == $adsData['seo_publication'])?'selected':''?>><?=$v['title']?></option>
                                            <?php endforeach ?>
                                        </optgroup>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="default-form-box">
                        <label for="email"><?=$text_email?></label>
                        <input type="text" id="email" name="email" value="<?=$adsData['email']?>" />
                    </div>
                    <div class="default-form-box">
                        <label for="mobile"><?=$text_mobile?></label>
                        <input type="text" id="mobile" class="customer_phone" name="mobile" value="<?=$adsData['mobile']?>" />
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <img src="<?=$adsData['img']?>" class="img-profile" alt="<?=$adsData['title']?>" />
                        </div>
                        <div class="col-sm-8">
                            <label for="images"><?=$text_images_advert?></label>
                            <input type="file" name="images_ads" id="images" />
                        </div>
                    </div>
                    
                    <div class="row">
                        <label for="datetimepicker7"><?=$text_show_period?></label>
                        <div class="col-lg-6">
                            <div class="default-form-box">
                                <div class="input-group date" id="datetimepicker7">
                                    <input type="text" class="form-control input_period" id="show_date_start" name="show_date_start" value="<?=date('d.m.Y', $adsData['show_date_start'])?>" />
                                    <span class="input-group-addon">
                                        <img src="/Media/martup/assets/images/icons/icon-calendar-app.svg" />
                                    </span>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="default-form-box">
                                <div class="input-group date" id="datetimepicker8">
                                    <input type="text" class="form-control input_period" name="show_date_end" value="<?=date('d.m.Y', $adsData['show_date_end'])?>" />
                                    <span class="input-group-addon">
                                        <img src="/Media/martup/assets/images/icons/icon-calendar-app.svg" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="review-btn"><button type="submit" id="addPost" name="saveAds" class="tn btn-sm btn-radius btn-default mb-4"><?=$text_save?></button></div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<link rel="stylesheet" href="/Media/tmart/css/bootstrap-datetimepicker.min.css" />
<script type="text/javascript" src="/Media/tmart/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/Media/tmart/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(function() {
        $('button#addPost').bind('click', function (e) {
            e.preventDefault();
            
            $.ajax({                             
                url: '/adscompany/save',
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($('#addNewAds').get(0)),
                dataType: 'json',
                cache: false,
                success: function (result) {
                    $('.error_list_icon').remove();
                    $('.addedSuccess').remove();
                    
                    if(result.errors.length != 0) {
                        $.map(result.errors, function(i, item) {
                            $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('#addNewAds').append('<p class="addedSuccess">' + result.success + '</p>');
                        document.getElementById('addNewAds').reset();
                    }
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("#datetimepicker7").datetimepicker({
            minDate: moment('<?=date("d.m.Y", $adsData["show_date_start"])?>', 'DD.MM.YYYY'),
            format: 'DD.MM.YYYY',
            locale: '<?=$_SESSION["lid"]?>'
        });
        
        $("#datetimepicker8").datetimepicker({
            useCurrent: false,
            format: 'DD.MM.YYYY',
            locale: '<?=$_SESSION["lid"]?>'
        });
        
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker8').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker8").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>