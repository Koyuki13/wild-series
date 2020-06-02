<?php
// src/Controller/ActorController.php
namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @param Actor $actor
     * @return Response
     * @Route ("/actor/{id}", name="show_actor")
     */
    public function show(Actor $actor): Response
    {

        return $this->render('actor/show.html.twig', array(
            'actor' => $actor,
        ));
    }
}