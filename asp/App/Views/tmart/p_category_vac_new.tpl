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
                            <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="/categoryvacancies/new" enctype="multipart/form-data">
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
                                        <div class="form-group">
                                            <label for="seoTitle_<?=$v['id']?>" class="control-label col-md-3 col-sm-3 col-xs-12">Seo</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="seoTitle_<?=$v['id']?>" name="category_description[<?=$v['id']?>][seoTitle]" type="text" class="form-control col-md-7 col-xs-12" placeholder="<?=$v['title']?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parent_id">Родительская категория</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="parent_id" class="parent_id" name="parent_id">
                                            <option value="0">- Выбор -</option>
                                            <?=$CategoryList?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <table class="table">
                                            <tr>
                                                <td><input type="file" name="CategoryLogo" /></td>
                                                <td><input type="radio" name="CategoryImage" value="image" id="CategoryLogo" /> <label for="CategoryLogo">Показывать изображение</label></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="CatecoryIconCode" /></td>
                                                <td><input type="radio" name="CategoryImage" value="icon" id="CatecoryIconCode" /> <label for="CatecoryIconCode">Показывать иконку</label></td>
                                            </tr>
                                        </table>
                                    </div>
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
<link href="/lptf_admin/views/css/select2.min.css" rel="stylesheet" />
<script src="/lptf_admin/views/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    	$( ".parent_id" ).select2({
    		theme: "bootstrap",
    		width: "100%",
    		placeholder: "Выбрать",
            language: {
                 noResults: function(term) {
                     return "Не найден";
                }
            }
    	});
    });
</script>