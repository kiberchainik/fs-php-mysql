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
                        <form action="/typeadverts/new/" method="post" id="demo-form2">
                            <div class="col-xs-2">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-left">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <li class="<?=($k == '0')?'active':''?>"><a href="#lang<?=$v['id']?>" data-toggle="tab"><?=$v['title']?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="col-xs-10">
                                <div class="tab-content">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nameType_<?=$v['id']?>">Название</label>
                                            <div class="col-md-12 col-sm-6 col-xs-12">
                                                <input id="nameType_<?=$v['id']?>" required="required" name="nameType[<?=$v['id']?>][name]" class="form-control col-md-7 col-xs-12" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="deactivate">Отключить данный тип</label>
                                <input type="checkbox" name="deactivate" id="deactivate" value="1" />
                            </div>
                            <div class="form-group">
                                <button type="submit" name="addnewtype" class="btn btn-success" style="margin: 10px 0px 0px 20px;">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>