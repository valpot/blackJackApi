<?php


namespace App\Logic;


use App\Logic\Calculation\DealerProbabilityCalculator;
use App\Logic\Calculation\PlayerProbabilityCalculator;

class PlayerLogic
{
    /** @var PlayerProbabilityCalculator */
    protected $playerProbabilityCalculator;

    /** @var DealerProbabilityCalculator */
    protected $dealerProbabilityCalculator;

    public function __construct(PlayerProbabilityCalculator $playerProbabilityCalculator, DealerProbabilityCalculator $dealerProbabilityCalculator)
    {
        $this->playerProbabilityCalculator = $playerProbabilityCalculator;
        $this->dealerProbabilityCalculator = $dealerProbabilityCalculator;
    }

    public function play(array $playerHand, array $dealerHand, array $remainingCards): string
    {
        $playerBustingProbability = $this->playerProbabilityCalculator->getNextDrawingBustingProbability($playerHand, $remainingCards);
        $bankBustingProbability   = $this->dealerProbabilityCalculator->getBustingProbability($dealerHand, $remainingCards);

        return (string) $playerBustingProbability;
    }
}
