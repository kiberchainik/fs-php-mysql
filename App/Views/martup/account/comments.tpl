<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <?php if(empty($commentsList)): ?>
                    <h4><?=$text_not_comments?></h4>
                <?php endif ?>
                <?php foreach($commentsList as $k => $ml): ?>
                <div class="author-details">
                    <div class="image">
                        <img src="/<?=(!empty($ml['user_img']))?$ml['user_img']:'/Media/images/no_avatar.png'?>" alt="<?=$ml['name']?>" />
                    </div>
                    <div class="info">
                        <span class="name"><?=$ml['name']?></span>
                        <span class="position"><?=$ml['email']?></span>
                    </div>
                </div>
                <div class="message_block">
                    <h2><a href="/adverts/view/<?=$ml['seo']?>" target="_blank"><?=$ml['title']?></a></h2>
                    <p><?=$ml['message']?></p>
                    <p><?=date('F j, Y, g:i a', $ml['date_send'])?> / <a href="/comments/trash/<?=$ml['id']?>"><span class="ti ti-trash"></span></a></p>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->