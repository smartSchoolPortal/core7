<?php
namespace App\Controllers;

use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ScheduleController extends AbstractController {
    #[Route('/schedules', 'app_schedules')]
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();

        return $this->render('schedule/index.html.twig', [
            'schedules' => $schedules,
        ]);
    }

    #[Route('/schedule/{id}', name: 'app_schedule_show')]
    public function show(Schedule $schedule): Response
    {
        return $this->render('schedule/show.html.twig', [
            'schedule' => $schedule,
        ]);
    }
}
