<link rel="stylesheet" href="/Media/martup/assets/css/bootstrap-datetimepicker.min.css" />
<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
            <!-- Nav tabs -->
            <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <?php if($portfolioData): ?>
                <div class="col-lg-12 profile_live_search mb-50">
                    <div class="row">
                        <p id="text_auto_portfolio"><?=$text_auto_portfolio?></p>
                        <div class="col-lg-6 col-md-6">
                            <div class="default-form-box mb-20">
                                <label><?=$text_acc_keywords_autoportfolio?></label>
                                <input name="automat_searchkeywords" id="automat_searchkeywords" type="text" value="<?=$automat_searchkeywords?>" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="default-form-box mb-20">
                                <label><?=$text_acc_location_autoportfolio?></label>
                                <input name="automat_location" id="automat_location" type="text" value="<?=$automat_location?>" />
                            </div>
                        </div>
                        <div class="row">
                            <input name="automat" type="submit" id="automat" class="btn-sm col-lg-9" value="<?=$text_btn_autoportfolio?>" />
                            <input name="disable" type="submit" id="disable" class="btn-sm col-lg-3" value="<?=$text_disable?>" />
                        </div>
                        <p id="autoportfolio_result"></p>
                    </div>
                </div>
                <?php endif ?>
                <div class="row">
                    <div class="d-flex align-items-start mb-50">
                        <div class="nav flex-column nav-pills me-4 col-lg-3 col-md-3 col-sm-12" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                            <a class="nav-link" id="v-pills-about-tab" data-bs-toggle="pill" href="#v-pills-about" role="tab" aria-controls="v-pills-about" aria-selected="false"><?=$text_about?></a>
                            <a class="nav-link" id="v-pills-education_tab-tab" data-bs-toggle="pill" href="#v-pills-education_tab" role="tab" aria-controls="v-pills-education_tab" tabindex="-1" aria-disabled="false"><?=$text_education?></a>
                            <a class="nav-link" id="v-pills-legend_education_languages_tab-tab" data-bs-toggle="pill" href="#v-pills-legend_education_languages_tab" role="tab" aria-controls="v-pills-legend_education_languages_tab" tabindex="-1" aria-disabled="false"><?=$text_knowledge_of_languages?></a>
                            <a class="nav-link" id="v-pills-education_computer_tab-tab" data-bs-toggle="pill" href="#v-pills-education_computer_tab" role="tab" aria-controls="v-pills-education_computer_tab" tabindex="-1" aria-disabled="false"><?=$text_knowledge_of_computer_programs?></a>
                            <a class="nav-link" id="v-pills-legend_work_post_tab-tab" data-bs-toggle="pill" href="#v-pills-legend_work_post_tab" role="tab" aria-controls="v-pills-legend_work_post_tab" tabindex="-1" aria-disabled="false"><?=$text_work_post?></a>
                            <a class="nav-link" id="v-pills-added_document_block_tab-tab" data-bs-toggle="pill" href="#v-pills-added_document_block_tab" role="tab" aria-controls="v-pills-added_document_block_tab" tabindex="-1" aria-disabled="false"><?=$text_acc_docs?></a>
                        </div>
                        <div class="tab-content col-lg-9 col-md-9 col-sm-12" id="v-pills-tabContent">
                            <div class="tab-pane dashboard-list fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <form method="POST" action="/ajax/saveportfolio" id="saveuserportfolio" enctype="multipart/form-data">
                                    <div class="row">
                                        <?php if($user_avatar): ?>
                                        <div class="col-lg-4">
                                            <img src="/<?=$user_avatar?>" class="img-portfolio" alt="<?=$userDate['name']?>" title="<?=$userDate['name']?>" />
                                        </div>
                                        <?php endif ?>
                                        <div class="<?=($user_avatar)?'col-lg-8':'col-lg-12'?>">
                                            <div class="blank-arrow">
                                                <label for="portfolio_profile_logo"><?=$text_select_photo?></label>
                                            </div>
                                            <input type="file" id="portfolio_profile_logo" style="margin-bottom: 3px !important;" name="portfolio_profile_logo" />
                                            <p class="auxiliary_text"><?=$text_auxiliary_text?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h4><?=$text_category_of_portfolio?></h4>
                                        <div class="default-form-box select-option mt--10">
                                            <select name="category_portfolio" id="id_category">
                                                <option value="0"><?=$text_select?></option>
                                                <?php foreach($CategoryListVacanceWithoutParetnId as $clv): ?>
                                                <option value="<?=$clv['id']?>" <?=($clv['id'] == $category_portfolio['id_category'])?'selected':''?>><?=$clv['title']?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="default-form-box">
                                                <input type="text" name="name" id="name" placeholder="<?=$text_name_placeholder?>" value="<?=(empty($portfolioData['name']))?$userDate['name']:$portfolioData['name']?>" />
                                            </div>
                                            <div class="default-form-box">
                                                <input type="text" name="lastname" id="lastname" placeholder="<?=$text_lastname_placeholder?>" value="<?=(empty($portfolioData['lastname']))?$userDate['lastname']:$portfolioData['lastname']?>" />
                                            </div>
                                            <div class="default-form-box">
                                                <input type="text" name="birthDate" class="daterangepicker_birthDate" value="<?=($portfolioData['birthDate'])?$portfolioData['birthDate']:''?>" id="birthDate" placeholder="<?=$text_birthday_placeholder?>" />
                                            </div>
                                            <div class="default-form-box">
                                                <input type="text" name="nacional" value="<?=$portfolioData['nacional']?>" id="nacional" placeholder="<?=$text_national?>" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="default-form-box">
                                                <input type="text" class="customer_phone" id="mobile" name="mobile" placeholder="<?=$text_mobile_placeholder?>" value="<?=(empty($portfolioData['mobile']))?$userDate['mobile']:$portfolioData['mobile']?>" />
                                            </div>
                                            <div class="default-form-box">
                                                <input type="email" name="email" id="email" placeholder="<?=$text_email_placeholder?>" value="<?=(empty($portfolioData['email']))?$userDate['email']:$portfolioData['email']?>" />
                                            </div>
                                            <div class="default-form-box">
                                                <input type="text" name="fiscalCode" id="fiscalCode" value="<?=($portfolioData['fiscalCode'])?$portfolioData['fiscalCode']:''?>" placeholder="<?=$text_fisical_code?>" />
                                            </div>
                                            <div class="default-form-box select-option">
                                                <select name="document" id="document">
                                                    <option value="0"><?=$text_document?></option>
                                                    <option value="Passport" <?=($portfolioData['document'] == 'Passport')?'selected':''?>>Passport</option>
                                                    <option value="Carta d'indetita" <?=($portfolioData["document"] == "Carta d'indetita")?"selected":""?>>Carta d'indetita</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="default-form-box">
                                                <input type="text" name="adResident" id="adResident" value="<?=$portfolioData['adresResident']?>" placeholder="<?=$text_resident_adres?>" />
                                            </div>
                                            <label class="checkbox-default collapsed" for="resident_yes" data-bs-toggle="collapse" data-bs-target="#newAccountAdress" aria-expanded="false">
                                                <input type="checkbox" name="resident_yes" id="resident_yes" value="1" <?=$checked?> />
                                                <span><?=$text_life_other_adres?></span>
                                            </label>
                                            <div id="newAccountAdress" class="mt-3 collapse" data-parent="#newAccountAdress" style="">
                                                <div class="card-body1 default-form-box">
                                                    <label><?=$text_life_adres?> <span>*</span></label><input type="text" name="adDom" id="adDom" value="<?=$portfolioData['adresDomicilio']?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <legend><?=$text_patent?></legend>
                                        <div class="col-lg-12">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[]" <?=(isset($patent['0']) and $patent['0'] == 'non_patent')?'checked':''?> id="patent" value="non_patent" />
                                                <span><img src="/Media/images/patent_icons/bicycle-32.png" alt="<?=$text_non_patent?>" title="<?=$text_non_patent?>" /> <?=$text_non_patent?></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[M]" <?=(isset($patent['M']))?'checked':''?> id="category_M" value="M" />
                                                <span><img src="/Media/images/patent_icons/scooter-32.png" alt="<?=$text_category_m?>" title="<?=$text_category_m?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[A1]" <?=(isset($patent['A1']))?'checked':''?> id="category_A1" value="A1" />
                                                <span><img src="/Media/images/patent_icons/motorcycle-lite.png" style="height: 32px; width:32px;" alt="<?=$text_category_a1?>" title="<?=$text_category_a1?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[A]" <?=(isset($patent['A']))?'checked':''?> id="category_A" value="A" />
                                                <span><img src="/Media/images/patent_icons/motorcycle-32.png" alt="<?=$text_category_a?>" title="<?=$text_category_a?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[B1]" <?=(isset($patent['B1']))?'checked':''?> id="category_B1" value="B1" />
                                                <span><img src="/Media/images/patent_icons/quad_bike-32.png" alt="<?=$text_category_b1?>" title="<?=$text_category_b1?>" /></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[B]" id="category_B" <?=(isset($patent['B']))?'checked':''?> value="B" />
                                                <span><img src="/Media/images/patent_icons/SUV-32.png" alt="<?=$text_category_b?>" title="<?=$text_category_b?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[BE]" id="category_BE" <?=(isset($patent['BE']))?'checked':''?> value="BE" />
                                                <span><img src="/Media/images/patent_icons/trailer-32.png" style="margin-top: -20px; margin-right: -2px;" alt="<?=$text_category_be?>" title="<?=$text_category_be?>" /><img src="/Media/images/patent_icons/SUV-32.png" alt="<?=$text_category_be?>" title="<?=$text_category_be?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[Tb]" id="category_Tb" <?=(isset($patent['Tb']))?'checked':''?> value="Tb" />
                                                <span><img src="/Media/images/patent_icons/trolleybus-32.png" alt="<?=$text_category_tb?>" title="<?=$text_category_tb?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[Tm]" id="category_Tm" <?=(isset($patent['Tm']))?'checked':''?> value="Tm" />
                                                <span><img src="/Media/images/patent_icons/tram-32.png" alt="<?=$text_category_tm?>" title="<?=$text_category_tm?>" /></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[C1]" id="category_C1" <?=(isset($patent['C1']))?'checked':''?> value="C1" />
                                                <span><img src="/Media/images/patent_icons/van-32.png" alt="<?=$text_category_c1?>" title="<?=$text_category_c1?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[C1e]" id="category_C1e" <?=(isset($patent['C1e']))?'checked':''?> value="C1e" />
                                                <span><img src="/Media/images/patent_icons/trailer-32.png" style="margin-top: -16px; margin-right: -2px;" alt="<?=$text_category_c1e?>" title="<?=$text_category_c1e?>" /><img src="/Media/images/patent_icons/van-32.png" alt="<?=$text_category_c1e?>" title="<?=$text_category_c1e?>" /></span>    
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[C]" id="category_C" <?=(isset($patent['C']))?'checked':''?> value="C" />
                                                <span><img src="/Media/images/patent_icons/truck-32.png" alt="<?=$text_category_c?>" title="<?=$text_category_c?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[Ce]" id="category_Ce" <?=(isset($patent['Ce']))?'checked':''?> value="Ce" />
                                                <span><img src="/Media/images/patent_icons/trailer-32.png" style="margin-right: -2px;" alt="<?=$text_category_ce?>" title="<?=$text_category_ce?>" /><img src="/Media/images/patent_icons/truck-32.png" alt="<?=$text_category_ce?>" title="<?=$text_category_ce?>" /></span>    
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[D1]" <?=(isset($patent['D1']))?'checked':''?> id="category_D1" value="D1" />
                                                <span><img src="/Media/images/patent_icons/bus2-32.png" alt="<?=$text_category_d1?>" title="<?=$text_category_d1?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[D1e]" <?=(isset($patent['D1e']))?'checked':''?> id="category_D1e" value="D1e" />
                                                <span><img src="/Media/images/patent_icons/trailer-32.png" style="margin-right: -2px;" alt="<?=$text_category_d1e?>" title="<?=$text_category_d1e?>" /><img src="/Media/images/patent_icons/bus2-32.png" alt="<?=$text_category_d1e?>" title="<?=$text_category_d1e?>" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[D]" <?=(isset($patent['D']))?'checked':''?> id="category_D" value="D" />
                                                <span><img src="/Media/images/patent_icons/bus_2-32.png" alt="Category D" title="Category D" /></span>
                                            </label>
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[De]" <?=(isset($patent['De']))?'checked':''?> id="category_De" value="De" />
                                                <span><img src="/Media/images/patent_icons/trailer-32.png" style="margin-top: -17px; margin-right: -2px;" alt="<?=$text_category_de?>" title="<?=$text_category_de?>" /><img src="/Media/images/patent_icons/bus_2-32.png" alt="<?=$text_category_de?>" title="<?=$text_category_de?>" /></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="patent[transport]" <?=(isset($patent['transport']) and $patent['transport'] == '1')?'checked':''?> id="transport" value="1" />
                                                <span for="transport"><?=$text_transport?></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-12">
                                            <legend><?=$text_marital_status?></legend>
                                            <div id="family"></div>
                                            <label class="checkbox-default"><input type="radio" name="family" id="family_yes" <?=($portfolioData['marital_status'] == "1")?'checked':''?> value="1" /><span for="family_yes"><?=$text_is_married?></span></label>
                                            <label class="checkbox-default"><input type="radio" name="family" id="family_no" <?=($portfolioData['marital_status'] == "0")?'checked':''?> value="0" /><span for="family_no"><?=$text_no_family?></span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-20 mt-20">
                                        <div class="blank-arrow"><label for="cv_of_user"><?=$text_cv_of_user?></label></div>
                                        <input type="file" id="cv_of_user" name="cv_of_user" />
                                    </div>
                                    <?php if(!empty($portfolioData['cv_of_user'])): ?>
                                    <div class="col-lg-12 mb-20 mt-20">
                                        <div class="cv_img_of_user">
                                            <img src="/<?=$portfolioData['cv_of_user']?>" />
                                            <a href="/ajax/cv_user_trash" class="btn_doc_trash">
                                                <img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="Delete" />
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif ?>
                                    <div class="col-lg-12">
                                        <div class="default-form-box">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="portfolio_off" value="1" <?=($portfolioData['search_status'] == '1')?'checked':''?> />
                                                <span><?=$text_portfolio_off?></span>
                                            </label>
                                        </div>
                                        <div class="review-btn">
                                            <button type="submit" name="save_portfolio" id="save_portfolio" class="tn btn-sm btn-radius btn-default mb-4"><?=$text_save?></button>
                                            <div id="ajax_result"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="v-pills-about" role="tabpanel" aria-labelledby="v-pills-about-tab">
                                <div class="row">
                                    <form method="post" action="/ajax/save_user_about" id="form_user_about">
                                        <div class="col-lg-12 default-form-box">
                                            <textarea class="textAdvert" name="about" id="about" placeholder="<?=$text_about?>"><?=htmlspecialchars_decode($portfolioData['about'])?></textarea>
                                        </div>
                                        <div class="col-lg-12 dashboard-list">
                                            <div class="row">
                                                <div id="assests" class="col-lg-4 mt--30">
                                                    <?php if(!empty($assests)): ?>
                                                    <legend><?=$text_assets?></legend>
                                                    <?php foreach($assests as $k => $a): ?>
                                                    <label class="checkbox-default">
                                                    <?php if(!empty($userAssests) and in_array($a['val'], $userAssests)): ?>
                                                        <input type="checkbox" id="<?=$a['val']?>_assests" name="assests[]" checked="" value="<?=$a['val']?>" /><span><?=$a['name']?></span>
                                                        <?php else: ?>
                                                        <input type="checkbox" id="<?=$a['val']?>_assests" name="assests[]" value="<?=$a['val']?>" /><span><?=$a['name']?></span>
                                                    <?php endif ?>
                                                    </label>
                                                    <?php endforeach ?>
                                                    <?php endif ?>
                                                </div>
                                                <div id="hobbi" class="col-lg-4 mt--30">
                                                    <?php if(!empty($hobbi)): ?>
                                                    <legend><?=$text_hobbi?></legend>
                                                    <?php foreach($hobbi as $k => $h): ?>
                                                    <label class="checkbox-default">
                                                    <?php if(!empty($userHobbi) and in_array($h['val'], $userHobbi)):?>
                                                        <input type="checkbox" id="<?=$h['val']?>_hobbi" name="hobbi[]" checked="" value="<?=$h['val']?>" /><span><?=$h['name']?></span>
                                                        <?php else: ?>
                                                        <input type="checkbox" id="<?=$h['val']?>_hobbi" name="hobbi[]" value="<?=$h['val']?>" /><span><?=$h['name']?></span>
                                                    <?php endif ?>
                                                    </label>
                                                    <?php endforeach ?>
                                                    <?php endif ?>
                                                </div>
                                                <div id="interests" class="col-lg-4 mt--30">
                                                    <?php if(!empty($interests)): ?>
                                                    <legend><?=$text_interests?></legend>
                                                    <?php foreach($interests as $k => $i): ?>
                                                    <label class="checkbox-default">
                                                    <?php if(!empty($userInterests) and in_array($i['val'], $userInterests)):?>
                                                        <input type="checkbox" id="<?=$i['val']?>_interests" name="interests[]" checked="" value="<?=$i['val']?>" /><span><?=$i['name']?></span>
                                                        <?php else: ?>
                                                        <input type="checkbox" id="<?=$i['val']?>_interests" name="interests[]" value="<?=$i['val']?>" /><span><?=$i['name']?></span>
                                                    <?php endif ?>
                                                    </label>
                                                    <?php endforeach ?>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review-btn">
                                            <button type="submit" name="save_user_about" id="save_user_about" class="tn btn-sm btn-radius btn-default mb-4"><?=$text_save?></button>
                                            <div id="ua_result"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-education_tab" role="tabpanel" aria-labelledby="v-pills-education_tab-tab">
                                <div class="col-lg-12 education">
                                    <div class="row">
                                        <legend id="legend_education" class="review-btn"><?=$text_education?><button name="education" id="education" data-url="NewEducation" class="fv-btn education_btn pull-right"><img src="/Media/martup/assets/images/icons/icons-add-45.png" /></button></legend>
                                        <div class="default-form-box col-sm-6">
                                            <div class="blank-arrow"><label for="date_of_the_beginning"><?=$text_date_begin?></label></div>
                                            <input type="text" name="date_of_the_beginning" class="daterangepicker_beginning " id="date_of_the_beginning" placeholder="<?=$text_date_begin_placeholder?>" value="" />
                                            <input type="hidden" name="id_education" id="id_education" value="" />
                                        </div>
                                        <div class="default-form-box col-sm-6">
                                            <div class="blank-arrow"><label for="end_date"><?=$text_date_end?></label></div>
                                            <input type="text" name="end_date" id="end_date" class="daterangepicker_end" value="" placeholder="<?=$text_date_end_placeholder?>" />
                                        </div>
                                        <div class="default-form-box col-sm-12">
                                            <div class="blank-arrow"><label for="education_received"><?=$text_education_received?></label></div>
                                            <input type="text" name="education_received" id="education_received" value="" placeholder="<?=$text_education_received_placeholder?>" />
                                        </div>
                                        <div class="default-form-box col-sm-12">
                                            <div class="blank-arrow"><label for="specialty"><?=$text_specialty?></label></div>
                                            <input type="text" name="specialty" id="specialty" value="" placeholder="<?=$text_specialty_placeholder?>" />
                                        </div>
                                        <div class="default-form-box col-sm-12">
                                            <div class="blank-arrow"><label for="educational_institution"><?=$text_institut?></label></div>
                                            <input type="text" name="educational_institution" id="educational_institution" value="" placeholder="<?=$text_institut?>" />
                                        </div>
                                        <div class="default-form-box col-sm-12">
                                            <div class="blank-arrow"><label for="primary_education">Primary education</label></div>
                                            <select name="primary_education" id="primary_education">
                                                <option value="0">- No -</option>
                                                <option value="1">- Yes -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="result_education">
                                        <div id="error_education" class="error"></div>
                                        <table class="table">
                                            <tr>
                                                <th><?=$text_date_begin?></th>
                                                <th><?=$text_date_end?></th>
                                                <th><?=$text_education_received?></th>
                                                <th><?=$text_specialty?></th>
                                                <th><?=$text_institut?></th>
                                                <th>Edit</th>
                                            </tr>
                                            <?php if(!$portfolioData_educations): ?>
                                            <tr id="non_result">
                                                <td colspan="6" class="text_null"><?=$text_null?></td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($portfolioData_educations as $pe):?>
                                            <tr id="<?=$pe['id']?>" <?=($pe['primary_education'] == "1")?'style="background:#fe980f;"':''?>>
                                                <td id="td_date_of_the_beginning"><?=$pe['date_of_the_beginning']?></td>
                                                <td id="td_end_date"><?=$pe['end_date']?></td>
                                                <td id="td_education_received"><?=$pe['education_received']?></td>
                                                <td id="td_specialty"><?=$pe['specialty']?></td>
                                                <td id="td_educational_institution"><?=$pe['educational_institution']?></td>
                                                <td>
                                                    <a data="<?=$pe['id']?>" data-url="UPDEducation" class="btn_edit" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg" alt="Edit" /></a> 
                                                    <a data="<?=$pe['id']?>" data-url="deleteEducation" class="btn_remove" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="Delete" /></a>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-legend_education_languages_tab" role="tabpanel" aria-labelledby="v-pills-legend_education_languages_tab-tab">
                                <div class="col-lg-12 education_languages">
                                    <fieldset>
                                        <legend id="legend_education_languages" class="review-btn"><?=$text_knowledge_of_languages?>
                                            <button name="education_languages" id="education_languages" data-url="NewEducation_languages" class="fv-btn education_btn pull-right"><img src="/Media/martup/assets/images/icons/icons-add-45.png" /></button>
                                        </legend>
                                        <table class="table">
                                            <tr>
                                                <th><?=$text_language?></th>
                                                <th><?=$text_letter?></th>
                                                <th><?=$text_read?></th>
                                                <th><?=$text_dialog?></th>
                                            </tr>
                                            <tr>
                                                <td class="default-form-box">
                                                    <input type="text" name="title_lang" id="title_lang" placeholder="" />
                                                    <input type="hidden" name="id_education_languages" id="id_education_languages" value="" />
                                                </td>
                                                <td class="default-form-box">
                                                    <select name="knowledge_level_write" id="knowledge_level_write">
                                                        <option value="0"><?=$text_select?></option>
                                                        <option value="3"><?=$text_perfect?></option>
                                                        <option value="2"><?=$text_good?></option>
                                                        <option value="1"><?=$text_bad?></option>
                                                    </select>
                                                </td>
                                                <td class="default-form-box">
                                                    <select name="knowledge_level_read" id="knowledge_level_read">
                                                        <option value="0"><?=$text_select?></option>
                                                        <option value="3"><?=$text_perfect?></option>
                                                        <option value="2"><?=$text_good?></option>
                                                        <option value="1"><?=$text_bad?></option>
                                                    </select>
                                                </td>
                                                <td class="default-form-box">
                                                    <select name="knowledge_level_dialog" id="knowledge_level_dialog">
                                                        <option value="0"><?=$text_select?></option>
                                                        <option value="3"><?=$text_perfect?></option>
                                                        <option value="2"><?=$text_good?></option>
                                                        <option value="1"><?=$text_bad?></option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <div id="result_education_languages">
                                        <div id="error_education_languages" class="error"></div>
                                        <table class="table">
                                            <tr>
                                                <th><?=$text_language?></th>
                                                <th><?=$text_letter?></th>
                                                <th><?=$text_read?></th>
                                                <th><?=$text_dialog?></th>
                                            </tr>
                                            <?php if(!$portfolioData_languages): ?>
                                            <tr id="non_result_languages">
                                                <td colspan="5" class="text_null"><?=$text_null?></td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($portfolioData_languages as $pl):?>
                                            <tr id="<?=$pl['id']?>">
                                                <td id="td_title_lang"><?=$pl['title_lang']?></td>
                                                <td id="td_knowledge_level_write"><?=($pl['level_write'] == '3')?$text_perfect:''?><?=($pl['level_write'] == '2')?$text_good:''?><?=($pl['level_write'] == '1')?$text_bad:''?></td>
                                                <td id="td_knowledge_level_read"><?=($pl['level_read'] == '3')?$text_perfect:''?><?=($pl['level_read'] == '2')?$text_good:''?><?=($pl['level_read'] == '1')?$text_bad:''?></td>
                                                <td id="td_knowledge_level_dialog"><?=($pl['level_dialog'] == '3')?$text_perfect:''?><?=($pl['level_dialog'] == '2')?$text_good:''?><?=($pl['level_dialog'] == '1')?$text_bad:''?></td>
                                                <td>
                                                    <a data="<?=$pl['id']?>" data-url="UPDEducation_languages" class="btn_edit" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg" alt="Edit" /></a> 
                                                    <a data="<?=$pl['id']?>" data-url="deleteEducation_languages" class="btn_remove" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="Delete" /></a>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-education_computer_tab" role="tabpanel" aria-labelledby="v-pills-education_computer_tab-tab">
                                <div class="col-lg-12 education_computer">
                                    <fieldset>
                                        <legend id="legend_education_computer" class="review-btn"><?=$text_knowledge_of_computer_programs?>
                                            <button name="education_computer" id="education_computer" data-url="NewEducation_computer" class="fv-btn education_btn pull-right"><img src="/Media/martup/assets/images/icons/icons-add-45.png" /></button>
                                        </legend>
                                        <table class="table">
                                            <tr>
                                                <th><?=$text_programm?></th>
                                                <th><?=$text_link_exemple?></th>
                                                <th><?=$text_level?></th>
                                            </tr>
                                            <tr>
                                                <td class="default-form-box">
                                                    <input type="text" name="title_lang_computer" id="title_lang_computer" placeholder="<?=$text_programm?>" />
                                                    <input type="hidden" name="id_education_computer" id="id_education_computer" />
                                                </td>
                                                <td class="default-form-box"><input type="text" name="url_example" id="url_example" placeholder="<?=$text_link_exemple_placeholder?>" /></td>
                                                <td class="default-form-box">
                                                    <select name="level" id="level">
                                                        <option value="0"><?=$text_select?></option>
                                                        <option value="3"><?=$text_perfect?></option>
                                                        <option value="2"><?=$text_good?></option>
                                                        <option value="1"><?=$text_bad?></option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <div id="result_education_computer">
                                        <div id="error_education_computer" class="error"></div>
                                        <table class="table">
                                            <tr>
                                                <th><?=$text_programm?></th>
                                                <th><?=$text_link_exemple?></th>
                                                <th><?=$text_level?></th>
                                            </tr>
                                            <?php if(!$portfolioData_computer): ?>
                                            <tr id="non_result_computer">
                                                <td colspan="4" class="text_null"><?=$text_null?></td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($portfolioData_computer as $pc):?>
                                            <tr id="<?=$pc['id']?>">
                                                <td id="td_title_lang_computer"><?=$pc['title_lang_computer']?></td>
                                                <td id="td_url_example"><?=$pc['url_example']?></td>
                                                <td id="td_level"><?=($pc['level'] == '3')?$text_perfect:''?><?=($pc['level'] == '2')?$text_good:''?><?=($pc['level'] == '1')?$text_bad:''?></td>
                                                <td>
                                                    <a data="<?=$pc['id']?>" data-url="UPDEducation_computer" class="btn_edit" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg" alt="Edit" /></a> 
                                                    <a data="<?=$pc['id']?>" data-url="deleteEducation_computer" class="btn_remove" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="Delete" /></a>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-legend_work_post_tab" role="tabpanel" aria-labelledby="v-pills-legend_work_post_tab-tab">
                                <div class="col-lg-12 legend_work_post">
                                    <div class="row">
                                        <legend id="legend_work_post" class="review-btn"><?=$text_work_post?>
                                            <button id="work_post" data-url="NewWork_post" class="fv-btn education_btn pull-right"><img src="/Media/martup/assets/images/icons/icons-add-45.png" /></button>
                                        </legend>
                                        <div class="default-form-box col-lg-6">
                                            <div class="blank-arrow"><label for="date_of_the_beginning_work"><?=$text_date_begin?></label></div>
                                            <input type="text" name="date_of_the_beginning_work" class="daterangepicker_beginning_work date" id="date_of_the_beginning_work" placeholder="<?=$text_work_post_date_begin?>" />
                                            <input type="hidden" name="id_work_post" id="id_work_post" value="" />
                                        </div>
                                        <div class="default-form-box col-lg-6">
                                            <div class="blank-arrow"><label for="end_date_work"><?=$text_date_end?></label></div>
                                            <input type="text" name="end_date_work" id="end_date_work" class="daterangepicker_end_work date" placeholder="<?=$text_work_post_date_end?>" />
                                        </div>
                                        <div class="default-form-box col-lg-12">
                                            <label class="checkbox-default">
                                                <input type="checkbox" name="real_work_post" id="real_work_post" /> 
                                                <span><?=$text_acc_real_work_post?></span>
                                            </label>
                                        </div>
                                        <div class="default-form-box col-lg-12">
                                            <div class="blank-arrow"><label for="work_post_fact"><?=$text_work_post_fact?></label></div>
                                            <input type="text" name="work_post_fact" id="work_post_fact" placeholder="<?=$text_work_post_fact?>" />
                                        </div>
                                        <div class="default-form-box col-lg-12">
                                            <div class="blank-arrow"><label for="position"><?=$text_work_level?></label></div>
                                            <input type="text" name="position" id="position" placeholder="<?=$text_work_level?>" />
                                        </div>
                                    </div>
                                    <div id="result_work_post">
                                        <div id="error_work_post" class="error"></div>
                                        <table class="table">
                                            <tr>
                                                <th><?=$text_date_begin?></th>
                                                <th><?=$text_date_end?></th>
                                                <th><?=$text_work_post_fact?></th>
                                                <th><?=$text_work_level?></th>
                                            </tr>
                                            <?php if(!$portfolioData_work_post): ?>
                                            <tr id="non_result_work_post">
                                                <td colspan="4" class="text_null"><?=$text_null?></td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($portfolioData_work_post as $pwp):?>
                                            <tr id="<?=$pwp['id']?>">
                                                <td id="td_date_of_the_beginning_work"><?=$pwp['date_of_the_beginning']?></td>
                                                <td id="td_end_date_work"><?=($pwp['real_work_post'] == '1')?$text_acc_real_work_post:$pwp['end_date']?></td>
                                                <td id="td_work_post_fact"><?=$pwp['work_post']?></td>
                                                <td id="td_position"><?=$pwp['experience']?></td>
                                                <td>
                                                    <a data="<?=$pwp['id']?>" data-url="UPDWork_post" class="btn_edit" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg" alt="Edit" /></a> 
                                                    <a data="<?=$pwp['id']?>" data-url="deleteWork_post" class="btn_remove" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="Delete" /></a>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>                                        
                                            <?php endif ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade dashboard-list" id="v-pills-added_document_block_tab" role="tabpanel" aria-labelledby="v-pills-added_document_block_tab-tab">
                                <div class="col-lg-12 added_document_block">
                                    <div class="row">
                                        <form method="post" action="/ajax/portfolio_document" class="col-lg-12" enctype="multipart/form-data">
                                            <div class="default-form-box">
                                                <input type="file" name="doc_file" />
                                            </div>
                                            <div class="default-form-box">
                                                <input type="text" name="doc_desc" placeholder="<?=$description?>" />
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="submit" name="send_doc" class="tn btn-sm btn-radius btn-default mb-4 education_btn pull-right" value="<?=$text_acc_add_doc?>" />
                                            </div>
                                        </form>
                                        <?php if(!empty($portfolioDocuments)): ?>
                                        <div class="col-lg-12 documents_block">
                                            <?php foreach($portfolioDocuments as $pd): ?>
                                            <div class="col-sm-3 doc_block">
                                                <div class="doc_img">
                                                    <img src="/<?=$pd['doc_url']?>" alt="<?=$pd['title']?>" title="<?=$pd['title']?>" />
                                                    <a href="/ajax/doc_trash/<?=$pd['id']?>/<?=$pd['file_name']?>" class="btn_doc_trash"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="Delete" /></a>
                                                </div>
                                                <div class="doc_title"><?=$pd['title']?></div>
                                            </div>
                                            <?php endforeach ?>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!empty($portfolioData)): ?>
                <div class="review-btn">
                    <a href="/portfolio/user/<?=$userDate['login']?>" target="_blank" class="tn btn-sm btn-radius btn-default mb-4"><?=$text_save_as_new?></a>
                    <a href="/portfolio/printpdf/<?=$userDate['login']?>" target="_blank" class="tn btn-sm btn-radius btn-default mb-4"><?=$text_print?></a>
                </div>
                <?php endif ?>
                <script src="/Media/martup/assets/js/portfolio.js"></script>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script type="text/javascript" src="/Media/martup/assets/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/Media/martup/assets/js/bootstrap-datetimepicker.min.js"></script>