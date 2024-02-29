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
                            <a href="/fields/p_fieldsgroup_new" class="btn btn-success pull-right">Добавить</a>
                        </div>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">Название </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($fieldsgroup)): ?>
                                <?php foreach($fieldsgroup as $v): ?>
                                <tr class="even pointer">
                                    <td class=" "><?=$v['title']?></td>
                                    <td class=" ">
                                        <a href="/fields/p_fieldsgroup_edit/<?=$v['id']?>" class="btn btn-sm btn-success">Изменить</a>
                                        <a href="/fields/p_fieldsgroup_trash/<?=$v['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
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