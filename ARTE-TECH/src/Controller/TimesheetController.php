<?php

namespace App\Controller;
use App\Entity\Timesheet;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
    * @Route("/timesheets/{id}", name="view_timesheet")
    */
    public function getById($id)
    {
        


        $timesheets = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->findBy([
            'id' => $id,
        ]);

        $employee = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy([
            'role' => 'ROLE_EMPLOYEE'
        ]);

        return $this->render('manager/index.html.twig', [
            'employee' => $employee,
            'timesheets' => $timesheets
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

    /**
     * @Route("/timesheets/{id}/download", name="download_timesheet")
     */
    public function download($id) {
        $timesheet = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->find($id);
        // dd($timesheet);

        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Werknemer');
        $sheet->setCellValue('A2', $timesheet->getEmployeeId());
        
        $sheet->setCellValue('B1', 'Klant');
        $sheet->setCellValue('B2', $timesheet->getCustomerId());
        
        $sheet->setCellValue('C1', 'Start datum');
        $sheet->setCellValue('C2', $timesheet->getStartDate());
        
        $sheet->setCellValue('D1', 'Eind datum');
        $sheet->setCellValue('D2', $timesheet->getEndDate());
        
        $sheet->setCellValue('E1', 'Pauze (min)');
        $sheet->setCellValue('E2', $timesheet->getPauze());
        
        $sheet->setCellValue('F1', 'Activiteiten');
        $sheet->setCellValue('F2', $timesheet->getActivities());
        
        $sheet->setCellValue('G1', 'Martiaal');
        $sheet->setCellValue('G2', $timesheet->getMaterials());
        
        $sheet->setCellValue('H1', 'Uur tarief');
        $sheet->setCellValue('H2', $timesheet->getHourlyRate());
        
        $sheet->setCellValue('I1', 'transport kosten');
        $sheet->setCellValue('I2', $timesheet->getTransportCost());
        // $timesheet->getEmployeeId()

        $writer = new Xlsx($spreadsheet);

        
        $writer->save("timesheets/timesheet-" . $timesheet->getId() . '.xlsx');

        // dd($spreadsheet);

        $timesheets = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->findAll();

        // dd($timesheet->getId() . '.xlsx');
        return $this->redirect("/timesheets/timesheet-" . $timesheet->getId() . '.xlsx');
        // return $this->redirectToRoute('manager', ['timesheets' => $timesheets]);
    }
}
