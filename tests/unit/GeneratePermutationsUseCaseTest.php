<?php declare(strict_types=1);

use App\UseCase\GeneratePermutationsUseCase;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

final class GeneratePermutationsUseCaseTest extends TestCase {


    #[TestDox('Testing creating permutations')]
    public static function executeDataProvider(): array {

        return [
            'data set' => [
                [
                    [
                    'string_1','string_2',
                    ],
                    [
                        'string_3',
                    ]
                ]
            ]
        ];
    }

    #[DataProvider('executeDataProvider')]
    public function testExecute(array $data): void {

        $useCase = new GeneratePermutationsUseCase();
        
        $expected = [
            ['string_1', 'string_3'],
            ['string_2', 'string_3'],
        ];

        $this->assertEquals($expected, $useCase->execute($data));
    }
}