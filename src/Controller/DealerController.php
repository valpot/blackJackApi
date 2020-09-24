<?php

namespace App\Controller;

use App\Logic\Calculation\DealerProbabilityCalculator;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dealer", name="dealer_")
 */
class DealerController extends AbstractController
{
    /** @var DealerProbabilityCalculator */
    protected $dealerProbabilityCalculator;

    public function __construct(DealerProbabilityCalculator $dealerProbabilityCalculator)
    {
        $this->dealerProbabilityCalculator = $dealerProbabilityCalculator;
    }

    /**
     * Get probability for player to bust on next card.
     *
     * @Route("/bust", methods={"POST"}, name="bust")
     *
     * @OA\Post(
     *     tags={"Dealer"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *             property="hand",
     *             description="Hand of user",
     *             type="array",
     *             @OA\Items(type="integer", example=1)
     *           ),
     *           @OA\Property(
     *             property="remainingCards",
     *             description="List of remaining cards",
     *             type="array",
     *             @OA\Items(type="integer", example=1)
     *          )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="get probability to bust on next card",
     *         @OA\JsonContent(
     *            type="integer",
     *            example="0.123456789"
     *         )
     *    ),
     *    @OA\Response(
     *         response=422,
     *         description="Invalid datas are provider",
     *         @OA\JsonContent(
     *            type="string",
     *            example="Missing 'hand' array in the message body."
     *         )
     *    )
     * )
     */
    public function getBustProbability(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        if (!array_key_exists('hand', $body)) {
            return new JsonResponse("Missing 'hand' array in the message body.", 422);
        }

        $hand = $body['hand'];

        foreach ($hand as $card) {
            if (!is_int($card) || $card < 1 || $card > 10) {
                return new JsonResponse(sprintf("Wrong value found in 'hand': %s. Expected values are integer between 1 and 10 included", $card), 422);
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

        $probability = $this->dealerProbabilityCalculator->getBustingProbability($hand, $remainingCards);

        return new JsonResponse($probability);
    }
}
