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
                                    <th class="column-title" style="display: table-cell;">От кого</th>
                                    <th class="column-title" style="display: table-cell;">Email отправителя </th>
                                    <th class="column-title" style="display: table-cell;">Тема сообщения </th>
                                    <th class="column-title" style="display: table-cell;">Дата отправки </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($MessageList)): ?>
                                <?php foreach($MessageList as $v): ?>
                                <tr class="even pointer">
                                    <td class=" ">
                                    <?php if(isset($v['userData'])):?>
                                        <a href="/users/details/<?=$v['userData']['login']?>"><?=$v['name_from']?></a>
                                    <?php else: ?>
                                        <?=$v['name_from']?>
                                    <?php endif ?>
                                    </td>
                                    <td class=" "><?=$v['email_from']?></td>
                                    <td class=" "><?=$v['subject']?></td>
                                    <td class=" "><?=date('d/m/Y', $v['date'])?></td>
                                    <td class=" ">
                                        <?php if($v['read_status'] == '0'): ?>
                                        <a href="#modal<?=$v['id']?>" class="openModal btn btn-sm btn-primary" data-toggle="modal">Ответить</a>
                                        <div id="modal<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Ответ на сообщение от <?=$v['name_from']?></h3>
                                                        <p><?=$v['message']?></p>
                                                    </div>
                                                    <div class="text">
                                                        <form method="post" action="/contacts/respond/<?=$v['id']?>">
                                                            <input type="hidden" name="user_id_to" value="<?=$v['user_id']?>" />
                                                            <input type="hidden" name="user_email_to" value="<?=$v['email_from']?>" />
                                                            <input type="hidden" name="user_name_to" value="<?=$v['name_from']?>" />
                                                            <div class="form-group"><input type="text" class="form-control" name="subject" placeholder="Тема ..." /></div>
                                                            <div class="form-group"><input type="text" class="form-control" name="message" placeholder="Сообщение ..." /></div>
                                                            <input type="submit" class="btn btn-default" name="send" value="Отправить" />
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                        <a href="/contacts/trash/<?=$v['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                						<a href="/contacts/spamlist/<?=$v['email_from']?>" >Спам</a>
                                        <?php if(!empty($v['respond_msg'])): ?>
                                        <a href="#respond<?=$v['id']?>" class="openModal btn btn-sm btn-primary">Посмотреть ответ</a>
                                        <div id="respond<?=$v['id']?>" class="modal">
                                            <div class="col-sm-auto">
                                                <div class="header_modal">
                                                    <h3>Ответ на сообщение от <?=$v['name_from']?></h3>
                                                </div>
                                                <div class="text">
                                                    <p><?=$v['respond_msg']['message']?></p>
                                                </div>
                                                <a href="#close" title="Закрыть">Закрыть</a>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <?php if(isset($v['userData'])):?>
                                <tr>
                                    <td colspan="6">
                                        <div class="user_info">
                                            <img src="<?=SITE.$v['userData']['user_img']?>" class="user_info_img" alt="<?=$v['userData']['login']?>" />
                                            <p class="user_info_text"><b>Логин:</b> <?=$v['userData']['login']?> <b>Телефон:</b> <?=$v['userData']['mobile']?> <b>Краткое инфо:</b> <?=$v['userData']['about']?> <b>Валидация:</b> <?=($v['userData']['validStatus'] == '1')?'Верифицирован':'Не прошел верификацию'?> <b>На сайте:</b> <?=($v['userData']['onlineSatus'] == '1')?'Онлайн':'Офлайн'?></p>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif ?>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="6" style="text-align: center;">
                                        <h2>Сообщений нет!</h2>
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