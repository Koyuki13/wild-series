<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/category")
 *
 */
class CategoryController extends AbstractController
{
    /**
     * @Route ("/add", name="category_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(
            CategoryType::class,
            $category
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('wild_index');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
