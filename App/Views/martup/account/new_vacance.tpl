<!-- ...:::: Start Account Dashboard Section:::... -->
<link rel="stylesheet" href="/Media/martup/assets/css/plugins/trumbowyg.css" />
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <form method="post" action="/profile/savevacance" id="addVacancy">
                    <?php if(!empty($filialList)): ?>
                    <div class="default-form-box">
                        <label for="filial_avdert"><?=$text_select_branch?></label>
                        <select name="filial_avdert" >
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
                        <label for="title"><?=$text_name?></label>
                        <input type="text" id="title" name="title" />
                    </div>
                    <div class="default-form-box">
                        <label for="id_category"><?=$text_category?></label>
                        <select id="id_category" name="id_category">
                            <option value="0"><?=$text_select_category?></option>
                            <?=$categoryListForVacancies?>
                        </select>
                    </div>
                    <div class="default-form-box">
                        <label for="tegsAdvert"><?=$text_tags?></label>
                        <input type="text" name="tags_vacance" id="tegsAdvert" />
                    </div>
                    <div class="default-form-box">
                        <label for="short_description"><?=$text_short_description?></label>
                        <input type="text" name="short_description" id="short_description" />
                    </div>
                    <div class="default-form-box">
                        <label for="full_description"><?=$text_full_description?></label>
                        <textarea class="textAdvert" name="full_description" id="full_description"></textarea>
                    </div>
                    <div class="default-form-box" style="display: block ruby;position: relative;">
                        <div class="default-form-box col-sm-12 col-md-6 col-lg-6">
                            <label for="id_country"><?=$text_country?></label>
                            <select id="id_country" name="id_country">
                                <option value="0">- <?=$text_select_country?> -</option>
                                <?php foreach($countryList as $cl): ?>
                                <option value="<?=$cl['id']?>" selected><?=$cl['name']?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="default-form-box col-sm-12 col-md-6 col-lg-6">
                            <label for="id_region"><?=$text_region?></label>
                            <select id="id_region" name="id_region">
                                <option value="0"><?=$text_select_region?></option>
                            </select>
                        </div>
                    </div>
                    <div class="default-form-box" style="display: block ruby;position: relative;">
                        <div class="default-form-box col-sm-12 col-md-6 col-lg-6">
                            <label for="id_provincies"><?=$text_provincies?></label>
                            <select id="id_provincies" name="id_provincies">
                                <option value="0">- <?=$text_select_provincies?> -</option>
                            </select>
                        </div>
                        <div class="default-form-box col-sm-12 col-md-6 col-lg-6">
                            <label for="location"><?=$text_location?></label>
                            <input type="text" name="location" id="location" />
                        </div>
                    </div>
                    <div class="row block_requirements">
                        <div class="col-md-12">
                            <h3 class="requirements"><?=$text_requirements?></h3>
                        </div>
                        <div class="col-md-4 default-form-box">
                            <div class="title_requirements"><?=$text_age?></div>
                            <div class="body_requirements">
                                <select class="select" name="age">
                                    <option value="0">- <?=$text_select?> -</option>
                                    <option value="1"><?=$text_18?></option>
                                    <option value="2"><?=$text_18_25?></option>
                                    <option value="3"><?=$text_25_30?></option>
                                    <option value="4"><?=$text_30_45?></option>
                                    <option value="5"><?=$text_45?></option>
                                </select>
                            </div>
                            <div class="input-radio footer_requirements">
                                <em><?=$text_necessarily?></em><span class="custom-radio"><input type="radio" id="age_necessarily" name="age_rm" value="necessarily" checked="" /></span>
                                <em><?=$text_desirable?></em><span class="custom-radio"><input type="radio" id="age_desirable" name="age_rm" value="desirable" /></span>
                            </div>
                        </div>
                        <div class="col-md-4 default-form-box">
                            <div class="title_requirements"><?=$text_education?></div>
                            <div class="body_requirements">
                                <select class="select" name="education">
                                    <option value="0">- <?=$text_select?> -</option>
                                    <option value="1"><?=$text_high?></option>
                                    <option value="2"><?=$text_incomplete_higher?></option>
                                    <option value="6"><?=$text_licenza_media?></option>
                                    <option value="3"><?=$text_specialized_secondary?></option>
                                    <option value="4"><?=$text_media?></option>
                                    <option value="5"><?=$text_without_education?></option>
                                </select>
                            </div>
                            <div class="input-radio footer_requirements">
                                <em><?=$text_necessarily?></em><span class="custom-radio"><input type="radio" id="education_necessarily" name="education_rm" value="necessarily" checked="" /></span>
                                <em><?=$text_desirable?></em><span class="custom-radio"><input type="radio" id="education_desirable" name="education_rm" value="desirable" /></span>
                            </div>
                        </div>
                        <div class="col-md-4 default-form-box">
                            <div class="title_requirements"><?=$text_languages?></div>
                            <div class="body_requirements">
                                <input type="text" name="languages" style="margin-bottom: 0px;" placeholder="<?=$text_comma_separated?>" />
                            </div>
                            <div class="input-radio footer_requirements">
                                <em><?=$text_necessarily?></em><span class="custom-radio"><input type="radio" id="languages_necessarily" name="languages_rm" value="necessarily" checked="" /></span>
                                <em><?=$text_desirable?></em><span class="custom-radio"><input type="radio" id="languages_desirable" name="languages_rm" value="desirable" /></span>
                            </div>
                        </div>
                        <div class="col-md-4 default-form-box">
                            <div class="title_requirements"><?=$text_special_knowledge?></div>
                            <div class="body_requirements">
                                <input type="text" name="special_knowledge" style="margin-bottom: 0px;" placeholder="<?=$text_comma_separated?>" />
                            </div>
                            <div class="input-radio footer_requirements">
                                <em><?=$text_necessarily?></em><span class="custom-radio"><input type="radio" id="special_knowledge_necessarily" name="special_knowledge_rm" value="necessarily" checked="" /></span>
                                <em><?=$text_desirable?></em><span class="custom-radio"><input type="radio" id="special_knowledge_desirable" name="special_knowledge_rm" value="desirable" /></span>
                            </div>
                        </div>
                        <div class="col-md-4 default-form-box">
                            <div class="title_requirements"><?=$text_experience?></div>
                            <div class="body_requirements">
                                <select class="select" name="experience">
                                    <option value="0">- <?=$text_select?> -</option>
                                    <option value="1"><?=$text_without_experience?></option>
                                    <option value="2"><?=$text_half_year?></option>
                                    <option value="3"><?=$text_year?></option>
                                    <option value="4"><?=$text_Up_to_5_years?></option>
                                    <option value="5"><?=$text_Morethan_5_years?></option>
                                </select>
                            </div>
                            <div class="input-radio footer_requirements">
                                <em><?=$text_necessarily?></em><span class="custom-radio"><input type="radio" id="experience_necessarily" name="experience_rm" value="necessarily" checked="" /></span>
                                <em><?=$text_desirable?></em><span class="custom-radio"><input type="radio" id="experience_desirable" name="experience_rm" value="desirable" /></span>
                            </div>
                        </div>
                        <div class="col-md-4 default-form-box">
                            <div class="title_requirements"><?=$text_Driver_license?></div>
                            <div class="body_requirements">
                                <select class="select" name="driver_license">
                                    <option value="0">- <?=$text_select?> -</option>
                                    <option value="1"><?=$text_non_patent?></option>
                                    <option value="2"><?=$text_category_m?></option>
                                    <option value="3"><?=$text_category_a1?></option>
                                    <option value="4"><?=$text_category_a?></option>
                                    <option value="5"><?=$text_category_b1?></option>
                                    <option value="6"><?=$text_category_b?></option>
                                    <option value="7"><?=$text_category_be?></option>
                                    <option value="8"><?=$text_category_tb?></option>
                                    <option value="9"><?=$text_category_tm?></option>
                                    <option value="10"><?=$text_category_c1?></option>
                                    <option value="11"><?=$text_category_c1e?></option>
                                    <option value="12"><?=$text_category_c?></option>
                                    <option value="13"><?=$text_category_ce?></option>
                                    <option value="14"><?=$text_category_d1?></option>
                                    <option value="15"><?=$text_category_d1e?></option>
                                    <option value="16"><?=$text_category_d?></option>
                                    <option value="17"><?=$text_category_de?></option>
                                </select>
                            </div>
                            <div class="input-radio footer_requirements">
                                <em><?=$text_necessarily?></em><span class="custom-radio"><input type="radio" id="Driver_license_necessarily" name="driver_license_rm" value="necessarily" checked="" /></span>
                                <em><?=$text_desirable?></em><span class="custom-radio"><input type="radio" id="Driver_license_desirable" name="driver_license_rm" value="desirable" /></span>
                            </div>
                        </div>
                        <div class="col-md-4 default-form-box">
                            <div class="title_requirements"><?=$text_own_transport?></div>
                            <div class="body_requirements">
                                <select class="select" name="own_transport">
                                    <option value="0">- <?=$text_select?> -</option>
                                    <option value="1"><?=$text_yes?></option>
                                    <option value="2"><?=$text_no?></option>
                                </select>
                            </div>
                            <div class="input-radio footer_requirements">
                                <em><?=$text_necessarily?></em><span class="custom-radio"><input type="radio" id="own_transport_necessarily" name="own_transport_rm" value="necessarily" checked="" /></span>
                                <em><?=$text_desirable?></em><span class="custom-radio"><input type="radio" id="own_transport_desirable" name="own_transport_rm" value="desirable" /></span>
                            </div>
                        </div>
                    </div>
                    <div class="review-btn">
                        <button type="submit" id="save_vacance" class="tn btn-sm btn-radius btn-default mb-4" name="save_vacance"><?=$text_save?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/langs/<?=$_SESSION['lang']?>.min.js"></script>
