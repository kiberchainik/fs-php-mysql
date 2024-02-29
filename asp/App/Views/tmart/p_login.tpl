<!-- Start Login Register Area -->
<div class="htc__login__register bg__white ptb--130">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <ul class="login__register__menu" role="tablist">
                    <li role="presentation" class="login <?=$tab_login?>"><a href="#login" role="tab" data-toggle="tab"><?=$text_login?></a></li>
                </ul>
            </div>
        </div>
        <!-- Start Login Register Content -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="htc__login__register__wrap">
                    <!-- Start Single Content -->
                    <div id="login" role="tabpanel" class="single__tabs__panel tab-pane fade <?=$tab_login_cont?>">
                        <?=$err_login?>
                        <form class="login" method="post" action="<?=Url::local('login/singin')?>">
                            <input type="text" name="login" id="author" placeholder="<?=$text_login?>" />
                            <input type="password" id="pass" name="pass" placeholder="<?=$text_pass?>" />
                            <button type="submit" class="htc__login__btn mt--30">
                                  Login
                            </button>
                        </form>
                    </div>
                    <!-- End Single Content -->
                </div>
            </div>
        </div>
        <!-- End Login Register Content -->
    </div>
</div>
<!-- End Login Register Area -->