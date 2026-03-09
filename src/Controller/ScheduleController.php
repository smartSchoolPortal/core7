<?php
namespace App\Controller;

use App\Repository\ActivityLogRepository;
use App\Repository\CourseRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ScheduleController extends AbstractController {
    #[Route('/portal', name: 'app_schedules')]
    public function index(ScheduleRepository $scheduleRepository, ActivityLogRepository $activityLogRepository): Response
    {
        $logs = $activityLogRepository->findBy([], ['date' => 'DESC']);
        $schedules = $scheduleRepository->findAll();
        return $this->render('schedule/index.html.twig', [
            'schedules' => $schedules,
            'logs' => $logs,
        ]);
    }

    #[Route('/portal/course/{id}/assignments', name: 'app_course_assignments')]
    public function show($id, CourseRepository $courseRepository): Response
    {
        $course = $courseRepository->find($id);
        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }
        return $this->render('schedule/assignments.html.twig', [
            'course' => $course,
            'assignments' => $course->getAssignments(),
        ]);
    }
}
