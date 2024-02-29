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
                        <p><h2>Создание карты сайта</h2></p>
                        <form action="/sitemap/save" method="post">
                            <input type="hidden" name="id_exeptions" value="<?=$id_exeptions?>" />
                            <input type="text" name="site_url" value="<?=$site_url?>" />
                            <textarea name="exeptions"><?=$exeption?></textarea>
                            Создать карту сайта <input type="checkbox" name="create_map" value="create" />
                            <div class="review-btn">
                                <button type="submit" class="fv-btn" name="save_exeption">Сохранить исключения</button>
                            </div>
                        </form>
                        <div>
                            <p><h3><?=$map?></h3></p>
                            <?php if($urls): ?>
                            <pre id="sitemap_block"><?=print_r($urls)?></pre>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>