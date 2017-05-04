<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invoice;
use AppBundle\Form\InvoiceForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class InvoicesController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction()
    {
        $invoices = $this->getDoctrine()->getRepository(Invoice::class)->findAll();

        return $this->render('default/index.html.twig', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * @Route("/invoice/{id}", name="invoice.detail", requirements={"id": "\d+"})
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $invoice = $this->getDoctrine()->getRepository(Invoice::class)
            ->find($id);
        if (!$invoice) {
            throw $this->createNotFoundException();
        }

        return $this->render('invoices/detail.html.twig', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * @Route("/invoice/new", name="invoice.new")
     * @Method("GET")
     */
    public function newAction()
    {
        $form = $this->createForm(InvoiceForm::class, new Invoice());

        return $this->render('invoices/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/invoice/new", name="invoice.create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(InvoiceForm::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $invoice = $form->getData();
            $em      = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('invoices/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/invoice/{id}/edit", name="invoice.edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $invoice = $this->getDoctrine()->getRepository(Invoice::class)
                        ->find($id);
        if ( ! $invoice) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(InvoiceForm::class, $invoice);

        return $this->render('invoices/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/invoice/{id}/edit", name="invoice.update")
     * @Method("POST")
     */
    public function updateAction($id, Request $request)
    {
        $invoice = $this->getDoctrine()->getRepository(Invoice::class)
                        ->find($id);
        if ( ! $invoice) {
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(InvoiceForm::class, $invoice);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $invoice = $form->getData();
            $em      = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('invoice.edit', ['id' => $id]);
        }

        return $this->render('invoice/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
