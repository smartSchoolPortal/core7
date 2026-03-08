<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Schedule;
use App\Form\CourseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class CourseController extends AbstractController{
    #[Route('/schedule/{id}/course/new', name: 'app_course_new')]
    public function new(Schedule $schedule, Request $request, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $course = new Course();
        $course->setSchedule($schedule);

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('app_schedules');
        }
        return $this->render('course/new.html.twig', [
            'form' => $form->createView(),
            'schedule' => $schedule,
        ]);
    }
}
