<?php declare(strict_types=1);

namespace App\UseCase;

use App\Utills\CheckArrayDiffsTrait;

final class FormatKeyWordListUseCase {

    use CheckArrayDiffsTrait;

    /**
     * @param string[] $words
     */
    public function execute(array $words): array {

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

                $setDiff = [];

                if (count($wordValues) > count($set)) {
                    $setDiff = array_diff_assoc($wordValues, $set);
                } else {
                    $setDiff = array_diff_assoc($set, $wordValues);
                }


                $contains = $this->checkArrayDiffs($wordValues, $set);

                if ($contains) {
                    $wordSets[$wordKey] = $key;
                    $set += $setDiff;
                    $setFound = true;
                }
            }

            if (!$setFound) {
                $sets[] = $wordValues;
                $wordSets[$wordKey] = count($sets) - 1;
            }

        }

        foreach ($words as $key => $word) {
            $wordValues = explode(' ', $word);

            $minusWords = array_map(fn(string $word): string => " -{$word}", array_diff_assoc($sets[$wordSets[$key]], $wordValues));

            $result[] = $word . implode("", $minusWords); 
            
        }
        
        return $result;
    }


}