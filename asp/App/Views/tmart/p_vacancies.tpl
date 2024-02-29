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
                                    <th class="column-title" style="display: table-cell;">Имг </th>
                                    <th class="column-title" style="display: table-cell;">Название </th>
                                    <th class="column-title" style="display: table-cell;">Место </th>
                                    <th class="column-title" style="display: table-cell;">Статус </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <div class="col-md-12">
                                            <div class="col-md-8 single-checkout-box">
                                                <input type="text" name="vacancie_tag" id="vacancie_tag" placeholder="Название или фраза из описания" />
                                                <ul id="list_of_search_result">
                                                    <li id="list_of_search_result_close">Закрыть</li>
                                                </ul>    
                                            </div>
                                            <div class="col-md-3 single-checkout-box">
                                                <select name="category_id" id="category_id">
                                                    <option value="">- Категория -</option>
                                                    <?=$categoryListForVacancies?>
                                                </select>
                                            </div>
                                            <div class="col-md-1 single-checkout-box">
                                                <input type="submit" name="search_vacancie" id="search_vacancie" class="fv-btn" value="Найти" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php if(!empty($vacancies)): ?>
                                <?php foreach($vacancies as $v): ?>
                                <tr class="even pointer">
                                    <td class=" "><img src="<?=SITEMAIN.$v['user_img']?>" style="width: 50px;height: 50px;border-radius: 50%;" /></td>
                                    <td class=" "><?=$v['title']?></td>
                                    <td class=" "><?=$v['location']?></td>
                                    <td class=" "><?=($v['valid_status'] == '0')?'на проверке':'публикуется'?></td>
                                    <td class=" ">
                                        <?php if($v['valid_status'] == '0'):?>
                                        <a href="/vacancies/upd_valid/<?=$v['id']?>" class="btn btn-sm btn-success">Одобрить</a>
                                        <?php endif ?>
                                        <a href="/vacancies/edit/<?=$v['id']?>" class="btn btn-sm btn-success">Изменить</a>
                                        <a href="/vacancies/delete/<?=$v['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                        <a href="#modal<?=$v['id']?>" class="openModal" data-toggle="modal">Замечание</a>
                                        <div id="modal<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Замечение для объявления <?=$v['title']?></h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?=$v['id_user']?>" />
                                                        <input type="hidden" name="user_email" id="user_email" value="<?=$v['email']?>" />
                                                        <input type="hidden" name="user_post_id" id="user_post_id" value="vacancies_<?=$v['id']?>" />
                                                        <div class="form-group"><input type="text" class="form-control" id="subject" name="subject" placeholder="Тема ..." /></div>
                                                        <div class="form-group"><input type="text" class="form-control" id="message" name="message" placeholder="Сообщение ..." /></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-default" id="sendMessageForUser" name="send" value="Отправить" />
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="5" style="text-align: center;">
                                        <?=$pagination?>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="5" style="text-align: center;">
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
	$('#search_vacancie').click(function(){
		var tag = $('#vacancie_tag').val();
        var cat_id = $('#category_id').val();
        
        $.ajax({
        	url: '/vacancies/life_search_vacancies',
        	method: 'post',
        	dataType: 'json',
        	data: {search_tag: tag, cat_id: cat_id},
        	success: function(data){
        	    $('#list_of_search_result').empty();
                $('#list_of_search_result').css('display', 'block');
                if(data) {
                    $.map(data, function(i, item) {
                        $('#list_of_search_result').prepend('<li>'+i['title']+'<a href="/vacancies/edit/'+i['id']+'">Edit</a><a href="/vacancies/trash/'+i['id']+'">Trash</a></li>');
                    });
                } else {
                    $('#list_of_search_result').prepend('<li>Ничего не найденно!</li>');
                }
        	}
         });
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    	$('#list_of_search_result_close').on('click', function(){
            $('#list_of_search_result').empty();
            $('#list_of_search_result').css('display', 'none');
        });
    });
</script>