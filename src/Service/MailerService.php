<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    private $mailer;
    private $admin_email;

    public function __construct( MailerInterface $mailer, string $admin_email)
    {
        $this->mailer = $mailer;
        $this->admin_email = $admin_email;
    }

    public function sendEmailToAdmin(string $from, string $fromFirstName, string $fromLastname, string $subject, string $content): bool
    {
        $email = (new Email())
            ->from($from)
            ->to($this->admin_email)
            ->subject('Love my bugs : ' . $subject)
            ->html(
                '<p><strong>Sent by:</strong> '.  $fromFirstName. ' '. $fromLastname . ' - ' . $from . '<p>' .
                '<p><strong>Subject:</strong> '. $subject . ' </p>' .
                '<p><strong>Content:</strong> '. $content . ' </p>'
            );
       try{ 
         $this->mailer->send($email);
        }catch(TransportExceptionInterface $e){
        
       }
        return true;
    }
}
