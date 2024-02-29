<?php
// Contact Form Settings
$to_mail = $_POST['contact_email'];

$email_Addr = "
	<?php
		\$recipient = '$to_mail';
	?>
";