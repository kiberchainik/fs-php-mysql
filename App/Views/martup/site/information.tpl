<div class="blog-details-section section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center flex-column-reverse flex-lg-row">
                <div class="col-xl-3 col-lg-4">
                    <!-- Start Sidebar Wrapper -->
                    <div class="siderbar-section">
                        <!-- Start Sidebar Single Widget - Recent Post-->
                        <div class="sidebar-single-widget sidebar-single-widget--seperator">
                            <div class="sidebar-content">
                                
                            </div>
                        </div>
                        <!-- End Sidebar Single Widget - Recent Post-->
                    </div>
                    <!-- End Sidebar Wrapper -->
                </div>
                <div class="col-xl-8 offset-xl-1 col-lg-8">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <h2><?=$title?></h2>
                            <ul>
                            <?php foreach($info as $v): ?>
                                <li><a href="/information/page/<?=$v['seo']?>"><?=$v['title']?></a></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>