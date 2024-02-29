<div class="breadcrumb-section">
    <div class="box-wrapper">
        <div class="breadcrumb-wrapper breadcrumb-wrapper--style-4 breadcrumb-bg pos-relative">
            <div class="breadcrumb-content section-fluid-270">
                <div class="container-fluid">
                    <div class="row justify-content-center justify-content-lg-start">
                        <div class="col-auto">
                            <ul class="breadcrumb-nav">
                                <li><a href="/vacancies">Offete di lavoro</a></li>
                                <?php if(is_array($vacance)): ?>
                                <li><a href="/vacancies/category/<?=$vacance['id_category']?>"><?=$vacance['category_title']?></a></li>
                                <?php else: ?>
                                <li><?=$vacance?></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-9">
                            <div class="content">
                                <?php if(is_array($vacance)): ?>
                                <span class="title-tag"><?=$vacance['company_name']?></span>
                                <h1 class="title"><?=$vacance['title']?></h1>
                                <div class="author-details">
                                    <div class="image">
                                        <img src="/<?=$vacance['user_img']?>" alt="<?=$vacance['login']?>" />
                                    </div>
                                    <div class="info">
                                        <span class="name"><?=$vacance['company_name']?></span>
                                        <span class="position"><a rel="nofollow" href="<?=$vacance['company_link']?>" target="_blank"><?=$vacance['company_link']?></a></span>
                                        <p id="online<?=$vacance['id_user']?>"></p>
                                    </div>
                                    <div id="online" val="<?=$vacance['id_user']?>"></div>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blog-details-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center flex-column-reverse flex-lg-row">
                <div class="col-xl-3 col-lg-4">
                    <!-- Start Sidebar Wrapper -->
                    <div class="siderbar-section">
                        <!-- Start Sidebar Single Widget - Catagory-->
                        <div class="sidebar-single-widget sidebar-single-widget--seperator">
                            <h6 class="sidebar-title"><?=$text_category_vacancies?></h6>
                            <div class="sidebar-content">
                                <div class="widget-catagory">
                                    <?php foreach($vacanciesCategoriList as $vm): ?>
                                    <a href="/vacancies/category/<?=$vm['seo']?>"><?=$vm['title']?></a>
                                    <?=($vm['vacancies_count'] == '0')?'':'<span class="portfolio_count">'.$vm['vacancies_count'].'</span>'?></li>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <!-- End Sidebar Single Widget - Catagory-->
                    </div>
                    <!-- End Sidebar Wrapper -->
                </div>
                <div class="col-xl-8 offset-xl-1 col-lg-8">
                    <div class="row justify-content-center">
                        <?php if(is_array($vacance)): ?>
                        <h2 class="mb-20"><?=$vacance['title']?></h2>
                        <div class="col-md-12 col-sm-12 col-xl-12">
                            <div class="row">
                                <div class="col-md-5 col-xl-5 col-sm-12">
                                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3626047805353694"
                                         crossorigin="anonymous"></script>
                                    <!-- adaptive -->
                                    <ins class="adsbygoogle"
                                         style="display:block"
                                         data-ad-client="ca-pub-3626047805353694"
                                         data-ad-slot="3091561332"
                                         data-ad-format="auto"
                                         data-full-width-responsive="true"></ins>
                                    <script>
                                         (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>
                                </div>
                                <div class="col-md-6 col-xl-6 col-sm-12 vacancies_user_date">
                                    <div class="u_date_box row">
                                        <div class="view mb-20"><img src="/Media/martup/assets/images/icons/view.svg" alt="views" /> <?=$vacance['views']?></div>
                                        <div class="u_name mb-20"><img src="/Media/martup/assets/images/icons/icons-company-24.png" alt="views" /> <b><a href="/company/page/<?=$vacance['login']?>"><?=$vacance['company_name']?></a></b></div>
                                        <div class="u_tel mb-20"><img src="/Media/martup/assets/images/icons/icons-call-24.png" alt="views" /> <?=$vacance['mobile']?></div>
                                        <div class="u_email mb-20"><img src="/Media/martup/assets/images/icons/icons-mail-24.png" alt="views" /> <?=$vacance['email']?></div>
                                        <div class="u_location mb-20"><img src="/Media/martup/assets/images/icons/icons-address-24.png" alt="views" /> <?=$vacance['location']?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div class="default-text-content">
                                <?=htmlspecialchars_decode($vacance['full_desc'])?>
                                <div class="row mt-20">
                                    <?php if(!empty($requirements_nec) or !empty($requirements_des)): ?>
                                        <div class="col-sm-12 requirements_block">
                                        <div class="row mt-20">
                                            <div class="col-sm-6">
                                                <h4 class="requirements"><?=$text_requisiti_obbligatori?></h4>
                                                <?php if(isset($requirements_nec['age'])): ?>
                        							<?php if ($requirements_nec['age']['value_rm'] == '1'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_18?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['age']['value_rm'] == '2'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_18_25?></span></div>
                        							<?php endif?>
                        							<?php if ($requirements_nec['age']['value_rm'] == '3'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_25_30?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['age']['value_rm'] == '4'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_30_45?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['age']['value_rm'] == '5'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_45?></span></div>
                        							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_nec['education'])): ?>
                        							<?php if ($requirements_nec['education']['value_rm'] == '1'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_high?></span></div>
                        							<?php endif ?>
                        							<?php if($requirements_nec['education']['value_rm'] == '2'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_incomplete_higher?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['education']['value_rm'] == '3'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_specialized_secondary?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['education']['value_rm'] == '4'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_media?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['education']['value_rm'] == '5'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_without_education?></span></div>
                        							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_nec['languages'])): ?>
                                                    <div class="value_rm"><span class="title_rm"><?=$text_languages?></span><span class="value_rm_v"><?=$requirements_nec['languages']['value_rm']?></span></div>
                                                <?php endif ?>
                                                <?php if(isset($requirements_nec['special_knowledge'])): ?>
                                                    <div class="value_rm"><span class="title_rm"><?=$text_special_knowledge?></span><span class="value_rm_v"><?=$requirements_nec['special_knowledge']['value_rm']?></span></div>
                                                <?php endif ?>
                                                <?php if(isset($requirements_nec['experience'])): ?>
                        							<?php if ($requirements_nec['experience']['value_rm'] == '1'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_without_experience?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['experience']['value_rm'] == '2'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_half_year?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['experience']['value_rm'] == '3'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_year?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['experience']['value_rm'] == '4'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_Up_to_5_years?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['experience']['value_rm'] == '5'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_Morethan_5_years?></span></div>
                        							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_nec['driver_license'])): ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '1'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_non_patent?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '2'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_m?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '3'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_a1?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '4'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_a?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '5'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_b1?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '6'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_b?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '7'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_be?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '8'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_tb?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '9'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_tm?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '10'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_c1?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '11'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_c1e?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '12'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_c?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '13'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_ce?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '14'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_d1?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '15'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_d1e?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '16'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_d?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['driver_license']['value_rm'] == '17'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_de?></span></div>
                        							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_nec['own_transport'])): ?>
                        							<?php if ($requirements_nec['own_transport']['value_rm'] == '1'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_own_transport?></span><span class="value_rm_v"><?=$text_yes?></span></div>
                        							<?php endif ?>
                        							<?php if ($requirements_nec['own_transport']['value_rm'] == '2'): ?>
                                                        <div class="value_rm"><span class="title_rm"><?=$text_own_transport?></span><span class="value_rm_v"><?=$text_no?></span></div>
                        							<?php endif ?>
                                                <?php endif ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <h4 class="requirements"><?=$text_requisiti_desiderabili?></h4>
                                                <?php if(isset($requirements_des['age'])): ?>
                    							<?php if ($requirements_des['age']['value_rm'] == '1'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_18?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['age']['value_rm'] == '2'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_18_25?></span></div>
                    							<?php endif?>
                    							<?php if ($requirements_des['age']['value_rm'] == '3'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_25_30?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['age']['value_rm'] == '4'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_30_45?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['age']['value_rm'] == '5'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_age?></span><span class="value_rm_v"><?=$text_45?></span></div>
                    							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_des['education'])): ?>
                    							<?php if ($requirements_des['education']['value_rm'] == '1'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_high?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['education']['value_rm'] == '2'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_incomplete_higher?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['education']['value_rm'] == '3'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_specialized_secondary?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['education']['value_rm'] == '4'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_media?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['education']['value_rm'] == '5'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_education?></span><span class="value_rm_v"><?=$text_without_education?></span></div>
                    							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_des['languages'])): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_languages?></span><span class="value_rm_v"><?=$requirements_des['languages']['value_rm']?></span></div>
                                                <?php endif ?>
                                                <?php if(isset($requirements_des['special_knowledge'])): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_special_knowledge?></span><span class="value_rm_v"><?=$requirements_des['special_knowledge']['value_rm']?></span></div>
                                                <?php endif ?>
                                                <?php if(isset($requirements_des['experience'])): ?>
                    							<?php if ($requirements_des['experience']['value_rm'] == '1'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_without_experience?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['experience']['value_rm'] == '2'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_half_year?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['experience']['value_rm'] == '3'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_year?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['experience']['value_rm'] == '4'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_Up_to_5_years?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['experience']['value_rm'] == '5'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_experience?></span><span class="value_rm_v"><?=$text_Morethan_5_years?></span></div>
                    							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_des['driver_license'])): ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '1'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_non_patent?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '2'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_m?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '3'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_a1?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '4'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_a?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '5'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_b1?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '6'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_b?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '7'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_be?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '8'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_tb?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '9'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_tm?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '10'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_c1?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '11'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_c1e?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '12'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_c?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '13'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_ce?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '14'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_d1?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '15'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_d1e?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '16'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_d?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['driver_license']['value_rm'] == '17'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_Driver_license?></span><span class="value_rm_v"><?=$text_category_de?></span></div>
                    							<?php endif ?>
                                                <?php endif ?>
                                                <?php if(isset($requirements_des['own_transport'])): ?>
                    							<?php if ($requirements_des['own_transport']['value_rm'] == '1'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_own_transport?></span><span class="value_rm_v"><?=$text_yes?></span></div>
                    							<?php endif ?>
                    							<?php if ($requirements_des['own_transport']['value_rm'] == '2'): ?>
                                                <div class="value_rm"><span class="title_rm"><?=$text_own_transport?></span><span class="value_rm_v"><?=$text_no?></span></div>
                    							<?php endif ?>
                                                <?php endif ?>
                                            </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <hr />
                                    <div class="sidebar-single-widget col-md-12 col-sm-12">
                                        <div class="vacance_data_public">
                                            <img src="/Media/martup/assets/images/icons/icon-calendar-app.svg" alt="<?=date('D, d M y H:i', $vacance['date_add'])?>" /> <span><?=date('D, d M y H:i', $vacance['date_add'])?></span>
                                        </div>
                                        <div class="share">
                                            <div class="fb-share-button" data-href="https://findsol.it<?=$_SERVER['REQUEST_URI']?>" data-layout="button_count"></div>
                                            <div class="twitter-button" style="margin-top: 1px;"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div>
                                        </div>
                                    </div>
                                    <?php if(!empty($tags)): ?>
                                    <div class="sidebar-content mb-20">
                                        <ul class="tag-link">
                                        <?php foreach($tags as $t): ?>
                                            <li><a href="/search/tags/<?=trim($t)?>"><?=$t?></a></li>
                                        <?php endforeach ?>
                                        </ul>
                                    </div>
                                    <div style="margin-bottom: 20px;">
                                        <ins class="adsbygoogle"
                                             style="display:block"
                                             data-ad-format="autorelaxed"
                                             data-ad-client="ca-pub-3626047805353694"
                                             data-ad-slot="6937726981"></ins>
                                        <script>
                                             (adsbygoogle = window.adsbygoogle || []).push({});
                                        </script>
                                    </div>
                                    <?php endif ?>
                                    <?php if($u_data): ?>
                                        <?php if($u_data['type_person'] == '5'): ?>
                                            <?php if(!$candidatIsset): ?>
                                            <!-- Start Reply Form -->
                                            <div class="our-reply-form-area mt--20">
                                                <div class="reply-form-inner mt--10">
                                                    <form method="post" action="/ajax/vmsendmsg/<?=$vacance['id']?>" id="vm_form">
                                                        <div class="blog__details__btn">
                                                            <button class="btn btn-sm btn-radius btn-default mb-4" id="btn_sendmsg" type="submit" name="candidatura"><?=$text_candidat?></button>
                                                        </div>
                                                        <div><span id="result"></span></div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- End Reply Form -->
                                            <?php else: ?>
                                                <div class="candidat_sended"><p><?=$text_candidat_sended?></p></div>
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <div class="account_form">
                                            <form action="/ajax/new_candidat" method="post" id="sendcv" enctype="multipart/form-data">
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 default-form-box">
                                                            <label><?=$text_candidat_name?> <span>*</span></label>
                                                            <input type="text" name="name" />
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 default-form-box">
                                                            <label><?=$text_candidat_lastname?> <span>*</span></label>
                                                            <input type="text" name="lastname" />
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 default-form-box">
                                                            <label><?=$text_candidat_email?> <span>*</span></label>
                                                            <input type="email" name="email" />
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 default-form-box">
                                                            <label><?=$text_candidat_cv?> <span>*</span></label>
                                                            <input type="file" name="cv" />
                                                            <input type="hidden" value="<?=$vacance['id']?>" name="id_v" />
                                                            <input type="hidden" value="<?=$vacance['title']?>" name="title_v" />
                                                        </div>
                                                        <div class="col-sm-12 col-md-4 default-form-box">
                                                            <span id="loader"></span>
                                                            <button type="submit" class="btn btn-sm btn-radius btn-default mb-4" name="sendcv">Invio</button>
                                                        </div>
                                                        <div class="col-sm-12 col-md-8 default-form-box">
                                                            <a href="/login" class="btn btn-sm btn-radius btn-default mb-4">Area privata</a>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12 default-form-box">
                                                            <span id="ajax_result"></span>
                                                            <?=$text_candidat_text?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <h2><?=$vacance?></h2>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '5343780585713271',
      cookie     : true,
      xfbml      : true,
      version    : 'v14.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!-- End Our ShopSide Area -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_sendmsg').on('click', function (e) {
            e.preventDefault();
            $('#result').empty();
            $.ajax({
                type: 'POST',
                url: '/ajax/vmsendmsg/<?=$vacance["id"]?>',
                data: {candidat: '1'},
                dataType: 'json',
                success: function(data) {
                    if(data.error) $('#result').html(data.error);
                    else {
                        $('#btn_sendmsg').remove();
                        $('#result').html(data.success);
                    }
                },
                error:  function(xhr, str){
                    alert('System error: ' + xhr.responseCode);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sendcv').on('submit', function (e){
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
                },
                success: function (result) {
                    $('span#loader').css('display', 'none');
                    $('#ajax_result').empty();
                    $('.error_list_icon').remove();
                    
                    if(result.errors) {
                        $.each(result.errors, function(i, item) {
                            $('input[name='+i+']').before('<p class="error_list_icon">' + item + '</p>');
                        });
                    } 
                    if(result.success) {
                        $('#ajax_result').html('<p class="addedSuccess">' + result.success + '</p>');
                        $('#save_edit_btn').remove();
                    }
                }
            });
        });
    });
</script>