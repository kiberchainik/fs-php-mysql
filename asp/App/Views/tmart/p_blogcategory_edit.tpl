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
                            <form method="post" action="/blogcategory/edit/<?=$categoryData['id']?>" enctype="multipart/form-data">
                                <div class="tab-content">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                        <div class="form-group">
                                            <label for="first-name">Название</label>
                                            <input id="first-name" name="category_description[<?=$v['id']?>][title]" value="<?=$categoryData['category_description'][$v['id']]['title']?>" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="last-name">Краткое описание</label>
                                            <input id="last-name" name="category_description[<?=$v['id']?>][description]" value="<?=$categoryData['category_description'][$v['id']]['description']?>" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="middle-name">Ключевые слова</label>
                                            <input id="middle-name" name="category_description[<?=$v['id']?>][keywords]" value="<?=$categoryData['category_description'][$v['id']]['keywords']?>" class="form-control col-md-7 col-xs-12" placeholder="<?=$v['title']?>" type="text" />
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="form-group">
                                    <label for="first-name">Родительская категория</label>
                                    <select class="form-control" name="parent_id">
                                        <option value="0">- Выбор -</option>
                                        <?=$CategoryList?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="middle-name">Seo название</label>
                                    <input id="middle-name" value="<?=$categoryData['seo']?>" class="form-control col-md-7 col-xs-12" name="seoTitle" type="text" />
                                </div>
                                <div class="form-group">
                                    <label for="middle-name"></label>
                                    <div class="col-xs-12">
                                        <div class="col-xs-3">
                                            <?php if($categoryData['mediaSet'] == "image"): ?>
                                            <img src="/<?=$categoryData['imgicon']?>" />
                                            <?php endif ?>
                                        </div>
                                        <div class="col-xs-9">
                                            <table class="table">
                                                <tr>
                                                    <td><input type="file" name="CategoryLogo" /></td>
                                                    <td><input type="radio" name="CategoryImage" value="image" <?=($categoryData['mediaSet'] == "image")?'checked':''?> id="CategoryLogo" /> <label for="CategoryLogo">Показывать изображение</label></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="CatecoryIconCode"  class="form-control"  value="<?=($categoryData['mediaSet'] == "icon")?htmlspecialchars_decode($categoryData['icon']):''?>" id="CatecoryIconCode" /></td>
                                                    <td><input type="radio" name="CategoryImage" value="icon" <?=($categoryData['mediaSet'] == "icon")?'checked':''?> id="CatecoryIconCode" /> <label for="CatecoryIconCode">Показывать иконку</label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="editcategory" class="btn btn-success">Сохранить</button>
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