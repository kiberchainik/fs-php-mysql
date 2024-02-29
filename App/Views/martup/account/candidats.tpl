<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <?php if($tottal_candidats): ?>
				<div class="col-sm-12 table_page table-responsive">
				    <table>
                        <thead>
                            <tr>
                                <th>Title vacance</th>
                                <th>Profile details</th>
                                <th>Date</th>
                                <th>Trash</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($tottal_candidats as $tc): ?>
        					<tr>
        						<td><a href="/vacancies/page/<?=$tc['v_id']?>" target="_blank"><?=$tc['title']?></a></td>
                                <td>
                                    <p id="online<?=$tc['id_user']?>"></p>
                                    <div id="online" val="<?=$tc['id_user']?>"></div>
                                    <a href="#win<?=$tc['id_user']?>" rel="nofollow" class="full btn btn-sm btn-radius btn-default mb-4" data="<?=$tc['login']?>"><?=$tc['name']?> <?=$tc['lastname']?></a>
                                    <div class="popup animated" id="win<?=$tc['id_user']?>">
                                        <div id="<?=$tc['login']?>_header"></div>
                                        <hr />
                                        <div class="row <?=$tc['login']?>" id="ajaxResult" data="<?=$tc['login']?>"></div>
                                        <a rel="nofollow" class="close" href="#close"></a>
                                    </div>
                                </td>
                                <td><?=date('d M Y', $tc['date_add'])?></td>
                                <td><a href="/profile/trash_candidat/<?=$tc['id']?>"><img src="/Media/martup/assets/images/icons/icon-trash.svg" /></a></td>
        					</tr>
        				<?php endforeach ?>
                        </tbody>
                    </table>
				</div>
			<?php endif ?>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script type="text/javascript">
    $(document).ready(function() {
        $('a.full').click(function(){
            var login = $(this).attr('data');
            
            $.ajax({
                url: '/profile/candidats',
                type: 'post',
                data: {'portfolio': login},
                dataType: 'json',
                beforeSend: function() {
                    $('.'+login).html('<p>Loading...</p>');
                },
                success: function(user) {
                    $('.'+login+' p').remove();
                    $('#'+login+'_header').empty();
                    $('.'+login).empty();
                    $('a.btn_portfolio_page').remove();
                    console.log(user);
                    if(user.error) {
                        $('#'+login+'_header').html('<h4>Error!</h4>');
                        $('.'+login).html('<h1>'+user.error+'</h1>');
                    } else {
                        $('#'+login+'_header').html('<h4>'+user.portfolio.name+' '+user.portfolio.lastname+'</h4>');
                        $('.'+login).append('<div class="c_cv_short_img col-sm-12 col-md-4 col-lg-4"><img src="/'+user.portfolio.portfolio_img+'" alt="'+user.portfolio.login+'" /></div>');
                        $('.'+login).append('<div class="col-sm-12 col-md-8 col-lg-8 candidats_data"><div class="c_cv_short_birthDate">'+user.portfolio.birthDate+'</div><div class="c_cv_short_nacional">'+user.portfolio.nacional+'</div><div class="c_cv_short_mobile">'+user.portfolio.mobile+'</div><div class="c_cv_short_email">'+user.portfolio.email+'</div><div class="c_cv_short_adresResident">'+user.portfolio.adresResident+'</div><div class="c_cv_short_patent">'+user.portfolio.patent+'</div></div>');
                        if (user.portfolio.candidat == 'notvalid') $('.'+login).append('<a href="/'+user.portfolio.portfolio_img+'" class="full btn btn-sm btn-radius btn-default" target="_blank">Download portfolio</a>');
                        else $('.'+login).append('<a href="/portfolio/user/'+user.portfolio.login+'" class="full btn btn-sm btn-radius btn-default" target="_blank">Open portfolio</a>');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $('.'+login+' p').remove();
                    $('.'+login).append('Ошибка: '+thrownError);
                }
            });
        });
    });
</script>