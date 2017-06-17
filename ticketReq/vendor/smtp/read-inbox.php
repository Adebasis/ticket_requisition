<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PHP get the unread emails from Gmail Inbox using PHP</title><meta name="google-site-verification" content="liGddaK7I8_x0tSdKv36CRi_rMfRt3yMNjILkbOAxxY" /><link href='http://feeds2.feedburner.com/webinfopedia' rel='alternate' title='Webinfopedia-Learn SEO, Web Designing and Web development easily with example and demos' type='application/rss+xml'/><meta name="msvalidate.01" content="1CBFD6FA96646CD69CE09C869B2F6313" /><META name="y_key" content="2e447c925218040f" /><link rel="search" type="application/opensearchdescription+xml" href="http://www.webinfopedia.com/classes/opensearch.xml" title="SEO,PHP and Ajax blog" /> <meta content="php gmail, gmail, php gmail smtp, php mail gmail, gmail php mail, gmail lite, php gamil, get emails, gmail email fetch, php gmail API, Gmail PHP fetch, Gmail php api, how to php gmail, how to gmail php" name="keywords"  /><meta name="author" content="webinfopedia" /><meta name="copyright" content="webinfopedia.com" /><meta name="Robots" content="index, follow" /><meta name="language" content="English" /><link rel="shortcut icon" href="http://www.webinfopedia.com/images/webinfopedia-fav.png"  /><script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22897853-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();</script>
<style type="text/css">body,td,th {	font-family: Georgia,"Times New Roman",Times,serif;;	font-size: 12px;	color: #333;}body {	margin-left: 0px;	margin-top: 30px;	margin-right: 0px;	margin-bottom: 0px;}.maindiv{ width:690px; margin:0 auto; padding:20px; background:#CCC;}.innerbg{ padding:6px; background:#FFF;}.links{ font-weight:bold; color:#c24f00; text-decoration:none; font-size:12px;}a{ text-decoration:none; outline:none;}.newsli li{ padding:4px 0px;}.info{ font-size:10px; color:#666;}</style></head>
<body><div>  <h1 style="color:#666;">Get Emails from Gmail in PHP. <a href="http://www.webinfopedia.com/get-emails-from-gmail-using-php.html" style="color:#EEDDCA; text-decoration:none; font-size:18px;">http://www.webinfopedia.com/get-emails-from-gmail-using-php.html</a></h1></div>  <div style="width:730px; margin:0 auto;">  </div><div class="maindiv">
<div class="innerbg">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td align="left" valign="middle" bgcolor="#008000"><div style="margin:0px 10px; font-weight:bold; color:#FFF; font-size:16px;">How to get emails from Gmail Inbox in PHP</div></td>
    </tr>
  <tr>
    <td align="center" valign="middle">
    <form method="post">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="5" align="left" class="info">We will not save your username or password. This is a just demo. If you don't want to enter login details you can download the example file and workout your own.</label></td>
    </tr>
  <tr>
    <td width="15%">Username</td>
    <td width="27%"><label for="username"></label>
      <input name="username" type="text" id="username" /></td>
    <td width="10%">Password</td>
    <td width="25%"><label for="password"></label>
      <input name="password" type="password" id="password" /></td>
    <td width="23%"><input type="submit" name="getgmails" id="getgmails" value="Get Gmail" /></td>
  </tr>
  <tr>
    <td colspan="5">
    <div class="newsli">
<?php
if(isset($_POST['getgmails']))
{
//fucntion to get unread emails taking username and password as parametes
function check_email($username, $password)
{ 
    //url to connect to
    $url = "https://mail.google.com/mail/feed/atom";
	 

    // sendRequest 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    $curlData = curl_exec($curl);
    curl_close($curl);
	
    //returning retrieved feed
    return $curlData;
}

//making page to behave like xml document to show feeds
//header('Content-Type:text/html; charset=UTF-8');
//calling function
$feed = check_email($_POST['username'], $_POST['password']);
	$x = new SimpleXmlElement($feed);
	echo "<ul>";
	foreach($x->entry as $entry)
	{
		?>
		<li><p><strong class="links"><?php echo $entry->title; ?></strong><br>
			<?php echo $entry->summary; ?>
		</p></li>
		<?php
	}
	echo "</ul>";
}
?>
    </div>
    </td>
    </tr>
</table>
</form>
    </td>
    </tr>
</table>
</div>
</div>
<div style="padding:4px; text-align:right;"><h1><a href="http://www.webinfopedia.com/get-emails-from-gmail-using-php.html" style="font-weight:bold; color:#FFF; padding:4px 8px; background:#333; text-decoration:none;">Go back to tutorial</a></h1></div></body></html>