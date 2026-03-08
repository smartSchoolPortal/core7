<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\ScheduleRepository;
use App\Repository\AssignementRepository;
use App\Repository\ActivityLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Course;
use App\Entity\ActivityLog;
use App\Form\CourseType;

class PortalController extends AbstractController
{
    #[Route('/portal', name: 'portal_index')]
    public function index(
        Request $request,
        CourseRepository $courseRepository,
        ScheduleRepository $scheduleRepository,
        ActivityLogRepository $activityLogRepository,
        AssignementRepository $assignementRepository
    ): Response {

        // Filter & Sort Parameter aus URL
        $department = $request->query->get('department');
        $sort = $request->query->get('sort');

        $courses = $courseRepository->findFiltered($department, $sort);

        $assignments = $assignementRepository->findAll();
        $schedules = $scheduleRepository->findAll();
        $logs = $activityLogRepository->findBy([], ['date' => 'DESC']);
        $stats = $scheduleRepository->countSchedulesPerCourse();

        return $this->render('portal/portal.html.twig', [
            'courses' => $courses,
            'schedules' => $schedules,
            'assignments' => $assignments,
            'stats' => $stats,
            'logs' => $logs
        ]);
    }

    #[Route('/course/new', name: 'course_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $course = new Course();

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //UserActivity
            $log = new ActivityLog();
            $log->setAction("Created course ".$course->getName());
            $log->setDate(new \DateTime());

            $em->persist($log);

            $em->persist($course); //Doctrine: Dieses Objekt soll in die Datenbank
            $em->flush(); //INSERT INTO course (...)

            return $this->redirectToRoute('portal_index');
        }

        return $this->render('course/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/course/edit/{id}', name: 'course_edit')]
    public function edit(
        int $id,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $course = $em->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //UserActivity
            $log = new ActivityLog();
            $log->setAction("Edited course ".$course->getName());
            $log->setDate(new \DateTime());

            $em->persist($log);
            $em->flush();

            return $this->redirectToRoute('portal_index');
        }

        return $this->render('course/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/course/delete/{id}', name: 'course_delete')]
    public function delete(
        int $id,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $course = $em->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException();
        }

        if ($request->isMethod('POST')) {

            //UserActivity
            $log = new ActivityLog();
            $log->setAction("Deleted course ".$course->getName());
            $log->setDate(new \DateTime());

            $em->persist($log);
            $em->remove($course);
            $em->flush();

            return $this->redirectToRoute('portal_index');
        }

        return $this->render('course/delete.html.twig', [
            'course' => $course
        ]);
    }
}