<!-- ...:::: Start Customer Login Section :::... -->
<div class="customer-login section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!--register area start-->
            <div class="col-lg-6 col-md-6 align-self-center">
                <div class="account_form register" data-aos="fade-up" data-aos-delay="200">
                    <h3><?=$text_register?></h3>
                    <p><?=$err_register?></p>
                    <form  action="<?=Url::local('login/singup')?>" method="post">
                        <div class="default-form-box">
                            <label><?=$text_login?> <span>*</span></label>
                            <input type="text" id="new_user" name="login" value="<?=$userinstalogin?>" />
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