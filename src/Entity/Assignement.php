<?php

namespace App\Entity;

use App\Repository\AssignementRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: AssignementRepository::class)]
class Assignement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    private ?string $teacher = null;

    #[ORM\Column]
    private ?int $assignmentNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getTeacher(): ?string
    {
        return $this->teacher;
    }

    public function setTeacher(string $teacher): static
    {
        $this->teacher = $teacher;
        return $this;
    }

    public function getAssignmentNumber(): ?int
    {
        return $this->assignmentNumber;
    }

    public function setAssignmentNumber(int $assignmentNumber): static
    {
        $this->assignmentNumber = $assignmentNumber;
        return $this;
    }
    
    public function setDueDate(\DateTimeInterface $dueDate): static
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }


    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $Course): static
    {
        $this->course = $Course;

        return $this;
    }
}
