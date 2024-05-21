<?php declare(strict_types=1);

namespace App\UseCase;


final class GenerateKeyPhrasesUseCase {


    public function __construct(
        private readonly FormatKeyWordListUseCase $formatKeyWordListUseCase,
        private readonly GeneratePermutationsUseCase $generatePermutationsUseCase
    ) {}


    public function execute(string $keyWords): array {
    

        $keyWords = str_replace(['.', '?', '&', '~', '<', '>', ')', '(', ')', '*', '/', "\""], ' ', $keyWords);

        $rows = explode("\n", $keyWords);

        $rows = array_map(
        function (string $row): string {
            
            $result = [];

            foreach (explode(',', $row) as $rowElement) {
                
                if($rowElement === '') continue;

                if(in_array($rowElement[0], ['!', '-', '+']) && !in_array($rowElement[1], ['!', '-', '+'])) {
                    $result[] = $rowElement[0] . str_replace(['!', '-', '+'], ' ', substr($rowElement, 1, strlen($rowElement)));
                } else {
                    $result[] = str_replace(['!', '-', '+'], ' ', $rowElement);
                } 
            }

            return implode(',', $result) . "\n";
        }, 

        $rows);

        $resultWords = []; 
        
        foreach ($rows as $row) {
            $resultWords[] = $this->formatKeyWordListUseCase->execute(explode("\n", $row));
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
                if (strlen($permValueDatum) > 0 && $permValueDatum[0] === '-') {
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