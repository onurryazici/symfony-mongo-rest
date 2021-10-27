<?php
namespace App\Command;

use Doctrine\ODM\MongoDB\DocumentManager;

use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Document\Queue;


class UserRegistrationMailer extends Command{
    
    protected static $defaultName = 'app:check-new-users';
    private $container;
    private $dm;
    public function __construct(ContainerInterface $container, DocumentManager $dm){
        $this->container = $container;
        $this->dm = $dm;
        parent::__construct();
    }
    
    protected function configure() {
        $this->setName(self::$defaultName)
        ->setDescription('Shows test output')
        ->setHelp('This is help text');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo "Cron job started ... \n";
        try {
            $queues = $this->dm->getRepository(Queue::class)->findExpiredQueues();
            foreach($queues as $queue){
                if($queue instanceof Queue){
                    echo "There is a user : " . $queue->getEmail() . "\n";
                    $mail = new PHPMailer();
                    $mail->IsSmtp();
                    $mail->SMTPDebug = 2;
                    $mail->Debugoutput = 'html';
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Host = "smtp-mail.outlook.com";
                    $mail->Port = 587;

                    $mail->IsHTML(true);
                    $mail->Username = "onurr.yazici@outlook.com";
                    $mail->Password = "2306Onur++4833";
                    $mail->setFrom("onurr.yazici@outlook.com");
                    $mail->Subject = "Ornek bir konu ";
                    $mail->Body = "Ornek bir body";
                    $mail->AddAddress($queue->getEmail());
                    $mail->Send();

                    $queueControler  = $this->container->get('App\Controller\QueueController'); // Via @Service anotation on QueueController.php
                    $queueControler->delete($queue->getId());
                }
            }
        } catch (Exception $e){
            echo $e->getTrace();
        }
        echo "End of cron job worker";
        return 0;
    }
}
?>