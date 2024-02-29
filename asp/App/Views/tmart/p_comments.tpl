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
                            <tbody>
                                <?php if(!empty($comments)): ?>
                                <?php foreach($comments as $v): ?>
                                <tr class="even pointer">
                                    <td class=""><?=$v['name']?> (<?=$v['email']?>)</td>
                                    <td class=""><a href="https://findsol.it/adverts/page/<?=($v['seo'] != '')?$v['seo']:$v['advert_id']?>" target="_blank"><?=$v['title']?></a></td>
                                    <td class=""><?=$v['message']?></td>
                                    <td class=""><?=($v['moderation'] == '0')?'на проверке':'публикуется'?></td>
                                    <td class=""><?=date('d/m/Y', $v['date'])?></td>
                                    <?php if($v['user_id'] != '0'): ?>
                                    <td class=""><a href="/users/details/<?=$v['user_id']?>" target="_blank"><img class="img-circle img-responsive img_list" src="/<?=$v['user_img']?>" alt="<?=$v['user_name']?>" title="<?=$v['user_name']?>" /></a> <a href="<?=$v['company_link']?>" target="_blank"><?=$v['company_name']?></a></td>
                                    <?php else: ?>
                                    <td>Гость</td>
                                    <?php endif ?>
                                    <td class="">
                                        <a href="/comments/edit/<?=$v['id']?>" class="btn btn-sm btn-success"><span class="ti-thumb-up"></span></a>
                                        <a href="#modal<?=$v['id']?>" class="openModal btn btn-sm btn-default" data-toggle="modal"><span class="ti-comments"></span></a>
                                        <div id="modal<?=$v['id']?>" class="modal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <p><?=$v['message']?></p>
                                                    </div>
                                                    <div class="text">
                                                        <form method="post" action="/comments/respond/<?=$v['id']?>">
                                                            <input type="hidden" name="advert_id" value="<?=$v['advert_id']?>" />
                                                            <input type="hidden" name="email" value="<?=$v['email']?>" />
                                                            <input type="hidden" name="name" value="<?=$v['name']?>" />
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
                                        <a href="/comments/trash/<?=$v['id']?>" class="btn btn-sm btn-danger"><span class="ti-trash"></span></a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="6" style="text-align: center;">
                                        <h2>Комментариев нет!</h2>
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