<?php

namespace App\Controller;

use App\Entity\Student;
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
        $input = json_decode($_request->getContent(), true);
        $result = (new Student\Student_Service_Student($this->getDoctrine()->getManager()))->createStudent($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function deleteStudent(Request $_request)
    {
        $input = json_decode($_request->getContent(), true);
        $result = (new Student\Student_Service_Student($this->getDoctrine()->getManager()))->deleteStudent($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function updateStudent(Request $_request)
    {
        $input = json_decode($_request->getContent(), true);
        $result = (new Student\Student_Service_Student($this->getDoctrine()->getManager()))->updateStudent($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function getStudent(Request $_request)
    {
        $input = json_decode($_request->getContent(), true);
        $result = (new Student\Student_Service_Student($this->getDoctrine()->getManager()))->getStudent($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }
}