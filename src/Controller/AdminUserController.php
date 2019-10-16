<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use App\Service\Pagination;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * Permet d'afficher la gestion des utilsateurs
     * 
     * @Route("/admin/users/{page<\d+>?1}", name="admin_users_index")
     */
    public function index(UserRepository $repo, $page, Pagination $pagination)
    {
        $pagination->setEntityClass(User::class)
                   ->setLimit(5)
                   ->setPage($page);

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     *
     * @Route("/admin/users/{id}/edit", name="admin_users_edit")
     * 
     * @return Response
     */
    public function editUser(User $user, Request $request, ObjectManager $manager) {
        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modification du profil de <strong>{$user->getFullName()} ont bien été enregistrées."
            );
            return $this->redirectToRoute("admin_users_index");
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un utilisateur
     *
     * @Route("/admin/users/{id}/delete", name="admin_users_delete")
     * 
     * @param User $user
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(User $user, ObjectManager $manager) {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'utililsateur a bien été supprimé."
        );

        return $this->redirectToRoute("admin_users_index");
    }
}
