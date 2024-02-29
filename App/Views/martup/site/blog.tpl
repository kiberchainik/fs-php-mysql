<div class="blog-list-section section-fluid-270 section-top-gap-100">
        <div class="box-wrapper">
            <div class="blog-list-wrapper">
                <div class="container-fluid">
                    <div class="row flex-column-reverse flex-lg-row">
                        <div class="col-xl-3 col-lg-4">
                            <!-- Start Sidebar Wrapper -->
                            <div class="siderbar-section">
                                <!-- Start Sidebar Single Widget - Catagory-->
                                <?=$blogMenu?>
                                <!-- End Sidebar Single Widget - Catagory-->

                                <!-- Start Sidebar Single Widget - Recent Post-->
                                <div class="sidebar-single-widget sidebar-single-widget--seperator">
                                    <div class="sidebar-content">
                                        <ul class="widget-blog-post">
                                            <?php foreach($ArticlesList as $lal): ?>
                                            <li class="widget-blog-post-single-item">
                                                <a href="/blog/article/<?=$lal['seo']?>" class="image">
                                                    <img src="/<?=$lal['logo']?>" alt="<?=$lal['title']?>" />
                                                </a>
                                                <div class="content">
                                                    <h5 class="title">
                                                        <a href="/blog/article/<?=$lal['seo']?>"><?=$lal['title']?></a>
                                                    </h5>
                                                    <span class="date">(<?=date('d M Y', $lal['add_date'])?>)</span>
                                                </div>
                                            </li>
                                            <?php endforeach ?>
                                        </ul>
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
                                </div>
                                <!-- End Sidebar Single Widget - Recent Post-->
                            </div>
                            <!-- End Sidebar Wrapper -->
                        </div>
                        <div class="col-xl-8 offset-xl-1 col-lg-8">
                            <!-- Start Blog List Wrapper -->
                            <div class="blog-list-wrapper">
                                <div class="row mb-n50">
                                    <?php foreach($lastArticles as $la):?>
                                    <div class="col-sm-6 mb-50">
                                        <!-- Start Blog List Single Item -->
                                        <div class="blog-list-single-item">
                                            <a href="/blog/article/<?=$la['seo']?>" class="image img-responsive">
                                                <img src="/<?=$la['logo']?>" alt="" />
                                            </a>
                                            <div class="post-meta">
                                                <a href="#" class="date">(<?=date('F j, Y', $la['add_date'])?>)</a>
                                            </div>
                                            <div class="content">
                                                <h4 class="title"><a href="/blog/article/<?=$la['seo']?>"><?=$la['title']?></a></h4>
                                            </div>
                                        </div>
                                        <!-- End Blog List Single Item -->
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <!-- End Blog List Wrapper -->

                            <!-- Start Pagination -->
                            <?=$pagination?>
                            <!-- End Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>