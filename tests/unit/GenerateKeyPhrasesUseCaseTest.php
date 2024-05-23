<?php declare(strict_types=1);

use App\Abstraction\FormatKeyWordListUseCaseInterface;
use App\Abstraction\GeneratePermutationsUseCaseInterface;
use App\UseCase\GenerateKeyPhrasesUseCase;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
final class GenerateKeyPhrasesUseCaseTest extends TestCase {

    #[TestDox('Testing creating key phrases list')]
    public static function executeDataProvider(): array {

        return [
            'first key words set' => [
                "word1,word2\n",
            ]
        ];
    }

    #[DataProvider('executeDataProvider')]
    public function testExecute(string $data) {
            $mockFormatKeywordListUseCase = $this->createMock(FormatKeyWordListUseCaseInterface::class);
            $mockGeneratePermutationsUseCase = $this->createMock(GeneratePermutationsUseCaseInterface::class);

            $mockFormatKeywordListUseCase->method('execute')->willReturn(['word1', 'word2']);
            $mockGeneratePermutationsUseCase->method('execute')->willReturn([['word1', '-word2']]);

            $useCase = new GenerateKeyPhrasesUseCase($mockFormatKeywordListUseCase, $mockGeneratePermutationsUseCase);

            $result = $useCase->execute($data);

            $this->assertSame([
                "word1 -word2",
            ], $result);
    }
}