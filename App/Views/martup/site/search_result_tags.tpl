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
                                <h1>Vacancies seach result</h1>
                                <?php if(!empty($result)): ?>
                                <!-- Start Single Product -->
                                <?php foreach($result as $pl): ?>
                                <div class="col-xl-4 col-md-6 col-12 mb-25">
                                    <!-- Start Product Single Item - Style 1 -->
                                    <div class="product-single-item-style-1">
                                        <a href="/vacancies/page/<?=$pl['id']?>" class="image img-responsive">
                                            <img class="img-fluid" src="/<?=$pl['img']?>" alt="<?=$pl['title']?>" />
                                        </a>
                                        <div class="content">
                                            <div class="top">
                                                <h4 class="title"><a href="/vacancies/page/<?=$pl['id']?>"><?=$pl['title']?></a></h4>
                                            </div>
                                            <div class="bottom">
                                                <div class="product-event-items">
                                                    <a href="/vacancies/page/<?=$pl['id']?>" class="btn cart-btn"><?=$pl['title']?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Single Item - Style 1 -->
                                </div>
                                <?php endforeach ?>
                                <!-- End Single Product -->
                                <?php else: ?>
                                    <h3>Search result is null</h3>
                                <?php endif ?>
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