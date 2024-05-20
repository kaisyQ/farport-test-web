<?php declare(strict_types=1);

namespace App\UseCase;


final class GenerateKeyPhrasesUseCase {


    public function __construct(
        private readonly FormatKeyWordListUseCase $formatKeyWordListUseCase,
        private readonly GeneratePermutationsUseCase $generatePermutationsUseCase
    ) {}


    public function execute(string $keyWords): array {
    

        $keyWords = str_replace(['.', '?', '&', '~', '<', '>', ')', '(', ')', '*', '/', "\""], ' ', $keyWords);

        $result = [];
        
        $keyWordsArray = explode(',', $keyWords);

        foreach ($keyWordsArray as $t) {
            foreach (explode(' ', $t) as $t1) {
                

                if($t1 === '') continue;

                if(in_array($t1[0], ['!', '-', '+']) && !in_array($t1[1], ['!', '-', '+'])) {
                    $result[] = $t1[0] . str_replace(['!', '-', '+'], ' ', substr($t1, 1, strlen($t1)));
                } else {
                    $result[] = str_replace(['!', '-', '+'], ' ', $t1);
                }
            }
        }


        
        $rows = explode("\n", implode(',', $result));

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