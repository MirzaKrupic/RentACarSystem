<?php
require_once  dirname(__FILE__).'/../config.php';
require_once  dirname(__FILE__).'/../../vendor/autoload.php';

class SMTPClient {

private $mailer;
  public function __construct(){
    // Create the Transport
    $transport = (new Swift_SmtpTransport(Config::SMTP_HOST, Config::SMTP_PORT, 'ssl'))
      ->setUsername(Config::SMTP_USER)
      ->setPassword(Config::SMTP_PASSWORD)
    ;

    // Create the Mailer using your created Transport
    $this->mailer = new Swift_Mailer($transport);
  }

  public function send_register_user_token($user){
    try {
        // Create a message
        $message = (new Swift_Message('Confirm your account'))
          ->setFrom(['mirza.krupic@stu.ibu.edu.ba' => 'Rent a car'])
          ->setTo([$user['mail']])
          ->setBody('Here is the confirmation link: http://localhost/rentacarsystem/api/users/confirm/'.$user['token'])
          ->setContentType('text/html')
        ;

        // Send the message
        $this->mailer->send($message);
    } catch(Exception $e) {
        echo $e->getMessage();
    }
  }


}

?>
