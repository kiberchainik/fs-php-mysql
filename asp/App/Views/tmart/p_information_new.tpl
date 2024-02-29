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
                        <form action="/information/new" method="post">
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
                                            <input id="title_<?=$v['id']?>" name="page_description[<?=$v['id']?>][title]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="keywords_<?=$v['id']?>">Ключевые слова</label>
                                            <input id="keywords_<?=$v['id']?>" name="page_description[<?=$v['id']?>][keywords]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="description_<?=$v['id']?>">Краткое описание</label>
                                            <input id="description_<?=$v['id']?>" name="page_description[<?=$v['id']?>][description]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="full_text_<?=$v['id']?>">Полный текст</label>
                                            <textarea id="full_text_<?=$v['id']?>" name="page_description[<?=$v['id']?>][full_text]"><?=$v['title']?></textarea>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="addpage" class="btn btn-success">Добавить</button>
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