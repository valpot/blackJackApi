<?php

declare(strict_types=1);

namespace App\Tests\Logic\Calculation;

use \App\Tests\UnitTester;
use App\Logic\Calculation\DeckHandler;

/**
 * Class DeckHandlerTest.
 */
class DeckHandlerTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var DeckHandler
     */
    private $sut;

    public function provider_test_getSum_shouldReturnRightTotal(): array
    {
        return [
            [
                [],
                0,
            ],
            [
                [10, 10, 1],
                21,
            ],
            [
                [10, 10, 10],
                30,
            ],
            [
                [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                21,
            ],
        ];
    }

    /**
     * @dataProvider provider_test_getSum_shouldReturnRightTotal
     */
    public function test_getSum_shouldReturnRightTotal(array $cards, int $expectedTotal): void
    {
        $result = $this->sut->getSum($cards);

        $this->assertEquals($expectedTotal, $result);
    }

    public function test_removeCardFromDeck_cardExist_shouldRemoveCard(): void
    {
        $card = 2;

        $deck = [1, 2];

        $this->assertCount(2, $deck);
        $this->assertContains(2, $deck);

        $this->sut->removeCardFromDeck($card, $deck);

        $this->assertCount(1, $deck);
        $this->assertNotContains(2, $deck);

        $card = 2;

        $deck = [1, 2, 2];

        $this->assertCount(3, $deck);
        $this->assertContains(2, $deck);

        $this->sut->removeCardFromDeck($card, $deck);

        $this->assertCount(2, $deck);
        $this->assertContains(2, $deck);
    }

    public function test_removeCardFromDeck_cardNotExist_shouldDoNothing(): void
    {
        $card = 3;

        $deck = [1, 2];

        $this->assertCount(2, $deck);
        $this->assertNotContains(3, $deck);

        $this->sut->removeCardFromDeck($card, $deck);

        $this->assertCount(1, $deck);
        $this->assertNotContains(3, $deck);
    }

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        $this->sut = new DeckHandler();
    }
}
