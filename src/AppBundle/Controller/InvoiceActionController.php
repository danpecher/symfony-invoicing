<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Invoice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceActionController extends Controller
{
    /**
     * @Route("/invoice/{id}/paid", name="invoice.paid")
     */
    public function setPaidAction($id)
    {
        $invoice = $this->findInvoice($id);
        $invoice->setPaid(true);

        return $this->saveAndReturn($invoice);
    }

    /**
     * @Route("/invoice/{id}/cancel", name="invoice.cancel")
     */
    public function setCancelledAction($id)
    {
        $invoice = $this->findInvoice($id);
        $invoice->setCancelled(true);

        return $this->saveAndReturn($invoice);
    }

    /**
     * @Route("/invoice/{id}/send", name="invoice.send")
     */
    public function sendAction($id)
    {
        $invoice = $this->findInvoice($id);

        // send email here
        // ...

        $invoice->setSent(true);

        return $this->saveAndReturn($invoice);
    }

    private function saveAndReturn($invoice)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($invoice);
        $em->flush();

        return $this->redirectToRoute('invoice.detail', ['id' => $invoice->getId()]);
    }

    private function findInvoice($id)
    {
        $invoice = $this->getDoctrine()->getRepository(Invoice::class)
                        ->find($id);
        if ( ! $invoice) {
            throw $this->createNotFoundException();
        }

        return $invoice;
    }
}