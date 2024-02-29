<!-- ...::: Strat Hero Slider Section :::... -->
<div class="hero-slider-section hero-slider-light section-fluid-270">
    <div class="box-wrapper">
        <div class="hero-slider-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-slider">
                            <!-- Slider main container -->
                            <div class="swiper-container">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    <?php foreach($sliderData as $s): ?>
                                    <!-- Start Hero Slider Single Item -->
                                    <div class="hero-slider-single-item--style-1 swiper-slide hero-bg">
                                        <div class="image">
                                            <picture>
                                            	<source type="image/webp" srcset="<?=$s['webp']?>" alt="<?=$s['title']?>" />
                                            	<img class="img-fluid" src="<?=$s['img']?>" width="469" height="760" loading="lazy" alt="hero-image-1" />
                                            </picture>
                                        </div>
                                        <div class="image-shape"></div>
                                        <div class="content-box">
                                            <div class="row">
                                                <div class="col-xl-5 offset-xl-1 col-lg-5 col-md-8 offset-md-1 col-10 ">
                                                    <div class="content hero-slider-content">
                                                        <span class="title-tag"><?=$s['mobile']?></span>
                                                        <h3 class="title"><?=$s['title']?></h3>
                                                        <p><?=$s['short_desc']?></p>
                                                        <a rel="nofollow" href="<?=($s['company_url'] == '')?$s['seo_publication']:$s['company_url']?>" class="btn btn-lg btn-default"><?=$s['title']?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hero-slider-shape hero-slider-top-shape"><img class="img-fluid" src="/Media/martup/assets/images/icons/hero-slider-top-shape.svg" width="113" height="107" loading="lazy" alt="hero-shape-1" /></div>
                                        <div class="hero-slider-shape hero-slider-bottom-shape"><img class="img-fluid" src="/Media/martup/assets/images/icons/hero-slider-bottom-shape.svg" width="221" height="234" loading="lazy" alt="hero-shape-1" /></div>
                                    </div>
                                    <!-- End Hero Slider Single Item -->
                                    <?php endforeach ?>
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ...::: End Hero Slider Section:::... -->