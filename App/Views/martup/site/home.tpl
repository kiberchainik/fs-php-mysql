<?=$slider?>
<!-- ...::: Strat Product Section :::... -->
<div class="product-item-section  section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="section-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center flex-warp section-content-gap-60">
                    <div class="col-lg-8 col-md-6 col-sm-8 col-auto me-5">
                        <div class="section-content">
                            <h1 class="section-title"><a href="/vacancies"><?=$text_vacancies_home_title?></a></h1>
                            <p><?=$text_vacancies_home_description?></p>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="top-slider-buttons">
                            <!-- If we need navigation buttons -->
                            <div class="slider-buttons">
                                <div class="slider-button button-prev"><span class="material-icons">arrow_left</span></div>
                                <div class="slider-button button-next"><span class="material-icons">arrow_right</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-item-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Slider main container -->
                        <div class="top-slider-3grids-2rows">
                            <div class="swiper-container">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <div class="product-single-item-style-1 swiper-slide">
                                        <ins class="adsbygoogle"
                                             style="display:block; text-align:center;"
                                             data-ad-layout="in-article"
                                             data-ad-format="fluid"
                                             data-ad-client="ca-pub-3626047805353694"
                                             data-ad-slot="1259677286"></ins>
                                        <script>
                                             (adsbygoogle = window.adsbygoogle || []).push({});
                                        </script>
                                    </div>
                                    <?php foreach($arr_vacances as $vl): ?>
                                    <!-- Start Product Single Item - Style 1 -->
                                    <div class="product-single-item-style-1 swiper-slide">
                                        <a href="/vacancies/page/<?=$vl['seo']?>" class="image img-responsive">
                                            <img class="img-fluid" src="/<?=$vl['user_img']?>" alt="<?=$vl['title']?>" width="435" height="350" loading="lazy" />
                                        </a>
                                        <div class="content">
                                            <div class="top">
                                                <h4 class="title"><a href="/vacancies/page/<?=$vl['seo']?>"><?=$vl['title']?></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Single Item - Style 1 -->
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...::: Strat Product Section :::... -->
<div class="product-tab-items-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-3626047805353694"
     data-ad-slot="6937726981"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
    </div>
