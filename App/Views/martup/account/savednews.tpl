<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <?php if(!empty($profile_adverts)): ?>
                <?php foreach($profile_adverts as $pa): ?>
                <div class="col-xl-4 col-md-6 col-12 mb-25">
                    <div class="product-single-item-style-1 swiper-slide">
                        <a href="/adverts/page/<?=$pa['seo']?>" class="image img-responsive">
                            <img class="img-fluid" src="/<?=$pa['imgs'][0]['src']?>" width="435" height="350" loading="lazy" alt="product-image" />
                        </a>
                        <div class="content">
                            <div class="top">
                                <h4 class="title"><a href="/adverts/page/<?=$pa['seo']?>"><?=$pa['title']?></a></h4>
                            </div>
                            <div class="bottom">
                                <div class="product-event-items">
                                    <a href="/adverts/page/<?=$pa['seo']?>" class="btn cart-btn">View</a>
                                </div>
                                <div class="product-event-items">
                                    <a title="Delete news" href="/savednews/trash/<?=$pa['id']?>" class="btn cart-btn"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                <?php else: ?>
                <h4 class="contact-title spc"><?=$text_adverts_dont_found?></h4>
                <?php endif ?>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->