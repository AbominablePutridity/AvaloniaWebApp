<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Parameter;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

use ApiPlatform\OpenApi\Model\Operation;
use App\Providers\ProductStateProvider as ProvidersProductStateProvider;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            openapi: new Operation(
                tags:[
                    'Продукция'
                ],
                summary: 'Получить Список продукции',
                description: 'Получить список продукции',
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
                            'default' => 6
                        ]
                    ),
                    new Parameter(
                        name: 'actorCode',
                        in: 'query',
                        schema: [
                            'type' => 'string',
                        ]
                    ),
                ]
            ),
            provider: ProvidersProductStateProvider::class,
        ),
        new Post(
            openapi: new Operation(
                tags: ['Продукция'],
                summary: 'Записать продукцию',
                description: 'Записать продукцию по id'
            )
        ),
        new Get(
            openapi: new Operation(
                tags: ['Продукция'],
                summary: 'Взять продукцию',
                description: 'Взять продукцию по id'
            )
        ),
        new Delete(
            openapi: new Operation(
                tags: ['Продукция'],
                summary: 'Удалить продукцию',
                description: 'Удалить продукцию по id'
            )
        ),
        new Patch(
            openapi: new Operation(
                tags: ['Продукция'],
                summary: 'Обновить продукцию',
                description: 'Обновить продукцию по id'
            )
        )
    ]
)]
class Product
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

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    /**
     * @var Collection<int, Raiting>
     */
    #[ORM\OneToMany(targetEntity: Raiting::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $raitings;

    /**
     * @var Collection<int, Material>
     */
    #[ORM\OneToMany(targetEntity: Material::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $materials;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiFilter(SearchFilter::class, properties: ['author' => 'exact'])]
    private ?Actor $author = null;

    public function __construct()
    {
        $this->raitings = new ArrayCollection();
    }

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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, Raiting>
     */
    public function getRaitings(): Collection
    {
        return $this->raitings;
    }

    public function addRaiting(Raiting $raiting): static
    {
        if (!$this->raitings->contains($raiting)) {
            $this->raitings->add($raiting);
            $raiting->setProduct($this);
        }

        return $this;
    }

    public function removeRaiting(Raiting $raiting): static
    {
        if ($this->raitings->removeElement($raiting)) {
            // set the owning side to null (unless already changed)
            if ($raiting->getProduct() === $this) {
                $raiting->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Material>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): static
    {
        if (!$this->materials->contains($material)) {
            $this->materials->add($material);
            $material->setProduct($this);
        }

        return $this;
    }

    public function removeMaterial(Material $material): static
    {
        if ($this->materials->removeElement($material)) {
            // set the owning side to null (unless already changed)
            if ($material->getProduct() === $this) {
                $material->setProduct(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?Actor
    {
        return $this->author;
    }

    public function setAuthor(?Actor $author): static
    {
        $this->author = $author;

        return $this;
    }
}
