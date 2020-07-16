<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\CommentType;
use App\Form\ProgramSearchType;
use App\Repository\CommentRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @Route("/wild")
 */
class WildController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="wild_index")
     */
    public function index() :Response
    {
        return $this->redirectToRoute('app_index', [], 301);
//        $programs = $this->getDoctrine()
//            ->getRepository(Program::class)
//            ->findAll();

//        if (!$programs) {
//            throw $this->createNotFoundException(
//                'No program found in program\'s table.'
//            );
//        }

//        return $this->render('Wild/index.html.twig', [
//            'programs' => $programs,
//        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="wild_show")
     * @return Response
     */
    public function show(
        ?string $slug = 'aucune série selectionner',
        ProgramRepository $programRepository
    ): Response{
        if(!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $programRepository->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' .$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('Wild/show.html.twig', [
            'program' => $program,
            'seasons' => $program->getSeasons(),
            'slug' => $slug
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $categoryName
     * @Route("/wild/category/{categoryName}", name="show_category")
     * @return Response
     */
    public function showByCategory(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(
                ['name' => $categoryName] // Critere
            );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                ['category' => $category],
                ['id' => 'DESC'],
                3
            );

        return $this->render('Wild/category.html.twig', [
            'programs' => $program,
        ]);
    }

    /**
     * Getting a program  from a slug passed through the url.
     *
     * @param string $slug The slugger
     * @Route("/showByProgram/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show_program")
     * @return Response
     */
    public function showByProgram(?string $slug = 'aucune saison selectionnée'): Response
    {
        if(!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' .$slug.' title.'
            );
        }

        return $this->render('Wild/showByProgram.html.twig', [
            'program' => $program,
            'slug' => $slug
        ]);
    }

    /**
     * @param int $id
     * @Route ("/showBySeason/{id}", name="show_season")
     * @return Response
     */
    public function showBySeason(
        int $id,
        SeasonRepository $seasonRepository,
        ProgramRepository $programRepository
    ): Response{
        $season = $seasonRepository->findOneBy(['id' => $id]);
        if (!$id) {
            throw $this->createNotFoundException(
                'No season with ' .$id.' identifier.'
            );
        }
        $slug = preg_replace(
            '/ /',
            '-', strtolower($season->getProgram()->getTitle())
        );

        return $this->render('Wild/showBySeason.html.twig', [
            'season' => $season,
            'program' => $season->getProgram(),
            'episodes' => $season->getEpisodes(),
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/episode/{id}", name="wild_episode")
     * @param Episode $episode
     * @param Request $request
     * @param CommentRepository $commentRepository
     * @return Response
     * IsGranted("ROLE_SUBSCRIBER")
     */
    public function showEpisode(Episode $episode, Request $request, CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy(['episode' => $episode->getId()]);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setAuthor($this->getUser());
            $comment->setEpisode($episode);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('wild_index');
        }

        $season = $episode->getSeason();
        $program = $season->getProgram();

        return $this->render('Wild/episode.html.twig',[
            'program' => $program,
            'episode' => $episode,
            'season' => $season,
            'comments' => $comments,
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }
}