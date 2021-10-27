<?php

namespace App\Controller;

use MongoDB\BSON\UTCDateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Document\User;
use App\Document\Queue;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Implementation\IDataAccessLayer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zenstruck\ScheduleBundle\Schedule;
use PHPMailer\PHPMailer\PHPMailer;
use Zenstruck\ScheduleBundle\Schedule\Task\CommandTask;
use Doctrine\DBAL\Types\DateType;

/**
 * @Route("/user")
 */
class UserController extends Controller implements IDataAccessLayer{
    private $documentManager;

    public function __construct(DocumentManager $documentManager){
        $this->documentManager=$documentManager;
    }
    
    /**
     * @Route("", methods={"GET"})
     */
    public function findAll(){
        $users = $this->documentManager->getRepository(User::class)->findAll();
        $index=0;
        $result = [];
        foreach($users as $user){
            $result[$index]['id']= (string)$user->getId();
            $result[$index]['username']= $user->getUsername();
            $result[$index]['tc']= $user->getTc();
            $result[$index]['phone']= $user->getPhone();
            $result[$index]['email']= $user->getEmail();
            $result[$index]['address']=$user->getAddress();
            $result[$index]['createdAt']= $user->getCreatedAt();
            $index++;
            
        }
        return new JsonResponse($result);
    }
   
    /**
     * @Route("", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
            $username = $request->request->get('username');
            $tc = $request->request->get('tc');
            $phone = $request->request->get('phone');
            $email = $request->request->get('email');
            $address = $request->request->get('address');



            $user = new User();
            $user->setUsername($username);
            $user->setUsername($username);
            $user->setTc($tc);
            $user->setPhone($phone);
            $user->setEmail($email);
            $user->setAddress($address);
            $user->setCreatedAt(new \DateTime());
            
            $this->documentManager->persist($user);
            $this->documentManager->flush();
            
            $queue = new Queue();
            $queue->setEmail($user->getEmail());
            $queue->setCreatedAt($user->getCreatedAt());
            
            $this->documentManager->persist($queue);
            $this->documentManager->flush();
            
           /* $mail = new PHPMailer();
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
            $mail->Subject = "�rnek konu";
            $mail->Body = "hello";
            $mail->AddAddress("onurryazicii@gmail.com");
            $mail->Send();*/
            
            /*
            WORKING
            $mgClient = \Mailgun\Mailgun::create('53a1241e1ece6086a3fb087871742044-20ebde82-86d630ad');
            $domain = "sandboxc25137df4e4645479432c60aea5f3fd6.mailgun.org";
            $params = array(
                'from' => 'postmaster@sandboxc25137df4e4645479432c60aea5f3fd6.mailgun.org',
                'to' => 'onurr.yazici@outlook.com',
                'subject' => 'Hello',
                'text' => 'Testing some Mailgun awesomness!'
            );
            
            $result = $mgClient->messages()->send($domain, $params);*/
 
          
            return new JsonResponse([
                'status' => true,
                'message'=> "User successfully added"
            ]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @Route("/{id}", methods={"PATCH"})
     */
    public function update(Request $request, $id)
    {
        $targetUser = $this->documentManager->getRepository(User::class)->findOneByProperty('_id',$id);
        if(!$targetUser instanceof User){
            throw new NotFoundHttpException(
                sprintf('There is no such user with this id : [%s] ', $id)
            );
        }
        
        $targetUser->setUsername($request->request->get('username'));
        $targetUser->setTc($request->request->get('tc'));
        $targetUser->setEmail($request->request->get('email'));
        $targetUser->setPhone($request->request->get('phone'));
        $targetUser->setAddress($request->request->get('address'));
        
        $this->documentManager->flush();
        
        return new JsonResponse([
            'statu'=> true,
            'message'=> "User updated"
        ]);
        
    }
    
    /**
     * @param Request $request
     * @param string $id
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        $targetUser = $this->documentManager->getRepository(User::class)->findOneByProperty('_id',$id);
        if(!$targetUser instanceof User){
            throw new NotFoundHttpException(
                sprintf("There is no such user with id : [%s]", $id)    
            );
        }
        
        $this->documentManager->remove($targetUser);
        $this->documentManager->flush();
        
        return new JsonResponse([
            'statu'=>true,
            'message'=>$targetUser->getId() . " successfully deleted"
        ]);
    }


}
?>