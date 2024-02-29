<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <?php if(!empty($portfolio_saved)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Trash</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($portfolio_saved as $pa): ?>
                    <tr>
                        <td>
                            <a href="/portfolio/user/<?=$pa['login']?>">
                                <?=$pa['name']?> <?=$pa['lastname']?>
                            </a>
                        </td>
                        <td><a title="Delete portfolio" href="/saveportfolio/trash/<?=$pa['id_user']?>"><img src="/Media/martup/assets/images/icons/icon-trash.svg" alt="" /></a></td>
                    </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
                <?php else: ?>
                <h4 class="contact-title spc"><?=$text_adverts_dont_found?></h4>
                <?php endif ?>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->