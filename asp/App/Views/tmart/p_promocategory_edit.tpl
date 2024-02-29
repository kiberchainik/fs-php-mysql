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
                        <form id="demo-form2" class="col-xs-10 form-horizontal form-label-left" method="post" action="/promocategory/edit/<?=$categoryData['id']?>" enctype="multipart/form-data">
                            <div class="tab-content">
                                <?php foreach($lang['data'] as $k => $v): ?>
                                <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Название</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="first-name" name="category_description[<?=$v['id']?>][title]" value="<?=$categoryData['category_description'][$v['id']]['title']?>" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" placeholder="<?=$v['title']?>" for="last-name">Краткое описание</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="last-name" name="category_description[<?=$v['id']?>][description]" value="<?=$categoryData['category_description'][$v['id']]['description']?>" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Ключевые слова</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="middle-name" name="category_description[<?=$v['id']?>][keywords]" value="<?=$categoryData['category_description'][$v['id']]['keywords']?>" class="form-control col-md-7 col-xs-12" placeholder="<?=$v['title']?>" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parent_id">Родительская категория</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="parent_id">
                                        <option value="0">- Выбор -</option>
                                        <?=$categoryList?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="seoTitle" class="control-label col-md-3 col-sm-3 col-xs-12">Seo название</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="seoTitle" value="<?=$categoryData['seo']?>" class="form-control col-md-7 col-xs-12" name="seoTitle" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="marker" class="control-label col-md-3 col-sm-3 col-xs-12">Порядок сортировки</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="marker" value="<?=$categoryData['lavel']?>" class="form-control col-md-7 col-xs-12" name="lavel" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="col-xs-9">
                                        <table class="table">
                                            <tr>
                                                <td><input type="file" name="CategoryLogo" /></td>
                                                <td><img src="<?=SITEMAIN.$categoryData['icon']?>" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" value="<?=$categoryData['id']?>" id="id_cat" name="id_cat" />
                                <button type="submit" name="editcategory" class="btn btn-success">Сохранить</button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>