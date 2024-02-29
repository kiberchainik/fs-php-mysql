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
                        <form action="/language/edit/<?=$langDate['id']?>" method="post" id="demo-form2">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Название</label>
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <input id="first-name" required="required" name="nameLang" value="<?=$langDate['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Код языка</label>
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <input id="first-name" required="required" name="codeLang" value="<?=$langDate['code']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Установить язык</label>
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <input id="first-name" name="statusSetup" value="1" <?=($langDate['status'] == "1")?'checked':''?> type="checkbox" />
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="editlang" class="btn btn-success" style="margin: 10px 0px 0px 20px;">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>