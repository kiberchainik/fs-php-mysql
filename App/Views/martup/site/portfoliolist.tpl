<div class="shop-list-section section-fluid-270 section-top-gap-100">
        <div class="box-wrapper">
            <div class="shop-list-wrapper">
                <div class="container-fluid">
                    <div class="row flex-column-reverse flex-lg-row">
                        <div class="col-xl-3 col-lg-3">
                            <!-- Start Sidebar Area -->
                            <div class="siderbar-section">
                                <!-- Start Single Sidebar Widget -->
                                <div class="sidebar-single-widget">
                                    <div class="sidebar-content">
                                        <h6 class="sidebar-title title-border title-border"><?=$text_category_companies?></h6>
                                        <div class="widget-catagory">
                                            <?php foreach($vacancies_menu as $vm): ?>
                                            <a href="/portfolio/category/<?=$vm['id']?>"><?=$vm['title']?></a>
                                            <?=($vm['port_count'] == '0')?'':'<span class="portfolio_count">'.$vm['port_count'].'</span>'?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Sidebar Area -->
                        </div>
                        <div class="col-xl-8 offset-xl-1 col-lg-9">
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
                                    <div class="col-md-4 col-12 mb-25">
                                        <!-- Start Product Single Item - Style 1 -->
                                        <div class="product-single-item-style-1">
                                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3626047805353694"
                                             crossorigin="anonymous"></script>
                                            <ins class="adsbygoogle"
                                                 style="display:block"
                                                 data-ad-format="fluid"
                                                 data-ad-layout-key="-6c+dt-5-dd+gb"
                                                 data-ad-client="ca-pub-3626047805353694"
                                                 data-ad-slot="7985899014"></ins>
                                            <script>
                                                 (adsbygoogle = window.adsbygoogle || []).push({});
                                            </script>
                                        </div>
                                        <!-- End Product Single Item - Style 1 -->
                                    </div>
                                    <?php foreach($portfolioList as $pl): ?>
                                    <div class="col-md-4 col-12 mb-25">
                                        <!-- Start Product Single Item - Style 1 -->
                                        <div class="product-single-item-style-1">
                                            <a href="/portfolio/user/<?=$pl['login']?>" class="image img-responsive">
                                                <img class="img-fluid" src="/<?=$pl['portfolio_img']?>" alt="<?=$pl['name']?>_<?=$pl['lastname']?>" />
                                            </a>
                                            <div class="content">
                                                <div class="top">
                                                    <h4 class="title"><a href="/portfolio/user/<?=$pl['login']?>"><?=$pl['name']?> <?=$pl['lastname']?></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Product Single Item - Style 1 -->
                                    </div>
                                    <?php endforeach ?>
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