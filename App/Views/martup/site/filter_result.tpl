<!-- ...:::: Start Shop List Section:::... -->
<div class="shop-list-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="shop-list-wrapper">
            <div class="container-fluid">
                <div class="row flex-column-reverse flex-lg-row">
                    <div class="col-xl-3 col-lg-3">
                        <!-- Start Sidebar Area -->
                        <div class="siderbar-section">
                            <?=$filter?>
                        </div> <!-- End Sidebar Area -->
                    </div>
                    <div class="col-xl-8 offset-xl-1 col-lg-9">
                        <ul class="product-shop-filter-info">
                            <li class="prduct-item-traking"><span>total 08 of 40</span></li>
                            <li class="prduct-item-filter">
                                <select name="choice">
                                    <option value="first">New Arrival</option>
                                    <option value="second" selected>Featured</option>
                                    <option value="third">Popular</option>
                                </select>
                            </li>
                        </ul>

                        <div class="product-shop-list-items">
                            <div class="row mb-n25">
                                <?php foreach($adverts as $pl): ?>
                                <div class="col-xl-4 col-md-6 col-12 mb-25">
                                    <!-- Start Product Single Item - Style 1 -->
                                    <div class="product-single-item-style-1">
                                        <a href="/adverts/page/<?=$pl['seo']?>" class="image img-responsive">
                                            <img class="img-fluid" src="/<?=$pl['src']?>" alt="<?=$pl['seo']?>" />
                                        </a>
                                        <div class="content">
                                            <div class="top">
                                                <h4 class="title"><a href="/adverts/page/<?=$pl['seo']?>"><?=$pl['title']?></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Single Item - Style 1 -->
                                </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- Start Pagination -->
                        <?=$pagination?>
                        <!-- End Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Shop List Section:::... -->