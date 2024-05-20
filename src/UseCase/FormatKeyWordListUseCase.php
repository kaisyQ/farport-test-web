<?php declare(strict_types=1);

namespace App\UseCase;

use App\Utills\CheckArrayDiffsTrait;

final class FormatKeyWordListUseCase {

    use CheckArrayDiffsTrait;

    /**
     * @param string $words
     */
    public function execute(string $words): array {

        dd($words);
        $result = [];
        $sets = [];
        $wordSets = [];

        foreach(explode(',', $words) as $wordKey => $word) {
            
            if (count($sets) === 0) {
                $sets[] = $word;
                $wordSets[$wordKey] = count($sets) - 1;
                continue;
            } 

            $setFound = false;

            foreach($sets as $key => &$set) {

                $setsDiffs = [];

                if (1 > count($set)) {
                    $setsDiffs = array_diff_assoc([$word], $set);
                } else {
                    $setsDiffs = array_diff_assoc($set, [$word]);
                }


                $contains = $this->checkArrayDiffs([$word], $set);

                if ($contains) {
                    $wordSets[$wordKey] = $key;
                    $set += $setsDiffs;
                    $setFound = true;
                }
            }

            if (!$setFound) {
                $sets[] = $word;
                $wordSets[$wordKey] = count($sets) - 1;
            }

        }

        dd($sets);

        foreach (explode(',', $words) as $key => $word) {

            // $minusWords = array_map(
                // fn (string $word): string => " -{$word}", 
                // array_diff_assoc($sets[$wordSets[$key]], [$word])
            // );

            // $result[] = $word . implode("", $minusWords); 
        }
        
        return $result;
    }


}