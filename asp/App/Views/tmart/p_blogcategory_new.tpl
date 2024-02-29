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
                            <form method="post" action="/blog/category_new" enctype="multipart/form-data">
                                <div class="tab-content">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                        <div class="form-group">
                                            <label for="title_<?=$v['id']?>">Название</label>
                                            <input id="title_<?=$v['id']?>" name="category_description[<?=$v['id']?>][title]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="description_<?=$v['id']?>">Краткое описание</label>
                                            <input id="description_<?=$v['id']?>" name="category_description[<?=$v['id']?>][description]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="keywords_<?=$v['id']?>">Ключевые слова</label>
                                            <input id="keywords_<?=$v['id']?>" name="category_description[<?=$v['id']?>][keywords]" type="text" class="form-control col-md-7 col-xs-12" placeholder="<?=$v['title']?>" />
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="form-group">
                                    <label for="parent_id">Родительская категория</label>
                                    <select class="parent_id form-control" id="parent_id" name="parent_id">
                                        <option value="0">- Выбор -</option>
                                        <?=$CategoryList?>
                                    </select>
                                </div>
                        <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="seoTitle">Seo название</label>
                                    <input id="seoTitle" class="form-control col-md-7 col-xs-12" name="seoTitle" type="text" />
                                </div>
                                <div class="form-group">
                                    <table class="table">
                                        <tr>
                                            <td><input type="file" name="CategoryLogo" /></td>
                                            <td><input type="radio" name="CategoryImage" value="image" id="CategoryLogo" /> <label for="CategoryLogo">Показывать изображение</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="CatecoryIconCode" class="form-control" /></td>
                                            <td><input type="radio" name="CategoryImage" value="icon" id="CatecoryIconCode" /> <label for="CatecoryIconCode">Показывать иконку</label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="addnewcategory" class="btn btn-success">Добавить</button>
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