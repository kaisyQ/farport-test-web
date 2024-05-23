<?php declare(strict_types=1);

namespace App\UseCase;

use App\Abstraction\FormatKeyWordListUseCaseInterface;
use App\Abstraction\GenerateKeyPhrasesUseCaseInterface;
use App\Abstraction\GeneratePermutationsUseCaseInterface;

final class GenerateKeyPhrasesUseCase implements GenerateKeyPhrasesUseCaseInterface {


    public function __construct(
        private readonly FormatKeyWordListUseCaseInterface $formatKeyWordListUseCase,
        private readonly GeneratePermutationsUseCaseInterface $generatePermutationsUseCase
    ) {}

    public function execute(string $keyWords): array {
        
        $filteredKeyWords = $this->filterInputKeyWordString($keyWords);

        $resultWords = []; 
        
        foreach ($filteredKeyWords as $row) {
            $resultWords[] = $this->formatKeyWordListUseCase->execute(explode("\n", $row));
        }   

        $perms = $this->generatePermutationsUseCase->execute($resultWords);
        
        return $this->generateFormattedPermutationList($perms);
    }  


    private function filterInputKeyWordString(string $keyWords): array {
        $keyWords = str_replace(['.', '?', '&', '~', '<', '>', ')', '(', ')', '*', '/', "\\", "@", "#"], ' ', $keyWords);

        $rows = explode("\n", $keyWords);

        $rows = array_map(
            function (string $row): string {
            
                $result = [];

                foreach (explode(',', $row) as $rowElement) {
                    
                    if($rowElement === '' || in_array($rowElement, ['!', '-', '+'])) continue;

                    if(in_array($rowElement[0], ['!', '-', '+']) && !in_array($rowElement[1], ['!', '-', '+'])) {
                        $result[] = $rowElement[0] . str_replace(['!', '-', '+'], ' ', substr($rowElement, 1, strlen($rowElement)));
                    } else {
                        $result[] = str_replace(['!', '-', '+'], ' ', $rowElement);
                    } 
                }

                return implode(',', $result) . "\n";
            }, 
            $rows
        );

        return $rows;
    }

    private function generateFormattedPermutationList(array $permutations) {

        foreach ($permutations as $permutation) {
            $permutationValue = explode(' ', implode(' ', $permutation));
        
        
            $minusWords = [];
            $plusWords = [];
        
            foreach ($permutationValue as $permutationValueDatum) {
                if (strlen($permutationValueDatum) > 0 && $permutationValueDatum[0] === '-') {
                    $minusWords[] = $permutationValueDatum;
                } else {
                    $plusWords[] = $permutationValueDatum;
                }
            }
            $str = implode(' ', array_merge($plusWords,$minusWords));
            
            $result[] = $str;
        }

        return $result;
    }

}