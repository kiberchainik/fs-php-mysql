<div class="product-item-section  section-fluid-270 section-top-gap-100">
    <div class="box-wrapper">
        <div class="product-item-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Slider main container -->
                        <div class="top-slider-3grids-2rows">
                            <div class="swiper-container">
                                <!-- Additional required wrapper -->
                                <div class="row">
                                    <div class="statistics col-md-12 col-sm-12 col-lg-12">
                                        <div class="col-md-12 col-sm-12 col-lg-12">
                                            <?=$text_header_text?>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-5 col-sm-12 reg_users_block">
                                                    <h3><?=$text_registered_user?></h3>
                                                    <p class="text_registered_user"><?=$text_registered_user_text?></p>
                                                    <p><?=$statistics['utenti_privati_registrati']?></p>
                                                    <img src="/Media/martup/assets/images/users.png" />
                                                </div>
                                                <div class="col-md-5 col-sm-12 cv_created_block pull-right">
                                                    <h3><?=$text_portfolio_created?></h3>
                                                    <p class="text_portfolio_created"><?=$text_portfolio_created_text?></p>
                                                    <p class="pull-right"><?=$statistics['cv_creati']?></p>
                                                    <img src="/Media/martup/assets/images/cv.png" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-lg-12 mb-30">
                                            <p><?=$text_candidacy_text?></p>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <table class="table candidats">
                                                <tr>
                                                    <th><?=$text_agency?></th>
                                                    <th><?=$text_candidats?></th>
                                                </tr>
                                                <?php foreach($statistics['candidati'] as $c): ?>
                                                <tr>
                                                    <td><?=$c['Agenzia']?></td>
                                                    <td><?=$c['Candidati']?></td>
                                                </tr>
                                                <?php endforeach ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="section-content section-content-gap-60">
                                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3626047805353694"
                                         crossorigin="anonymous"></script>
                                    <!-- adaptive -->
                                    <ins class="adsbygoogle"
                                         style="display:block"
                                         data-ad-client="ca-pub-3626047805353694"
                                         data-ad-slot="3091561332"
                                         data-ad-format="auto"
                                         data-full-width-responsive="true"></ins>
                                    <script>
                                         (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>