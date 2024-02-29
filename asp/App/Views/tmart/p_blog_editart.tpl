<link rel="stylesheet" href="<?=SITEMAIN?>/Media/martup/assets/css/plugins/trumbowyg.css" />
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
                        <h3><?=$title?></h3>
                        <hr />
                        <?php if ($upd_message): ?>
                            <p><?=$upd_message?></p>
                        <?php endif ?>
                        <form method="post" action="/blog/edit/<?=$ArticleData['id']?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="parent_id">Категория</label>
                                <select class="form-control" name="artcategory">
                                    <option value="0">- Выбор -</option>
                                    <?=$CategoryList?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Advert">Прикрепить к объявлению</label>
                                <select class="form-control" name="idAdvert">
                                    <option value="0">- Выбор -</option>
                                    <?php foreach ($AdvertsList as $val): ?>
                                    <option value="<?=$val['id']?>"><?=$val['title']?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="site_sector">Для раздела</label>
                                <select class="form-control" name="site_sector">
                                    <option value="0">- Select -</option>
                                    <option value="portfolio">Список резюме</option>
                                    <option value="vacancy">Список вакансий</option>
                                    <option value="vacancy_page">Страница вакансии</option>
                                    <option value="adverts">Список объявлений</option>
                                    <option value="adverts_page">Страница объявления</option>
                                    <option value="company">Список компаний</option>
                                    <option value="company_page">Страница компании</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="seoTitle">Seo название</label>
                                <input id="seoTitle" class="form-control col-md-7 col-xs-12" name="seoTitle" type="text" value="<?=$ArticleData['seo']?>" />
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <?php if(!empty($ArticleData['logo'])):?><img src="<?=SITEMAIN.$ArticleData['logo']?>" /><?php endif ?> 
                                                Логотип<input type="file" name="artLogo" />
                                            </td>
                                            <td>
                                                On <input type="radio" name="showart" value="1" <?=($ArticleData['show_status'] == '1')?'checked':''?> /> / 
                                                Off <input type="radio" name="showart" value="0" <?=($ArticleData['show_status'] == '0')?'checked':''?> />
                                            </td>
                                            <td><button type="submit" name="addnewarticle" class="btn btn-success">Сохранить</button></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <ul class="nav nav-tabs tabs-left">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <li class="<?=($k == '0')?'active':''?>"><a href="#lang<?=$v['id']?>" data-toggle="tab"><?=$v['title']?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="col-xs-10">
                                <div class="tab-content">
                                    <script src="/Media/tmart/js/ckeditor.js"></script>
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">
                                        <div class="form-group">
                                            <label for="title_<?=$v['id']?>">Название</label>
                                            <input id="title_<?=$v['id']?>" value="<?=$ArticleData['artDesc'][$v['id']]['title']?>" name="category_description[<?=$v['id']?>][title]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="description_<?=$v['id']?>">Краткое описание</label>
                                            <input id="description_<?=$v['id']?>" value="<?=$ArticleData['artDesc'][$v['id']]['description']?>" name="category_description[<?=$v['id']?>][description]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="keywords_<?=$v['id']?>">Ключевые слова</label>
                                            <input id="keywords_<?=$v['id']?>" value="<?=$ArticleData['artDesc'][$v['id']]['keywords']?>" name="category_description[<?=$v['id']?>][keywords]" type="text" class="form-control col-md-7 col-xs-12" placeholder="<?=$v['title']?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="fullarticletext_<?=$v['id']?>"></label>
                                            <textarea id="fullarticletext_<?=$v['id']?>" name="category_description[<?=$v['id']?>][fullarticletext]"><?=$ArticleData['artDesc'][$v['id']]['text']?></textarea>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/langs/ru.min.js"></script>
<script type="text/javascript">
    $('textarea').trumbowyg({
        lang: 'ru'
    });
</script>