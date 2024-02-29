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
                        <form method="post" action="/settings" enctype="multipart/form-data">
                            <fieldset>
                                <legend>Настройки сайта</legend>
                                <div class="form-group">
                                    <label for="title">Название сайта</label>
                                    <input type="text" id="title" class="form-control col-md-7 col-xs-12" value="<?=$settings['title']?>" name="title" />
                                </div>
                                <div class="form-group">
                                    <label for="title">Ключевые слова</label>
                                    <input type="text" id="title" class="form-control col-md-7 col-xs-12" value="<?=$settings['keywords']?>" name="keywords" />
                                </div>
                                <div class="form-group">
                                    <label for="title">Краткое описание</label>
                                    <input type="text" id="title" class="form-control col-md-7 col-xs-12" value="<?=$settings['description']?>" name="description" />
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label for="title">Логотип</label>
                                    <div class="clearfix"></div>
                                    <?php if($settings['logo']): ?>
                                    <div class="col-sm-3"><img class="col-sm-12" src="<?=SITEMAIN.$settings['logo']?>" alt="<?=$settings['title']?>" title="<?=$settings['title']?>" /></div>
                                    <?php endif ?>
                                    <div class="col-sm-9"><input type="file" class="col-md-7 col-xs-12" name="logo" /></div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Язык сайта по умолчанию</label>
                                    <select name="lang_default" class="form-control col-md-7 col-xs-12">
                                        <?php foreach($langs as $k => $v): ?>
                                            <?php if(isset($settings['lang_default']) and $v['code'] == $settings['lang_default']): ?>
                                                <option value="<?=$v['code']?>" selected><?=$v['title']?><?=($v['status'] == '1')?'':' - Откулючен'?></option>
                                            <?php else: ?>
                                                <option value="<?=$v['code']?>"><?=$v['title']?><?=($v['status'] == '1')?'':' - Откулючен'?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Технические работы</label>
                                    <select name="tec_work" class="form-control col-md-7 col-xs-12">
                                        <option value="1" <?=(isset($settings['tec_work']) and $settings['tec_work'] == '1')?'selected':''?>>ДА</option>
                                        <option value="0" <?=(isset($settings['tec_work']) and $settings['tec_work'] == '0')?'selected':''?>>НЕТ</option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Контакты администрации</legend>
                                <div class="form-group">
                                    <label for="title">Фамилия Имя</label>
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?=$settings['admin_name']?>" name="admin_name" />
                                </div>
                                <div class="form-group">
                                    <label for="title">Мобильный номер</label>
                                    <input type="text"  class="form-control col-md-7 col-xs-12" value="<?=$settings['admin_mobile']?>" name="admin_mobile" />
                                </div>
                                <div class="form-group">
                                    <label for="title">Email</label>
                                    <input type="text"  class="form-control col-md-7 col-xs-12" value="<?=$settings['admin_email']?>" name="admin_email" />
                                </div>
                                <div class="form-group">
                                    <label for="title">Адрес</label>
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?=$settings['admin_adres']?>" name="admin_adres" />
                                </div>
                            </fieldset>
                            <div class="clearfix"></div>
                            <div class="form-group" style="margin-top: 10px;">
                                <button class="btn btn-primary" name="saveSettings" type="submit">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>