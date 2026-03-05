<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Course;
use App\Form\CourseType;

class PortalController extends AbstractController
{
    #[Route('/portal', name: 'portal_index')]
    public function index(
        CourseRepository $courseRepository,
        ScheduleRepository $scheduleRepository
    ): Response {

        $courses = $courseRepository->findAll();
        $schedules = $scheduleRepository->findAll();

        //$courses = $courseRepository->findByDepartmentSorted("Science");

        return $this->render('portal/portal.html.twig', [
            'courses' => $courses,
            'schedules' => $schedules
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

            $em->remove($course);
            $em->flush();

            return $this->redirectToRoute('portal_index');
        }

        return $this->render('course/delete.html.twig', [
            'course' => $course
        ]);
    }
}