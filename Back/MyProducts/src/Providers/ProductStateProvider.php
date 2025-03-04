<?php

// api/src/State/BlogPostProvider.php

namespace App\Providers;

use App\Entity\BlogPost;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class ProductStateProvider implements ProviderInterface
{
    private array $data;

    public function __construct(
        private readonly EntityManagerInterface $entityManaer, 
        private readonly RequestStack $requestStack) {
        
    } 

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $request = $this->requestStack->getCurrentRequest();

        $filteredArray = $this->entityManaer->getRepository(Product::class)->getProductsList(
            $request->query->get('actorCode'),
            $request->query->get('page'),
            $request->query->get('amountOfPages')
        );

        return $filteredArray;
    }
}