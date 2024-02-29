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
                        <form method="post" action="/banners/edit/<?=$bannerData['id']?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="seoTitle">Ссылка</label>
                                <input id="seoTitle" class="form-control col-md-7 col-xs-12" name="link" type="text" value="<?=$bannerData['link']?>" />
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <?php if(!empty($bannerData['img_src'])):?><img src="<?=SITEMAIN.$bannerData['img_src']?>" /><?php endif ?>
                                            </td>
                                            <td>
                                                Загрузить <br /><input type="file" name="artLogo" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="code">Код баннера</label>
                                <textarea id="code" name="code"><?=$bannerData['code']?></textarea>
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
                                            <input id="title_<?=$v['id']?>" value="<?=$bannerData['desc'][$v['id']]['title']?>" name="bd[<?=$v['id']?>][title]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="text_<?=$v['id']?>"></label>
                                            <textarea id="text_<?=$v['id']?>" name="bd[<?=$v['id']?>][text]"><?=$bannerData['desc'][$v['id']]['text']?></textarea>
                                            <script>
                                            	ClassicEditor
                                            		.create( document.querySelector( '#text_<?=$v["id"]?>' ), {
                                            			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
                                            		} );
                                            </script>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <button type="submit" name="addnewarticle" class="btn btn-success">Сохранить</button>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>