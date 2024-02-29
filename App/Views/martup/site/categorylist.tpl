<!-- Start Our ShopSide Area -->
<section class="htc__shop__sidebar bg__white ptb--30">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                <div class="htc__shop__left__sidebar">
                    <!-- Start Product Cat -->
                    <div class="htc__shop__cat">
                        <h4 class="section-title-4"><?=$text_vacancies?></h4>
                        <div class="widget-catagory">
                            <?php foreach($vacanciesCategoriList as $vm): ?>
                            <a href="/vacancies/category/<?=$vm['seo']?>"><?=$vm['title']?></a>
                            <?=($vm['vacancies_count'] == '0')?'':'<span class="portfolio_count">'.$vm['vacancies_count'].'</span>'?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <!-- End Product Cat -->
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30">
                <div class="row">
                    <div class="shop__grid__view__wrap another-product-style">
                        <h2><?=$text_title_category?></h2>
                        <div class="widget-catagory">
                        <?php foreach($categoryList as $cl): ?>
                            <a href="/category/page/<?=$cl['seo']?>"><?=$cl['title']?></a>
                        <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                <div class="htc__shop__left__sidebar">
                    <!-- Start Product Cat -->
                    <div class="htc__shop__cat">
                        <h4 class="section-title-4"><?=$text_professionals?></h4>
                        <div class="widget-catagory">
                            <?php foreach($portfolio_menu as $vm): ?>
                            <a href="/portfolio/category/<?=$vm['id']?>"><?=$vm['title']?></a>
                            <?=($vm['port_count'] == '0')?'':'<span class="portfolio_count">'.$vm['port_count'].'</span>'?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <!-- End Product Cat -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Our ShopSide Area -->