</div>
<!-- ...::: Strat Product Tab Item Section :::... -->
<div class="product-tab-items-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="section-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center flex-warp">
                    <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12 col-auto me-5">
                        <div class="section-content section-content-gap-60"><?=$text_curriculum_home_text?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-tab-item-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Start Product Tab Items  -->
                        <ul class="product-tab nav" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#features" type="button"><?=$text_features_adverts?></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#popular" type="button"><?=$text_popular_adverts?></button>
                            </li>
                        </ul>
                        <!-- End Product Tab Items  -->

                        <!-- Start Tab Content Items -->
                        <div class="tab-content">
                            <!-- Start Tab Content Single Item -->
                            <div class="tab-pane tab-animate active" id="features" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="center-slider-nav product-slider-3grids-2rows">
                                            <!-- Slider main container -->
                                            <div class="swiper-container">
                                                <!-- Additional required wrapper -->
                                                <div class="swiper-wrapper">
                                                    <!-- Slides -->
                                                    <?php foreach($arr_features_adverts as $fa): ?>
                                                    <!-- Start Product Single Item - Style 1 -->
                                                    <div class="product-single-item-style-1 swiper-slide">
                                                        <a href="/adverts/page/<?=$fa['seo']?>" class="image img-responsive">
                                                            <picture>
                                                            	<source type="image/webp" srcset="/<?=$fa['webp']?>" width="435" height="350" />
                                                                <img class="img-fluid" src="/<?=$fa['imgs'][0]['src']?>" width="435" height="350" loading="lazy" alt="<?=$fa['title']?>" />
                                                            </picture>
                                                        </a>
                                                        <div class="content">
                                                            <div class="top">
                                                                <h4 class="title"><a href="/adverts/page/<?=$fa['seo']?>"><?=$fa['title']?></a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Product Single Item - Style 1 -->
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                            <!-- If we need navigation buttons -->
                                            <div class="center-slider-nav-buttons slider-buttons">
                                                <div class="slider-button button-prev"><span class="material-icons">arrow_left</span></div>
                                                <div class="slider-button button-next"><span class="material-icons">arrow_right</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Tab Content Single Item -->
                            <!-- Start Tab Content Single Item -->
                            <div class="tab-pane tab-animate" id="popular" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="center-slider-nav product-slider-3grids-2rows">
                                            <!-- Slider main container -->
                                            <div class="swiper-container">
                                                <!-- Additional required wrapper -->
                                                <div class="swiper-wrapper">
                                                    <!-- Slides -->
                                                    <?php foreach($arr_popular_adverts as $pa): ?>
                                                    <!-- Start Product Single Item - Style 1 -->
                                                    <div class="product-single-item-style-1 swiper-slide">
                                                        <a href="/adverts/page/<?=$pa['seo']?>" class="image img-responsive">
                                                            <picture>
                                                            	<source type="image/webp" srcset="/<?=$pa['webp']?>" width="435" height="350" />
                                                                <img class="img-fluid" src="/<?=$pa['imgs'][0]['src']?>" width="435" height="350" loading="lazy" alt="<?=$pa['title']?>" />
                                                            </picture>
                                                        </a>
                                                        <div class="content">
                                                            <div class="top">
                                                                <h4 class="title"><a href="/adverts/page/<?=$pa['seo']?>"><?=$pa['title']?></a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Product Single Item - Style 1 -->
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                            <!-- If we need navigation buttons -->
                                            <div class="center-slider-nav-buttons slider-buttons">
                                                <div class="slider-button button-prev"><span class="material-icons">arrow_left</span></div>
                                                <div class="slider-button button-next"><span class="material-icons">arrow_right</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Tab Content Single Item -->
                        </div>
                        <!-- End Tab Content Items -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ...::: Strat Company Logo Section Section :::... -->
<div class="company-logo-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="company-logo-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="section-content section-content-gap-60"><?=$text_api_connection_dscription?></div>
                    </div>
                    <div class="col-12">
                        <?=$logoCompany?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...::: Strat Company Logo Section Section :::... -->
<div class="product-tab-items-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-layout="in-article"
             data-ad-format="fluid"
             data-ad-client="ca-pub-3626047805353694"
             data-ad-slot="1259677286"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>
<!-- ...::: Strat Blog  Section :::... -->
<div class="product-item-section  section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="section-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center flex-warp section-content-gap-60">
                    <div class="col-lg-8 col-md-6 col-sm-8 col-auto me-5">
                        <div class="section-content">
                            <h2 class="section-title"><?=$text_blog_home_title?></h2>
                            <p><?=$text_blog_home_description?></p>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="blog-slider-buttons">
                            <!-- If we need navigation buttons -->
                            <div class="slider-buttons">
                                <div class="slider-button button-prev"><span class="material-icons">arrow_left</span></div>
                                <div class="slider-button button-next"><span class="material-icons">arrow_right</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-item-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Slider main container -->
                        <div class="blog-slider-3grids-1row">
                            <div class="swiper-container">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <?php foreach($LastArticlesList as $lal): ?>
                                    <!-- Start Product Single Item - Style 1 -->
                                    <div class="product-single-item-style-1 swiper-slide">
                                        <a href="/blog/article/<?=$lal['seo']?>" class="image img-responsive">
                                            <picture>
                                            	<source type="image/webp" srcset="/<?=$lal['webp']?>" />
                                                <img class="img-fluid" src="/<?=$lal['logo']?>" width="435" height="350" loading="lazy" alt="<?=$lal['title']?>" />
                                            </picture>
                                        </a>
                                        <div class="content">
                                            <div class="top">
                                                <span class="catagory">By: Admin</span>
                                                <h4 class="title"><a href="/blog/article/<?=$lal['seo']?>"><?=$lal['title']?></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Single Item - Style 1 -->
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...::: Strat Portfolio Section :::... -->
<div class="product-item-section  section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="product-item-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 footer_home_text">
                        <?=$text_footer_home_text?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>