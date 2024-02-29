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
                                    <th class="column-title" style="display: table-cell;">Название </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($public)): ?>
                                <?php foreach($public as $v): ?>
                                <tr class="even pointer">
                                    <td class=" "><?=$v['title']?></td>
                                    <td class=" ">
                                        <a href="#modal<?=$v['id']?>" class="openModal btn btn-sm btn-success" data-toggle="modal"><span class="ti-search"></span></a>
                                        <div id="modal<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3><img src="<?=SITEMAIN?>/<?=$v['user_img']?>" class="user_portfolio_avatar" /> <?=$v['title']?></h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="p_public_company_img"><img src="<?=SITEMAIN?>/<?=$v['img']?>" /></div>
                                                        <div class="p_short_user_date">
                                                            <p><b>Валидация / статус:</b> <?=($v['valid_status'] == '0')?'<span class="valid_no">no</span>':'<span class="valid_yes">yes</span>'?> / <?=($v['show_status'] == '0')?'offline':'<span class="onlineSatus">online</span>'?></p>
                                                            <p><b>Дата создания рекламной компании: </b> <?=date('d/m/Y', $v['date_add'])?></p>
                                                        </div>
                                                        <div class="p_short_user_date"><b>Контакты:</b>
                                                            <span class="ti-user userName"> <?=$v['user_name']?></span>
                                                            <span class="userLastname"><?=$v['user_lastname']?></span>
                                                            <span class="ti-mobile userMobile"> <?=$v['mobile']?></span>
                                                            <span class="ti-email userPatent"> <?=$v['email']?></span>
                                                            <span class="ti-world company_name"> <a href="<?=($v['company_url'] == '')?$v['seo_publication']:$v['company_url']?>" target="_blank"><?=$v['title']?></a></span>
                                                        </div>
                                                        <div class="p_user_public_date">
                                                            <b>Начало публикации: </b> <?=date('D, d M y H:i', $v['show_date_start'])?>
                                                            <b>Конец публикаци: </b> <?=date('D, d M y H:i', $v['show_date_end'])?>
                                                            <b>Переходов:</b> <?=$v['clicks']?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a class="btn btn-primary" href="/public/updshowstatus/<?=$v['id']?>"><?=($v['show_status'] == '0')?'Опубликовать':'<span class="onlineSatus">Не показывать</span>'?></a>
                                                        <a class="btn btn-primary" href="/public/updstatus/<?=$v['id']?>">Одобрить</a>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#msg<?=$v['id']?>" class="openModal btn btn-sm btn-success" data-toggle="modal"><span class="ti-location-arrow"></span></a>
                                        <div id="msg<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Сообщение для <?=$v['user_name']?></h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="/main/sendMessageForUser">
                                                            <input type="hidden" name="user_id" value="<?=$v['user_id']?>" />
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
                                        <!--a href="/private/public_edit/<?=$v['id']?>" class="btn btn-sm btn-success">Изменить</a-->
                                        <a href="/public/trash/<?=$v['id']?>" class="btn btn-sm btn-danger"><span class="ti-trash"></span></a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="6" style="text-align: center;">
                                        <h2>Страниц нет!</h2>
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