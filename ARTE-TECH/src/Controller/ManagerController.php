<?php

namespace App\Controller;

use App\Entity\Timesheet;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/manager", name="manager")
     */
    public function index()
    {
        $timesheets = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->findAll();

        $employees = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy(['role' => 'ROLE_EMPLOYEE']);

        $customers = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy(['role' => 'ROLE_CUSTOMER']);

        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
            'timesheets' => $timesheets,
            'employees' => $employees,
            'customers' => $customers,
        ]);
    }
   

}
