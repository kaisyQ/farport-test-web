<?php declare(strict_types=1);

namespace App\UseCase;


final class GenerateKeyPhrasesUseCase {


    public function __construct(
        private readonly FormatKeyWordListUseCase $formatKeyWordListUseCase,
        private readonly GeneratePermutationsUseCase $generatePermutationsUseCase
    ) {}


    public function execute(string $keyWords): array {
        $rows = explode("\n", $keyWords);

        $rows = array_map(
            /**
             * @return string[]
             */
            fn (string $row): array => explode(', ', $row), 
        $rows);
        
        $resultWords = [];
        
        foreach ($rows as $row) {
            $resultWords[] = $this->formatKeyWordListUseCase->execute($row);
        }
        
        
        $perms = $this->generatePermutationsUseCase->execute($resultWords);
        
        return $this->generateFormattedPermutationList($perms);
    }  


    private function generateFormattedPermutationList(array $permutations) {
        
        foreach ($permutations as $perm) {
            $permValue = explode(' ', implode(' ', $perm));
        
        
            $minusWords = [];
            $plusWords = [];
        
            foreach ($permValue as $permValueDatum) {
                if ($permValueDatum[0] === '-') {
                    $minusWords[] = $permValueDatum;
                } else {
                    $plusWords[] = $permValueDatum;
                }
            }
            $str = implode(' ', array_merge($plusWords,$minusWords));
            
            $result[] = $str;
        }

        return $result;
    }

}