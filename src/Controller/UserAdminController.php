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
<<<<<<< HEAD
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

=======
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
>>>>>>> d34d4597b11bc954348de578e62551ec5dda01d1

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
<<<<<<< HEAD
    public function create(Request $request, UserPasswordHasherInterface $encoder)
=======
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
>>>>>>> d34d4597b11bc954348de578e62551ec5dda01d1
    {
        $notification = null;

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

<<<<<<< HEAD
            $search_email = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            //dd($search_email);

            if(!$search_email) {
                $password = $encoder->hashPassword($user, $user->getPassword());
=======
            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if(!$search_email) {
                $password = $encoder->encodePassword($user, $user->getPassword());
>>>>>>> d34d4597b11bc954348de578e62551ec5dda01d1
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
<<<<<<< HEAD
    public function update(UserRepository $userRepository, $id, Request $request, UserPasswordHasherInterface $encoder): Response
=======
    public function update(UserRepository $userRepository, $id, Request $request, UserPasswordEncoderInterface $encoder): Response
>>>>>>> d34d4597b11bc954348de578e62551ec5dda01d1
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

<<<<<<< HEAD
            $password = $encoder->hashPassword($user, $user->getPassword());
=======
            $password = $encoder->encodePassword($user, $user->getPassword());
>>>>>>> d34d4597b11bc954348de578e62551ec5dda01d1
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
