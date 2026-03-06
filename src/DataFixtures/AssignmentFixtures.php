<?php

namespace App\DataFixtures;

use App\Entity\Assignment;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AssignmentFixtures extends Fixture implements DependentFixtureInterface{
    public function load(ObjectManager $manager): void
    {
        $courses = $manager->getRepository(Course::class)->findAll();

        $assignments = [
            ['title' => 'Symfony Controller erstellen', 'teacher' => 'Herr Müller', 'dueDate' => '2026-03-20', 'courseId' => 0],
            ['title' => 'Doctrine ORM Übung', 'teacher' => 'Herr Müller', 'dueDate' => '2026-03-25', 'courseId' => 0],
            ['title' => 'SQL Normalisierung', 'teacher' => 'Frau Huber', 'dueDate' => '2026-03-22', 'courseId' => 1],
            ['title' => 'Netzwerkprotokolle Analyse', 'teacher' => 'Herr Leitner', 'dueDate' => '2026-03-28', 'courseId' => 2],
            ['title' => 'Ableitungen Übungsblatt', 'teacher' => 'Herr Gruber', 'dueDate' => '2026-03-21', 'courseId' => 3],
            ['title' => 'Aufsatz schreiben', 'teacher' => 'Frau Bauer', 'dueDate' => '2026-03-27', 'courseId' => 4],
            ['title' => 'Vocabulary Test Vorbereitung', 'teacher' => 'Mr. Smith', 'dueDate' => '2026-03-29', 'courseId' => 5],
        ];

        foreach ($assignments as $assignmentData) {
            $assignment = new Assignment();
            $assignment->setTitle($assignmentData['title']);
            $assignment->setTeacher($assignmentData['teacher']);
            $assignment->setDueDate($assignmentData['dueDate']);
            $assignment->setCourse($courses[$assignmentData['courseId']]);
            $manager->persist($assignment);
        }
        $manager->flush();
    }
    public function getDependencies(): array{
        return [
            CourseFixtures::class,
        ];
    }
}
