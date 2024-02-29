<div class="breadcrumb-section">
        <div class="box-wrapper">
            <div class="breadcrumb-wrapper breadcrumb-wrapper--style-4 breadcrumb-bg pos-relative">
                <div class="breadcrumb-content section-fluid-270">
                    <div class="container-fluid">
                        <div class="row justify-content-center justify-content-lg-start">
                            <div class="col-auto">
                                <ul class="breadcrumb-nav">
                                    <li><a href="/company">Agenzie e aziende</a></li>
                                    <li><a href="/company/category/<?=$companyDate['idTypeCompany']?>"><?=$companyDate['companyName']?></a></li>
                                    <li><?=$companyDate['name']?> <?=$companyDate['lastname']?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-9">
                                <div class="content">
                                    <span class="title-tag"><?=$companyDate['companyName']?></span>
                                    <h1 class="title"><?=$companyDate['name']?> <?=$companyDate['lastname']?></h1>
                                    <p><?=$companyDate['about']?></p>
                                    <div class="author-details">
                                        <div class="image">
                                            <img src="/<?=$companyDate['user_img']?>" alt="<?=$companyDate['login']?>" />
                                        </div>
                                        <div class="info">
                                            <span class="name"><?=$companyDate['company_name']?></span>
                                            <span class="position"><a rel="nofollow" href="<?=$companyDate['company_link']?>" target="_blank"><?=$companyDate['company_link']?></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blog-details-section section-fluid-270 section-top-gap-100">
        <div class="box-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center flex-column-reverse flex-lg-row">
                    <div class="col-xl-3 col-lg-4">
                        <!-- Start Sidebar Wrapper -->
                        <div class="siderbar-section">
                            
                            <!-- Start Sidebar Single Widget - Catagory-->
                            <div class="sidebar-single-widget sidebar-single-widget--seperator">
                                <h6 class="sidebar-title"><?=$text_category_companies?></h6>

                                <div class="sidebar-content">
                                    <div class="widget-catagory">
                                        <?php foreach($company_category as $cc): ?>
                                        <a href="/company/category/<?=$cc['id_type']?>"><?=$cc['name']?></a>
                                        <?=($cc['company_count'] == '0')?'':'<span class="portfolio_count">'.$cc['company_count'].'</span>'?>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                            <!-- End Sidebar Single Widget - Catagory-->
                        </div>
                        <!-- End Sidebar Wrapper -->
                    </div>
                    <div class="col-xl-8 offset-xl-1 col-lg-8">
                        <div class="blog-details-hero">
                            <div class="image">
                                <img class="img-fluid" src="/<?=$companyDate['user_img']?>" alt="<?=$companyDate['login']?>" />
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <div class="default-text-content">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                            <!-- Nav tabs -->
                                            <div class="dashboard_tab_button">
                                                <ul role="tablist" class="nav flex-column dashboard-list">
                                                    <li><a href="#company" data-bs-toggle="tab" class="nav-link btn btn-sm btn-default-outline  active">About company</a></li>
                                                    <li><a href="#adverts" data-bs-toggle="tab" class="nav-link btn btn-sm btn-default-outline ">Adverts</a></li>
                                                    <li><a href="#vacancies" data-bs-toggle="tab" class="nav-link btn btn-sm btn-default-outline ">Vacancies</a></li>
                                                    <?php if(!empty($branchlist)): ?>
                                                    <li><a href="#branch" data-bs-toggle="tab" class="nav-link btn btn-sm btn-default-outline ">Branch</a></li>
                                                    <?php endif ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-9 col-lg-9">
                                            <!-- Tab panes -->
                                            <div class="tab-content dashboard_content">
                                                <div class="tab-pane fade show active" id="company">
                                                    <h4><?=$companyDate['company_name']?></h4>
                                                    <p id="online<?=$companyDate['user_id']?>"></p>
                                                    <div id="online" val="<?=$companyDate['user_id']?>"></div>
                                                    <p class="address"><img src="/Media/martup/assets/images/icons/icons-address-16.png" height="16" width="16" /> <a href="/company/category/<?=$companyDate['idTypeCompany']?>"><?=$companyDate['companyName']?></a></p>
                                                    <p class="phone"><img src="/Media/martup/assets/images/icons/icons-call-16.png" height="16" width="16" /> <a rel="nofollow" href="tel:<?=$companyDate['mobile']?>"><?=$companyDate['mobile']?></a></p>
                                                    <p class="email"><img src="/Media/martup/assets/images/icons/icons-mail-16.png" height="16" width="16" /> <a rel="nofollow" href="mailto:<?=$companyDate['email']?>"><?=$companyDate['email']?></a></p>
                                                    <p class="url_company"><img src="/Media/martup/assets/images/icons/icons-website-16.png" height="16" width="16" /> <a rel="nofollow" href="<?=$companyDate['company_link']?>" target="_blank"><?=$companyDate['company_link']?></a></p>
                                                    <blockquote><?=$companyDate['about']?></blockquote>
                                                </div>
                                                <div class="tab-pane fade" id="adverts">
                                                    <h4>adverts list</h4>
                                                    <div class="table_page table-responsive">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($adverts as $k => $adv): ?>
                                                                <tr>
                                                                    <td><a href="/adverts/page/<?=$adv['seo']?>"><?=$adv['title']?></a></td>
                                                                    <td><?=date('M d Y',$adv['add_date'])?></td>
                                                                    <td><?php if($auth and $u_id['u_id'] != $adv['idUser']): ?>
                                                                        <span class="review-btn rat__qun">
                                                                            <?php if(!empty($status_saved)): ?>
                                                                                <p><?=$text_saved?></p>
                                                                            <?php else: ?>
                                                                                <p><span id="btn_save"><img src="/Media/martup/assets/images/icons/icon-heart-light.svg" /></span></p>
                                                                            <?php endif ?>
                                                                        </span>
                                                                        <?php endif ?>
                                                                        <?php if(!$auth): ?>
                                                                            <a href="/login"><span id="btn_save"><img src="/Media/martup/assets/images/icons/icon-heart-light.svg" /></a>
                                                                        <?php endif ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="vacancies">
                                                    <h4>vacancies list</h4>
                                                    <div class="table_page table-responsive">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($vacanceList as $k => $vl): ?>
                                                                <tr>
                                                                    <td><a href="/vacancies/page/<?=$vl['seo']?>"><?=$vl['title']?></a></td>
                                                                    <td><?=date('M d Y',$vl['date_add'])?></td>
                                                                    <td><?php if($auth and $u_id['u_id'] != $vl['id_user']): ?>
                                                                        <span class="review-btn rat__qun">
                                                                            <?php if(!empty($status_saved)): ?>
                                                                                <p><?=$text_saved?></p>
                                                                            <?php else: ?>
                                                                                <p><span id="btn_save"><img src="/Media/martup/assets/images/icons/icon-heart-light.svg" /></span></p>
                                                                            <?php endif ?>
                                                                        </span>
                                                                        <?php endif ?>
                                                                        <?php if(!$auth): ?>
                                                                            <a href="/login"><span id="btn_save"><img src="/Media/martup/assets/images/icons/icon-heart-light.svg" /></a>
                                                                        <?php endif ?>
                                                                        </td>
                                                                </tr>
                                                                <?php endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php if(!empty($branchlist)): ?>
                                                <div class="tab-pane" id="branch">
                                                    <h5 class="billing-address">Branch list</h5>
                                                    <div class="table_page table-responsive">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Filial name</th>
                                                                    <th>Adress</th>
                                                                    <th>Phone</th>
                                                                    <th>Email</th>
                                                                    <th>View</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($branchlist as $bl): ?>
                                                                <tr>
                                                                    <td><?=$bl['name_company']?></td>
                                                                    <td><?=$bl['adres']?></td>
                                                                    <td><?=$bl['phone']?></td>
                                                                    <td><?=$bl['email']?></td>
                                                                    <td><a href="/company/branch/<?=$bl['id']?>">View all list</a></td>
                                                                </tr>
                                                                <?php endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-10">
                                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3626047805353694"
                                         crossorigin="anonymous"></script>
                                    <!-- adaptive -->
                                    <ins class="adsbygoogle"
                                         style="display:block"
                                         data-ad-client="ca-pub-3626047805353694"
                                         data-ad-slot="3091561332"
                                         data-ad-format="auto"
                                         data-full-width-responsive="true"></ins>
                                    <script>
                                         (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    