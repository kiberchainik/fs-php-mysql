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
                        <div class="col-sm-12">
                            <a href="/newbanner" class="btn btn-success pull-right">Добавить</a>
                        </div>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">Лого </th>
                                    <th class="column-title" style="display: table-cell;">Название </th>
                                    <th class="column-title" style="display: table-cell;">Ссылка </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($bannerList)): ?>
                                <?php foreach($bannerList as $v): ?>
                                <tr class="even pointer">
                                    <td class="blog_artLogo"><img src="<?=SITEMAIN.$v['img_src']?>" /></td>
                                    <td class=" "><?=$v['title']?></td>
                                    <td class=" "><a href="<?=$v['link']?>" target="_blank"><?=$v['link']?></a></td>
                                    <td class=" ">
                                        <a href="/banners/edit/<?=$v['b_id']?>" class="btn btn-sm btn-success">Изменить</a>
                                        <a href="/banners/trash/<?=$v['b_id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <tr>
                                    <td colspan="4"><?=$pagination?></td>
                                </tr>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="6" style="text-align: center;">
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