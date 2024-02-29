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
                                    <th class="column-title" style="display: table-cell;">Название </th>
                                    <th class="column-title" style="display: table-cell;">Статус </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">
                                        <div class="col-md-12">
                                            <div class="col-md-8 single-checkout-box">
                                                <input type="text" name="advert_tag" id="advert_tag" placeholder="Название или фраза из описания" />
                                                <ul id="list_of_search_result"></ul>    
                                            </div>
                                            <div class="col-md-3 single-checkout-box">
                                                <select name="category_id" id="category_id">
                                                    <option value="">- Категория -</option>
                                                    <?=$categoryList?>
                                                </select>
                                            </div>
                                            <div class="col-md-1 single-checkout-box">
                                                <input type="submit" name="search_advert" id="search_advert" class="fv-btn" value="Найти" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php if(!empty($adverts)): ?>
                                <?php foreach($adverts as $v): ?>
                                <tr class="even pointer">
                                    <td class=" "><?=$v['title']?></td>
                                    <td class=" "><?=($v['validate'] == '0')?'на проверке':'публикуется'?></td>
                                    <td class=" ">
                                        <?php if($v['validate'] == '0'):?>
                                        <a href="/moderation/upd_valid/<?=$v['id']?>" class="btn btn-sm btn-success">Одобрить</a>
                                        <?php endif ?>
                                        <a href="/adverts/edit/<?=$v['id']?>" class="btn btn-sm btn-success">Изменить</a>
                                        <a href="/adverts/delete/<?=$v['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                        <a href="#modal<?=$v['id']?>" class="openModal" data-toggle="modal">Замечание</a>
                                        <div id="modal<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Замечение для объявления <?=$v['title']?></h3>
                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?=$v['idUser']?>" />
                                                        <input type="hidden" name="user_email" id="user_email" value="<?=$v['email']?>" />
                                                        <input type="hidden" name="user_post_id" id="user_post_id" value="adverts_<?=$v['id']?>" />
                                                        <div class="form-group"><input type="text" class="form-control" id="subject" name="subject" placeholder="Тема ..." /></div>
                                                        <div class="form-group"><input type="text" class="form-control" id="message" name="message" placeholder="Сообщение ..." /></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-default" name="send" id="sendMessageForUser" value="Отправить" />
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="3" style="text-align: center;">
                                        <?=$pagination?>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="3" style="text-align: center;">
                                        <h2>Объявлений нет!</h2>
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
               user_post_id: $('#user_post_id').val(),
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
		var tag = $('#advert_tag').val();
        var cat_id = $('#category_id').val();
        
        $.ajax({
        	url: '/adverts/life_search_adverts',
        	method: 'post',
        	dataType: 'json',
        	data: {search_tag: tag, cat_id: cat_id},
        	success: function(data){
        	    $('#list_of_search_result').empty();
                $('#list_of_search_result').css('display', 'block');
                if(data) {
                    $.map(data, function(i, item) {
                        $('#list_of_search_result').append('<li>'+i['title']+'<a href="/adverts/p_adverts_edit/'+i['id']+'">Edit</a><a href="/adverts/p_adverts_trash/'+i['id']+'">Trash</a></li>');
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
    	$('#list_of_search_result li#list_of_search_result_close').on('click', function(){
            $('#list_of_search_result').empty();
            $('#list_of_search_result').css('display', 'none');
        });
    });
</script>