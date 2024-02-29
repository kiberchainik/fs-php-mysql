<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
<!-- Customized Bootstrap Stylesheet -->
<link href="/Media/martup/assets/css/style_cv.css" rel="stylesheet" />
<!-- Header Start -->
<div class="container-fluid bg-primary d-flex align-items-center mb-5 py-5" id="home" style="min-height: 100vh;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 px-5 pl-lg-0 pb-5 pb-lg-0">
                <img class="img-fluid w-100 rounded-circle shadow-sm" src="/<?=$portfolioData['portfolio_img']?>" alt="<?=$portfolioData['name']?> <?=$portfolioData['lastname']?>" />
            </div>
            <div class="col-lg-7 text-center text-lg-left">
                <h3 class="text-white font-weight-normal mb-3">I'm</h3>
                <h1 class="display-3 text-uppercase text-primary mb-2" style="-webkit-text-stroke: 2px #ffffff;"><?=$portfolioData['name']?> <?=$portfolioData['lastname']?></h1>
                <h1 class="typed-text-output d-inline font-weight-lighter text-white"></h1>
                <div class="typed-text d-none"><?=$education_text_header?></div>
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-5">
                    <a href="/portfolio/printpdf/<?=$portfolioData['login']?>" class="btn btn-sm btn-radius btn-default mb-4">Download CV</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->
<!-- About Start -->
<div class="container-fluid py-5" id="about">
    <div class="container">
        <div class="position-relative d-flex align-items-center justify-content-center">
            <h1 class="display-1 text-uppercase text-white" style="-webkit-text-stroke: 1px #dee2e6;">About</h1>
            <h1 class="position-absolute text-uppercase text-primary">About Me</h1>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-5 pb-4 pb-lg-0">
                <img class="img-fluid rounded w-100" src="/<?=$portfolioData['portfolio_img']?>" alt="<?=$portfolioData['name']?> <?=$portfolioData['lastname']?>" />
            </div>
            <div class="col-lg-7">
                <h3 class="mb-4"><?=$text_about?></h3>
                <p><?=htmlspecialchars_decode($portfolioData['about'])?></p>
                <div class="row mb-3">
                    <div class="col-sm-6 py-2"><h6>Name: <span class="text-secondary"><?=$portfolioData['name']?> <?=$portfolioData['lastname']?></span></h6></div>
                    <div class="col-sm-6 py-2"><h6>Birthday: <span class="text-secondary"><?=$portfolioData['birthDate']?></span></h6></div>
                    <div class="col-sm-6 py-2"><h6><?=$text_nacional?>: <span class="text-secondary"><?=$portfolioData['nacional']?></span></h6></div>
                    <div class="col-sm-6 py-2"><h6>Phone: <span class="text-secondary"><?=($userAuth_type == '4')?$portfolioData['mobile']:'+39 (***) **** ***'?></span></h6></div>
                    <div class="col-sm-6 py-2"><h6>Email: <span class="text-secondary"><?=$portfolioData['email']?></span></h6></div>
                    <div class="col-sm-6 py-2"><h6><?=$text_adresResident?>: <span class="text-secondary"><?=($userAuth_type == '4')?$portfolioData['adresResident']:'*****, ******, *****'?></span></h6></div>
                    <div class="col-sm-6 py-2"><h6><?=$text_patent?>: <span class="text-secondary">
                        <?php if(isset($patent[0])): ?>
                        <?=$text_non_patent?>
                        <?php else: ?>
                            <?php foreach($patent as $p): ?>
                                <?php if($p == '1'): ?>
                                    (<?=$text_transport?>)
                                <?php else: ?>
                                    <?=$p?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </span></h6></div>
                    <div class="col-sm-6 py-2"><h6><?=$text_marital_status?>: <span class="text-secondary"><?php if($portfolioData['marital_status'] == '1'): ?><?=$text_yes?><?php else: ?><?=$text_no?><?php endif ?></span></h6></div>
                </div>
                <div class="row mb-3">
                    <?php if(!empty($nameAssests)): ?>
                    <div class="col-sm-6 py-2"><h6>
                        <?=$text_nameAssests?>: 
                        <?php foreach($nameAssests as $na): ?>
                        <span class="text-secondary"><?=$na[0]['name']?></span>
                        <?php endforeach ?>
                        </h6>
                    </div>
                    <?php endif ?>
                    <?php if(!empty($nameHobbi)): ?>
                    <div class="col-sm-6 py-2"><h6>
                        <?=$text_nameHobbi?>: 
                        <?php foreach($nameHobbi as $nh): ?>
                        <span class="text-secondary"><?=$nh[0]['name']?></span>
                        <?php endforeach ?>
                        </h6>
                    </div>
                    <?php endif ?>
                    <?php if(!empty($nameInterests)): ?>
                    <div class="nameInterests_block">
                        <?=$text_nameInterests?><br />
                        <?php foreach($nameInterests as $ni): ?>
                        <span class="nameInterests"><?=$ni[0]['name']?></span>
                        <?php endforeach ?>
                    </div>
                    <?php endif ?>
                </div>
                <a href="/portfolio/printpdf/<?=$portfolioData['login']?>" class="btn btn-sm btn-radius btn-default mb-4">Download CV</a>
                <p id="online<?=$portfolioData['id_user']?>"></p>
                <div id="online" val="<?=$portfolioData['id_user']?>"></div>
                <?php if($userAuth['type_person'] == '4'): ?>
                <p class="review-btn"><a class="fv-btn" data-toggle="modal" data-target="#exampleModal"><?=$text_review?></a></p>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/ajax/newreview" class="reviewForm" id="reviewForm" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?=$text_newReview?></h5>
                                </div>
                                <div class="modal-body">
                                    <div class="review-box message"><textarea name="review" id="msg_review" class="textarea"></textarea></div>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <input name="user" id="user" value="<?=$portfolioData['id_user']?>" type="hidden" />
                                        <label for="type_review_yes" class="btn btn-secondary active">
                                            <input type="radio" id="type_review_yes" name="type_review" value="1" checked="" /> <?=$text_type_review_yes?>
                                        </label>
                                        <label for="type_review_no" class="btn btn-secondary">
                                            <input type="radio" id="type_review_no" name="type_review" value="0" /> <?=$text_type_review_no?>
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div id="review_respond"></div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$text_close?></button>
                                    <button type="button" name="addreview" id="addreview" class="btn btn-primary"><?=$text_send?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<!-- About End -->
