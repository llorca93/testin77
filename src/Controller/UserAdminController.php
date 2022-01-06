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
    *@Route("/admin/user/update-{id}", name="admin_user_update")
    */
    public function update(UserRepository $userRepository, $id, Request $request): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

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
     * @Route("/admin/user/delete-{id}", name="admin_user_delete")
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
