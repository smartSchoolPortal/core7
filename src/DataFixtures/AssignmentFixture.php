<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Assignement;
use App\Entity\Course;

class AssignmentFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $courses = $manager->getRepository(Course::class)->findAll();

        if (empty($courses)) {
            return;
        }

        $assignments = [];

        $assignmentTitles = [
            "Homework 1",
            "Project Work",
            "Lab Exercise",
            "Midterm Assignment",
            "Final Assignment"
        ];

        $teachers = [
            "Wagner",
            "Weiss",
            "White",
            "Nussbaumer",
            "Javurek"
        ];

        foreach ($assignmentTitles as $index => $title) {
            $assignment = new Assignement();
            $assignment->setTitle($title);
            $assignment->setTeacher($teachers[$index]);
            $assignment->setAssignmentNumber($index + 1);
            $assignment->setDueDate(new \DateTime("+".($index+5)." days"));

            $assignment->setCourse($courses[array_rand($courses)]);

            $manager->persist($assignment);
            $assignments[] = $assignment;

        }

        $manager->flush();
    }
}
