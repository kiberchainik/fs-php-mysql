<div class="sidebar-single-widget sidebar-single-widget--seperator">
    <div class="sidebar-content">
        <div class="widget-catagory">
            <a href="/profile"><?=$text_profile?></a>
            <a href="/profile/edit"><?=$text_profile_edit?></a>
            <a href="/newadvert"><?=$text_addnews?></a>
            <a href="/adscompany"><?=$text_public_edit?></a>
            <?php if($u_date['type_person'] == '5'): ?>
            <a href="/savednews"><?=$text_saved_news?></a>
            <?php endif ?>
            <?php if($u_date['type_person'] == '4'): ?>
            <a href="/saveportfolio"><?=$text_saved_portfolio?></a>
            <?php endif ?>
            <a href="/profile/messages"><?=$text_messages_btn?> <span class="num_message_unread"><?=$nunMessage['numCount']?></span></a>
            <a href="/comments"><?=$text_comments?> <span class="num_message_unread"><?=$numComments['numCount']?></span></a>
            <?php if($u_date['type_person'] == '5'): ?>
            <a href="/profile/portfolio"><?=$text_portfolio?></a>
            <?php endif ?>
            <?php if($u_date['type_person'] == '4'): ?>
            <a href="/profile/vacancies"><?=$text_vacancies?></a>
            <a href="/profile/candidats"><?=$text_candidatura?> <span class="num_message_unread"><?=$numCandidats['numCount']?></span></a>
            <a href="/branch"><?=$text_branch?></a>
            <a href="/profile/api">API settings</a>
            <?php endif ?>
            <a href="/logout"><?=$text_logout?></a>
        </div>
    </div>
</div>