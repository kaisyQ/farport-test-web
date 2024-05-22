<?php declare(strict_types=1);

use App\UseCase\GeneratePermutationsUseCase;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

final class GeneratePermutationsUseCaseTest extends TestCase {


    #[TestDox('Testing creating permutations')]
    public static function executeDataProvider(): array {

        return [
            'Data set' => [
                [
                    ['a','b',],
                    ['c',]
                ]
            ]
        ];
    }

    #[DataProvider('executeDataProvider')]
    public function testExecute(array $data): void {

        $useCase = new GeneratePermutationsUseCase();
        
        $expected = [
            ['+a', '+c'],
            ['+b', '+c'],
        ];

        $this->assertEquals($expected, $useCase->execute($data));
    }
}