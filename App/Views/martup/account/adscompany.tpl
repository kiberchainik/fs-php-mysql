<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <div class="col-sm-12">
                    <?php if(!empty($message)): ?>
                        <h1 class=""><?=$message?></h1>
                    <?php endif ?>
                </div>
                <div class="shop__btn"><a href="/adscompany/newads" class="btn btn-sm btn-radius btn-default mb-4"><i class="fa fa-plus"></i> <?=$add?></a></div>
                <div class="col-sm-12" style="margin-top: 20px;">
                    <?php if(!empty($adsList)): ?>
                    <div class="table_page table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Clicks</th>
                                    <th>Edit</th>
                                    <th>Trash</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($adsList as $ad): ?>
                                <tr>
                                    <td><a href="/adverts/view/<?=$ad['id']?>"><?=$ad['title']?></a></td>
                                    <td><?=$ad['short_desc']?></td>
                                    <td>
                                        <p class="moderation"><?=($ad['valid_status'] == '0')?$moder:$public?></p>
                                        <p class="moderation"><?=($ad['show_status'] == '0')?$dont_show:$show_ok?></p>
                                    </td>
                                    <td>
                                        <a href="#win<?=$ad['id']?>" rel="nofollow" class="btn btn-sm btn-radius btn-default mb-4"><?=$clicks?>: <?=count($getClicks[$ad['title']]['click'])?></a>
                                        <div class="popup animated" id="win<?=$ad['id']?>">
                                            <div id="chart<?=$ad['id']?>" style="height: 400px; width: 100%;"></div>
                                            <a rel="nofollow" class="close" href="#close"></a>
                                        </div>    
                                    </td>
                                    <td>
                                        <a href="<?=(empty($ad['company_url']))?$ad['seo_publication']:$ad['company_url']?>" target="_blank" class="htc__btn">
                                            <img src="/Media/martup/assets/images/icons/view.svg" />
                                        </a>
                                        <a href="/adscompany/edit/<?=$ad['id']?>" class="htc__btn" >
                                            <img src="/Media/martup/assets/images/icons/icon-edit.svg" />
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/adscompany/delete/<?=$ad['id']?>" class="htc__btn" >
                                            <img src="/Media/martup/assets/images/icons/icon-trash.svg" />
                                        </a>
                                    </td>
                                </tr>
                                <!-- Модальное окно -->
                                <script>
                                window.onload = function () {
                                
                                    var options = {
                                    	exportEnabled: true,
                                    	animationEnabled: true,
                                    	axisY: {
                                    		title: "Click",
                                    		titleFontColor: "#4F81BC",
                                    		lineColor: "#4F81BC",
                                    		labelFontColor: "#4F81BC",
                                    		tickColor: "#4F81BC",
                                    		includeZero: false
                                    	},
                                    	toolTip: {
                                    		shared: true
                                    	},
                                    	legend: {
                                    		cursor: "pointer",
                                    		itemclick: toggleDataSeries
                                    	},
                                    	data: [{
                                    		type: "spline",
                                    		name: "Amount",
                                    		showInLegend: false,
                                    		xValueFormatString: "MMM YYYY",
                                    		yValueFormatString: "#,##0 Click",
                                    		dataPoints: [
                                                <?php foreach($getClicks[$ad['title']]['click'] as $v): ?>
                                                { x: new Date(<?=$v['date']?>),  y: <?=$v['clicks']?> },
                                                <?php endforeach ?>
                                    		]
                                    	}]
                                    };
                                    
                                    $("#chart<?=$ad['id']?>").CanvasJSChart(options);
                                    
                                    function toggleDataSeries(e) {
                                    	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                    		e.dataSeries.visible = false;
                                    	} else {
                                    		e.dataSeries.visible = true;
                                    	}
                                    	e.chart.render();
                                    }
                                }
                                </script>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    </div>
                    <?php else: ?>
                        <h2><?=$not_news?></h2>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>