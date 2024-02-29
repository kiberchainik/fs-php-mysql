<!-- Start Footer Area -->
        <footer class="htc__foooter__area gray-bg">
            <div class="container">
                <!-- Start Copyright Area -->
                <div class="htc__copyright__area">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="copyright__inner">
                                <div class="copyright">
                                    <p>© 2019 <a href="https://findsol.it">FindSolution</a> All Right Reserved.</p>
                                </div>
                                <ul class="footer__menu">
                                    <li><a href="/">Home</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Copyright Area -->
            </div>
        </footer>
        <!-- End Footer Area -->
    </div>
    <!-- Body main wrapper end -->
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- Bootstrap framework js -->
    <script src="/Media/tmart/js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="/Media/tmart/js/plugins.js"></script>
    <script src="/Media/tmart/js/slick.min.js"></script>
    <script src="/Media/tmart/js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="/Media/tmart/js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="/Media/tmart/js/main.js"></script>
    <script type="text/javascript">
//обработчик
	jQuery(document).ready(function () {
		jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
	});
//активный класс
	$(function(){	
		$("#demo-list li").click(function(){
			$("#demo-list li.active").removeClass("active")
			$(this).addClass("active");
		})	
	})	
</script>