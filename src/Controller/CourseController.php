<?php

namespace App\Controller;

use App\Entity\ActivityLog;
use App\Entity\Course;
use App\Entity\Schedule;
use App\Form\CourseType;
use App\Repository\ActivityLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends AbstractController{
    #[Route('/schedule/{id}/course/new', name: 'app_course_new')]
    public function new(Schedule $schedule, Request $request, EntityManagerInterface $entityManager, ActivityLogRepository $activityLogRepository): Response
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

    #[Route('/course/{id}/edit', name: 'app_course_edit')]
    public function edit(Course $course, Request $request, EntityManagerInterface $entityManager) : Response {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            return $this->redirectToRoute('app_schedules');
        }
        return $this->render('course/edit.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
        ]);
    }

    #[Route('/course/{id}/delete', name: 'app_course_delete')]
public function delete(Course $course, Request $request, EntityManagerInterface $entityManager): Response {
        $entityManager->remove($course);
        $entityManager->flush();

        return $this->redirectToRoute('app_schedules');
    }
}
