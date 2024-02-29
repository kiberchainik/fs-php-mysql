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
                        <div class="col-xs-2">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-left">
                                <?php foreach($lang['data'] as $k => $v): ?>
                                <li class="<?=($k == '0')?'active':''?>"><a href="#lang<?=$v['id']?>" data-toggle="tab"><?=$v['title']?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="col-xs-10">
                            <!-- Tab panes -->
                            <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="/promocategory/new" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parent_id">Родительская категория</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="parent_id" class="parent_id" name="parent_id">
                                            <option value="0">- Выбор -</option>
                                            <?=$categoryList?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="seoTitle" class="control-label col-md-3 col-sm-3 col-xs-12">Seo название</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="seoTitle" class="form-control col-md-7 col-xs-12" name="seoTitle" type="text" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="marker" class="control-label col-md-3 col-sm-3 col-xs-12">Порядок сортировки</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="marker" class="form-control col-md-7 col-xs-12" name="lavel" type="text" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input type="file" name="CategoryLogo" />
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title_<?=$v['id']?>">Название</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="title_<?=$v['id']?>" name="category_description[<?=$v['id']?>][title]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" placeholder="<?=$v['title']?>" for="description_<?=$v['id']?>">Краткое описание</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="description_<?=$v['id']?>" name="category_description[<?=$v['id']?>][description]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="keywords_<?=$v['id']?>" class="control-label col-md-3 col-sm-3 col-xs-12">Ключевые слова</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="keywords_<?=$v['id']?>" name="category_description[<?=$v['id']?>][keywords]" type="text" class="form-control col-md-7 col-xs-12" placeholder="<?=$v['title']?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="save_new_category" class="btn btn-success">Добавить</button>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>