<?php

namespace App\DataFixtures;

use App\Entity\Schedule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ScheduleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $schedules = [
            [
                'title' => '3AHIT Wochenplan',
                'description' => 'Übersicht aller Kurse und Aufgaben für die Klasse 3AHIT'
            ],
            [
                'title' => 'Informatik Schwerpunktplan',
                'description' => 'Enthält alle Informatik-Kurse und Programmierprojekte'
            ],
            [
                'title' => 'Prüfungsphase Frühling',
                'description' => 'Zeitplan für Tests, Schularbeiten und wichtige Abgaben'
            ],
            [
                'title' => 'Projektwoche Planung',
                'description' => 'Organisation der Kurse und Aufgaben während der Projektwoche'
            ],
            [
                'title' => 'Semester Organisation',
                'description' => 'Allgemeine Übersicht über Kurse, Deadlines und Termine'
            ],
        ];
        foreach ($schedules as $scheduleData) {
            $schedule = new Schedule();
            $schedule->setTitle($scheduleData['title']);
            $schedule->setDescription($scheduleData['description']);
            $manager->persist($schedule);
        }
        $manager->flush();
    }
}
