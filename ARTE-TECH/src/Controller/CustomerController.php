<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", name="customers")
     */
    public function index()
    {

        $customers = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy([
            'role' => "ROLE_CUSTOMER",
        ]);
        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
        ]);
    }
    
    /**
     * @Route("/customers/create", name="create_customer")
     */
    public function create()
    {
        
        return $this->render('customer/create.html.twig');
    }
    /**
     * @Route("/customers/create/post", name="post_customer")
     */
    public function post(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $customer = new User();
        $customer->setName($request->request->get('name'));
        $customer->setEmail($request->request->get('email'));
        $customer->setPassword($request->request->get('password'));
        $customer->setHourlyRate($request->request->get('hourly_rate'));
        $customer->setIsSubtractor(false);
        $customer->setRole('ROLE_CUSTOMER');
        $entityManager->persist($customer);
        $entityManager->flush();
        
        $customers = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy([
            'role' => "ROLE_CUSTOMER",
        ]);
        return $this->render('customer/index.html.twig', [
            'customers' => $customers
        ]);
    }

    /**
     * @Route("/customers/{id}/edit", name="edit_customer")
     */
    public function edit($id) {

        $customer = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id);
        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
        ]);
    }


    /**
     * @Route("/customers/{id}/update", name="update_customer")
     */
    public function update(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getmanager();
        $customer = $entityManager->getRepository(User::class)->find($id);

        $customer->setName($request->request->get('name'));
        
        // DateTimeInterface error
        // $timesheet->setStartDate($request->request->get('startDate'));
        // $timesheet->setEndDate($request->request->get('endDate'));
        $customer->setHourlyRate($request->request->get('hourly_rate'));
        $customer->setEmail($request->request->get('email'));
        $entityManager->flush();


        $customers = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy([
            'role' => "ROLE_CUSTOMER",
        ]);

        return $this->redirectToRoute('customers', ['customers' => $customers]);

    }
    
    /**
     * @Route("/customers/{id}/delete", name="delete_customer")
     */
    public function delete($id) {

        $entityManager = $this->getDoctrine()->getmanager();
        $customer = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->redirectToRoute('customers');
        
    }
}
