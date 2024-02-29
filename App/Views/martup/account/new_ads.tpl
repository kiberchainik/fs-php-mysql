<link rel="stylesheet" href="/Media/martup/assets/css/bootstrap-datetimepicker.min.css" />
<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-md-9 col-lg-9">
                <form method="post" id="addNewAds" action="/adscompany/save" enctype="multipart/form-data">
                    <div class="default-form-box">
                        <label for="title"><?=$text_title?></label>
                        <input type="text" id="title" name="title" />
                    </div>
                    <div class="default-form-box">
                        <label for="keywords"><?=$text_keywords?></label>
                        <input type="text" id="keywords" name="keywords" />
                    </div>
                    <div class="default-form-box">
                        <label for="description"><?=$text_description?></label>
                        <input type="text" id="description" name="description" />
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="default-form-box">
                                <label for="link_company"><?=$text_link_company?></label>
                                <input type="text" id="link_company" name="link_company" />
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <h3 class="mt-20" id="or"><?=$text_or?></h3>
                        </div>
                        <div class="col-lg-5">
                            <div class="default-form-box">
                                <label for="advert_vacance"><?=$text_select_advert_vacance?></label>
                                <select id="advert_vacance" name="advert_vacance">
                                    <option value="0"> -<?=$text_select?>- </option>
                                    <?php if(!empty($advertsOfUser)):?>
                                        <optgroup label="<?=$text_select_advert?>">
                                            <?php foreach($advertsOfUser as $v):?>
                                            <option value="/adverts/page/<?=$v['seo']?>"><?=$v['title']?></option>
                                            <?php endforeach ?>
                                        </optgroup>
                                    <?php endif ?>
                                    <?php if(!empty($vacanceOfUser)):?>
                                        <optgroup label="<?=$text_select_vacance?>">
                                            <?php foreach($vacanceOfUser as $v):?>
                                            <option value="/vacancies/full/<?=$v['seo']?>"><?=$v['title']?></option>
                                            <?php endforeach ?>
                                        </optgroup>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="default-form-box">
                        <label for="email"><?=$text_email?></label>
                        <input type="text" id="email" name="email" value="<?=$email?>" />
                    </div>
                    <div class="default-form-box">
                        <label for="mobile"><?=$text_mobile?></label>
                        <input type="text" id="mobile" name="mobile" class="customer_phone" value="<?=$mobile?>" />
                    </div>
                    <div class="default-form-box">
                        <label for="images"><?=$text_images_advert?></label>
                        <input type="file" name="images_ads" id="images" />
                    </div>
                    <div class="row">
                        <label for="datetimepicker7"><?=$text_show_period?></label>
                        <div class="clearfix"></div>
                        <div class="col-lg-6">
                            <div class="default-form-box">
                                <div class="input-group date" name="show_date_start" id="datetimepicker7">
                                    <input type="text" class="form-control input_period" id="show_date_start" name="show_date_start"/>
                                    <span class="input-group-addon">
                                        <img src="/Media/martup/assets/images/icons/icon-calendar-app.svg" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="default-form-box">
                                <div class="input-group date" name="show_date_end" id="datetimepicker8">
                                    <input type="text" class="form-control input_period" id="show_date_end" name="show_date_end" />
                                    <span class="input-group-addon">
                                        <img src="/Media/martup/assets/images/icons/icon-calendar-app.svg" />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="review-btn"><button type="submit" id="addPost" name="addPost" class="btn btn-sm btn-radius btn-default mb-4"><?=$text_save?></button></div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script type="text/javascript" src="/Media/martup/assets/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/Media/martup/assets/js/bootstrap-datetimepicker.min.js"></script>
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
                success: function (r) {
                    $('.error_list_icon').remove();
                    $('.addedSuccess').remove();
                    
                    if(r.errors.length != 0) {
                        $.map(r.errors, function(i, item) {
                            $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('#addNewAds').append('<p class="addedSuccess">' + r.success + '</p>');
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
            minDate: moment(),
            format: 'DD.MM.YYYY',
            locale: '<?=$_SESSION["lid"]?>',
            icons: {
                previous: '<img src="/Media/martup/assets/images/icons/icon-previous-24.png">',
                next: '<img src="/Media/martup/assets/images/icons/icon-next-24.png">'
            }
      });
        $("#datetimepicker8").datetimepicker({
            useCurrent: false,
            format: 'DD.MM.YYYY',
            locale: '<?=$_SESSION["lid"]?>',
            icons: {
                previous: '<img src="/Media/martup/assets/images/icons/icon-previous-24.png">',
                next: '<img src="/Media/martup/assets/images/icons/icon-next-24.png">'
            }
        });
        
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker8').data("DateTimePicker").minDate(e.date);
        });
        
        $("#datetimepicker8").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>