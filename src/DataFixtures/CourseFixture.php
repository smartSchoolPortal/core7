<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $courses = [];

        $courseNames = [
            ["Mathematics", "Science", 2026],
            ["Physics", "Science", 2026],
            ["History", "Arts", 2026],
            ["Chemistry", "Science", 2026],
            ["Biology", "Science", 2026]
        ];

        foreach ($courseNames as $data) {
            $course = new Course();
            $course->setName($data[0]);
            $course->setDepartment($data[1]);
            $course->setYearOffered($data[2]);

            $manager->persist($course);
            $courses[] = $course;
        }
        
        $manager->flush();
    }
}