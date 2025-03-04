<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\RaitingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: RaitingRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            openapi: new Operation(
                tags:[
                    'Рейтинг'
                ],
                summary: 'Получить Список рейтингов',
                description: 'Получить список рейтингов',
                parameters: [
                    new Parameter(
                        name: 'page',
                        in: 'query',
                        schema: [
                            'type' => 'integer',
                            'default' => 1
                        ]
                    ),
                    new Parameter(
                        name: 'amountOfPages',
                        in: 'query',
                        schema: [
                            'type' => 'integer',
                            'default' => 30
                        ]
                    ),
                ]
            )
        ),
        new Post(
            openapi: new Operation(
                tags: ['Рейтинг'],
                summary: 'Записать рейтинг',
                description: 'Записать рейтинг по id'
            )
        ),
        new Get(
            openapi: new Operation(
                tags: ['Рейтинг'],
                summary: 'Взять рейтинг',
                description: 'Взять рейтинг по id'
            )
        ),
        new Delete(
            openapi: new Operation(
                tags: ['Рейтинг'],
                summary: 'Удалить рейтинг',
                description: 'Удалить рейтинг по id'
            )
        ),
        new Patch(
            openapi: new Operation(
                tags: ['Рейтинг'],
                summary: 'Обновить рейтинг',
                description: 'Обновить рейтинг по id'
            )
        )
    ]
)]
class Raiting
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?int $amountOfStars = null;

    #[ORM\ManyToOne(inversedBy: 'raitings')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiFilter(SearchFilter::class, properties: ['actor' => 'exact'])]
    private ?Actor $actor = null;

    #[ORM\ManyToOne(inversedBy: 'raitings')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiFilter(SearchFilter::class, properties: ['product' => 'exact'])]
    private ?Product $product = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getAmountOfStars(): ?int
    {
        return $this->amountOfStars;
    }

    public function setAmountOfStars(int $amountOfStars): static
    {
        $this->amountOfStars = $amountOfStars;

        return $this;
    }

    public function getActor(): ?Actor
    {
        return $this->actor;
    }

    public function setActor(?Actor $actor): static
    {
        $this->actor = $actor;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
