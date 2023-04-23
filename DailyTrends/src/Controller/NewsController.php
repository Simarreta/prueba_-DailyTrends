<?php
namespace App\Controller;

use App\Service\Gnews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewsController extends AbstractController
{
    private $gnews;

    public function __construct(Gnews $gnews)
    {
        $this->gnews = $gnews;
    }

    public function index()
    {
        $articles = $this->gnews->getTopNews();

        dump($articles);
        //return new JsonResponse($articles);
        return $this->render('news.html.twig', [
            'articles' => $articles,
        ]);
    }
}
