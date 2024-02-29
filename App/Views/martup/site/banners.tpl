<?php foreach($banners as $b): ?>
<div class="col-lg-3 col-md-6 mb-20">
    <!-- Start Banner Card Single Item -->
    <div class="main_banner">
        <div class="banner-content">
            <a href="<?=$b['link']?>" class="text-link white"><h5 class="banner-title"><?=$b['title']?></h5></a>
        </div>
        <span class="banner-cad-note"><?=$b['text']?></span>
    </div>
    <!-- End Banner Card Single Item -->
</div>
<?php endforeach ?>