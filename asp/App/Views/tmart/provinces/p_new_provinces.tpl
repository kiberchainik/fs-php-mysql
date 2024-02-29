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
                        <form action="/provinces/new" method="post">
                            <div class="col-xs-12">
                                <select name="id_c" id="country-list" class="form-control col-xs-12">
                                <option value="0">- Select -</option>
                                <?php foreach($c_list as $v): ?>
                                    <option value="<?=$v['id']?>"><?=$v['name']?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-xs-12">
                                <select name="id_r" id="region-list" class="form-control col-xs-12">
                                    <option value="0">- Select -</option>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-left">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <li class="<?=($k == '0')?'active':''?>"><a href="#lang<?=$v['id']?>" data-toggle="tab"><?=$v['title']?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="col-xs-10">
                                <div class="tab-content">
                                    <?php foreach($lang['data'] as $k => $v): ?>
                                    <div class="tab-pane <?=($k == '0')?'active':''?>" id="lang<?=$v['id']?>">                            
                                        <div class="form-group">
                                            <label for="title_<?=$v['id']?>">Название</label>
                                            <input id="title_<?=$v['id']?>" name="p_name[<?=$v['id']?>][name]" placeholder="<?=$v['title']?>" class="form-control col-md-7 col-xs-12" type="text" />
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="addpage" class="btn btn-success">Добавить</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#country-list").change(function(){
            var c_id = $('#country-list').val();
            
            if(c_id != '0') {
                $.ajax({
                    url:'/provinces/region',
                    method: 'post',
                    dataType: 'json',
                    data: {'c_id': c_id},
                	success: function(data){
                        $.map(data, function(i) {
                            $('#region-list').append('<option value="'+i.id+'">'+i.name+'</option>');
                        });
                	}
                });
            }
        });
    });
</script>