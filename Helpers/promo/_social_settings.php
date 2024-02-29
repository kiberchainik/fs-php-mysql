<?php
// Social Settings
$twitter_username = $_POST['twitter_screen_name'];
$twitter_post_limit = $_POST['twitter_max_tweets'];
$insta_client_id = $_POST['insta_client_id'];
$insta_access_token = $_POST['insta_access_token'];
$insta_user_id = $_POST['insta_user_id'];
$insta_img_limit = $_POST['insta_img_limit'];
$flickr_user_id = $_POST['flickr_user_id'];
$flickr_img_limit = $_POST['flickr_img_limit'];

$socialData = "
(function($){ 'use strict';
	
	// Instafeed Active
	var feed = new Instafeed({
        get: 'user',
        clientId: '". $insta_client_id ."',
        accessToken: '". $insta_access_token ."',
        userId: '". $insta_user_id ."',
        limit: ". $insta_img_limit .",
        template: \"<a href='{{link}}' target='_blank'><img src='{{image}}' /></a>\"
	});
	feed.run();

	// Flickr feed
	$('#flickr-feed').jflickrfeed({
        limit: ". $flickr_img_limit .",
        qstrings: {
            id: '". $flickr_user_id ."'
        },
        itemTemplate: \"<div class='feed-media'>\"+
                        \"<a class='flickr-light' href='{{image}}' title='{{title}}'>\" +
                            \"<img src='{{image_s}}' alt='{{title}}' />\" +
                        \"</a>\" +
                      \"</li>\"
    }, function(data) {
        $('.flickr-light').venobox({
            numeratio: true,
            infinigall: true
        }); 
    });

    // Twitter feed
    function handleTweets(tweets) {
        
        var x = tweets.length,
        n = 0,
        element = document.getElementById('twitter-feed'),
        html = \"<div class='twitter-carousel owl-carousel'>\";
        while (n < x) {
            html += \"<div class='tweet-single'>\" + tweets[n] + '</div>';
            n++;
        }
        html += '</div>';
        
        element.innerHTML = html;
           
        /* Tweets attached to owl-carousel */
        $('.twitter-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            smartSpeed: 1000,
            dots: false,
            items: 1
        });
    }

    if( $('#twitter-feed').length ) 
    {   
        var config_feed = {
        \"profile\": {\"screenName\": '". $twitter_username ."'},
          \"domId\": 'twitter-feed',
          \"maxTweets\": ". $twitter_post_limit .",
          \"enableLinks\": true,
          \"showUser\": true,
          \"showTime\": true,
          \"dateFunction\": '',
          \"showRetweet\": false,
          \"customCallback\": handleTweets,
          \"showInteraction\": false
        };
        twitterFetcher.fetch(config_feed);
    }

})(jQuery);
";