<?php declare(strict_types=1);

namespace App\Controller;

use App\UseCase\GenerateKeyPhrasesUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;


#[Route(path: '/')]
final class KeyPhraseController extends AbstractController {
    
    public function __construct(private readonly GenerateKeyPhrasesUseCase $generateKeyPhrasesUseCase)
    {   
    }


    #[Route(path: '/',name: 'key_phrase_index', methods: ['GET'])]
    public function getPage(#[MapQueryParameter('key_words')] ?string $words): Response
    {

        if($words) {
            $result = $this->generateKeyPhrasesUseCase->execute($words);
            return $this->json($result);
        }

        return $this->render('base.html.twig');
    }
}