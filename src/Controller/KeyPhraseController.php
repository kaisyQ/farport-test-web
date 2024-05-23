<?php declare(strict_types=1);

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

use App\Abstraction\GenerateKeyPhrasesUseCaseInterface;
#[Route(path: '/')]
final class KeyPhraseController extends AbstractController {
    
    public function __construct(private readonly GenerateKeyPhrasesUseCaseInterface $generateKeyPhrasesUseCase)
    {   
    }


    #[Route(path: '/',name: 'key_phrase_index', methods: ['GET'])]
    public function getPage(#[MapQueryParameter('key_words')] ?string $words): Response
    {

        if($words !== null) {
            $result = $this->generateKeyPhrasesUseCase->execute(trim($words));
        }

        return $this->render('/key-phrase/index.html.twig', ['keyPrases' => $result ?? []]);
    }
}