<!-- Qualification Start -->
<div class="container-fluid py-5" id="qualification">
    <div class="container">
        <div class="position-relative d-flex align-items-center justify-content-center">
            <h1 class="display-1 text-uppercase text-white" style="-webkit-text-stroke: 1px #dee2e6;">Quality</h1>
            <h1 class="position-absolute text-uppercase text-primary">Education</h1>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="mb-4"><?=$text_portfolio_languages?></h3>
                <div class="border-left border-primary pt-2 pl-4 ml-2">
                    <?php foreach($portfolioData_languages as $pl): ?>
                    <div class="position-relative mb-4">
                        <i class="far fa-dot-circle text-primary position-absolute" style="top: 2px; left: -32px;"></i>
                        <h5 class="font-weight-bold mb-1"><?=$pl['title_lang']?></h5>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="mb-4"><?=$text_portfolio_computer?></h3>
                <div class="border-left border-primary pt-2 pl-4 ml-2">
                    <?php foreach($portfolioData_computer as $pc): ?>
                    <div class="position-relative mb-4">
                        <i class="far fa-dot-circle text-primary position-absolute" style="top: 2px; left: -32px;"></i>
                        <h5 class="font-weight-bold mb-1"><?=$pc['title_lang_computer']?></h5>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-12">
                <h3 class="mb-4"><?=$text_portfolio_educations?></h3>
                <div class="border-left border-primary pt-2 pl-4 ml-2">
                    <?php foreach($portfolioData_educations as $pe): ?>
                    <div class="position-relative mb-4">
                        <i class="far fa-dot-circle text-primary position-absolute" style="top: 2px; left: -32px;"></i>
                        <h5 class="font-weight-bold mb-1"><?=$pe['education_received']?></h5>
                        <p class="mb-2"><strong><?=$pe['educational_institution']?></strong> | <small><?=substr($pe['end_date'], -4)?></small></p>
                        <p><?=$pe['specialty']?></p>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>        
    </div>
