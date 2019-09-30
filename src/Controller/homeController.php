<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class homeController extends AbstractController  {
/**
 * @Route("/bonjour/{prenom}/age/{age}", name="hello")
 * @Route ("/salut", name="hello_base")
 * @Route("/bonjour/{prenom}", name="hello_prenom")
 * 
 * Montre la page qui dit bonjour
 * 
 * @return void
 */
    public function hello($prenom = "anonyme", $age = 0 ) {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
            );
    }




    /** 
     * @Route("/", name="homepage")
    */
    public function home(){
        $prenoms = ["Lior" => 31, "Kevin" => 12, "Theo" => 58];

        return $this->render(
            'home.html.twig',
            [ 'title' => "Page web de Jonathan",
                'age' => 14,
                'tableau' => $prenoms
            ]
        );
       

    }

}

?>
