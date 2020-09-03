<?php

use App\Tests\FunctionalTester;
use Codeception\Test\Unit;

class DealerControllerTest extends Unit
{
    /**
     * @var FunctionalTester
     */
    protected $tester;

    public function provideDealerBustScenario()
    {
        $deck = [2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 8, 8, 8, 8, 9, 9, 9, 9, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 1, 1, 1, 1];

        return [
            [
                [
                    "hand"           => [2],
                    "remainingCards" => $deck
                ],
                200
            ],
            [
                [
                    "hand"           => [],
                    "remainingCards" => $deck
                ],
                200
            ],
            [
                [
                    "hand"           => [2],
                    "remainingCards" => []
                ],
                422
            ],
            [
                [],
                422
            ],
            [
                [
                    "hand" => [2]
                ],
                422
            ],
            [
                [
                    "remainingCards" => $deck
                ],
                422
            ],
        ];
    }

    /**
     * @param $body
     * @param $expectedResponseCode
     *
     * @dataProvider provideDealerBustScenario
     */
    public function testDealerBustProbability($body, $expectedResponseCode)
    {
        $this->tester->sendPost('/dealer/bust', json_encode($body));
        $this->tester->seeResponseCodeIs($expectedResponseCode);
    }
}
