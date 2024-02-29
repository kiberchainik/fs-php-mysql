<!-- ...:::: Start Customer Login Section :::... -->
<div class="customer-login section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <!--login area start-->
            <div class="col-lg-6 col-md-6">
                <div class="account_form">
                    <h3><?=$text_login?></h3>
                    <p><?=$err_login?></p>
                    <form action="<?=Url::local('login/singin')?>" method="POST">
                        <div class="default-form-box">
                            <label><?=$text_login?> <span>*</span></label>
                            <input type="text" name="login" id="author" />
                        </div>
                        <div class="default-form-box">
                            <label><?=$text_pass?> <span>*</span></label>
                            <input type="password" id="pass" name="pass" />
                        </div>
                        <div class="row login_submit">
                            <button class="col-sm-2 col-md-2 btn btn-sm btn-radius btn-default mb-4" type="submit">login</button>
                            <div class="col-sm-10 col-md-10 social_auth">
                                <a href="<?=$btn_google_auth?>"><img class="icon-svg social-auth-icon" src="/Media/martup/assets/images/icons/icon-google.svg" alt="Google" /></a>
                                <a href="<?=$btn_fb_auth?>"><img class="icon-svg social-auth-icon" src="/Media/martup/assets/images/icons/icon-facebook-f-dark.svg" alt="Facebook" /></a>
                                <a href="<?=$btn_insta_auth?>"><img class="icon-svg social-auth-icon" src="/Media/martup/assets/images/icons/instagram.svg" alt="Instagram" /></a>
                            </div>
                            <label class="checkbox-default mb-4" for="offer">
                                <input type="checkbox" id="offer" />
                                <span style="top:0px;"><?=$text_remember?></span>
                            </label>
                            <a href="/login/recovery"><?=$text_forgetpass?></a>
                        </div>
                    </form>
                </div>
            </div>
            <!--login area start-->

            <!--register area start-->
            <div class="col-lg-6 col-md-6">
                <div class="account_form register" data-aos="fade-up" data-aos-delay="200">
                    <h3><?=$text_register?></h3>
                    <p><?=$err_register?></p>
                    <form  action="<?=Url::local('login/singup')?>" method="post">
                        <div class="default-form-box">
                            <label><?=$text_login?> <span>*</span></label>
                            <input type="text" id="new_user" name="login" />
                        </div>
                        <div class="default-form-box">
                            <label><?=$text_email?> <span>*</span></label>
                            <input type="email" id="new_email" name="email" />
                        </div>
                        <div class="default-form-box">
                            <label><?=$text_pass?> <span>*</span></label>
                            <input type="password" id="password" name="pass" />
                        </div>
                        <div class="default-form-box">
                            <label><?=$text_select_type_person?></label>
                            <?php foreach($type_person as $tp): ?>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="user_type" id="user_type_<?=$tp['type']?>" value="<?=$tp['index']?>" />
                              <label class="form-check-label" for="user_type_<?=$tp['type']?>"><?=$tp['name']?></label>
                            </div>
                            <?php endforeach ?>
                            <div id="user_type_radio"></div>
                        </div>
                        <div class="login_submit">
                            <button class="btn btn-sm btn-radius btn-default" id="registration" type="submit"><?=$text_register?></button>
                        </div>
                    </form>
                </div>
            </div>
            <!--register area end-->
        </div>
    </div>
</div> <!-- ...:::: End Customer Login Section :::... -->