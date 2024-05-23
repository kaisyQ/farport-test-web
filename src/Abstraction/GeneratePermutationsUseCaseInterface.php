<?php declare(strict_types=1);


namespace App\Abstraction;

/**
 * UseCase отвечающий за генерацию перестановок
 */
interface GeneratePermutationsUseCaseInterface {
    /**
     * @param string[][] $arraysOrWords Массив элементами, которого являются множества слов, для которых надо сделать перестановки
     * @raturn string[][] Массив с перестановками
     */
    public function execute(array $arraysOfWords): array;
}