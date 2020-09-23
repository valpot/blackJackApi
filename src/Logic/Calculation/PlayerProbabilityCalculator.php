<?php

namespace App\Logic\Calculation;

class PlayerProbabilityCalculator
{
    /** @var DeckHandler */
    protected $deckHandler;

    public function __construct(DeckHandler $deckHandler)
    {
        $this->deckHandler = $deckHandler;
    }

    /**
     * Calculates the busting probability for the next drawing of the player
     *
     * @param array $playerHand
     * @param array $remainingCards
     * @return float
     */
    public function getNextDrawingBustingProbability(array $playerHand, array $remainingCards): float
    {
        $bustingProbability = 0;
        $handProbability    = 1 / count($remainingCards);

        foreach ($remainingCards as $drawnCard) {
            $tempRemainingCards = $remainingCards;

            $this->deckHandler->removeCardFromDeck($drawnCard, $tempRemainingCards);

            $hand   = $playerHand;
            $hand[] = $drawnCard;

            $sum = $this->deckHandler->getSum($hand);

            if ($sum > 21) {
                $bustingProbability += $handProbability;
            }
        }

        return $bustingProbability;
    }
}
