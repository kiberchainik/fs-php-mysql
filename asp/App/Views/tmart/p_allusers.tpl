<!-- Start BLog Area -->
<div class="htc__blog__area bg__white ptb--50">
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
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">Изо</th>
                                    <th class="column-title" style="display: table-cell;">Логин</th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($UserList)): ?>
                                <tr>
                                    <td colspan="3">
                                        <div class="col-md-12">
                                            <div class="col-md-11 single-checkout-box">
                                                <input type="text" name="user" id="user" placeholder="Логин/Фамилия/имя/email/телефон/компания" />
                                                <ul id="list_of_search_result"></ul>    
                                            </div>
                                            <div class="col-md-1 single-checkout-box">
                                                <input type="submit" name="search_advert" id="search_advert" class="fv-btn" value="Найти" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php foreach($UserList as $v): ?>
                                <tr class="even pointer">
                                    <td><img class="user_portfolio_avatar" src="<?=SITEMAIN.$v['user_img']?>" alt="<?=$v['login']?>" title="<?=$v['login']?> (<?=$v['lastname']?> <?=$v['name']?>)" /></td>
                                    <td><?=$v['login']?> (<?=$v['email']?>)</td>
                                    <td>
                                        <a href="/users/details/<?=$v['login']?>" class="btn btn-sm btn-success"><span class="ti-layout-tab"></span></a>
                                        <a href="/users/trash/<?=$v['login']?>" class="btn btn-sm btn-danger"><span class="ti-trash"></span></a>
                                        <a href="#modal<?=$v['id']?>" class="openModal btn btn-sm btn-success" data-toggle="modal"><span class="ti-location-arrow"></span></a>
                                        <a href="/users/lock/<?=$v['login']?>" class="btn btn-sm btn-danger"><span class="ti-lock"></span></a>
                                        <div id="modal<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Сообщение для <?=$v['login']?></h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="p_short_user_date">
                                                            Валидация / статус: <?=($v['validStatus'] == '0')?'<span class="valid_no">no</span>':'<span class="valid_yes">yes</span>'?> <?=($v['onlineSatus'] == '0')?'':'<span class="onlineSatus">'?>
                                                        </div>
                                                        <div class="p_short_user_date">Контакты:
                                                            <span class="userName"><?=$v['name']?></span>
                                                            <span class="userLastname"><?=$v['lastname']?></span>
                                                            <span class="userMobile"><?=$v['mobile']?></span>
                                                            <span class="userPatent"><?=$v['patent']?></span>
                                                            <span class="userType"><?=$v['nameType']?></span>
                                                        </div>
                                                        <div class="p_short_user_date">
                                                            Объявлений: <?=$v['numUserAdverts']?>
                                                        </div>
                                                        <form method="post" action="/main/sendMessageForUser">
                                                            <input type="hidden" name="user_id" id="user_id" value="<?=$v['id']?>" />
                                                            <input type="hidden" name="user_email" id="user_email" value="<?=$v['email']?>" />
                                                            <div class="form-group"><input type="text" class="form-control" name="subject" id="subject" placeholder="Тема ..." /></div>
                                                            <div class="form-group"><input type="text" class="form-control" name="message" id="message" placeholder="Сообщение ..." /></div>
                                                            <input type="submit" class="btn btn-default" id="sendMessageForUser" name="send" value="Отправить" />
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <tr>
                                    <td class="a-center" colspan="4" style="text-align: center;">
                                        <?=$pagination?>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="4" style="text-align: center;">
                                        <h2>Пользователей нет!</h2>
                                    </td>
                                </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
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
<script type="text/javascript">
$(document).ready(function(){
	$('#search_advert').click(function(e){
        e.preventDefault();
        $.ajax({
        	url: '/users/life_search_user/'+$('#user').val(),
        	method: 'get',
        	dataType: 'json',
        	success: function(data){
        	    $('#list_of_search_result').empty();
                $('#list_of_search_result').css('display', 'block');
                if(data) {
                    $.map(data, function(i, item) {
                        $('#list_of_search_result').append('<li><div class="user">'+i['login']+'</div><div><a href="/users/details/'+i['id']+'">Детали</a><a href="#modal'+i['id']+'" class="openModal" data-toggle="modal"><span class="ti-location-arrow"></span></a></div></li>');
                    });
                } else {
                    $('#list_of_search_result').append('<li>Ничего не найденно!</li>');
                }
                $('#list_of_search_result').append('<li id="list_of_search_result_close">Закрыть</li>');
        	}
         });
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    	$('#list_of_search_result #list_of_search_result_close').on('click', function(){
        $('#list_of_search_result').animate({opacity: 0}, 198, function(){
            $(this).css('display', 'none');
                $('#myOverlay').fadeOut(297);
            });
        });
    });
</script>