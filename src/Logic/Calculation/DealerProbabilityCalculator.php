<?php

namespace App\Logic\Calculation;

class DealerProbabilityCalculator
{
    const PROBABILITY = 'p';
    const VALUES      = 'v';
    const SUM         = 's';

    /** @var DeckHandler */
    protected $deckHandler;

    public function __construct(DeckHandler $deckHandler)
    {
        $this->deckHandler = $deckHandler;
    }

    /**
     * @param array<int> $dealerCards
     * @param array<int> $remainingCards
     */
    public function getBustingProbability(array $dealerCards, array $remainingCards): float
    {
        $bustingProbability = 0;
        $handTree           = [
            0 => [
                self::VALUES => [
                    json_encode($dealerCards) => [
                        self::SUM         => $this->deckHandler->getSum($dealerCards),
                        self::PROBABILITY => 1,
                    ],
                ],
            ],
        ];

        $nesting      = 1;
        $needsNesting = true;
        while ($needsNesting) {
            $handTree[$nesting] = [
                self::VALUES      => [],
                self::PROBABILITY => 0,
            ];

            foreach ($handTree[$nesting - 1][self::VALUES] as $parentHandAsString => $parentHandInfo) {
                $parentHand         = json_decode($parentHandAsString, true);
                $tempRemainingCards = $remainingCards;

                // Calculating the remaining cards for each hand of our tree
                foreach ($parentHand as $card) {
                    $this->deckHandler->removeCardFromDeck($card, $tempRemainingCards);
                }

                // Calculating the probability of reaching this hand
                $remainingCardsCount = count($tempRemainingCards);
                $handProbability     = $parentHandInfo[self::PROBABILITY] * (1 / $remainingCardsCount);

                // Foreach of the remaining cards we generate all of the possible hands
                foreach ($tempRemainingCards as $card) {
                    if ($parentHandInfo[self::SUM] >= 17) {
                        continue;
                    }

                    $hand   = $parentHand;
                    $hand[] = $card;
                    sort($hand);

                    $sum = $this->deckHandler->getSum($hand);

                    $handAsString = json_encode($hand);

                    if (array_key_exists($handAsString, $handTree[$nesting][self::VALUES])) {
                        $handTree[$nesting][self::VALUES][$handAsString][self::PROBABILITY] += $handProbability;
                    } else {
                        $handTree[$nesting][self::VALUES][$handAsString] = [self::SUM => $sum, self::PROBABILITY => $handProbability];
                    }

                    if ($sum > 21) {
                        $handTree[$nesting][self::PROBABILITY] += $handProbability;
                    }
                }
            }

            $bustingProbability += $handTree[$nesting][self::PROBABILITY];
            $needsNesting       = count($handTree[$nesting][self::VALUES]) > 0;
            ++$nesting;
        }

        return $bustingProbability;
    }
}
