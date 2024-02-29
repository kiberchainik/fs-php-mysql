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
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">Фото </th>
                                    <th class="column-title" style="display: table-cell;">Фамилия Имя</th>
                                    <th class="column-title" style="display: table-cell;">Адрес</th>
                                    <th class="column-title" style="display: table-cell;">Поиск </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($portfolioList)): ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="col-md-12">
                                            <div class="col-md-11 single-checkout-box">
                                                <input type="text" name="user" id="user" placeholder="Email/Адрес/Имя/Фамилия" />
                                                <ul id="list_of_search_result"></ul>    
                                            </div>
                                            <div class="col-md-1 single-checkout-box">
                                                <input type="submit" name="search_advert" id="search_advert" class="fv-btn" value="Найти" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php foreach($portfolioList as $v): ?>
                                <tr class="even pointer">
                                    <td class=" "><img class="img-circle img-responsive img_list" src="<?=SITEMAIN.$v['portfolio_img']?>" alt="<?=$v['lastname']?> <?=$v['name']?>" title="<?=$v['lastname']?> <?=$v['name']?>" /></td>
                                    <td class=" "><?=$v['lastname']?> <?=$v['name']?></td>
                                    <td class=" "><?=$v['adresResident']?></td>
                                    <td class=" "><?=($v['search_status'] == '1')?'Отключенно':'Включенно'?></td>
                                    <td class=" ">
                                        <a href="https://findsol.it/portfolio/user/<?=$v['id_user']?>" target="_blank" class="btn btn-sm btn-success"><span class="ti-search"></span></a>
                                        <a href="#modal<?=$v['id']?>" class="openModal btn btn-sm btn-success" data-toggle="modal"><span class="ti-location-arrow"></span></a>
                                        <div id="modal<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Сообщение для <?=$v['name']?></h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="/main/sendMessageForUser">
                                                            <input type="hidden" name="user_id" value="<?=$v['id']?>" />
                                                            <input type="hidden" name="user_email" value="<?=$v['email']?>" />
                                                            <div class="form-group"><input type="text" class="form-control" name="subject" placeholder="Тема ..." /></div>
                                                            <div class="form-group"><input type="text" class="form-control" name="message" placeholder="Сообщение ..." /></div>
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
                                    <td colspan="5"><?=$pagination?></td>
                                </tr>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="8" style="text-align: center;">
                                        <h2>Резюме нет!</h2>
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
	$('#sendMessageForUser').click(function(){
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
	$('#search_advert').click(function(){
        
        $.ajax({
        	url: '/portfolio/life_search_portfolio',
        	method: 'post',
        	dataType: 'json',
        	data: {user: $('#user').val()},
        	success: function(data){
        	    $('#list_of_search_result').empty();
                $('#list_of_search_result').css('display', 'block');
                if(data) {
                    $.map(data, function(i, item) {
                        $('#list_of_search_result').append('<li>'+i['name']+' '+i['lastname']+'<a href="https://findsol.it/portfolio/user/'+i['id_user']+'">Детали</a><a href="#modal'+i['id_user']+'" class="openModal" data-toggle="modal"><span class="ti-location-arrow"></span></a></li>');
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