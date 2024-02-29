<!-- Start BLog Area -->
<div class="htc__blog__area bg__white ptb--60">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="blod-details-left-sidebar mrg-blog">
                    <!-- Start Tag -->
                    <?=$p_menu?>
                    <!-- End Tag -->
                </div>
            </div>
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="private_wrapp">
                        <form method="post">
                            <div class="col-xs-12">
                            <div class="col-xs-4">
                                <div id="private_userBlock">
                                    <div id="private_login">
                                        <?=$userDate['login']?> - <?=$userDate['nameType']?> (<?=($userDate['onlineSatus'] == '1')?'В сети':'Офлайн'?>)
                                    </div>
                                    <div id="private_userData">
                                        <div class="private_status"><?=($userDate['validStatus'] == '1')?'Верифицирован':'Не верифицирован'?></div>
                                        <div class="private_logo"><img src="<?=SITEMAIN.$userDate['user_img']?>" class="user_portfolio_avatar" alt="<?=$userDate['login']?>" title="<?=$userDate['lastname']?> <?=$userDate['name']?>" /></div>
                                        <div class="private_patent"><?=($userDate['patent'] == '')?$userDate['patent']:''?></div>
                                        <div class="private_lastname"><?=$userDate['lastname']?> <?=$userDate['name']?></div>
                                        <div class="private_mobile"><?=$userDate['mobile']?></div>
                                        <div class="private_email"><?=$userDate['email']?></div>
                                        <div class="private_address"><?=$userDate['address']?></div>
                                        <div class="private_country"><?=$userDate['country']?> <?=$userDate['region']?> <?=$userDate['town']?></div>
                                        <div class="private_msg">
                                            <a href="#modal" class="openModal btn btn-primary" data-toggle="modal">Написать сообщение</a>
                                            <div id="modal" class="modal" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>Сообщение для <?=$userDate['lastname']?> <?=$userDate['name']?></h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="/main/sendMessageForUser">
                                                                <input type="hidden" name="user_id" id="user_id" value="<?=$userDate['id']?>" />
                                                                <input type="hidden" name="user_email" id="user_email" value="<?=$userDate['email']?>" />
                                                                <div class="form-group"><input type="text" class="form-control" id="subject" name="subject" placeholder="Тема ..." /></div>
                                                                <div class="form-group"><input type="text" class="form-control" id="message" name="message" placeholder="Сообщение ..." /></div>
                                                                <input type="submit" class="btn btn-default" id="sendMessageForUser" name="send" value="Отправить" />
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(!empty($portfolio)): ?>
                                        <div class="private_user_portfolio"><a href="https://findsol.it/portfolio/user/<?=$portfolio['id_user']?>" target="_blank" class="btn btn-success"><?=$portfolio['name']?></a></div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <div id="private_userAbout"><?=htmlspecialchars_decode($userDate['about'])?></div>
                                <div id="private_userAdverts">
                                <table class="table">
                                    <?php if(!empty($UserAdverts)): ?>
                                    <?php foreach($UserAdverts as $v): ?>
                                    <tr class="even pointer">
                                        <td class=" "><a href="https://findsol.it/adverts/page/<?=$v['seo']?>" target="_blank"><?=$v['title']?></a></td>
                                        <td class=" "><?=date('D, d M y H:i', $v['add_date'])?></td>
                                        <td class=" ">
                                            <a href="/adverts/edit/<?=$v['id']?>" class="btn btn-sm btn-success">Изменить</a>
                                            <a href="/adverts/delete/<?=$v['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                    <?php else: ?>
                                    <tr class="even pointer">
                                        <td class="a-center" colspan="6" style="text-align: center;">
                                            <h2>Объявлений нет!</h2>
                                        </td>
                                    </tr>
                                    <?php endif ?>
                                </table>
                                <table class="table">
                                    <?php if(!empty($review)): ?>
                                    <h2>Рецензии</h2>
                                    <?php foreach($review as $r): ?>
                                    <tr class="even pointer">
                                        <td class=" "><?=$r['review_text']?></td>
                                        <td class=" "><?=$r['name']?> <?=$r['lastname']?> <?=$r['company_name']?></td>
                                        <td class=" "><?=date('d/m/Y', $r['date_send'])?></td>
                                        <td class=" ">
                                            <a href="/users/deletereview/<?=$r['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                    <?php else: ?>
                                    <tr class="even pointer">
                                        <td class="a-center" colspan="6" style="text-align: center;">
                                            <h2>Рецензий нет!</h2>
                                        </td>
                                    </tr>
                                    <?php endif ?>
                                </table>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#sendMessageForUser').click(function(e){
        e.preventDefault();
        $.ajax({
        	url: '/main/sendMessageForUser',
        	method: 'post',
        	dataType: 'json',
        	data: {
        	   user_id: $('#user_id').val(),
               user_email: $('#user_email').val(),
               subject: $('#subject').val(),
               message: $('#message').val()
            },
        	success: function(data){
                $('#respond').remove();
                $('#message').after('<p id="respond">'+data+'</p>');
        	}
         });
    });
});
</script>