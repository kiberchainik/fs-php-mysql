<!-- Start BLog Area -->
<div class="htc__blog__area bg__white ptb--60">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-12">
                <div class="blod-details-left-sidebar mrg-blog">
                    <!-- Start Tag -->
                    <?=$p_menu?>
                    <!-- End Tag -->
                </div>
            </div>
            <div class="col-md-9 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="private_wrapp">
                        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" />
                        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
                        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
                        <style>
                        #line-chart{
                          min-height: 250px;
                        }
                        </style>
                        <div class="text-center">
                        <label class="label label-success">Посещаемость за день</label>
                        <div id="line-chart"></div>
                        </div>
                        <script type="text/javascript">
                            var data = [
                                <?php foreach($userstatistics as $us):?>
                                    { y: '<?=$us["date"]?>', hosts: <?=$us['hosts']?>, views: <?=$us['views']?>},
                                <?php endforeach ?>
                                ],
                                config = {
                                  data: data,
                                  xkey: 'y',
                                  ykeys: ['hosts', 'views'],
                                  labels: ['Посетители', 'Просмотры'],
                                  fillOpacity: 0.6,
                                  hideHover: 'auto',
                                  behaveLikeLine: true,
                                  resize: true,
                                  pointFillColors:['#ffffff'],
                                  pointStrokeColors: ['black'],
                                  lineColors:['gray','red']
                              };
                            config.element = 'line-chart';
                            Morris.Line(config);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>