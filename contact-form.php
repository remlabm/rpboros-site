<?php
/**
  Only change the settings below!
*/
$_username = 'rboros24@gmail.com';
$_password = 'bumblebee24';
$_subject = 'Borosinc.com Message';
$_email = 'rboros24@gmail.com';

$msgs['form']['ok'] = "Thank you! I will be in contact shortly!";
$msgs['form']['bad'] = "Sorry! There was an error in your message!";

$msgs['contact-user-name']['bad'] = "Invalid Name!";
$msgs['contact-user-email']['bad'] = "Invalid Email Address!";
$msgs['contact-message']['bad'] = "Invalid Message!";


/*****************************************************************************
 *****************************************************************************
 *****************************************************************************
 *****************************************************************************
 *****************************************************************************
 *******************  DONT TOUCH ANYTHIGN BELOW THIS!  ***********************
 *****************************************************************************
 *****************************************************************************
 *****************************************************************************
 *****************************************************************************
 *****************************************************************************
 */

require_once '../../../library/Swift-4.1.7/lib/swift_required.php';
//contact-user-name=test&contact-user-email=test%40t43st.com&contact-message=test123
try{

  $r['info'] = array();
  foreach($_POST as $k => $v){
    unset($i);

    if(preg_match('/name$/', $k)){
      $i['bad'] = !preg_match('/[\w\-\s]{3,50}/i', $v);
    }else if(preg_match('/email$/', $k)){
      $i['bad'] = !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $v);
    }else if(preg_match('/message$/', $k)){
      $i['bad'] = !preg_match('/[\w\-\s]{10,400}/i', $v);
    }else{
      $i['bad'] = 'true';
      unset($_POST[$k]);
    }
    
    if($i['bad']){
      $i['id'] = $k;
      $f = true;
      $i['msg'] = $msgs[$k]['bad'];
      $r['info'][] = $i;
    }
    
  }

  if($f){
    throw new Exception($msgs['form']['bad']);
  }
	try{
		
	  $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
	    ->setUsername('remlabm@gmail.com')
	    ->setPassword('');
	
	  $mailer = Swift_Mailer::newInstance($transport);
	
	  // Create the message
	  $message = Swift_Message::newInstance()
				    ->setSubject($_subject)
				    ->setFrom(array($_POST['contact-user-email'] => $_POST['contact-user-name']))
				    ->setTo(array($_email => $_name))
				    ->setBody($_POST['contact-message']);
	
	
	  $numSent = $mailer->send($message);
	}catch(Exception $e){
		throw new Exception('Unable to send your message at this time!');
	}

  $r['status'] = 'ok';
  $r['msg'] = $msg['form']['ok'];
}catch(Exception $e){
  $r['status'] = 'err';
  $r['msg'] = $e->getMessage();
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($r);

