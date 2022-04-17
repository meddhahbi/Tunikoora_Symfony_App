<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class AdminController extends AbstractController
{

     /**
     * @Route("/admin_auth", name="security_admin")
     */
    public function show(): Response
    {
        return $this->render('admin/auth.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }




   
     /**
     * @Route("admin/login", name="security_login_admin")
     */
  /*  public function connexionAdmin(Request $request)
    { 

       
        return $this->render('admin/auth.html.twig');
        
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this -> redirectToRoute("app_dashboard");
         }
        
    }
*/





        /**
     * @Route("/admin", name="app_dashboard")
     */
   public function index(UsersRepository $repository): Response
    {
        
      
      //  $count = $repository->countUsers();


        return $this->render('admin/index.html.twig', [
            
        ]);
    }



    /**
     * @Route("admin/utilisateurs", name="utilisateurs")
     */
    public function userList(PaginatorInterface $paginator, Request $request){

        $users = $paginator->paginate($this->getDoctrine()->getRepository(Users::class)->findAll(),
        $request->query->getInt('page', 1),
        5
    );

        
        return $this->render('admin/users.html.twig', [
          
            'users'=>$users
        ]);
    
    }


   
      /**
     * @Route("admin/utilisateurs/modifier/{id}", name="modify_user")
     */
    public function editUser( Request $request, int $id, FlashyNotifier $flashyNotifier){

     

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(Users::class)->find($id);
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
    
       // dd($user);
       if($form->isSubmitted() && $form->isValid())
        {   
            $entityManager->persist($user);
            $entityManager->flush();
            $flashyNotifier->success('Utilisateur modifié avec succée');

            return $this -> redirectToRoute("utilisateurs");
        }
    
        return $this->render('admin/editUser.html.twig', [
            'userForm'=>$form->createView()
        ]);

    }

  
    /**
 * @Route("admin/utilisateurs/supp/{id}", name="delete_user")
 */
public function deleteProduct(int $id, FlashyNotifier $flashyNotifier): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $user = $entityManager->getRepository(Users::class)->find($id);
    $entityManager->remove($user);
    $entityManager->flush();
    $flashyNotifier->error('Utilisateur supprimé');

    return $this->redirectToRoute("utilisateurs");
}




            /**
             * @Route("admin/utilisateurs/orderName", name="order_by_name")
             */

        function orderByName(UsersRepository $repository, PaginatorInterface $paginator, Request $request){

        $users = $paginator->paginate($repository->orderByName(),
        $request->query->getInt('page', 1),
        5
        );

            
            return $this->render('admin/users.html.twig',[
                'users' => $users ]);


        }



    

        function userSearch(Request $request, UsersRepository $repository){

            $users = $this->getDoctrine()->getRepository(Users::class)->findAll();
            $studentsByMail = $repository->orderByMail();
          //  $searchForm = $this->createForm(SearchStudentType::class);



        }

}