<script type="text/javascript">
    $('textarea').trumbowyg({
        lang: '<?=$_SESSION["lang"]?>'
    });
</script>
<script>
    $(function() {
        $('button#save_vacance').bind('click', function (e) {
            e.preventDefault();
            
            $.ajax({                             
                url: '/profile/savevacance',
                type:'post',
                contentType: false,
                processData: false,
                data: new FormData($('#addVacancy').get(0)),
                dataType: 'json',
                cache: false,
                success: function (result) {
                    $('.error_list_icon').remove();
                    $('.addedSuccess').remove();
                    
                    if(result.errors.length != 0) {
                        $.map(result.errors, function(i, item) {
                            $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                            $('select[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                            $('textarea[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('#addVacancy').after('<p class="addedSuccess">' + result.success + '</p>');
                        document.getElementById('addVacancy').reset();
                        $('.trumbowyg-editor').text('');
                    }
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(window).on('load', function(){
            var c_id = $('#id_country').val();
            
            if(c_id != '0') {
                $.ajax({
                    url:'/profile/region',
                    method: 'post',
                    dataType: 'json',
                    data: {'c_id': c_id},
                	success: function(data){
                        $.map(data, function(i) {
                            $('#id_region').append('<option value="'+i.id+'">'+i.name+'</option>');
                        });
                	}
                });
            }
        });
    });
    
    $(document).ready(function() {
        $("#id_region").change(function(){
            var r_id = $('#id_region').val();
            
            if(r_id != '0') {
                $.ajax({
                    url:'/profile/provinces',
                    method: 'post',
                    dataType: 'json',
                    data: {'r_id': r_id},
                	success: function(data){
                        $('#id_provincies').empty();
                        $('#id_provincies').append('<option value="0">- <?=$text_select_provincies?> -</option>');
                        $.map(data, function(i) {
                            $('#id_provincies').append('<option value="'+i.id+'">'+i.p_name+'</option>');
                        });
                	}
                });
            }
        });
    });
</script>