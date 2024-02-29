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
                        <form action="/interests/edit/<?=$interestsData['interests'][1]['id_interests']?>" method="post">
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
                                            <label for="interest<?=$v['id']?>">Название</label>
                                            <input id="interest<?=$v['id']?>" name="interest[<?=$v['id']?>][name]" value="<?=$interestsData['interests'][$v['id']]['name']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <input type="text" id="active" value="<?=$interestsData['active'][0]['val']?>" name="active" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="edit" class="btn btn-success" style="margin: 10px 0px 0px 20px;">Сохранить</button>
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