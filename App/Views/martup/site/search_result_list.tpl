<div class="shop-list-section section-fluid-270 section-top-gap-100">
        <div class="box-wrapper">
            <div class="shop-list-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <ul class="product-shop-filter-info">
                                <li class="prduct-item-traking"><span>total 08 of 40</span></li>
                                <li class="prduct-item-filter">
                                    <select name="choice" style="display: none;">
                                        <option value="first">New Arrival</option>
                                        <option value="second" selected="">Featured</option>
                                        <option value="third">Popular</option>
                                    </select><div class="nice-select" tabindex="0"><span class="current">Featured</span><ul class="list"><li data-value="first" class="option">New Arrival</li><li data-value="second" class="option selected">Featured</li><li data-value="third" class="option">Popular</li></ul></div>
                                </li>
                            </ul>
                            <div class="product-shop-list-items">
                                <div class="row mb-n25">
                                    <div class="col-xl-4 col-md-6 col-12 mb-25">
                                        <div class="col-md-12">
                                            <h1>Users seach result</h1>
                                            <?php if(!empty($result['users'])): ?>
                                            <!-- Start Single Product -->
                                            <?php foreach($result['users'] as $pl): ?>
                                            <!-- Start Product Single Item - Style 1 -->
                                            <div class="product-single-item-style-1">
                                                <a href="/user/page/<?=$pl['id']?>" class="image img-responsive">
                                                    <img class="img-fluid" src="/<?=$pl['user_img']?>" alt="" />
                                                </a>
                                                <div class="content">
                                                    <div class="top">
                                                        <h4 class="title"><a href="/user/page/<?=$pl['id']?>"><?=$pl['name']?> <?=$pl['lastname']?></a></h4>
                                                    </div>
                                                    <div class="bottom">
                                                        <div class="product-event-items">
                                                            <a href="/user/page/<?=$pl['id']?>" class="btn wishlist-btn"><span class="material-icons">favorite_border</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach ?>
                                            <!-- End Single Product -->
                                            <?php else: ?>
                                                <h3>Search result is null</h3>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-md-12">
                                            <h1>Portfolio seach result</h1>
                                            <?php if(!empty($result['portfolio'])): ?>
                                            <!-- Start Single Product -->
                                            <?php foreach($result['portfolio'] as $pl): ?>
                                            <div class="product-single-item-style-1">
                                                <a href="/portfolio/user/<?=$pl['id_user']?>" class="image img-responsive">
                                                    <img class="img-fluid" src="/<?=$pl['portfolio_img']?>" alt="" />
                                                </a>
                                                <div class="content">
                                                    <div class="top">
                                                        <h4 class="title"><a href="/portfolio/user/<?=$pl['id_user']?>"><?=$pl['name']?> <?=$pl['lastname']?></a></h4>
                                                    </div>
                                                    <div class="bottom">
                                                        <div class="product-event-items">
                                                            <a href="/portfolio/user/<?=$pl['id_user']?>" class="btn wishlist-btn"><span class="material-icons">favorite_border</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach ?>
                                            <!-- End Single Product -->
                                            <?php else: ?>
                                                <h3>Search result is null</h3>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-md-12">
                                            <h1>Adverts seach result</h1>
                                            <?php if(!empty($result['adverts'])): ?>
                                            <!-- Start Single Product -->
                                            <?php foreach($result['adverts'] as $pl): ?>
                                            <div class="product-single-item-style-1">
                                                <a href="/adverts/view/<?=$pl['id']?>" class="image img-responsive">
                                                    <img class="img-fluid" src="/<?=$pl['src']?>" alt="<?=$pl['title']?>" />
                                                </a>
                                                <div class="content">
                                                    <div class="top">
                                                        <h4 class="title"><a href="/adverts/view/<?=$pl['id']?>"><?=$pl['title']?></a></h4>
                                                    </div>
                                                    <div class="bottom">
                                                        <div class="product-event-items">
                                                            <a href="/adverts/view/<?=$pl['id']?>" class="btn wishlist-btn"><span class="material-icons">favorite_border</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach ?>
                                            <!-- End Single Product -->
                                            <?php else: ?>
                                                <h3>Search result is null</h3>
                                            <?php endif ?>
                                        </div>
                                        <div class="col-md-12">
                                            <h1>Vacancies seach result</h1>
                                            <?php if(!empty($result['vacancies'])): ?>
                                            <!-- Start Single Product -->
                                            <?php foreach($result['vacancies'] as $pl): ?>
                                            <div class="product-single-item-style-1">
                                                <a href="/vacancies/page/<?=$pl['seo']?>" class="image img-responsive">
                                                    <img class="img-fluid" src="/<?=$pl['img']?>" alt="<?=$pl['title']?>" />
                                                </a>
                                                <div class="content">
                                                    <div class="top">
                                                        <h4 class="title"><a href="/vacancies/page/<?=$pl['seo']?>"><?=$pl['title']?></a></h4>
                                                    </div>
                                                    <div class="bottom">
                                                        <div class="product-event-items">
                                                            <a href="/vacancies/page/<?=$pl['seo']?>" class="btn wishlist-btn"><span class="material-icons">favorite_border</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach ?>
                                            <!-- End Single Product -->
                                            <?php else: ?>
                                                <h3>Search result is null</h3>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Pagination -->
                            <?=$pagination?>
                            <!-- End Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>