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
                        <form action="/filter/save" method="post" id="demo-form2">
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="category">Для категории</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="category" multiple="" name="category[]" size="15">
                                            <option value="0">- Выбор -</option>
                                            <?=$categoryList?>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="namefilter">Название</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" id="namefilter" name="namefilter" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sortfilter">Порядок сортировки</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" id="sortfilter" name="sortfilter" class="form-control col-md-7 col-xs-12" />
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="listfieldsgroup">Список полей</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="listfieldsgroup" name="fieldsgroup">
                                            <option value="0">- Выбор -</option>
                                            <?php foreach($fieldsgroup as $fg): ?>
                                            <option value="<?=$fg['id']?>"><?=$fg['title']?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12" for="listfields">Список полей</label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" multiple="" id="listfields" name="fields[]" size="15">
                                            <option value="0">- Выбор -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="addfield" class="btn btn-success" style="margin: 10px 0px 0px 20px;">Добавить</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                        <script type="text/javascript">
                            $(document).ready(function () {
                        		$("#listfieldsgroup").on('change', function() {
                                    $.ajax({
                                        url: '/filter/get_fields',
                                        type:'post',
                                        data: {id: $(this).val()},
                                        dataType: 'json',
                                        cache: false,
                                        error: function(req, text, error){
                                            console.error('TEXT: ' + text + ' | error:' + error);
                                        },                
                                        success: function (result) {
                                            $('select#listfields').empty();
                                            var newSelect = '<option value="0">- Выбор -</option>';
                                            $.map(result, function(v) {
                                                newSelect += '<option value="' + v.id + '">' + v.placeholder + ' - ' + v.type + '</option>';
                                            });
                                            $('select#listfields').append(newSelect);
                                        }
                                    });
                        		});
                        	});
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>