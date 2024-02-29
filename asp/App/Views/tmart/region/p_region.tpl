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
                        <a href="/region/new" class="btn btn-success pull-right">Добавить</a>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">Страна </th>
                                    <th class="column-title" style="display: table-cell;">Регион </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($r_list)): ?>
                                <?php foreach($r_list as $v): ?>
                                <tr class="even pointer">
                                    <td class=" "><?=$v['c_name']?></td>
                                    <td class=" "><?=$v['r_name']?></td>
                                    <td class=" ">
                                        <a href="/region/edit/<?=$v['id']?>" class="btn btn-sm btn-success">Изменить</a>
                                        <a href="/region/trash/<?=$v['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="6" style="text-align: center;">
                                        <h2>Регионов нет!</h2>
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