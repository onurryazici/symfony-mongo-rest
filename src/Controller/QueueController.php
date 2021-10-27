<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Implementation\IDataAccessLayer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zenstruck\ScheduleBundle\Schedule;
use PHPMailer\PHPMailer\PHPMailer;
use Zenstruck\ScheduleBundle\Schedule\Task\CommandTask;
use Doctrine\DBAL\Types\DateType;
use App\Document\Queue;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Route("/queue")
 */
class QueueController extends Controller implements IDataAccessLayer{

    private $documentManager;
    
    public function __construct(DocumentManager $documentManager){
        $this->documentManager=$documentManager;
    }
    /**
     * @Route("", methods={"GET"})
     */
    public function findAll(){
        $queues = $this->documentManager->getRepository(Queue::class)->findAll();
        $index=0;
        $result = [];
        foreach($queues as $queue){
            $result[$index]['id']= (string)$queue->getId();
            $result[$index]['email']= $queue->getEmail();
            $result[$index]['createdAt']= $queue->getCreatedAt();
            $x = $queue->getCreatedAt();
            
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
        $email     = $request->request->get('email');
        $now       = new \DateTime();
        $createdAt = $now->format('Y-m-d H:i:s');
        
        $queue = new Queue();
        $queue->setEmail($email);
        $queue->setCreatedAt($createdAt);
        
        $this->documentManager->persist($queue);
        $this->documentManager->flush();
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
        $targetQueue = $this->documentManager->getRepository(Queue::class)->findOneByProperty('_id',$id);
        if(!$targetQueue instanceof Queue){
            throw new NotFoundHttpException(
                sprintf('There is no such queue with this id : [%s] ', $id)
                );
        }
        
        $targetQueue->setEmail($request->request->get('email'));
        $targetQueue->setCreatedAt($request->request->get('createdAt'));
        
        $this->documentManager->flush();
        
        return new JsonResponse([
            'statu'=> true,
            'message'=> "Queue updated"
        ]);
        
    }
    
    /**
     * @param string $id
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        $targetQueue = $this->documentManager->getRepository(Queue::class)->findOneByProperty('_id',$id);
        if(!$targetQueue instanceof Queue){
            throw new NotFoundHttpException(
                sprintf("There is no such queue with id : [%s]", $id)
                );
        }
        
        $this->documentManager->remove($targetQueue);
        $this->documentManager->flush();
        
        return new JsonResponse([
            'statu'=>true,
            'message'=>$targetQueue->getId() . " successfully deleted"
        ]);
    }
    
    
}
?>