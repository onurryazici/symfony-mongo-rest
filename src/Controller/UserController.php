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
        $users  = $this->documentManager->getRepository(User::class)->findAll();
        $index  = 0;
        $result = [];
        foreach($users as $user){
            $result[$index]['id']        = (string)$user->getId();
            $result[$index]['username']  = $user->getUsername();
            $result[$index]['phone']     = $user->getPhone();
            $result[$index]['email']     = $user->getEmail();
            $result[$index]['address']   = $user->getAddress();
            $result[$index]['createdAt'] = $user->getCreatedAt();
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
            $phone    = $request->request->get('phone');
            $email    = $request->request->get('email');
            $address  = $request->request->get('address');

            $user = new User();
            $user->setUsername($username);
            $user->setUsername($username);
            $user->setPhone($phone);
            $user->setEmail($email);
            $user->setAddress($address);
            $user->setCreatedAt(new \DateTime());
            
            $this->documentManager->persist($user);
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
        $targetUser = $this->documentManager->getRepository(User::class)->findOneByProperty('_id',$id);
        if(!$targetUser instanceof User){
            throw new NotFoundHttpException(
                sprintf('There is no such user with this id : [%s] ', $id)
            );
        }
        
        $targetUser->setUsername($request->request->get('username'));
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