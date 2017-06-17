<?php
function readMail() {

    $dns = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
    $email = "joelcroft658@gmail.com";
    $password = "demopapu";

    $openmail = imap_open($dns,$email,$password ) or die("Cannot Connect ".imap_last_error());
    if ($openmail) {

        echo  "You have ".imap_num_msg($openmail). " messages in your inbox <br><br><br>";

        for($i=1; $i <= 100; $i++) {

            $header = imap_header($openmail,$i);
            echo "";
            echo $header->Subject." (".$header->Date.")";
			echo $msg."<br>----------------<br>";
        }

        $msg = imap_fetchbody($openmail,1,"","FT_PEEK");

        /*
        $msgBody = imap_fetchbody ($openmail, $i, "2.1");
        if ($msgBody == "") {
           $portNo = "2.1";
           $msgBody = imap_fetchbody ($openmail, $i, $portNo);
        }

        $msgBody = trim(substr(quoted_printable_decode($msgBody), 0, 200));

        */
       
        imap_close($openmail);
        
    } else {

        echo "Failed reading messages!!";

    }

}
readMail();
?>