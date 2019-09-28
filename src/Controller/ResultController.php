<?php


namespace App\Controller;

use App\Entity\Results;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResultController extends Controller
{
    /**
     * @param Request $_request
     * @return Response
     */
    public function createResult(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);

            if (empty($input['studentId']) || empty($input['points']) || empty($input['grade'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_result = (new Results())
                ->setStudentId($input['studentId'])
                ->setPoints($input['points'])
                ->setGrade($input['grade'])
                ->setComment($input['comment']);

            $_entityManager = $this->getDoctrine()->getManager();
            $_entityManager->persist($_result);
            $_entityManager->flush();

            return new Response(json_encode(['id' => $_result->getId()]), 201, ['Content-Type' => 'application/json']);
        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }

    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function deleteResult(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);

            if (empty($input['id'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_result = $this->getDoctrine()->getRepository(Results::class)->find($input['id']);

            if (!isset($_result)) {
                throw new \Exception('Result not found', 400);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($_result);
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
    public function updateResult(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);

            if (empty($input['id']) || empty($input['studentId']) || empty($input['points']) || empty($input['grade'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            /** @var Results $_result */
            $_result = $this->getDoctrine()->getRepository(Results::class)->find($input['id']);

            if (!isset($_result)) {
                throw new \Exception('Result not found', 400);
            }

            $_result->setStudentId($input['studentId'])
                ->setPoints($input['points'])
                ->setGrade($input['grade'])
                ->setComment($input['comment']);

            $_entityManager = $this->getDoctrine()->getManager();
            $_entityManager->persist($_result);
            $_entityManager->flush();

            return new Response(null, 200);
        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function getResult(Request $_request)
    {
        try {
            $input = json_decode($_request->getContent(), true);
            $_conn = $this->getDoctrine()->getConnection();

            if (empty($input['id'])) {
                $_query = $_conn->prepare("select r.id, r.points, r.grade, r.comment, s.name, s.surname, s.email from results as r JOIN student as s on r.student_id = s.id");
                $_query->execute();

                return new Response(json_encode($_query->fetchAll()), 201, ['Content-Type' => 'application/json']);
            } else {
                $_query = $_conn->prepare("select r.id, r.points, r.grade, r.comment, s.name, s.surname, s.email from results as r JOIN student as s on r.student_id = s.id WHERE r.id = :id");
                $_query->execute(['id' => $input['id']]);

                return new Response(json_encode($_query->fetchAll()), 201, ['Content-Type' => 'application/json']);
            }
        } catch (\Exception $_e) {
            return new Response(json_encode(['message' => $_e->getMessage()]), 400);
        }
    }

}