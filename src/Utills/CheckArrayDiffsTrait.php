<?php declare(strict_types=1);

namespace App\Utills;

trait CheckArrayDiffsTrait {
    
    public function checkArrayDiffs(array $firstArray, array $secondArray): bool {
        
        foreach ($firstArray as $data) {
            if (in_array($data, $secondArray)) {
                return true;
            }
        }
        
        return false;
    }   

}