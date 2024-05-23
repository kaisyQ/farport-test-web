<?php declare(strict_types=1);

namespace App\Abstraction;

/**
 * UseCase отвечающий за генерацию списка уникальных ключевых фраз
 */
interface GenerateKeyPhrasesUseCaseInterface {
     /**
     * @param string $keyWords Строка, в которой перечислены ключевые слова
     * @return string[] Массив, в котором перечислены сформированные ключевые фразы
     */
    public function execute(string $keyWords): array;
}