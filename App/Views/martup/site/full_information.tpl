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
                            <div class="default-text-content">
                                <p><?=date('D, d M y H:i', $info['date'])?></p>
                                <?=htmlspecialchars_decode($info['full_text'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>