<!-- ...:::: Start Customer Login Section :::... -->
<div class="customer-login section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <!--login area start-->
            <div class="col-lg-12 col-md-12">
                <div class="account_form">
                    <h3><?=$text_recovery_login?></h3>
                    <p><?=$err_login?></p>
                    <form action="/ajax/recovery" method="POST">
                        <div class="default-form-box">
                            <label><?=$text_email?> <span>*</span></label>
                            <input type="text" name="email" id="email" />
                        </div>
                        <div class="row login_submit">
                            <button id="recovery_btn" class="col-sm-2 col-md-2 btn btn-sm btn-radius btn-default mb-4" type="submit"><?=$text_recovery?></button>
                        </div>
                    </form>
                </div>
            </div>
            <!--login area start-->
        </div>
    </div>
</div> <!-- ...:::: End Customer Login Section :::... -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#recovery_btn').click(function (e){
            e.preventDefault();
                        
            $.ajax({
                url: '/ajax/recovery',
                type:'post',
                data: {email: $('input#email').val()},
                dataType: 'json',
                beforeSend: function () {
                    $('#recovery_btn').after('<img src="/Media/martup/assets/images/icons/icons-loading-circle.gif" style="height: 30px;width: 54px;margin-top: 6px;" />');
                },
                error: function(req, text, error){
                    //console.error(text + ' | ' + error);
                  },                
                success: function (result) {
                    $('.login_submit img').remove();
                    $('.login_submit p').remove();
                    $('#recovery_btn').before('<p>'+result+'</p>');
                }
            });
        });
    });
</script>