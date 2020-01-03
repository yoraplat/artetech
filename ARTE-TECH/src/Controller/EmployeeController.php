<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Timesheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee", name="employee")
     */
    public function index()
    {
        return $this->render('employee/index.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }

    
    /**
    * @Route("/employee/{id}", name="view_employee")
    */
    public function getById($id)
    {
        $employee = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy([
            'id' => $id,
            'role' => 'ROLE_EMPLOYEE'
        ]);


        $timesheets = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->findBy([
            'employee_id' => $id,
        ]);

        return $this->render('employee/view.html.twig', [
            'employee' => $employee,
            'timesheets' => $timesheets
        ]);
    }
}
