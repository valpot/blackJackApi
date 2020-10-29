<?php

namespace App\Controller;

use App\Logic\PlayerLogic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/player", name="player_")
 *
 */
class PlayerController extends AbstractController
{
    /** @var PlayerLogic */
    protected $playerLogic;

    public function __construct(PlayerLogic $playerLogic)
    {
        $this->playerLogic = $playerLogic;
    }

    /**
     * @Route("/play", methods={"POST"}, name="bust")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function play(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        if (!array_key_exists('playerHand', $body)) {
            return new JsonResponse("Missing 'playerHand' array in the message body.", 422);
        }

        $playerHand = $body['playerHand'];

        foreach ($playerHand as $card) {
            if (!is_int($card) || $card < 1 || $card > 10) {
                return new JsonResponse(sprintf("Wrong value found in 'playerHand': %s. Expected values are integer between 1 and 10 included", $card), 422);
            }
        }

        if (!array_key_exists('dealerHand', $body)) {
            return new JsonResponse("Missing 'dealerHand' array in the message body.", 422);
        }

        $dealerHand = $body['dealerHand'];

        foreach ($dealerHand as $card) {
            if (!is_int($card) || $card < 1 || $card > 10) {
                return new JsonResponse(sprintf("Wrong value found in 'dealerHand': %s. Expected values are integer between 1 and 10 included", $card), 422);
            }
        }

        if (!array_key_exists('remainingCards', $body)) {
            return new JsonResponse("Missing 'remainingCards array in the message body.", 422);
        }

        $remainingCards = $body['remainingCards'];

        if (count($remainingCards) < 1) {
            return new JsonResponse(sprintf("There should be at least a value in 'remainingCards', %s given", count($remainingCards)), 422);
        }

        foreach ($remainingCards as $card) {
            if (!is_int($card) || $card < 1 || $card > 10) {
                return new JsonResponse(sprintf("Wrong value found in 'remainingCards': %s. Expected values are integer between 1 and 10 included", $card), 422);
            }
        }

        $optimalPlay = $this->playerLogic->play($playerHand, $dealerHand, $remainingCards);

        return new JsonResponse($optimalPlay);
    }
}
