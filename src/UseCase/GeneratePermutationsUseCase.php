<?php declare(strict_types=1);


namespace App\UseCase;


final class GeneratePermutationsUseCase {

    public function execute(array $arraysOfWords): array {
        $result = $this->makePermutations($arraysOfWords);
        
        return $result;
    }


    private function makePermutations(array $arraysOfWords, &$key = 0, &$perms = [], &$currentPerm = []): array {
        foreach ($arraysOfWords[$key] as $word) {
            
            $currentPerm[] = $word;
                
            $arrayCopy = array_slice($arraysOfWords, 0, $key) + array_slice($arraysOfWords, $key + 1);

            if (count($arrayCopy) === 0) {
                $perms[] = $currentPerm;
            } else {
                if (count($arraysOfWords) > $key) {
                    $this->makePermutations($arrayCopy, $key, $perms, $currentPerm);
                }
            }

            array_pop($currentPerm);
        }

        return $perms;
    }
}