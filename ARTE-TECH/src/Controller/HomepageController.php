<?php
// src/Controller/HomepageController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomepageController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index() {
        $user = $this->getUser()->getRole();

        if($user == "ROLE_MANAGER") {
            $response = $this->forward('App\Controller\ManagerController::index');

        } elseif($user == "ROLE_CUSTOMER") {
            $response = $this->forward('App\Controller\FrontendController::index');
        } else {
            dd('no_access_right');
        }
        return $response;
        // return $this->render('base.html.twig');
    }
    
}