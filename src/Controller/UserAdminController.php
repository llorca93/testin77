<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
    *@Route("/admin/user", name="admin_user")
    */
    public function index(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        

        return $this->render('admin/user.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     *@Route("/admin/user/create", name="admin_user_create")
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $notification = null;

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if(!$search_email) {
                $password = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $notification = "Votre inscription s'est correctement déroulée, vous pouvez dès à présent vous connecter à votre compte.";
                return $this->redirectToRoute('admin_user');

            } else {
                $notification = "L'email que vous avez renseigné existe déjà.";
            }
        }

        return $this->render('admin/userForm.html.twig', [
            'userForm' => $form->createView(),
            'notification' => $notification 
        ]);
    }

    /**
    *@Route("/admin/user/update/{id}", name="admin_user_update")
    */
    public function update(UserRepository $userRepository, $id, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'L\'utilisateur a été bien modifié');
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/userForm.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     */
    public function deleteUser (UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute('admin_user');
    }
}
