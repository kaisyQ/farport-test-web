<?php declare(strict_types=1);

namespace App\UseCase;

use App\Utills\CheckArrayDiffsTrait;

final class FormatKeyWordListUseCase {

    use CheckArrayDiffsTrait;

    /**
     * @param string[] $words
     */
    public function execute(array $words): array {

        $words = $this->filterInputRow($words);;

        $result = [];
        $sets = [];
        $wordSets = [];

        foreach($words as $wordKey => $word) {

            $wordValues = explode(' ', $word);

            if (count($sets) === 0) {
                $sets[] = $wordValues;
                $wordSets[$wordKey] = count($sets) - 1;
                continue;
            } 

            $setFound = false;


            foreach($sets as $key => &$set) {

                $contains = $this->checkArrayDiffs($wordValues, $set);

                if (!$contains) continue;

                $setDiff = [];

                if (count($wordValues) > count($set)) {
                    $setDiff = array_diff($wordValues, $set);
                } else {
                    $setDiff = array_diff($set, $wordValues);
                }


                $wordSets[$wordKey] = $key;
                $set += $setDiff;
                $setFound = true;
            }

            if (!$setFound) {
                $sets[] = $wordValues;
                $wordSets[$wordKey] = count($sets) - 1;
            }

        }


        foreach ($words as $key => $word) {

            $wordValues = explode(' ', $word);

            $minusWords = array_map(fn(string $word): string => " -{$word}", array_diff($sets[$wordSets[$key]], $wordValues));

            $wordValues = array_map(fn(string $value) => trim($value) !== '' && strlen($value) < 2 ? "+{$value}" : $value, $wordValues);

            $result[] = implode(' ', $wordValues) . implode("", $minusWords); 

        }


        return $result;
    }


    /**
     * @param string[] $words
     */

    private function filterInputRow(array $words) {
        
        $words = explode(',', $words[0]);

        $result = [];
        
        foreach($words as $word) {

            $wordValues = array_filter(explode(' ', $word), fn($value) => trim($value) !== '');

            if (count($wordValues) === 0) continue;

            $result[] = implode(' ', $wordValues);

        }

        return $result;
    }
}