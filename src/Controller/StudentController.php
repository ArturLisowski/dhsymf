<?php

namespace App\Controller;

use App\Entity\Student;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class StudentController extends Controller
{
    public function createStudent(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);
            $_entityManager = $this->getDoctrine()->getManager();

            if (empty($input['name']) || $input['surname'] || $input['email']) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_student = (new Student())
                ->setName($input['name'])
                ->setSurname($input['surname'])
                ->setEmail($input['email']);

            $_entityManager->persist($_student);
            $_entityManager->flush();

            return new Response(json_encode(['id' => $_student->getId()]), 201, ['Content-Type' => 'application/json']);
        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }

    }
}