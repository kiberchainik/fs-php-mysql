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
                            <h2 class="pull-left">Список типов</h2>
                            <a href="/typecompany/new" class="btn btn-success pull-right">Добавить тип</a>
                        </div>
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">Название </th>
                                    <th class="column-title" style="display: table-cell;">Статус </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($TypeList)): ?>
                                <?php foreach($TypeList as $v): ?>
                                <tr class="categoryT even pointer">
                                    <td class=" "><?=$v['name']?></td>
                                    <td class=""><?=($v['active']=='1')?'Тип включен':'Тип отключен'?></td>
                                    <td class=" ">
                                        <a href="/typecompany/edit/<?=$v['id_type']?>" class="btn btn-sm btn-success">Изменить</a>
                                        <a href="/typecompany/delete/<?=$v['id_type']?>" class="btn btn-sm btn-danger">Удалить</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="3" style="text-align: center;">
                                        <h2>Типов объявлений нет!</h2>
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