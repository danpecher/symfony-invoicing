<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Form\ClientForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ClientController extends Controller
{
    /**
     * @Route("/clients", name="clients")
     */
    public function indexAction()
    {
        $clients = $this->getDoctrine()->getRepository(Client::class)
            ->findAll();
        return $this->render('client/index.html.twig', [
            'clients' => $clients
        ]);
    }

    /**
     * @Route("/client/{id}", name="client.detail", requirements={"id": "\d+"})
     */
    public function detailAction($id)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)
            ->find($id);
        if (!$client) {
            throw $this->createNotFoundException();
        }

        return $this->render('client/detail.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/clients/new", name="client.new")
     * @Method("GET")
     */
    public function newAction()
    {
        return $this->render('client/new.html.twig', [
            'form' => $this->createForm(ClientForm::class)->createView()
        ]);
    }

    /**
     * @Route("/clients/new", name="client.create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(ClientForm::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $client = $form->getData();
            $em     = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('clients');
        }

        return $this->render('client/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/clients/{id}/edit", name="client.edit")
     * @Method("GET")
     */
    public function editAction($id, Request $request)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)
            ->find($id);
        if (!$client) {
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(ClientForm::class, $client);
        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/clients/{id}/edit", name="client.update")
     * @Method("POST")
     */
    public function updateAction($id, Request $request)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)
            ->find($id);
        if (!$client) {
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(ClientForm::class, $client);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $client = $form->getData();
            $em     = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('clients');
        }

        return $this->render('client/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     * @Route("/clients/{id}/delete", name="client.delete", requirements={"id": "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)
                       ->find($id);
        if (!$client) {
            throw $this->createNotFoundException();
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        return $this->redirectToRoute('clients');
    }

}