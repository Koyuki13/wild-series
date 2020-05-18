<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
   /**
    * @Route("/wild", name="wild_index")
    */
    public function index() : Response
    {
        return $this->render('Wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/wild/show/{slug}", requirements={"slug"="[0-9a-z-]+"}, name="wild_show")
     */
    public function show(string $slug = 'aucune série selectionner'): Response
    {
        $slug = str_replace('-',' ', $slug);
        $slug = ucwords($slug);

        return $this->render('Wild/show.html.twig', ['slug' => $slug]);

    }
}