<?php

namespace App\Entity\Results;

use App\Entity\Results;

class Results_Service_Results
{
    private $_entityManager;

    /**
     * Results_Service_Results constructor.
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
    public function createResult($input)
    {
        try {
            if (empty($input['studentId']) || empty($input['points']) || empty($input['grade'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_result = (new Results())
                ->setStudentId($input['studentId'])
                ->setPoints($input['points'])
                ->setGrade($input['grade'])
                ->setComment($input['comment']);


            $this->_entityManager->persist($_result);
            $this->_entityManager->flush();

            return [
                'result' => ['id' => $_result->getId()],
                'code' => 201,
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
    public function deleteResult($input)
    {
        try {
            if (empty($input['id'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            $_result = $this->_entityManager->getRepository(Results::class)->find($input['id']);

            if (!isset($_result)) {
                throw new \Exception('Result not found', 400);
            }


            $this->_entityManager->remove($_result);
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
    public function updateResult($input)
    {
        try {
            if (empty($input['id']) || empty($input['studentId']) || empty($input['points']) || empty($input['grade'])) {
                throw new \Exception('Incomplete payload', 400);
            }

            /** @var Results $_result */
            $_result = $this->_entityManager->getRepository(Results::class)->find($input['id']);

            if (!isset($_result)) {
                throw new \Exception('Result not found', 400);
            }

            $_result->setStudentId($input['studentId'])
                ->setPoints($input['points'])
                ->setGrade($input['grade'])
                ->setComment($input['comment']);

            $this->_entityManager->persist($_result);
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
    public function getResult($input)
    {
        try {
            $_conn = $this->_entityManager->getConnection();

            if (empty($input['id'])) {
                $_query = $_conn->prepare("select r.id, r.points, r.grade, r.comment, s.name, s.surname, s.email from results as r JOIN student as s on r.student_id = s.id");
                $_query->execute();

                return [
                    'result' => $_query->fetchAll(),
                    'code' => 200,
                    'headers' => ['Content-Type' => 'application/json']
                ];
            } else {
                $_query = $_conn->prepare("select r.id, r.points, r.grade, r.comment, s.name, s.surname, s.email from results as r JOIN student as s on r.student_id = s.id WHERE r.id = :id");
                $_query->execute(['id' => $input['id']]);

                return [
                    'result' => $_query->fetchAll(),
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