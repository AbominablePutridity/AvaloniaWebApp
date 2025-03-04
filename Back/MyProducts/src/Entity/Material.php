<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use App\Repository\MaterialRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            openapi: new Operation(
                tags:[
                    'Материалл'
                ],
                summary: 'Получить Материаллы',
                description: 'Получить список Материаллов',
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
                    )
                ]
            )
        ),
        new Post(
            openapi: new Operation(
                tags:[
                    'Материалл'
                ],
                summary: 'Записать Материалл',
                description: 'Записать Материалл'
            )
        ),
        new Get(
            openapi: new Operation(
                tags:[
                    'Материалл'
                ],
                summary: 'Получить Материалл',
                description: 'Получить Материалл по id'
            )
        ),
        new Delete(
            openapi: new Operation(
                tags: ['Материалл'],
                summary: 'Удалить Материалл',
                description: 'Удалить Материалл по id'
            )
        ),
        new Patch(
            openapi: new Operation(
                tags: ['Материалл'],
                summary: 'Заменить Материалл',
                description: 'Заменить Материалл по id'
            )
        )
    ]
)]
class Material
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 5000)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $amountOf = null;

    #[ORM\Column]
    private ?int $salary = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAmountOf(): ?int
    {
        return $this->amountOf;
    }

    public function setAmountOf(int $amountOf): static
    {
        $this->amountOf = $amountOf;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

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
