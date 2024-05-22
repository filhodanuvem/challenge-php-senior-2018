<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Service\PredictionsFinder;
use App\Controller\Transformer\Predictions as PredicitionsTransformer;

class DefaultController extends Controller
{
    public function listPredictions(Request $request, PredictionsFinder $predictionFinder, PredicitionsTransformer $transformer)
    {
        $dateString = $request->get('date');
        $city = $request->get('city');
        if (empty($city)) {
            return new Response('City required', Response::HTTP_BAD_REQUEST);
        }
        $now = new \DateTime('now');
        $date = $now;
        if (!empty($dateString)) {
            $date = new \DateTime($dateString);
        }
        
        if ($date < $now || $date > new \DateTime('+10days')) {
            return new Response('Date required should not be greater then 10 days or in the past', Response::HTTP_BAD_REQUEST);
        }

        $predictions = $predictionFinder->findPredictions($city, $date);

        return new JsonResponse(
            $transformer->transform($predictions)
        );
    }

    public function index()
    {
        
    }
}
