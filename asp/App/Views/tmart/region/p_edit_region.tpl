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
                        <form action="/region/edit/<?=$r_data['id']?>" method="post" id="demo-form2">
                            <div class="col-xs-12">
                                <select name="id_c" class="form-control col-xs-12">
                                <option value="0">- Select -</option>
                                <?php foreach($c_list as $v): ?>
                                    <option value="<?=$v['id']?>" <?=($v['id'] == $r_data['id_country'])?'selected':''?>><?=$v['name']?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
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
                                            <label for="title_<?=$v['id']?>">Название</label>
                                            <input id="title_<?=$v['id']?>" name="r_data[<?=$v['id']?>][name]" placeholder="<?=$v['title']?>" value="<?=$r_data['r_data'][$v['id']]['name']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="editpage" class="btn btn-success">Сохранить</button>
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