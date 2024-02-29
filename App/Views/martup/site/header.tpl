<!-- .....:::::: Start Header Section - Light Header :::::.... -->
<header class="header-section @@pos_absolute pos-relative light-bg sticky-header d-none d-lg-block section-fluid-270">
    <div class="header-wrapper pos-relative">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <!-- Start Header Logo -->
                    <a href="/" class="header-logo">
                        <img class="img-fluid" src="/Media/images/siteLogo/fq.png" alt="FindSolution" />
                    </a>
                    <!-- End Header Logo -->
                </div>
                <div class="col-auto align-items-center">
                    <div class="header-event">
                        <!-- Start Menu event -->
                        <?=$mainmenumod?>
                        <div class="search-event">
                            <form method="post" action="/search">
                                <input class="header-search" name="search_query" type="search" placeholder="Search" />
                                <button class="header-search-btn" type="submit"><img src="/Media/martup/assets/images/icons/icon-search.svg" alt="search" /></button>
                            </form>
                        </div>
                        <!-- End Menu event -->
                    </div>
                    <ul class="site_sections">
                    	<li><a href="/portfolio"><?=$text_portfolio?></a></li>
                    	<li><a href="/vacancies"><?=$text_vacancies?></a></li>
                    	<li><a href="/company"><?=$text_company?></a></li>
                    	<li><a href="/category"><?=$text_adverts?></a></li>
                     </ul>
                </div>
                <div class="col-auto">
                    <div class="header-action">
                        <ul class="offcanvas-products-list header-languages">
                            <?php foreach($lang as $l): ?>
                            <li><a href="/lang/<?=$l['code']?>"><img src="<?=$l['icon']?>" alt="<?=$l['code']?>" title="<?=$l['title']?>" /></a></li>
                            <?php endforeach ?>
                        </ul>
                        <?php if(!$auth): ?>
                        <a href="/login" class="header-action-item header-action-wishlist"><img src="/Media/martup/assets/images/icons/users_icon.png" alt="login" /> ACCOUNT</a>
                        <?php else: ?>
                        <button class="header-action-item header-action-wishlist" data-bs-toggle="offcanvas" data-bs-target="#profileOffcanvas"><img src="/Media/martup/assets/images/icons/users_icon.png" alt="user" /> PROFILE</button>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- .....:::::: End Header Section - Light Header :::::.... -->
<!-- .....:::::: Start Mobile Header Section :::::.... -->
<div class="mobile-header d-block d-lg-none">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                <div class="mobile-logo">
                    <a href="/"><img class="img-fluid" src="/Media/images/siteLogo/fq.png" style="height: 35px;" alt="FindSolution" /></a>
                </div>
            </div>

            <div class="col-auto">
                <div class="mobile-action-link text-end d-flex ">
                    <button data-bs-toggle="offcanvas" data-bs-target="#toggleMenu"><span class="material-icons">menu</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .....:::::: Start MobileHeader Section :::::.... -->
<!--  .....::::: Start Offcanvas Mobile Menu Section :::::.... -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="toggleMenu">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php if(!$auth): ?>
        <div class="d-flex justify-content-center ">
            <a href="/login" class="header-action-item header-action-wishlist"><img src="/Media/martup/assets/images/icons/users_icon.png" alt="login" /><span class="item-count item-count--light"> Login/Register</span></a>
        </div>
        <?php else: ?>
        <div class="d-flex justify-content-center"><a href="/profile">Profile</a> | <a href="/logout">Logout</a></div>
        <?php endif ?>
        <div class="header-event mobile-search my-5">
            <div class="search-event">
                <form method="post" action="/search">
                    <input class="header-search" name="search_query" type="search" />
                    <button class="header-search-btn" style="padding: 0px 4px;" type="submit"><img src="/Media/martup/assets/images/icons/icon-search.svg" alt="search" /></button>
                </form>
            </div>
        </div>

        <!-- Start Offcanvas Mobile Menu Wrapper -->
        <div class="offcanvas-mobile-menu-wrapper">
            <!-- Start Mobile Menu  -->
            <div class="mobile-menu-bottom">
                <!-- Start Mobile Menu Nav -->
                <div class="offcanvas-menu">
                    <ul>
                        <li>
                            <a href="#"><span>Language</span></a>
                            <ul class="mobile-sub-menu">
                                <?php foreach($lang as $l): ?>
                                <li><a href="/lang/<?=$l['code']?>"><?=$l['title']?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                        <?=$mobile_menu?>
                    </ul>
                </div> <!-- End Mobile Menu Nav -->
            </div> <!-- End Mobile Menu -->

        </div> <!-- End Offcanvas Mobile Menu Wrapper -->
    </div>
</div>
<!-- ...:::: End Offcanvas Mobile Menu Section:::... -->

<!--  .....::::: Start Wishlist Offcanvas Section :::::.... -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="langOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Languages</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="offcanvas-products-list">
            <?php foreach($lang as $l): ?>
            <li><a href="/lang/<?=$l['code']?>"><?=$l['title']?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<!-- ...:::: End Wishlist Offcanvas Section:::... -->
<?php if($auth): ?>
<!--  .....::::: Start Add Cart Offcanvas Section :::::.... -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="profileOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"><?=$user_name?> <?=$user_lastname?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?=$profile_menu?>
    </div>
</div>
<!-- ...:::: End Add Cart Offcanvas Section:::... -->
<?php endif ?>