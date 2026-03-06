<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Schedule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseFixtures extends Fixture implements DependentFixtureInterface{
    public function load(ObjectManager $manager): void
    {
        $schedules = $manager->getRepository(Schedule::class)->findAll();

        $courses = [
            ['name' => 'Software Engineering', 'department' => 'Informatik', 'scheduleId' => 0],
            ['name' => 'Datenbanken', 'department' => 'Informatik', 'scheduleId' => 0],
            ['name' => 'Netzwerktechnik', 'department' => 'IT Infrastruktur', 'scheduleId' => 1],
            ['name' => 'Mathematik', 'department' => 'Naturwissenschaften', 'scheduleId' => 2],
            ['name' => 'Deutsch', 'department' => 'Sprachen', 'scheduleId' => 3],
            ['name' => 'Englisch', 'department' => 'Sprachen', 'scheduleId' => 4],
        ];
        foreach ($courses as $courseData) {
            $course = new Course();
            $course->setName($courseData['name']);
            $course->setDepartment($courseData['department']);
            $course->setSchedule($schedules[$courseData['scheduleId']]);
            $manager->persist($course);
        }
        $manager->flush();
    }
    public function getDependencies(): array{
        return [
            ScheduleFixtures::class,
        ];
    }
}
