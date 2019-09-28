<?php

namespace App\Entity\Student;

use App\Entity\Student;
use Symfony\Component\HttpFoundation\Response;

class Student_Service_Student
{
    private $_entityManager;

    public function __construct($_em)
    {
    $this->_entityManager = $_em;
    }
    public function createStudent($input)
    {
        try {
            if (empty($input['name']) || empty($input['surname']) || empty($input['email'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_student = (new Student())
                ->setName($input['name'])
                ->setSurname($input['surname'])
                ->setEmail($input['email']);

            $this->_entityManager->persist($_student);
            $this->_entityManager->flush();

            return [
                'result' => ['id' => $_student->getId()],
                'code' => 200,
                'headers' => ['Content-Type' => 'application/json']
            ];

            return new Response(json_encode(['id' => $_student->getId()]), 201, ['Content-Type' => 'application/json']);
        } catch (\Exception $_e) {
            return [
                'result' => ['message' => $_e->getMessage()],
                'code' => 400,
                'headers' => []
            ];
        }
    }
}