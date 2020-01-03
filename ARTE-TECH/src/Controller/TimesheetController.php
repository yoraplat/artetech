<?php

namespace App\Controller;
use App\Entity\Timesheet;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TimesheetController extends AbstractController
{
    /**
     * @Route("/timesheets", name="timesheet")
     */
    public function index()
    {
        return $this->render('timesheet/index.html.twig', [
            'controller_name' => 'TimesheetController',
        ]);
    }

    /**
     * @Route("/timesheets/{id}/edit", name="edit_timesheet")
     */
    public function editTimesheet($id)
    {
        $timesheet = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->find($id);

        return $this->render('timesheet/edit.html.twig', [
            'timesheet' => $timesheet,
        ]);
    }
   
    /**
     * @Route("/timesheets/{id}/update", name="update_timesheet")
     */
    public function updateTimesheet(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getmanager();
        $timesheet = $entityManager->getRepository(Timesheet::class)->find($id);

        $timesheet->setRateId($request->request->get('rate'));
        
        // DateTimeInterface error
        // $timesheet->setStartDate($request->request->get('startDate'));
        // $timesheet->setEndDate($request->request->get('endDate'));
        $timesheet->setPauze($request->request->get('pauze'));
        $timesheet->setActivities($request->request->get('activities'));
        $timesheet->setMaterials($request->request->get('materials'));
        $timesheet->setHourlyRate($request->request->get('hourlyRate'));
        $timesheet->setTransportCost($request->request->get('transportCost'));
        $entityManager->flush();


        $timesheets = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->findAll();

        return $this->redirectToRoute('manager', ['timesheets' => $timesheets]);

    }

    /**
     * @Route("/timesheets/new", name="create_timesheet")
     */
    public function createTimesheet() {

        return $this->render('timesheet/new.html.twig');
    }
}
