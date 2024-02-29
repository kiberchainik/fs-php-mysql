<!-- Start Company Slider -->
<div class="company-slider company-slider-bg">
    <!-- Slider main container -->
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <?php foreach($logoCompany as $lc): ?>
            <!-- Start Company Slider Single Item -->
            <a rel="nofollow" href="<?=$lc['company_link']?>" target="_blank" class="company-slider-single-item swiper-slide">
                <div class="image">
                    <picture>
                    	<source type="image/webp" srcset="<?=$lc['webp']?>" />
                        <img class="img-fluid" src="/<?=$lc['user_img']?>" loading="lazy" alt="<?=$lc['company_name']?>" />
                    </picture>
                </div>
            </a>
            <!-- End Company Slider Single Item -->
            <?php endforeach ?>
        </div>
    </div>
</div>
<!-- End Company Slider -->