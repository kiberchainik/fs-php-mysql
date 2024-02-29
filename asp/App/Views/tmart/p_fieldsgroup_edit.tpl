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
                        <form action="/fields/p_fieldsgroup_edit/<?=$fieldDate['id']?>" method="post">
                            <div class="form-group">
                                <label class="control-label  col-xs-12" for="title">Название</label>
                                <input id="title" name="title" class="form-control col-md-7 col-xs-12" value="<?=$fieldDate['title']?>" type="text" />
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12" for="desc">Краткое описание группы</label>
                                <input id="desc" name="desc" class="form-control col-md-7 col-xs-12" value="<?=$fieldDate['description']?>" type="text" />
                            </div>
                            <div class="form-group">
                                <button type="submit" name="editfield" class="btn btn-success" style="margin: 10px 0px 0px 20px;">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>