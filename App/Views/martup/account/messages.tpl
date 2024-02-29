<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul role="tablist" class="nav flex-column dashboard-list">
                                <li><a href="#inbox" data-bs-toggle="tab" class="nav-link btn btn-sm btn-default-outline active"><?=$text_inbox?></a></li>
                                <li><a href="#outbox" data-bs-toggle="tab" class="nav-link btn btn-sm btn-default-outline">Outbox</a></li>
                                <li><a href="#system_message" data-bs-toggle="tab" class="nav-link btn btn-sm btn-default-outline"><?=$text_sended?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade active show row" id="inbox">
                                <?php if(empty($messagesInbox)): ?>
                                    <h4><?=$text_messages_non?></h4>
                                <?php endif ?>
                                <?php foreach($messagesInbox as $k => $ml): ?>
                                <div class="message_block <?=($ml['read_status'] == '1')?'readed':'msg_unread'?> col-md-12 col-sm-12">
                                    <div class="single-blog-comment row">
                                        <?php if($ml['user_img']):?>
                                        <div class="blog-comment-thumb col-md-2 col-sm-2 col-xs-12">
                                            <img src="/<?=$ml['user_img']?>" alt="<?=$ml['login']?>" class="img_message" />
                                        </div>
                                        <?php endif ?>
                                        <div class="review-btn blog-comment-details col-md-10 col-sm-10 col-xs-12">
                                            <div class="comment-title-date">
                                                <?php if($ml['login'] != ""): ?>
                                                    <h3><a href="/<?=($ml['type_person'] == '4')?'company/page/'.$ml['user_id_from']:'portfolio/'.$ml['login']?>"><?=$ml['name_from']?></a></h3>
                                                <?php else: ?>
                                                    <h3><?=$ml['name_from']?></h3>
                                                    <?=$ml['email_from']?>
                                                <?php endif ?>
                                                <div class="reply">
                                                    <p><?=date('F j, Y, g:i a', $ml['date_send'])?> / <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?=$ml['id']?>Modal"><?=$text_reply?></button> / <a href="/ajax/trash/<?=$ml['id']?>">Delete</a></p>
                                                </div>
                                            </div>
                                            <button class="fv-btn" type="button" data-toggle="collapse" data-target="#collapse<?=$k?>" aria-expanded="false" aria-controls="collapse<?=$k?>">
                                                <?=$ml['subject']?>
                                            </button>
                                            <div class="collapse" id="collapse<?=$k?>">
                                                <div class="card card-block">
                                                    <?=$ml['message']?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Start Reply Form -->
                                    <div class="modal fade" id="<?=$ml['id']?>Modal" tabindex="-1" role="dialog" aria-labelledby="<?=$ml['id']?>ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form method="post" id="reply_form" action="/ajax/reply">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel"><?=$text_reply?> <?=$ml['name']?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="reply_m_id" value="<?=$ml['id']?>" />
                                                        <input type="hidden" name="reply_user" value="<?=$ml['user_id_from']?>" />
                                                        <input type="hidden" name="reply_subject" value="Re: <?=$ml['subject']?>" />
                                                        <textarea name="reply_message" id="reply_message" placeholder="Message"></textarea>
                                                    </div>
                                                    <div class="review-btn modal-footer">
                                                        <button type="submit" id="btn_reply" name="btn_reply" class="fv-btn"><?=$text_reply?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Reply Form -->
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="tab-pane fade" id="outbox">
                                <?php if(empty($messagesSended)): ?>
                                    <h4>You dont have send messages</h4>
                                <?php endif ?>
                                <?php foreach($messagesSended as $k => $ml): ?>
                                <div class="message_block">
                                    <div class="single-blog-comment">
                                        <div class="blog-comment-thumb">
                                            <img src="/<?=$ml['user_img']?>" alt="<?=$ml['login']?>" />
                                        </div>
                                        <div class="review-btn blog-comment-details">
                                            <div class="comment-title-date">
                                                <?php if($ml['login'] != ""): ?>
                                                    <h2><a href="/user/<?=$ml['login']?>"><?=$ml['name']?> <?=$ml['lastname']?> #<?=$ml['login']?></a></h2>
                                                <?php else: ?>
                                                    <?=$ml['email_from']?>
                                                <?php endif ?>
                                                <div class="reply">
                                                    <p><?=date('F j, Y, g:i a', $ml['date_send'])?> / <a href="/ajax/trash/<?=$ml['id']?>"><span class="ti ti-trash"></span></a></p>
                                                </div>
                                            </div>
                                            <button class="fv-btn" type="button" data-toggle="collapse" data-target="#collapse_send<?=$k?>" aria-expanded="false" aria-controls="collapse<?=$k?>">
                                                <?=$ml['subject']?>
                                            </button>
                                            <div class="collapse" id="collapse_send<?=$k?>">
                                                <div class="card card-block">
                                                    <?=$ml['message']?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="tab-pane fade" id="system_message">
                                system_message
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_reply').on('click', function (e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: '/ajax/reply',
                data: new FormData($('#reply_form').get(0)),
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.error_list_icon').remove();
                    if(data.error !== null) {
                        $.map(data.errors, function(i, item) {
                          $('input[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                          $('textarea[name='+item+']').before('<p class="error_list_icon">' + i + '</p>');
                        });
                    }
                    
                    if(data.errors.length == 0) {
                        $('#reply_message').appendTo('<li class="addedSuccess">' + data.success + '</li>');
                    }
                },
                error:  function(xhr, str){
                    alert('System error: ' + xhr.responseCode);
                }
            });
        });
    });
</script>