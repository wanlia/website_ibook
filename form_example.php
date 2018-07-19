<? include("head.php"); ?>

<!--
	Free PHP Mail Form v2 - Secure single-page PHP mail form for your website
	Copyright (c) Jem Turner 2007, 2008

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	To read the GNU General Public License, see http://www.gnu.org/licenses/.
-->

<?php
// OPTIONS - PLEASE CONFIGURE THESE BEFORE USE!

$yourEmail = "YOU@YOURWEBSITE.COM"; // the email address you wish to receive these mails through
$yourWebsite = "WEBSITE NAME"; // the name of your website
$maxPoints = 4; // max points a person can hit before it refuses to submit - recommend 4


function isBot() {
	$bots = array("Indy", "Blaiz", "Java", "libwww-perl", "Python", "OutfoxBot", "User-Agent", "PycURL", "AlphaServer", "T8Abot", "Syntryx", "WinHttp", "WebBandit", "nicebot");
	$isBot = false;

	foreach ($bots as $bot)
	if (strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false)
		$isBot = true;

	if (empty($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT'] == " ")
		$isBot = true;

	return $isBot;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isBot())
		exit("Bots not allowed.</p>");

	function clean($data) {
		$data = trim(stripslashes(strip_tags($data)));
		return $data;
	}

	// lets check a few things - not enough to trigger an error on their own, but worth assigning a spam score..
	// score quickly adds up therefore allowing genuine users with 'accidental' score through but cutting out real spam :)
	$points = (int)0;

	$badwords = array("adult", "beastial", "bestial", "blowjob", "clit", "cum", "cunilingus", "cunillingus", "cunnilingus", "cunt", "ejaculate", "fag", "felatio", "fellatio", "fuck", "fuk", "fuks", "gangbang", "gangbanged", "gangbangs", "hotsex", "hardcode", "jism", "jiz", "orgasim", "orgasims", "orgasm", "orgasms", "phonesex", "phuk", "phuq", "porn", "pussies", "pussy", "spunk", "xxx", "viagra", "phentermine", "tramadol", "adipex", "advai", "alprazolam", "ambien", "ambian", "amoxicillin", "antivert", "blackjack", "backgammon", "texas", "holdem", "poker", "carisoprodol", "ciara", "ciprofloxacin", "debt", "dating", "porn", "link=", "voyeur");
	$exploits = array("content-type", "bcc:", "cc:", "document.cookie", "onclick", "onload", "javascript");

	foreach ($badwords as $word)
		if (strpos($_POST['comments'], $word) !== false)
			$points += 2;

	foreach ($exploits as $exploit)
		if (strpos($_POST['comments'], $exploit) !== false)
			$points += 2;

	if (strpos($_POST['comments'], "http://") === true || strpos($_POST['comments'], "www.") === true)
		$points += 2;
	elseif (isset($_POST['nojs']))
		$points += 1;
	elseif (preg_match("/(<.*>)/i", $_POST['comments']))
		$points += 2;
	elseif (strlen($_POST['name']) < 3)
		$points += 1;
	elseif (strlen($_POST['comments']) < 15 || strlen($_POST['comments'] > 1500))
		$points += 2;
	// end score assignments

	if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['comments'])) {
		$error_msg .= "Name, e-mail and comments are required fields. \n";
	} elseif (strlen($_POST['name']) > 15) {
		$error_msg .= "The name field is limited at 15 characters. Your first name or nickname will do! \n";
	} elseif (!ereg("^[A-Za-z' -]*$", $_POST['name'])) {
		$error_msg .= "The name field must not contain special characters. \n";
	} elseif (!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$",strtolower($_POST['email']))) {
		$error_msg .= "That is not a valid e-mail address. \n";
	} elseif (!empty($_POST['url']) && !preg_match('/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i', $_POST['url']))
		$error_msg .= "Invalid website url.";

	if ($error_msg == NULL && $points <= $maxPoints) {
		$subject = "Automatic Form Email";

		$message = "You received this e-mail message through your website: \n\n";
		foreach ($_POST as $key => $val) {
			$message .= ucwords($key) . ": $val \r\n";
		}
		$message .= 'IP: '.$_SERVER['REMOTE_ADDR']."\r\n";
		$message .= 'Browser: '.$_SERVER['HTTP_USER_AGENT']."\r\n";
		$message .= 'Points: '.$points;

		if (strstr($_SERVER['SERVER_SOFTWARE'], "Win")) {
			$headers   = "From: $yourEmail \r\n";
			$headers  .= "Reply-To: {$_POST['email']}";
		} else {
			$headers   = "From: $yourWebsite <$yourEmail> \r\n";
			$headers  .= "Reply-To: {$_POST['email']}";
		}

		if (mail($yourEmail,$subject,$message,$headers)) {
			echo '<p>Your mail was successfully sent.</p>';
		} else {
			echo '<p>Your mail could not be sent this time.</p>';
		}
	}
}
function get_data($var) {
	if (isset($_POST[$var]))
		echo htmlspecialchars($_POST[$var]);
}
if ($error_msg != NULL) {
	echo '<p><strong style="color: red;">ERROR:</strong><br />';
	echo nl2br($error_msg) . "</p>";
}
?>


<form action="mail_form_v2.php" method="post">
<noscript>
		<p><input type="hidden" name="nojs" id="nojs" /></p>
</noscript>
<p>
	<label for="name">Name:</label>
		<input type="text" name="name" id="name" value="<?php get_data("name"); ?>" /><br />

	<label for="email">E-mail:</label>
		<input type="text" name="email" id="email" value="<?php get_data("email"); ?>" /><br />

	<label for="url">Website URL:</label>
		<input type="text" name="url" id="url" value="<?php get_data("url"); ?>" /><br />

	<label for="location">Location:</label>
		<input type="text" name="location" id="location" value="<?php get_data("location"); ?>" /><br />

	<label for="comments">Comments:</label>
		<textarea name="comments" id="comments" rows="5" cols="20" class="textareaA"><?php get_data("comments"); ?></textarea><br />
</p>
<p>
	<input type="submit" name="submit" id="submit" value="Send" />
</p>
</form>


<? include("foot.php"); ?>