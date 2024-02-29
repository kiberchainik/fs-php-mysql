<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Paypal Integration by Subroto Biswas</title>
  </head>
  <body>
      <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="subroto.bisiness@edeves.com">

        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">

        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="Hot Sauce-12oz. Bottle">
        <input type="hidden" name="amount" value="100">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="return" value="http://www.edeves.com/paypal/thank-you.php">
        <input type="hidden" name="cancel_return" value="http://edeves.com/paypal/cancle.php">
        <input type="hidden" name="notify_url" value="http://www.edeves.com/paypal/update-record.php">

        <!-- Display the payment button. -->
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png"
        alt="Buy Now">
        <img alt="" border="0" width="1" height="1"
        src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

      </form>


  </body>
</html>
