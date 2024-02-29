<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
<!-- Customized Bootstrap Stylesheet -->
<link href="/Media/martup/assets/css/style_cv.css" rel="stylesheet" />
<!-- Header Start -->
<div class="container-fluid bg-primary d-flex align-items-center mb-5 py-5" id="home" style="min-height: 100vh;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 px-5 pl-lg-0 pb-5 pb-lg-0">
                <img class="img-fluid w-100 rounded-circle shadow-sm" src="/<?=$userData['user_img']?>" alt="<?=$userData['name']?> <?=$userData['lastname']?>" />
            </div>
            <div class="col-lg-7 text-center text-lg-left">
                <h3 class="text-white font-weight-normal mb-3">I'm</h3>
                <h1 class="display-3 text-uppercase text-primary mb-2" style="-webkit-text-stroke: 2px #ffffff;"><?=$userData['name']?> <?=$userData['lastname']?></h1>
                <h1 class="typed-text-output d-inline font-weight-lighter text-white"></h1>
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
                <img class="img-fluid rounded w-100" src="/<?=$userData['user_img']?>" alt="<?=$userData['name']?> <?=$userData['lastname']?>" />
            </div>
            <div class="col-lg-7">
                <p><?=$portfolioData?></p>
                <div class="row mb-3">
                    <div class="col-sm-6 py-2"><h6>Name: <span class="text-secondary"><?=$userData['name']?> <?=$userData['lastname']?></span></h6></div>
                    <div class="col-sm-6 py-2"><h6>Email: <span class="text-secondary"><?=$userData['email']?></span></h6></div>
                </div>
                <p id="online<?=$userData['user_id']?>"></p>
                <div id="online" val="<?=$userData['user_id']?>"></div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

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
<div class="u_copy">CV FindSolution &copy; <?=date('Y', time())?> <a href="/portfolio/user/<?=$userData['login']?>">#<?=$userData['login']?></a>.</p></div>
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