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
                        <ul class="menu_dbnames">
                            <?php foreach($DBNames as $d):?>
                            <li><a href="/dbeditor/dbname/<?=$d['Database']?>" dbname="<?=$d['Database']?>"><?=$d['Database']?></a></li>
                            <?php endforeach ?>
                            <li class="newtable"><a href="#modal" class="openModal" data-toggle="modal">Новая таблица</a></li>
                        </ul>
                        <div id="dbtables">
                            <div id="modal" class="modal" tabindex="-1">
                            	<div class="modal-dialog" style="width: 98%;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div id="ajaxResult_header"></div>
                                        </div>
                                        <div class="modal-body" style="width: 100%;">
                                            <div id="ajaxResult"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                        </div>
                                	</div>
                                </div>
                            </div>
                            <table class="table">
                                <tr>
                                    <th colspan="7">База данных: <span id="curentdatabase"><?=$dbname?></span></th>
                                </tr>
                                <tr>
            						<th>C+</th>
                                    <th>R+</th>
                                    <th>Таблица</th>
                                    <th>Количесвто записей</th>
                                    <th>Кодировка</th>
                                    <th>Движок</th>
                                    <th>Дата создания</th>
                                </tr>
                                <?php if(!empty($Tables)): ?>
                                <?php foreach($Tables as $t):?>
                                <tr>
            						<td><a href="#modal" class="newcolunm openModal" data-toggle="modal" data="<?=$t['table_name']?>" title="Новое поле">+</a></td>
            						<td><a href="#modal" class="addrecord openModal" data-toggle="modal" data="<?=$t['table_name']?>" title="Новая запись">+</a></td>
                                    <td><a href="#modal" class="full openModal btn btn-sm btn-success" data-toggle="modal" data="<?=$t['table_name']?>"><?=$t['table_name']?></a></td>
                                    <td><?=$t['table_rows']?></td>
                                    <td><?=$t['table_collation']?></td>
                                    <td><?=$t['engine']?></td>
                                    <td><?=$t['create_time']?></td>
                                </tr>
                                <?php endforeach ?>
                                <?php endif ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/Media/tmart/js/dbeditor.js"></script>