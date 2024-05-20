<?php declare(strict_types=1);

use App\UseCase\FormatKeyWordListUseCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class FormatKeyWordListUseCaseTest extends TestCase {


    #[TestDox('testing format key words list')]
    private static function executeDataProvider(): array {
        return [
            'Key words' => [
                ['Nissan', 'Nissan Babun-450x'] 
            ]
        ];
    }


    #[DataProvider('executeDataProvider')]
    /**
     * @param string[] $data
     */
    public function testExecute(array $data) {
        $useCase = new FormatKeyWordListUseCase();

        $result = $useCase->execute($data);

        $this->assertEquals(['Nissan -Babun-450x', 'Nissan Babun-450x'], $result);
    }
}