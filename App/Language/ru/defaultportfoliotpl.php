<?php
	$lang = array(
        'defaulttpl' => '
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="alexandr" />
    <style type="text/css">
        html {height: 100%; margin: 0px; padding: 0px;}
        body{position: relative; display: block; height: 100%; margin: 0px; padding: 0px; font-family: "DejaVu Sans", sans-serif;}
        
        #conteiner {width: 100%;height: auto !important;}
        
        #leftbar {width: 250px;position: relative; height:100%; display: grid; float: left;background: #FF9F0F;}
            #leftbar #img_user {background: #FF9F0F;}
                #leftbar #img_user img {width: 100%; border-radius: 0% 0% 50% 50%;}
            #leftbar #user_data {background: #FF9F0F; padding-top: 15px; margin-top: -1px; padding-left: 10px;}
                #leftbar #user_data .data_element {padding: 5px; font-size: 11px;}
                    #leftbar #user_data .data_element img {}
                    #leftbar #user_data .data_element p {margin-left: 25px; margin-top: -20px;}
        #leftbar #about_user { padding-left: 10px;margin-top: -1px; padding-bottom: 20px; border-radius: 0px 0px 5px 5px;padding-top: 30px;}
            #leftbar #about_user div {line-height: 1.5; padding: 10px; font-size: 11px; border-left: 3px solid #E38800; margin-left: 10px; margin-top: 0px;}
            #leftbar #qr_email, #qr_user {width: 48%; text-align: center;}
            #leftbar #qr_email {float: left;}
            #leftbar #qr_user {float:right;}
            #leftbar #qr_email img, #leftbar #qr_user img {width: 80px !important; height:80px !important;}
            #leftbar #qr_email p, #leftbar #qr_user p {font-size: 10px}
        
        #content {width: 700px; padding: 10px; margin-right: -200px; float:right;}
            #content #cnt-header {border-bottom: 2px solid #499adf;text-align: right;font-size: 2.5em;text-transform: uppercase; font-weight: 100;}
            
            .position-relative {position: relative !important;}
            .align-items-center {align-items: center !important;}
            .justify-content-center {justify-content: center !important;}
            .d-flex {display: flex !important;}
            .text-white {color: #fff !important;}
            .mb-2 {margin-top: 5px !important; font-size: 15px;}
            strong {font-weight: bolder;}
            .small {font-size: 80%;font-weight: 400;}
            p:last-child {margin-bottom: 0 !important;}
            p.mb-2{font-size: 15px;color: #6c757d; margin-top:-20px !important; margin-bottom:10px !important;}
            .mb-2 small{font-size: 11px;}
            
            .text-primary {color: #499adf !important; font-size: 1.5em;}
            .text-uppercase {text-transform: uppercase !important;}
            .position-absolute {position: absolute !important; text-align: center;}
            .border-primary {border-color: #499adf !important;}
            .border-left {border-left: 2px solid #499adf !important; border-left-color: #499adf;}
            .pl-4, .px-4 {padding-left: 1.5rem !important;}
            .pt-2, .py-2 {padding-top: 0.5rem !important;}
            .ml-2, .mx-2 {margin-left: 0.5rem !important;}
            h3.mb-4, .my-4 {color: black; font-weight: normal; font-size: 15px;}
                .font-weight-bold {font-weight: 500 !important; font-size: 13px;}
                .mb-1 {font-weight: normal !important; font-size: 13px;margin-top: 0px}
        
        #footer {width: 100%; position: absolute;display: flex;text-align: center; bottom:0px}
            #logo img {height: 30px; width: 100px; margin-right: 200px;margin-bottom: 20px;}
            #copy {width: 100%;margin-top: 30px;font-size: 12px;color: #6c757d;}
            
        .documents {margin-left: 5px}
        .documents img{widht: 100%;}
    </style>
</head>

<body>
    <div id="conteiner">
        <div id="leftbar">
            <div id="img_user"><img src="{user_logo}" /></div>
            <div id="user_data">
                <div class="data_element"><img src="https://img.icons8.com/external-tanah-basah-basic-outline-tanah-basah/16/000000/external-user-user-tanah-basah-basic-outline-tanah-basah-6.png" class="icon" /><p>{user_name}</p></div>
                <div class="data_element"><img src="https://img.icons8.com/dotty/16/000000/biometric-passport.png" class="icon" /><p>{nacional}</p></div>
                <div class="data_element"><img src="https://img.icons8.com/ios/16/000000/new-post.png" class="icon" /><p>{email}</p></div>
                <div class="data_element"><img src="https://img.icons8.com/ios/16/000000/smartphone-approve.png" class="icon" /><p>{mobile}</p></div>
                <div class="data_element"><img src="https://img.icons8.com/small/16/000000/address.png" class="icon" /><p>{adresResident}</p></div>
                <div class="data_element"><img src="https://img.icons8.com/small/16/000000/tesla-model-3.png" class="icon" /><p>{patent}</p></div>
                <div class="data_element"><img src="https://img.icons8.com/ios/16/000000/family--v1.png" class="icon" /><p>{material_status}</p></div>
            </div>
            <div id="about_user"><div>{about_user}</div></div>
            <!--div id="qr_images">
                <div id="qr_email">
                    <p>Send email</p>
                    {qr_email}
                </div>
                <div id="qr_user">
                    <p>Curriculum online</p>
                    {qr_cv}
                </div>
            </div-->
        </div>
        <div id="content">
            <div id="cnt-body">
                <div class="position-relative d-flex align-items-center justify-content-center">
                    <h1 class="text-uppercase text-primary">{page_portfolio_portfolio_educations}</h1>
                </div>
                <h3 class="mb-4">{page_portfolio_portfolio_languages}</h3>
                <div class="border-left border-primary pt-2 pl-4 ml-2">{language}</div>
                
                <h3 class="mb-4">{page_portfolio_portfolio_educations}</h3>
                <div class="border-left border-primary pt-2 pl-4 ml-2">{education}</div>
            
                <h3 class="mb-4">{page_portfolio_portfolio_computer}</h3>
                <div class="border-left border-primary pt-2 pl-4 ml-2">{computer}</div>
                <div class="position-relative d-flex align-items-center justify-content-center">
                    <h1 class="text-uppercase text-primary">{page_portfolio_portfolio_work_post}</h1>
                </div>
                <div class="border-left border-primary pt-2 pl-4 ml-2">{work_post}</div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div id="logo"><img src="https://findsol.it/Media/images/siteLogo/fq.png" alt="Find Solution" /></div>
    </div>
    {documents}
</body>
</html>
        '
    );
?>