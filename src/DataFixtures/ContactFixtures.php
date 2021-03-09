<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Contact;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $contact = new Contact();
        $contact->setEmail("test@test.com")
            ->setSubject("Ceci est un test")
            ->setMessage("Un message de test, pouvant être long, ou non. Celui-ci ne l'est pas :) .")
            ->setCreatedAt(new \DateTime());

        $manager->persist($contact);
        $manager->flush();
    }
}
