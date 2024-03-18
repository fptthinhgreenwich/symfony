<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Review;
use App\Form\ReviewType;


class ReviewController extends AbstractController
{

    /**
     * @Route("/review/all", name="review_list")
     */
    public function reviewAction()
    {
        $review = $this->getDoctrine()
            ->getRepository(Review::class)
            ->findAll();

        return $this->render('review/allreview.html.twig', [
            'review' => $review
        ]);
    }

        /**
     * Creates a new review entity.
     *
     * @Route("/review/new", methods={"GET", "POST"}, name="review_new")
     */
    public function newAction(Request $request)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            
    
        return $this->render('review/new.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }
        /**
     * @Route("/review/edit/{id}", name="review_edit")
     */
    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $review = $entityManager->getRepository(review::class)->find($id);

        $form = $this->createForm(reviewType::class, $review);
        $form->handleRequest($request);


            $entityManager->flush();

            $this->addFlash(
                'notice',
                'review Edited'
            );

        
        

        return $this->render('review/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
        /**
     * @Route("/review/delete/{id}", name="review_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $review = $em->getRepository(review::class)->find($id);
        $em->remove($review);
        $em->flush();
        
        $this->addFlash(
            'error',
            'review deleted'
        );
        
        return $this->redirectToRoute('review_list');
    }
    
}
