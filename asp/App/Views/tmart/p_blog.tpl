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
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: table-cell;">Лого </th>
                                    <th class="column-title" style="display: table-cell;">Название </th>
                                    <th class="column-title" style="display: table-cell;">Статус </th>
                                    <th class="column-title" style="display: table-cell;">Действие </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($articles)): ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="col-md-12">
                                            <div class="col-md-8 single-checkout-box">
                                                <input type="text" name="art_tag" id="art_tag" placeholder="Название или фраза из описания" />
                                                <ul id="list_of_search_result"></ul>    
                                            </div>
                                            <div class="col-md-3 single-checkout-box">
                                                <select name="category_id" id="category_id">
                                                    <option value="">- Категория -</option>
                                                    <?=$categoryList?>
                                                </select>
                                            </div>
                                            <div class="col-md-1 single-checkout-box">
                                                <input type="submit" name="search_advert" id="search_advert" class="fv-btn" value="Найти" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php foreach($articles as $v): ?>
                                <tr class="even pointer">
                                    <td class="blog_artLogo"><img src="<?=SITEMAIN.$v['logo']?>" /></td>
                                    <td class=" "><?=$v['title']?></td>
                                    <td class=" "><?=($v['show_status'] == '0')?'<a href="/blog/upd_art_valid/'.$v['id'].'">на проверке</a>':'публикуется'?></td>
                                    <td class=" ">
                                        <a href="/blog/edit/<?=$v['id']?>" class="btn btn-sm btn-success">Изменить</a>
                                        <a href="/blog/trash/<?=$v['id']?>" class="btn btn-sm btn-danger">Удалить</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                                <tr>
                                    <td colspan="4"><?=$pagination?></td>
                                </tr>
                                <?php else: ?>
                                <tr class="even pointer">
                                    <td class="a-center" colspan="6" style="text-align: center;">
                                        <h2>Объявлений нет!</h2>
                                    </td>
                                </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#search_advert').click(function(){
		var tag = $('#art_tag').val();
        var cat_id = $('#category_id').val();
        
        $.ajax({
        	url: '/blog/life_search_articles',
        	method: 'post',
        	dataType: 'json',
        	data: {search_tag: tag, cat_id: cat_id},
        	success: function(data){
        	    $('#list_of_search_result').empty();
                $('#list_of_search_result').css('display', 'block');
                if(data) {
                    $.map(data, function(i, item) {
                        $('#list_of_search_result').append('<li>'+i['title']+'<a href="/blog/edit/'+i['id_blog_article']+'">Edit</a><a href="/blog/trash/'+i['id_blog_article']+'">Trash</a></li>');
                    });
                } else {
                    $('#list_of_search_result').append('<li>Ничего не найденно!</li>');
                }
                $('#list_of_search_result').append('<li id="list_of_search_result_close">Закрыть</li>');
        	}
         });
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    	$('#list_of_search_result li#list_of_search_result_close').on('click', function(){
            $('#list_of_search_result').empty();
            $('#list_of_search_result').css('display', 'none');
        });
    });
</script>