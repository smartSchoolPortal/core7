<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class filterAndSort extends AbstractController
{
    #[Route('/courses/search', name: 'app_course_search')]
    public function search(Request $request, CourseRepository $courseRepository): Response
    {
        $department = $request->query->get('department');
        $search = $request->query->get('search');
        $sortBy = $request->query->get('sort', 'name');
        $order = $request->query->get('order', 'ASC');
        $page = max(1, (int) $request->query->get('page', 1));

        $courses = $courseRepository->findFilteredSortedPaginated(
            $department,
            $search,
            $sortBy,
            $order,
            $page,
            5
        );

        return $this->render('course/search.html.twig', [
            'courses' => $courses,
            'department' => $department,
            'search' => $search,
            'sort' => $sortBy,
            'order' => $order,
            'page' => $page,
        ]);
    }
}
