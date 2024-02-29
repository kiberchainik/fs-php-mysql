<div class="shop-list-section section-fluid-270 section-top-gap-100">
        <div class="box-wrapper">
            <div class="shop-list-wrapper">
                <div class="container-fluid">
                    <div class="row flex-column-reverse flex-lg-row">
                        <div class="col-xl-3 col-lg-3">
                            <!-- Start Sidebar Area -->
                            <div class="siderbar-section">
                                <!-- Start Single Sidebar Widget -->
                                <div class="sidebar-single-widget">
                                    <div class="sidebar-content">
                                        <h6 class="sidebar-title title-border title-border"><?=$text_category_vacancies?> <?=$loc?></h6>
                                        <div class="widget-catagory">
                                            <?php foreach($vacanciesCategoriList as $vm): ?>
                                            <a href="/vacancelocal/<?=$loc?>/category/<?=$vm['seo']?>"><?=$vm['title']?></a>
                                            <?=($vm['vacancies_count'] == '0')?'':'<span class="portfolio_count">'.$vm['vacancies_count'].'</span>'?></li>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div> <!-- End Single Sidebar Widget -->
                            </div> <!-- End Sidebar Area -->
                        </div>
                        <div class="col-xl-8 offset-xl-1 col-lg-9">
                            <div class="col-xl-12 breadcrumbs">
                                <?=$breadcrumb?>
                            </div>
                            <ul class="product-shop-filter-info">
                                <li class="prduct-item-filter">
                                    <select name="choice" id="company">
                                        <option value="0">- Seleziona agenzia -</option>
                                        <?php foreach($companylist as $cl): ?>
                                            <?php if(!empty($id_company) and $id_company == $cl['user_id']):?>
                                                <option value="<?=$cl['user_id']?>" selected=""><?=$cl['company_name']?></option>
                                            <?php else: ?>
                                                <option value="<?=$cl['user_id']?>"><?=$cl['company_name']?></option>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </select>
                                </li>
                                <li class="prduct-item-filter branch"></li>
                                <!--li class="prduct-item-filter location">
                                    <select name="location">
                                        <option value="0">- Seleziona luogo -</option>
                                    </select>
                                </li-->
                            </ul>
                            <ul class="product-shop-filter-info">
                                <div class="search_box">
                                    <input type="text" name="v_local" id="v_local" placeholder="Inserisci città" />
                                    <div id="search_box-result"></div>
                                </div>
                            </ul>
                            <?php if(isset($tottal)): ?>
                                <div>Trovato: <?=$tottal?></div>
                            <?php endif ?>
                            <div class="product-shop-list-items">
                                <div class="row mb-n25">
                                    <div class="col-md-4 col-12 mb-25">
                                        <!-- Start Product Single Item - Style 1 -->
                                        <div class="product-single-item-style-1">
                                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3626047805353694"
                                             crossorigin="anonymous"></script>
                                            <ins class="adsbygoogle"
                                                 style="display:block"
                                                 data-ad-format="fluid"
                                                 data-ad-layout-key="-6c+dt-5-dd+gb"
                                                 data-ad-client="ca-pub-3626047805353694"
                                                 data-ad-slot="7985899014"></ins>
                                            <script>
                                                 (adsbygoogle = window.adsbygoogle || []).push({});
                                            </script>
                                        </div>
                                        <!-- End Product Single Item - Style 1 -->
                                    </div>
                                    <?php foreach($vacanciesList as $pl): ?>
                                    <div class="col-md-4 col-12 mb-25">
                                        <!-- Start Product Single Item - Style 1 -->
                                        <div class="product-single-item-style-1">
                                            <a href="/vacancies/page/<?=$pl['seo']?>" class="image img-responsive">
                                                <img class="img-fluid" src="/<?=$pl['user_img']?>" alt="<?=$pl['title']?>" />
                                            </a>
                                            <div class="content">
                                                <div class="top">
                                                    <h4 class="title"><a href="/vacancies/page/<?=$pl['seo']?>"><?=$pl['title']?></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Product Single Item - Style 1 -->
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <!-- Start Pagination -->
                            <?=$pagination?>
                            <!-- End Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function() {
        $('#company').change(function (e) {
            e.preventDefault();
            var id = $(this).val();
            
            select_ajax(id);
        });
        
        $('#company').each(function () {
            var id = $(this).val();
            
            select_ajax(id);
        });
        
        function select_ajax (id) {
            $('li.branch').empty();
            $.ajax({
                url: '/ajax/branchlist',
                data: {id_company: id},
                dataType: 'json',
                type: 'POST',
                success: function(r) {
                    if (r != '') {
                        var $newSelect = $('<select name="company_branch" id="company_branch"/>');
                        $newSelect.append('<option value="0">- Seleziona filiale -</option>');
                        
                        $.map(r, function(v) {
                            if(localStorage.getItem('branch') == v.id) $newSelect.append('<option value="' + v.id + '" selected>' + v.name_company + '</option>');
                            else $newSelect.append('<option value="' + v.id + '">' + v.name_company + '</option>');
                        });
                        $('li.branch').append($newSelect);
                    }
                }
            });
        }
        
        var url = window.location.pathname;
        $('li.branch').on('change', '#company_branch', function () {
          localStorage.setItem("branch", $(this).val());
          
          $(location).attr('href', '/branch/vacancie/'+$('#company').val()+'/'+$(this).val());
        });
    });
</script>
<script>
    $(document).ready(function() {	
	var $result = $('#search_box-result');
	
	$('#v_local').on('keyup', function(){
		var search = $(this).val();
		if ((search != '') && (search.length > 1)){
			$.ajax({
				type: "POST",
				url: "/ajax/vacancies_by_location",
				data: {'v_local': search},
				success: function(msg){
					$result.html(msg);
					if(msg != ''){	
						$result.fadeIn();
					} else {
						$result.fadeOut(100);
					}
				}
			});
		 } else {
			$result.html('');
			$result.fadeOut(100);
		 }
	});
	
});
</script>