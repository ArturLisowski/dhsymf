<?php

namespace App\Entity\Student;

use App\Entity\Student;
use Symfony\Component\HttpFoundation\Response;

class Student_Service_Student
{
    private $_entityManager;

    /**
     * Student_Service_Student constructor.
     * @param $_em
     */
    public function __construct($_em)
    {
        $this->_entityManager = $_em;
    }

    /**
     * @param $input
     * @return array
     */
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

        } catch (\Exception $_e) {
            return [
                'result' => ['message' => $_e->getMessage()],
                'code' => 400,
                'headers' => []
            ];
        }
    }

    /**
     * @param $input
     * @return array
     */
    public function deleteStudent($input)
    {
        try {
            if (empty($input['id'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_student = $this->_entityManager->getRepository(Student::class)->find($input['id']);

            if (!isset($_student)) {
                throw new \Exception('Student not found', 400);
            }

            $this->_entityManager->remove($_student);
            $this->_entityManager->flush();

            return [
                'result' => [],
                'code' => 200,
                'headers' => ['Content-Type' => 'application/json']
            ];
        } catch (\Exception $_e) {
            return [
                'result' => ['message' => $_e->getMessage()],
                'code' => 400,
                'headers' => []
            ];
        }
    }

    /**
     * @param $input
     * @return array
     */
    public function updateStudent($input)
    {
        try {
            if (empty($input['id']) || empty($input['name']) || empty($input['surname']) || empty($input['email'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_student = $this->_entityManager->getRepository(Student::class)->find($input['id']);

            if (!isset($_student)) {
                throw new \Exception('Student not found', 400);
            }

            $_student->setName($input['name'])
                ->setSurname($input['surname'])
                ->setEmail($input['email']);

            $this->_entityManager->persist($_student);
            $this->_entityManager->flush();

            return [
                'result' => [],
                'code' => 200,
                'headers' => ['Content-Type' => 'application/json']
            ];
        } catch (\Exception $_e) {
            return [
                'result' => ['message' => $_e->getMessage()],
                'code' => 400,
                'headers' => []
            ];
        }
    }

    /**
     * @param $input
     * @return array
     */
    public function getStudent($input)
    {
        try {
            if (empty($input['id'])) {
                $_students = $this->_entityManager->getRepository(Student::class)->findAll();

                if (!isset($_students)) {
                    throw new \Exception('Student not found', 400);
                }

                $responseContent = [];

                /** @var Student $_student */
                foreach ($_students as $_student) {
                    $responseContent[] = $_student->serialize();
                }

                return [
                    'result' => $responseContent,
                    'code' => 200,
                    'headers' => ['Content-Type' => 'application/json']
                ];
            } else {
                /** @var Student $_student */
                $_student = $this->_entityManager->getRepository(Student::class)->find($input['id']);

                if (!isset($_student)) {
                    throw new \Exception('Student not found', 400);
                }

                return [
                    'result' => $_student->serialize(),
                    'code' => 200,
                    'headers' => ['Content-Type' => 'application/json']
                ];
            }
        } catch (\Exception $_e) {
            return [
                'result' => ['message' => $_e->getMessage()],
                'code' => 400,
                'headers' => []
            ];
        }
    }
}