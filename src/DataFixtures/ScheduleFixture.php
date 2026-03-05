<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Schedule;
use App\Entity\Course;

class ScheduleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $courses = $manager->getRepository(Course::class)->findAll();

        if (empty($courses)) {
            return;
        }
                
        $scheduleSubjects = [
            "Mathematics Lecture",
            "Physics Lab",
            "History Seminar",
            "Chemistry Practice",
            "Biology Introduction"
        ];

        $rooms = ["A101", "B202", "C303", "D404", "E505"];

        $teachers = [
            "John Miller",
            "Sarah Brown",
            "David White",
            "Laura Green",
            "Michael Clark"
        ];

        for ($i = 0; $i < 5; $i++) {
            $schedule = new Schedule();

            $schedule->setCourse($courses[array_rand($courses)]);
            $schedule->setDate(new \DateTime("+".($i+1)." days"));
            $schedule->setSubject($scheduleSubjects[$i]);
            $schedule->setRoom($rooms[$i]);
            $schedule->setTeacher($teachers[$i]);

            $manager->persist($schedule);
        }

        $manager->flush();
    }
}
