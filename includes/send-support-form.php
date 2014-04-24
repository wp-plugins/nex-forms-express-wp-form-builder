<?php
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-Type: text/html; charset=utf-8\n\n'. "\r\n";
$headers .= 'From: NEX Forms Admin <'.$_POST['email'].'>' . "\r\n";

$body .= 'Name: '.$_POST['_name'].'<br />';
$body .= 'Email: '.$_POST['email'].'<br />';
$body .= 'Username: '.$_POST['username'].'<br />';
$body .= 'Password: '.$_POST['password'].'<br />';
$body .= 'Admin link: '.$_POST['admin_link'].'<br />';
$body .= 'Test Link: '.$_POST['test_link'].'<br />';
$body .= 'Query:<br> '.$_POST['query'].'<br />';

mail('support@basixonline.net','NEX-FORMS Support',$body,$headers);
?>