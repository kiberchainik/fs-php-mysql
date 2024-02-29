<!-- Start BLog Area -->
<div class="htc__blog__area bg__white ptb--60">
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
                        <form method="post" action="/vacancies/saveedit" id="addVacancy" >
                            <div class="single-checkout-box">
                                <label for="title">Название</label>
                                <input type="hidden" name="v_id" value="<?=$vacanceData['id']?>" />
                                <input type="hidden" name="user_id" value="<?=$vacanceData['id_user']?>" />
                                <input type="text" id="title" name="title" value="<?=$vacanceData['title']?>" />
                            </div>
                            <div class="single-checkout-box">
                                <label for="id_category">Категория</label>
                                <select id="id_category" name="id_category">
                                    <option value="0">- Выбрать -</option>
                                    <?php foreach($categoryList as $cl): ?>
                                    <option value="<?=$cl['id']?>" <?=($cl['id'] == $vacanceData['id_category'])?'selected':''?>><?=$cl['title']?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="single-checkout-box">
                                <label for="tegsAdvert">Теги вакансии</label>
                                <input type="text" name="tags_vacance" id="tegsAdvert" value="<?=$vacanceData['tags']?>" />
                            </div>
                            <div class="single-checkout-box">
                                <label for="short_description">Краткое описание</label>
                                <input type="text" name="short_description" id="short_description" value="<?=$vacanceData['short_desc']?>" />
                            </div>
                            <div class="single-checkout-box">
                                <label for="full_description">Полное описание</label>
                                <textarea class="textAdvert" name="full_description" id="full_description"><?=htmlspecialchars_decode($vacanceData['full_desc'])?></textarea>
                            </div>
                            <div class="col-md-12 block_requirements">
                                <div class="col-md-12">
                                    <h3 class="requirements">Требования к работнику</h3>
                                </div>
                                <div class="col-md-4 single-checkout-box">
                                    <div class="title_requirements">Возраст</div>
                                    <div class="body_requirements">
                                        <select class="select" name="age">
                                            <option value="0">- Выбрать -</option>
                                            <option value="1" <?=(isset($requirements['age']) and $requirements['age']['value_rm'] == '1')?'selected':''?>>До 18</option>
                                            <option value="2" <?=(isset($requirements['age']) and $requirements['age']['value_rm'] == '2')?'selected':''?>>18-25</option>
                                            <option value="3" <?=(isset($requirements['age']) and $requirements['age']['value_rm'] == '3')?'selected':''?>>25-30</option>
                                            <option value="4" <?=(isset($requirements['age']) and $requirements['age']['value_rm'] == '4')?'selected':''?>>30-45</option>
                                            <option value="5" <?=(isset($requirements['age']) and $requirements['age']['value_rm'] == '5')?'selected':''?>>45 и выше</option>
                                        </select>
                                    </div>
                                    <div class="footer_requirements">
                                        <?php if(isset($requirements['age'])):?>
                                        <label for="age_necessarily">Обязательно</label><input type="radio" id="age_necessarily" name="age_rm" value="necessarily" <?=($requirements['age']['status_rm'] == 'necessarily')?'checked':''?> />
                                        <label for="age_desirable">Желательно</label><input type="radio" id="age_desirable" name="age_rm" value="desirable" <?=($requirements['age']['status_rm'] == 'desirable')?'checked':''?> />
                                        <?php else: ?>
                                        <label for="age_necessarily">Обязательно</label><input type="radio" id="age_necessarily" name="age_rm" value="necessarily" checked="" />
                                        <label for="age_desirable">Желательно</label><input type="radio" id="age_desirable" name="age_rm" value="desirable" />
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-md-4 single-checkout-box">
                                    <div class="title_requirements">Образование</div>
                                    <div class="body_requirements">
                                        <select class="select" name="education">
                                            <option value="0">- Выбрать -</option>
                                            <option value="1" <?=(isset($requirements['education']) and $requirements['education']['value_rm'] == '1')?'selected':''?>>Высшее</option>
                                            <option value="2" <?=(isset($requirements['education']) and $requirements['education']['value_rm'] == '2')?'selected':''?>>Не полное высшее</option>
                                            <option value="6" <?=(isset($requirements['education']) and $requirements['education']['value_rm'] == '6')?'selected':''?>>Средняя школа</option>
                                            <option value="3" <?=(isset($requirements['education']) and $requirements['education']['value_rm'] == '3')?'selected':''?>>Среднее специальное</option>
                                            <option value="4" <?=(isset($requirements['education']) and $requirements['education']['value_rm'] == '4')?'selected':''?>>Среднее</option>
                                            <option value="5" <?=(isset($requirements['education']) and $requirements['education']['value_rm'] == '5')?'selected':''?>>Без образования</option>
                                        </select>
                                    </div>
                                    <div class="footer_requirements">
                                        <?php if (isset($requirements['education'])): ?>
                                        <label for="education_necessarily">Обязательно</label><input type="radio" id="education_necessarily" name="education_rm" value="necessarily" <?=($requirements['education']['status_rm'] == 'necessarily')?'checked':''?> />
                                        <label for="education_desirable">Желательно</label><input type="radio" id="education_desirable" name="education_rm" value="desirable" <?=($requirements['education']['status_rm'] == 'desirable')?'checked':''?> />
                                        <?php else: ?>
                                        <label for="education_necessarily">Обязательно</label><input type="radio" id="education_necessarily" name="education_rm" value="necessarily" checked="" />
                                        <label for="education_desirable">Желательно</label><input type="radio" id="education_desirable" name="education_rm" value="desirable" />
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-md-4 single-checkout-box">
                                    <div class="title_requirements">Знание языков</div>
                                    <div class="body_requirements">
                                        <input type="text" name="languages" value="<?=(!empty($requirements['languages']['value_rm']))?$requirements['languages']['value_rm']:''?>" style="margin-bottom: 0px;" placeholder="Вводить через зяпятую" />
                                    </div>
                                    <div class="footer_requirements">
                                        <?php if(isset($requirements['languages'])):?>
                                        <label for="languages_necessarily">Обязательно</label><input type="radio" id="languages_necessarily" name="languages_rm" value="necessarily" <?=($requirements['languages']['status_rm'] == 'necessarily')?'checked':''?> />
                                        <label for="languages_desirable">Желательно</label><input type="radio" id="languages_desirable" name="languages_rm" value="desirable" <?=($requirements['languages']['status_rm'] == 'desirable')?'checked':''?> />
                                        <?php else: ?>
                                        <label for="languages_necessarily">Обязательно</label><input type="radio" id="languages_necessarily" name="languages_rm" value="necessarily" checked="" />
                                        <label for="languages_desirable">Желательно</label><input type="radio" id="languages_desirable" name="languages_rm" value="desirable"  />
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-md-4 single-checkout-box">
                                    <div class="title_requirements">Специальные знания</div>
                                    <div class="body_requirements">
                                        <input type="text" name="special_knowledge" value="<?=(!empty($requirements['special_knowledge']['value_rm']))?$requirements['special_knowledge']['value_rm']:''?>" style="margin-bottom: 0px;" placeholder="Вводить ерез зяпятую" />
                                    </div>
                                    <div class="footer_requirements">
                                        <?php if(isset($requirements['special_knowledge'])):?>
                                        <label for="special_knowledge_necessarily">Обязательно</label><input type="radio" id="special_knowledge_necessarily" name="special_knowledge_rm" value="necessarily" <?=($requirements['special_knowledge']['status_rm'] == 'necessarily')?'checked':''?> />
                                        <label for="special_knowledge_desirable">Желательно</label><input type="radio" id="special_knowledge_desirable" name="special_knowledge_rm" value="desirable" <?=($requirements['special_knowledge']['status_rm'] == 'desirable')?'checked':''?> />
                                        <?php else: ?>
                                        <label for="special_knowledge_necessarily">Обязательно</label><input type="radio" id="special_knowledge_necessarily" name="special_knowledge_rm" value="necessarily" checked="" />
                                        <label for="special_knowledge_desirable">Желательно</label><input type="radio" id="special_knowledge_desirable" name="special_knowledge_rm" value="desirable" />
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-md-4 single-checkout-box">
                                    <div class="title_requirements">Опыт работы</div>
                                    <div class="body_requirements">
                                        <select class="select" name="experience">
                                            <option value="0">- Выбрать -</option>
                                            <option value="1" <?=(isset($requirements['experience']) and $requirements['experience']['value_rm'] == '1')?'selected':''?>>Без опыта работы</option>
                                            <option value="2" <?=(isset($requirements['experience']) and $requirements['experience']['value_rm'] == '2')?'selected':''?>>Пол года</option>
                                            <option value="3" <?=(isset($requirements['experience']) and $requirements['experience']['value_rm'] == '3')?'selected':''?>>Год</option>
                                            <option value="4" <?=(isset($requirements['experience']) and $requirements['experience']['value_rm'] == '4')?'selected':''?>>До 5 лет</option>
                                            <option value="5" <?=(isset($requirements['experience']) and $requirements['experience']['value_rm'] == '5')?'selected':''?>>Более 5 лет</option>
                                        </select>
                                    </div>
                                    <div class="footer_requirements">
                                        <?php if(isset($requirements['experience'])):?>
                                        <label for="experience_necessarily">Обязательно</label><input type="radio" id="experience_necessarily" name="experience_rm" value="necessarily" <?=($requirements['experience']['status_rm'] == 'necessarily')?'checked':''?> />
                                        <label for="experience_desirable">Желательно</label><input type="radio" id="experience_desirable" name="experience_rm" value="desirable" <?=($requirements['experience']['status_rm'] == 'desirable')?'checked':''?> />
                                        <?php else: ?>
                                        <label for="experience_necessarily">Обязательно</label><input type="radio" id="experience_necessarily" name="experience_rm" value="necessarily" checked="" />
                                        <label for="experience_desirable">Желательно</label><input type="radio" id="experience_desirable" name="experience_rm" value="desirable" />
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-md-4 single-checkout-box">
                                    <div class="title_requirements">Водительские права</div>
                                    <div class="body_requirements">
                                        <select class="select" name="driver_license">
                                            <option value="0">- Выбрать -</option>
                                            <option value="1" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '1')?'selected':''?>>Без прав</option>
                                            <option value="2" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '2')?'selected':''?>>Категория M</option>
                                            <option value="3" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '3')?'selected':''?>>Категория A1</option>
                                            <option value="4" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '4')?'selected':''?>>Категория A</option>
                                            <option value="5" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '5')?'selected':''?>>Категория B1</option>
                                            <option value="6" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '6')?'selected':''?>>Категория B</option>
                                            <option value="7" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '7')?'selected':''?>>Категория Be</option>
                                            <option value="8" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '8')?'selected':''?>>Категория Tb</option>
                                            <option value="9" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '9')?'selected':''?>>Категория Tm</option>
                                            <option value="10" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '10')?'selected':''?>>Категория C1</option>
                                            <option value="11" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '11')?'selected':''?>>Категория C1e</option>
                                            <option value="12" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '12')?'selected':''?>>Категория C</option>
                                            <option value="13" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '13')?'selected':''?>>Категория Ce</option>
                                            <option value="14" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '14')?'selected':''?>>Категория D1</option>
                                            <option value="15" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '15')?'selected':''?>>Категория D1e</option>
                                            <option value="16" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '16')?'selected':''?>>Категория D</option>
                                            <option value="17" <?=(isset($requirements['driver_license']) and $requirements['driver_license']['value_rm'] == '17')?'selected':''?>>Категория De</option>
                                        </select>
                                    </div>
                                    <div class="footer_requirements">
                                        <?php if(isset($requirements['driver_license'])): ?>
                                        <label for="Driver_license_necessarily">Обязательно</label><input type="radio" id="Driver_license_necessarily" name="driver_license_rm" value="necessarily" <?=($requirements['driver_license']['status_rm'] == 'necessarily')?'checked':''?> />
                                        <label for="Driver_license_desirable">Желательно</label><input type="radio" id="Driver_license_desirable" name="driver_license_rm" value="desirable" <?=($requirements['driver_license']['status_rm'] == 'desirable')?'checked':''?> />
                                        <?php else: ?>
                                        <label for="Driver_license_necessarily">Обязательно</label><input type="radio" id="Driver_license_necessarily" name="driver_license_rm" value="necessarily" checked="" />
                                        <label for="Driver_license_desirable">Желательно</label><input type="radio" id="Driver_license_desirable" name="driver_license_rm" value="desirable" />
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="col-md-4 single-checkout-box">
                                    <div class="title_requirements">Свой транспорт</div>
                                    <div class="body_requirements">
                                        <select class="select" name="own_transport">
                                            <option value="0">- Выбрать -</option>
                                            <option value="1" <?=(isset($requirements['own_transport']) and $requirements['own_transport']['value_rm'] == '1')?'selected':''?>>Да</option>
                                            <option value="2" <?=(isset($requirements['own_transport']) and $requirements['own_transport']['value_rm'] == '2')?'selected':''?>>Нет</option>
                                        </select>
                                    </div>
                                    <div class="footer_requirements">
                                        <?php if(isset($requirements['own_transport'])):?>
                                        <label for="own_transport_necessarily">Обязательно</label><input type="radio" id="own_transport_necessarily" name="own_transport_rm" value="necessarily" <?=($requirements['own_transport']['status_rm'] == 'necessarily')?'checked':''?> />
                                        <label for="own_transport_desirable">Желательно</label><input type="radio" id="own_transport_desirable" name="own_transport_rm" value="desirable" <?=($requirements['own_transport']['status_rm'] == 'desirable')?'checked':''?> />
                                        <?php else: ?>
                                        <label for="own_transport_necessarily">Обязательно</label><input type="radio" id="own_transport_necessarily" name="own_transport_rm" value="necessarily" checked="" />
                                        <label for="own_transport_desirable">Желательно</label><input type="radio" id="own_transport_desirable" name="own_transport_rm" value="desirable" />
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="review-btn">
                                <button type="submit" id="save_vacance" class="fv-btn" name="save_vacance">Сохранить</button>
                            </div>
                            <ul class="errorList"></ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/Media/tmart/js/ckeditor.js"></script>
<script>
	ClassicEditor
		.create( document.querySelector( '#full_description' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} );
</script>
<script>
    $(function() {
        $('button#save_vacance').bind('click', function (e) {
            e.preventDefault();
            
            $('#textAdvert').val($('#textAdvert_ifr').contents().find("body#tinymce").html());
            
            $.ajax({                             
                url: '/vacancies/saveedit',
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
                        //console.log(result.errors);
                        $.map(result.errors, function(i, item) {
                            $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                            $('select[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                            $('textarea[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    } else {
                        $('#save_vacance').append('<p class="addedSuccess">' + result.success + '</p>');
                        document.getElementById('newVacancy').reset();
                        $('#id_category').remote();
                    }
                }
            });
        });
    });
</script>