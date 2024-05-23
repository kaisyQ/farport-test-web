<?php declare(strict_types=1);

namespace App\Abstraction;

/**
 * UseCase отвечающий за формирование минус слов для пересекающихся ключевых слов
 */
interface FormatKeyWordListUseCaseInterface {
     /**
     * @param string[] $words
     */
    public function execute(array $words): array;
}