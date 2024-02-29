<div class="contact-section section-fluid-270">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Start Contact Details -->
                <div class="contact-details-wrapper section-top-gap-80">
                    <div class="contact-team">
                        <div class="team-avatar">
                            <img src="/Media/images/contacts/dsfs.png" alt="Domenico Saldutto" title="Domenico Saldutto" />
                        </div>
                        <div class="contact-details-team">
                            <div class="contact-details-content contact-phone">
                                <a href="https://www.linkedin.com/in/domenicosaldutto/" target="_blank">Ambassador - Area Manager
                            </div>
                        </div> <!-- End Contact Details Single Item -->
                    </div>
                    <div class="contact-details">
                        <!-- Start Contact Details Single Item -->
                        <div class="contact-details-single-item">
                            <div class="contact-details-icon">
                                <span class="material-icons">phone</span>
                            </div>
                            <div class="contact-details-content contact-phone">
                                <a href="tel:+012345678102"><?=$contacts['admin_mobile']?></a>
                            </div>
                        </div> <!-- End Contact Details Single Item -->
                        <!-- Start Contact Details Single Item -->
                        <div class="contact-details-single-item">
                            <div class="contact-details-icon">
                                <span class="material-icons">language</span>
                            </div>
                            <div class="contact-details-content contact-phone">
                                <a href="mail:<?=$contacts['admin_email']?>"><?=$contacts['admin_email']?></a>
                                <a href="https://www.findsol.it">www.findsol.it</a>
                            </div>
                        </div> <!-- End Contact Details Single Item -->
                        <!-- Start Contact Details Single Item -->
                        <div class="contact-details-single-item">
                            <div class="contact-details-icon">
                                <span class="material-icons">location_on</span>
                            </div>
                            <div class="contact-details-content contact-phone">
                                <span><?=$contacts['admin_adres']?></span>
                            </div>
                        </div> <!-- End Contact Details Single Item -->
                    </div>
                </div> <!-- End Contact Details -->
            </div>
            <div class="col-lg-8">
                <div class="contact-form section-top-gap-120">
                    <form id="contact-form" action="/contacts/support" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="default-form-box mb-20">
                                    <label for="contact-name"><?=$text_name?></label>
                                    <input name="name" type="text" id="contact-name" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="default-form-box mb-20">
                                    <label for="contact-email">Email</label>
                                    <input name="email" type="email" id="contact-email" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="default-form-box mb-20">
                                    <label for="contact-subject"><?=$text_subject?></label>
                                    <input name="subject" type="text" id="contact-subject" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="default-form-box mb-20">
                                    <label for="contact-message"><?=$text_message?></label>
                                    <textarea name="message" id="contact-message" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 contact-btn mb-20">
                                    <!-- добавление элемента div -->
                                    <div class="g-recaptcha" data-sitekey="6LeU_mMfAAAAANi3pNozJzIyWWgXE5yXivrYgRW0"></div>
                                    <!-- элемент для вывода ошибок -->
                                    <div class="text-danger" id="recaptchaError"></div>
                                    <!-- js-скрипт гугл капчи -->
                                    <script src='https://www.google.com/recaptcha/api.js'></script>
                                    <input type="hidden" name="authUser" value="<?=$authUser?>" />
                                </div>
                            <div class="col-lg-12 mb-20">
                                <button class="btn btn-sm btn-radius btn-default" id="submit" type="submit"><?=$text_send?></button>
                            </div>
                            <div class="col-ld-12"><div class="errorList"></div></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('button#submit').on('click', function (e) {
            e.preventDefault();
            
            var captcha = grecaptcha.getResponse();
            
            if (!captcha.length) {
              // Выводим сообщение об ошибке
              $('#recaptchaError').text('<?=$text_error_captcha?>');
            } else {
              // получаем элемент, содержащий капчу
              $('#recaptchaError').text('');
            }
            
            var formData = new FormData($('#contact-form').get(0));
            
            // 3. Если форма валидна и длина капчи не равно пустой строке, то отправляем форму на сервер (AJAX)
            if ((captcha.length)) {
              // добавить в formData значение 'g-recaptcha-response'=значение_recaptcha
              formData.append('g-recaptcha-response', captcha);
            }
            
            $.ajax({                             
                url: '/contacts/support',
                type:'post',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                cache: false,
                success: function (result) {
                    $('.error_list_icon').remove();
                    $('.addedSuccess').remove();
                    grecaptcha.reset();
                    if(result.errors != '') {
                        $.each(result.errors, function(i, item) {
                            $('input[name='+i+']').before('<p class="error_list_icon">' + item + '</p>');
                            $('textarea[name='+i+']').before('<p class="error_list_icon">' + item + '</p>');
                        });
                    } else {
                        $('.errorList').append('<p class="addedSuccess">' + result.success + '</p>');
                        document.getElementById('contact-form').reset();
                    }
                }
            });
        });
    });
</script>