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
                        <form action="/usertypes/new" method="post">
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
                                            <label for="nameType_<?=$v['id']?>">Название</label>
                                            <input id="nameType_<?=$v['id']?>" name="nameType[<?=$v['id']?>][name]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="index">Индекс</label>
                                    <input type="text" id="index" name="index" class="form-control col-md-7 col-xs-12" />
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="index">Тип</label>
                                    <input type="text" id="type" name="type" class="form-control col-md-7 col-xs-12" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="addtype" class="btn btn-success">Добавить</button>
                                </div>
                            </div>                                                
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>