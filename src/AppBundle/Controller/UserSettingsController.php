<?php


namespace AppBundle\Controller;


use AppBundle\Form\UserSettingsForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserSettingsController extends Controller
{
    /**
     * @Route("/user", name="user")
     * @Method("GET")
     */
    public function indexAction()
    {
        $form = $this->createForm(UserSettingsForm::class, $this->getUser());
        return $this->render('user/settings.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user", name="user.update")
     * @Method("POST")
     */
    public function updateAction(Request $request)
    {
        $form = $this->createForm(UserSettingsForm::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/settings.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}