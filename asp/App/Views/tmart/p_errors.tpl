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
                        <div>
                            <a href="/errors/clearfile" class="">Clear file</a>
                            <hr />
                        </div>
                        <div style="height: 600px;overflow: auto;">
                            <?php foreach($errors as $e): ?>
                            <p><?=$e?></p>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>