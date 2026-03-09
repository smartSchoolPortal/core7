<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ScheduleStatisticsController extends AbstractController
{
    #[Route('/statistics', name: 'schedule-statistics')]
    public function statistics(ScheduleRepository $scheduleRepository) : Response{
        $schedules = $scheduleRepository->findAllWithCourseAndAssignments();
        $stats = $scheduleRepository->getScheduleStatistics();

        return $this->render('schedule/statistics.html.twig', [
            'schedules' => $schedules,
            'stats' => $stats,
        ]);
    }
}
