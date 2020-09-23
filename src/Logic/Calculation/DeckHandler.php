<?php

namespace App\Logic\Calculation;

class DeckHandler
{
    /**
     * @param array<int> $cards
     */
    public function getSum(array $cards): int
    {
        $sum         = 0;
        $remainingAs = 0;

        foreach ($cards as $card) {
            if (1 === $card) {
                ++$remainingAs;
                continue;
            }

            $sum += $card;
        }

        while ($remainingAs > 0) {
            $sum += $sum + $remainingAs + 10 > 21
                ? 1
                : 11;

            --$remainingAs;
        }

        return $sum;
    }

    /**
     * @param array<int> $deck
     */
    public function removeCardFromDeck(int $card, array &$deck): void
    {
        array_splice($deck, array_search($card, $deck), 1);
    }
}
