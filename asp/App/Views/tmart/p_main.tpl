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
                        <table>
                            <tr>
                                <th colspan="2"><a href="/users">Пользователи</a></th>
                                <th rowspan="2"><a href="/portfolio">Резюме</a></th>
                                <th rowspan="2">Объявлений</th>
                                <th rowspan="2">Вакансий</th>
                            </tr>
                            <tr>
                                <th>Юр. лица</th>
                                <th>Физ. лица</th>
                            </tr>
                            <tr>
                                <td><?=$legal_u['numCount']?></td>
                                <td><?=$individual_u['numCount']?></td>
                                <td><?=$portfolo_u['numCount']?></td>
                                <td><?=$adverts_u['numCount']?></td>
                                <td><?=$vacancies_u['numCount']?></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <?php if($messages): ?>
                                        <?php foreach($messages as $m): ?>
                                            <div class="message_block">
                                                
                                            </div>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <h2>Сообщений нет</h2>
                                    <?php endif ?>
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
                                    <?php else: ?>
                                    <tr class="even pointer">
                                        <td class="a-center" colspan="5" style="text-align: center;">
                                            <h2>Новых объявлений нет!</h2>
                                        </td>
                                    </tr>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <form method="post" action="/main/" class="col-md-12">
                                        <input type="hidden" name="noteId" value="<?=$noteData['id']?>" />
                                        <textarea name="note" id="editor"><?=htmlspecialchars_decode($noteData['noteText'])?></textarea>
                                        <input type="submit" class="btn btn-lg btn-default" name="saveNote" value="Сохранить запись" />
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End BLog Area -->
<script src="/Media/tmart/js/ckeditor.js"></script>
<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} );
</script>