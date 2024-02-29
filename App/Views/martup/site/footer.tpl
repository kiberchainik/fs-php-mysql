<!-- ...::: Strat Footer Section - Footer Light :::... -->
<footer class="footer-section footer-section-style-1 section-top-gap-120">
    <div class="box-wrapper">
        <div class="footer-wrapper section-fluid-270">
            <div class="container-fluid">

                <!-- Start Footer Top  -->
                <div class="footer-top">
                    <div class="footer-top-left">
                        <div class="footer-contact-items">
                            <a class="icon-left" href="mailto:<?=$admin_email?>"><img class="icon-svg" src="/Media/martup/assets/images/icons/icon-mail-open-dark.svg" alt="email" /><?=$admin_email?></a>
                        </div>
                    </div>
                    <div class="footer-top-right">
                        
                    </div>
                </div>
                <!-- End Footer Top  -->

                <!-- Start Footer Center  -->
                <div class="footer-center">
                    <div class="footer-widgets-items">
                        <!-- Start Footer Widget Single Item -->
                        <div class="footer-widgets-single-item footer-widgets-single-item--light">
                            <h5 class="title">Infomation</h5>
                            <h5 class="collapsed-title collapsed" data-bs-toggle="collapse" data-bs-target="#dividerId-1">Product</h5>
                            <div id="dividerId-1" class="widget-collapse-body collapse">
                                <ul class="footer-nav">
                                    <?php foreach($information as $i): ?>
                                    <li><a href="/information/page/<?=$i['seo']?>"><?=$i['title']?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                        <!-- End Footer Widget Single Item -->
                        <!-- Start Footer Widget Single Item -->
                        <div class="footer-widgets-single-item footer-widgets-single-item--light">
                            <h5 class="title">About</h5>
                            <h5 class="collapsed-title collapsed" data-bs-toggle="collapse" data-bs-target="#dividerId-4">About</h5>
                            <div id="dividerId-4" class="widget-collapse-body collapse">
                                <ul class="footer-nav">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/information">Information</a></li>
                                    <li><a href="/contacts">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Footer Widget Single Item -->
                        <!-- Start Footer Widget Single Item -->
                        <div class="footer-widgets-single-item footer-widgets-single-item--light">
                            <!--LiveInternet counter--><a href="https://www.liveinternet.ru/click"
target="_blank"><img id="licnt2EEC" width="88" height="120" style="border:0" 
title="LiveInternet: показано количество просмотров и посетителей"
src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAIBTAA7"
alt=""/></a><script>(function(d,s){d.getElementById("licnt2EEC").src=
"https://counter.yadro.ru/hit?t27.6;r"+escape(d.referrer)+
((typeof(s)=="undefined")?"":";s"+s.width+"*"+s.height+"*"+
(s.colorDepth?s.colorDepth:s.pixelDepth))+";u"+escape(d.URL)+
";h"+escape(d.title.substring(0,150))+";"+Math.random()})
(document,screen)</script><!--/LiveInternet-->

                        </div>
                        <!-- End Footer Widget Single Item -->
                        <!-- Start Footer Widget Single Item -->
                        <div class="footer-widgets-single-item footer-widgets-single-item--light">
                            
                        </div>
                        <!-- End Footer Widget Single Item -->
                    </div>
                </div>
                <!-- End Footer Center  -->

                <!-- Start Footer Bottom -->
                <div class="footer-bottom">
                    <p class="copyright-text copyright-text--light">&copy; 2019 <a href="https://findsol.it">FindSolution</a> All Right Reserved.</p>
                </div>
                <!-- End Footer Bottom -->
            </div>
        </div>
    </div>
</footer>
<!-- ...::: End Footer Section Section - Footer Light :::... -->
<!-- ::::::::::::::All JS Files here :::::::::::::: -->
<!-- Global Vendor -->
<script src="/Media/martup/assets/js/vendor/bootstrap.bundle.min.js"></script>

<script src="/Media/martup/assets/js/jquery.dlmenu.js"></script>
<script>
	$(function() {
		$( '#dl-menu' ).dlmenu({
			animationClasses : { in : 'dl-animate-in-2', out : 'dl-animate-out-2' }
		});
	});
</script>
<?php if (empty($_COOKIE['messages_cookies'])): ?>
<div class="messages_cookies">
	<div class="messages_cookies-wrp">
		<a href="#" class="messages_cookies-close"><img src="/Media/martup/assets/images/icons/icons8-close-24.png" alt="Close" /></a>
		<?=$text_cookie?>
	</div>
</div>	
<?php endif; ?>
<script type="text/javascript">
$(document).ready(function(){
	$('.messages_cookies-close').click(function(){
		$('.messages_cookies').hide(100);
		document.cookie = "messages_cookies=true; max-age=31556926";
		return false;
	});
});
</script>
<!--Plugins JS-->
<?php if($auth): ?>
	<div id="favorit" data="<?=$auth['u_id']?>"></div>
	<div id="usersChatList"></div>
	<div id="chatBox"></div>
	<div id="noSound" data="1"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.js"></script>
    <script src="/Media/martup/assets/js/howler.js"></script>
	<script src="/Media/martup/assets/js/client.js"></script>
<?php endif ?>
<script src="/Media/martup/assets/js/plugins/swiper-bundle.min.js"></script>
<script src="/Media/martup/assets/js/plugins/ion.rangeSlider.min.js"></script>
<script src="/Media/martup/assets/js/plugins/ajax-mail.js"></script>
<script src="/Media/martup/assets/js/main.js"></script>