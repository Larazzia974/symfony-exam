<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repo->findAll();
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, EntityManagerInterface $manager)
    {
        $contact = new Contact;

        $form = $this->createFormBuilder($contact)
            ->add('email')
            ->add('subject')
            ->add('message')
            ->add('save', SubmitType::class, [
                'label' => 'envoyer'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedAt(new \DateTime());

            $manager->persist($contact);
            $manager->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('default/contact.html.twig', [
            'formContact' => $form->createView()
        ]);
    }
}
