<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Timesheet;
use App\Entity\User;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FrontendController extends AbstractController
{
    /**
     * @Route("/dashboard", name="frontend_dashboard")
     */
    public function index()
    {
        $user = $this->getUser()->getId();

        $timesheets = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->findBy([
            'customer_id' => $user,
        ]);

        $employees = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy(['role' => 'ROLE_EMPLOYEE']);

        return $this->render('frontend/index.html.twig', [
            'timesheets' => $timesheets,
            'employees' => $employees,
        ]);
    }

    /**
     * @Route("/home/{id}/download", name="download_timesheet_frontend")
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
    
    /**
     * @Route("/home/{id}/accept", name="timesheet_approve_frontend")
     */
    public function accept($id) {

        $entityManager = $this->getDoctrine()->getmanager();
        $timesheet = $entityManager->getRepository(Timesheet::class)->find($id);

        $timesheet->setIsAccepted(true);
        $entityManager->flush();

        $user = $this->getUser()->getId();

        $timesheets = $this->getDoctrine()
        ->getRepository(Timesheet::class)
        ->findBy([
            'customer_id' => $user,
        ]);

        $employees = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy(['role' => 'ROLE_EMPLOYEE']);

        return $this->render('frontend/index.html.twig', [
            'timesheets' => $timesheets,
            'employees' => $employees,
        ]);

    }
}
