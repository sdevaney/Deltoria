<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
        db_connect();

	// read post from PayPal system and add 'cmd'
	$postvars = array();
	while (list ($key, $value) = each ($HTTP_POST_VARS)) {
		$postvars[] = $key;
	}
	$req = 'cmd=_notify-validate';
	for ($var = 0; $var < count ($postvars); $var++) {
		$postvar_key = $postvars[$var];
		$postvar_value = $$postvars[$var];
		$req .= "&" . $postvar_key . "=" . urlencode ($postvar_value);
	}

	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";
	$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);

	// assign posted variables to local variables
	// note: additional IPN variables also available -- see IPN documentation
	$item_name = $HTTP_POST_VARS['item_name'];
	$receiver_email = $HTTP_POST_VARS['receiver_email'];
	$item_number = $HTTP_POST_VARS['item_number'];
	$invoice = $HTTP_POST_VARS['invoice'];
	$payment_date = $HTTP_POST_VARS['payment_date'];
	$payment_status = $HTTP_POST_VARS['payment_status'];
	$pending_reason = $HTTP_POST_VARS['pending_reason'];
	$payment_gross = $HTTP_POST_VARS['payment_gross'];
	$txn_id = $HTTP_POST_VARS['txn_id'];
	$payer_email = $HTTP_POST_VARS['payer_email'];


	if (!$fp) {
		// HTTP ERROR - Unable to connect to PayPal to verify payment.
		ErrorLog($payer_email,$payment_status,$item_name,$item_number,$payment_gross,$payment_date,$pending_reason,"HTTP ERROR - Unable to connect to paypal to verify payment");
		echo "$errstr ($errno)";
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				if ($payment_status == "Completed") {
					Register_Payment($item_name);
					PaymentLog($item_name,$payer_email,$payment_status,$item_name,$item_number,$payment_gross,$payment_date,$pending_reason);
				}
			} else if (strcmp ($res, "INVALID") == 0) {
				ErrorLog($raw_item_name,$Game,$payer_email,$payment_status,$item_name,$item_number,$payment_gross,$payment_date,$pending_reason,"Unknown Error");
			}
		}
		fclose ($fp);
	}


	function PaymentLog ($raw_item_name,$Game,$payer_email,$payment_status,$item_name,$item_number,$payment_gross,$payment_date,$pending_reason) {
		$ffp = fopen("/public_html/paypal/payment_success","a");
		fwrite($ffp,"$Game --- $raw_item_name --- $payer_email --- $payment_status --- $item_name --- $item_number --- $payment_gross -- $payment_date --- $pending_reason\n");
		fclose($ffp);
	}

	function ErrorLog ($raw_item_name,$Game,$payer_email,$payment_status,$item_name,$item_number,$payment_gross,$payment_date,$pending_reason,$error) {
		$ffp = fopen("/public_html/paypal/payment_error","a");
		fwrite($ffp,"$Game --- $raw_item_name --- $payer_email --- $payment_status --- $item_name --- $item_number --- $payment_gross -- $payment_date --- $pending_reason\n$error\n\n");
		fclose($ffp);
	}

?>
