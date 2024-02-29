<?php
// Fox Builder Mail Campaign API

$export_type = $_POST['export_type'];
$fox_b_cm_apikey = $_POST['cm_api_key'];
$fox_b_cm_listid = $_POST['cm_list_id'];
$fox_b_mc_apikey = $_POST['mailchimp_api_key'];
$fox_b_mc_listid = $_POST['mailchimp_api_listid'];
$fox_b_gr_apikey = $_POST['getresponse_api_key'];
$fox_b_gr_campaign = $_POST['getresponse_campaign_token'];
$fox_b_active_url = $_POST['ac_api_url'];
$fox_b_active_api_key = $_POST['ac_api_key'];
$fox_b_active_list_id = $_POST['ac_api_listid'];
$fox_b_aw_listname = $_POST['aweber_list_name'];
$fox_b_mailerlite_api_key = $_POST['ml_api_key'];
$fox_b_mailerlite_group_id = $_POST['ml_groupid'];

$mailConfigData = "<?php

    \$export_mail_type = '$export_type';

    /* AWeber List Name. 
    Get AWeber List Name from https://www.aweber.com/users/autoresponder/manage
    */

    define('aweber_list_name','$fox_b_aw_listname');

    /* ActiveCampaign API URL, API KEY and List ID. 
    Get API URL, API KEY and list id from go to http://www.activecampaign.com/ > My Settings > Developers
    */

    define('ac_api_url','$fox_b_active_url');
    define('ac_api_key','$fox_b_active_api_key');
    define('ac_api_listid','$fox_b_active_list_id');


    /* Campaign Monitor API key and List ID. 
    Get CM API KEY from https://your-username.createsend.com/admin/account/
    Get CM List ID from https://www.campaignmonitor.com/api/getting-started/#listid
    */

    define('cm_api_key', '$fox_b_cm_apikey');
    define('cm_list_id', '$fox_b_cm_listid');

    /* GetResponse API key and Campaign Token. 
    Get GetResponse API KEY from https://app.getresponse.com/my_api_key.html
    Get GetResponse Campaign Token from https://app.getresponse.com/campaign_list.html
    */

    define('getresponse_api_key','$fox_b_gr_apikey'); 
    define('getresponse_campaign_token','$fox_b_gr_campaign'); 

    /* Mailchimp API key and List ID. 
    Get Mailchimp API key from http://admin.mailchimp.com/account/api
    Get Mailchimp List ID from http://admin.mailchimp.com/lists/
    */

    define('mailchimp_api_key', '$fox_b_mc_apikey'); 
    define('mailchimp_api_listid', '$fox_b_mc_listid');

    /* MailerLite API KEY &amp; GROUP ID
    Get API KEY and GROUP ID from go to https://app.mailerlite.com/integrations/api/
    */

    define('ml_api_key','$fox_b_mailerlite_api_key');
    define('ml_groupid','$fox_b_mailerlite_group_id');

    ?>";