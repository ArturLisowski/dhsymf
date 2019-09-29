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
        $input = json_decode($_request->getContent(), true);
        $result = (new Results\Results_Service_Results($this->getDoctrine()->getManager()))->createResult($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function deleteResult(Request $_request)
    {
        $input = json_decode($_request->getContent(), true);
        $result = (new Results\Results_Service_Results($this->getDoctrine()->getManager()))->deleteResult($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function updateResult(Request $_request)
    {
        $input = json_decode($_request->getContent(), true);
        $result = (new Results\Results_Service_Results($this->getDoctrine()->getManager()))->updateResult($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }

    /**
     * @param Request $_request
     * @return Response
     */
    public function getResult(Request $_request)
    {
        $input = json_decode($_request->getContent(), true);
        $result = (new Results\Results_Service_Results($this->getDoctrine()->getManager()))->getResult($input);

        return new Response(json_encode($result['result']), $result['code'], $result['headers']);
    }

}