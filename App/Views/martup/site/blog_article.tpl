<div class="breadcrumb-section">
        <div class="box-wrapper">
            <div class="breadcrumb-wrapper breadcrumb-wrapper--style-4 breadcrumb-bg pos-relative">
                <div class="breadcrumb-content section-fluid-270">
                    <div class="container-fluid">
                        <div class="row justify-content-center justify-content-lg-start">
                            <div class="col-auto">
                                <ul class="breadcrumb-nav">
                                    <li><a href="/blog">Blog</a></li>
                                    <li><a href="/blog/category/<?=$article['category_seo']?>"><?=$article['category_title']?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-9">
                                <div class="content">
                                    <span class="title-tag"><?=$article['category_title']?></span>
                                    <h2 class="title"><?=$article['title']?></h2>
                                    <p><?=$article['description']?></p>
                                    <div class="author-details">
                                        <div class="image">
                                            <img src="/Media/martup/assets/images/icons/fs_lending_logo.png" alt="<?=$article['title']?>" />
                                        </div>
                                        <div class="info">
                                            <span class="name">Admin</span>
                                            <span class="position">(<?=date('d M Y', $article['add_date'])?>)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blog-details-section section-fluid-270 section-top-gap-100">
        <div class="box-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center flex-column-reverse flex-lg-row">
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
                                        <?php foreach($lastArticles as $lal): ?>
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
                        <div class="blog-details-hero">
                            <div class="image">
                                <img class="img-fluid" src="/<?=$article['logo']?>" alt="" />
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <div class="default-text-content">
                                    <?=htmlspecialchars_decode($article['text'])?>
                                </div>
                                <hr />
                                <div style="float: left;"><img src="/Media/martup/assets/images/icons/view.svg" alt="views" style="height: 25px;" /> <?=$article['vews']?></div>
                                <div class="share">
                                    <div class="fb-share-button" data-href="https://findsol.it<?=$_SERVER['REQUEST_URI']?>" data-layout="button_count"></div>
                                    <div class="twitter-button" style="margin-top: 7px;"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>