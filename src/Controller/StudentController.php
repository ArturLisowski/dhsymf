<?php

namespace App\Controller;

use App\Entity\Student;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class StudentController extends Controller
{
    /**
     * @param Request $_request
     * @return Response
     */
    public function createStudent(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);

            if (empty($input['name']) || empty($input['surname']) || empty($input['email'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_student = (new Student())
                ->setName($input['name'])
                ->setSurname($input['surname'])
                ->setEmail($input['email']);

            $_entityManager = $this->getDoctrine()->getManager();
            $_entityManager->persist($_student);
            $_entityManager->flush();

            return new Response(json_encode(['id' => $_student->getId()]), 201, ['Content-Type' => 'application/json']);
        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }

    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function deleteStudent(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);

            if (empty($input['id'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_student = $this->getDoctrine()->getRepository(Student::class)->find($input['id']);

            if(!isset($_student))  if(isset($_student)) {
                throw new \Exception('Student not found', 400);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($_student);
            $entityManager->flush();

            return new Response(null, 200);

        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }

    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function updateStudent(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);

            if (empty($input['id']) || empty($input['name']) || empty($input['surname']) || empty($input['email'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_student = $this->getDoctrine()->getRepository(Student::class)->find($input['id']);

            if (!isset($_student)) {
                    throw new \Exception('Student not found', 400);
            }

            $_student->setName($input['name'])
                ->setSurname($input['surname'])
                ->setEmail($input['email']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($_student);
            $entityManager->flush();

            return new Response(null, 200);
        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function getStudent(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);

            if (empty($input['id'])){
                $_students = $this->getDoctrine()->getRepository(Student::class)->findAll();

                if (!isset($_students)) {
                    throw new \Exception('Student not found', 400);
                }

                $responseContent = [];

                /** @var Student $_student */
                foreach($_students as $_student){
                    $responseContent[] = $_student->serialize();
                }

                return new Response(json_encode($responseContent), 200, ['Content-Type' => 'application/json']);
            } else {
                /** @var Student $_student */
                $_student = $this->getDoctrine()->getRepository(Student::class)->find($input['id']);

                if (!isset($_student)) {
                        throw new \Exception('Student not found', 400);
                    }

                return new Response(json_encode($_student->serialize()), 200, ['Content-Type' => 'application/json']);
            }
        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }
    }
}