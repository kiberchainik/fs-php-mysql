<div class="">
    <div class="col-sm-12">
        <div class="profile_avatar">
            <img class="img-fluid" src="/<?=($u_date['user_img'])?$u_date['user_img']:'Media/images/no_avatar.png'?>" alt="<?=$u_date['login']?>" />
            <h4 class="section-title-2 ptb--20"><?=$u_date['name']?> <?=$u_date['lastname']?></h4>
        </div>
        <?php if($u_date['type_person'] == '4'): ?>
        <div class="short_statistic">
            <p class=""><?=$text_numAdverts?>: <?=$numAdverts['numCount']?></p>
            <p class=""><?=$text_numvacancies?>: <?=$vacancies['numCount']?></p>
            <p class=""><?=$text_numcandidati?>: <?=$candidati['numCount']?></p>
        </div>
        <?php endif ?>
    </div>
    <div class="clearfix"></div>
    <div class="dashboard_tab_button">
        <ul class="nav flex-column dashboard-list" role="tablist">
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/profile"><?=$text_profile?></a></li>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/profile/edit"><?=$text_profile_edit?></a></li>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/newadvert"><?=$text_addnews?></a></li>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/adscompany"><?=$text_public_edit?></a></li>
            <?php if($u_date['type_person'] == '5'): ?>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/savednews"><?=$text_saved_news?></a></li>
            <?php endif ?>
            <?php if($u_date['type_person'] == '4'): ?>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/saveportfolio"><?=$text_saved_portfolio?></a></li>
            <?php endif ?>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/profile/messages"><?=$text_messages_btn?> <span class="num_message_unread"><?=$nunMessage['numCount']?></span></a></li>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/comments"><?=$text_comments?> <span class="num_message_unread"><?=$numComments['numCount']?></span></a></li>
            <?php if($u_date['type_person'] == '5'): ?>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/profile/portfolio"><?=$text_portfolio?></a></li>
            <?php endif ?>
            <?php if($u_date['type_person'] == '4'): ?>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/profile/vacancies"><?=$text_vacancies?></a></li>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/profile/candidats"><?=$text_candidatura?> <span class="num_message_unread"><?=$numCandidats['numCount']?></span></a></li>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/branch"><?=$text_branch?></a></li>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/profile/api">API settings</a></li>
            <?php endif ?>
            <li><a class="nav-link btn btn-sm btn-default-outline" href="/logout"><?=$text_logout?></a></li>
        </ul>
    </div>
</div>