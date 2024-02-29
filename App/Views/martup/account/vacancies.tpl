<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="review-btn">
                    <a href="/profile/newvacance" class="btn btn-sm btn-radius btn-default mb-4"><?=$text_add_new?></a>
                </div>
                <?php if(empty($vacanciesList)): ?>
                    <div style="margin-top: 15px;"><h4><?=$text_not_vacance?></h4></div>
                <?php else: ?>
                <div class="col-sm-12 table_page table-responsive" style="margin-top: 40px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th><a href="/profile/vacancies/title">Title</a></th>
                                <th><a href="/profile/vacancies/date">Date of public</a></th>
                                <th><a href="/profile/vacancies/views">Visits</a></th>
                                <th><a href="/profile/vacancies/filial">Filial</a></th>
                                <th>Trash</a></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($vacanciesList as $k => $ml): ?>
                        <tr>
                            <td><a href=""><?=($ml['valid_status'] == '1')?'<img src="/Media/martup/assets/images/icons/view.svg" height="24" widht="24" alt="" />':'<img src="/Media/martup/assets/images/icons/view.svg" alt="" />'?></a></td>
                            <td><a href="/vacancies/page/<?=$ml['seo']?>" target="_blank"><?=$ml['title']?></td>
                            <td><?=date('F j, Y, g:i a', $ml['date_add'])?></td>
                            <td><?=$ml['views']?></td>
                            <td><?=$ml['name_company']?></td>
                            <td>
                                <a href="/profile/vacanceedit/<?=$ml['id']?>"><img src="/Media/martup/assets/images/icons/edit.svg" alt="" /></a>
                                <a href="/profile/vacancetrash/<?=$ml['id']?>"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="" /></a>
                            </td>                                    
                        </tr>
                        <?php endforeach ?>
                        <tr>
                            <td colspan="6"><?=$pagination?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->