</div>
<!-- Qualification End -->
<!-- Qualification Start -->
<div class="container-fluid py-5" id="qualification">
    <div class="container">
        <div class="position-relative d-flex align-items-center justify-content-center">
            <h1 class="display-1 text-uppercase text-white" style="-webkit-text-stroke: 1px #dee2e6;">Quality</h1>
            <h1 class="position-absolute text-uppercase text-primary">My Expericence</h1>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-12">
                <h3 class="mb-4"><?=$text_portfolio_work_post?></h3>
                <div class="border-left border-primary pt-2 pl-4 ml-2">
                    <?php foreach($portfolioData_work_post as $wp): ?>
                    <div class="position-relative mb-4">
                        <i class="far fa-dot-circle text-primary position-absolute" style="top: 2px; left: -32px;"></i>
                        <h5 class="font-weight-bold mb-1"><?=$wp['experience']?></h5>
                        <p class="mb-2"><strong><?=$wp['work_post']?></strong> | <small><?=$wp['date_of_the_beginning']?> - <?=($wp['real_work_post'] == '1')?$text_real_work_post:$wp['end_date']?></small></p>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>        
    </div>
</div>
<!-- Qualification End -->
<!-- Contact Start -->
<div class="container-fluid py-5" id="contact">
    <div class="container">
        <div class="position-relative d-flex align-items-center justify-content-center">
            <h1 class="display-1 text-uppercase text-white" style="-webkit-text-stroke: 1px #dee2e6;">Contact</h1>
            <h1 class="position-absolute text-uppercase text-primary">Contact Me</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form text-center">
                    <div id="success"></div>
                    <form name="sentMessage" id="contactForm" novalidate="novalidate">
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <input type="hidden" id="user_to" value="<?=$portfolioData['id_user']?>" />
                                <input type="text" class="form-control p-4" id="name" placeholder="Your Name" value="<?=$userAuth_name?>" required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group col-sm-6">
                                <input type="email" class="form-control p-4" id="email" placeholder="Your Email" value="<?=$userAuth_email?>" required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control p-4" id="subject" placeholder="Subject" required="required" data-validation-required-message="Please enter a subject" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control py-3 px-4" rows="5" id="message" placeholder="Message" required="required" data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-radius btn-default mb-4" type="submit" id="sendMessageButton">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="u_copy">CV FindSolution &copy; <?=date('Y', time())?> <a href="/portfolio/user/<?=$portfolioData['login']?>">#<?=$portfolioData['login']?></a>.</p></div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#addreview').on('click', function (e) {
            e.preventDefault();
            $('#review_respond').empty();
            
            $.ajax({
                type: 'POST',
                url: '/ajax/newreview',
                data: {
                    user_to: $('#user').val(),
                    msg: $('#msg_review').val(),
                    type_review: $('label.active > input[name=type_review]').val()
                },
                dataType: 'json',
                success: function(data) {
                    $('#review_respond').text(data);
                },
                error:  function(xhr, str){
                    alert('System error: ' + xhr.responseCode);
                }
            });
        });
    });
</script>
<script src="/Media/martup/assets/js/typed.min.js"></script>

<!-- Contact Javascript File -->
<script src="/Media/martup/assets/js/jqBootstrapValidation.min.js"></script>
<script src="/Media/martup/assets/js/contact.js"></script>

<!-- Template Javascript -->
<script src="/Media/martup/assets/js/main_cv.js"></script>