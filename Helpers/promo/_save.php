<?php
$return = [];

if( isset($_POST['data']) && $_POST['data'] != '' ) 
{
	if( isset($_POST['data']['delete']) ) 
	{
		$exfile = fopen("site.json", "w");
		fwrite($exfile, '{}');
		fclose($exfile);
	} else 
	{
		$exfile = fopen("site.json", "w");
		fwrite($exfile, json_encode($_POST['data']));
		fclose($exfile);
	}

	$return['responseCode'] = 1;
	$return['responseHTML'] = '<p>The site was saved successfully!</p>';

} else 
{
	$return['responseCode'] = 0;
	$return['responseHTML'] = '<h5>Oops!</h5> <p>Something went wrong and the site could not be saved :(</p>';
}
echo json_encode($return);