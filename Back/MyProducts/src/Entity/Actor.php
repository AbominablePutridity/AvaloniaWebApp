<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Parameter;
use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

use ApiPlatform\OpenApi\Model\Operation;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            openapi: new Operation(
                tags:[
                    'ПользовательскийКод'
                ],
                summary: 'Получить дользовательские коды',
                description: 'Получить список пользовательских кодов',
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
                    )
                ]
            )
        ),
        new Post(
            openapi: new Operation(
                tags:[
                    'ПользовательскийКод'
                ],
                summary: 'Записать дользовательский код',
                description: 'Записать дользовательский код'
            )
        ),
        new Get(
            openapi: new Operation(
                tags:[
                    'ПользовательскийКод'
                ],
                summary: 'Получить дользовательский код',
                description: 'Получить код по id'
            )
        ),
        new Delete(
            openapi: new Operation(
                tags: ['ПользовательскийКод'],
                summary: 'Удалить пользовательский код',
                description: 'Удалить пользовательский код по id'
            )
        ),
        new Patch(
            openapi: new Operation(
                tags: ['ПользовательскийКод'],
                summary: 'Заменить пользовательский код',
                description: 'Заменить пользовательский код по id'
            )
        )
    ]
)]
class Actor
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    /**
     * @var Collection<int, Raiting>
     */
    #[ORM\OneToMany(targetEntity: Raiting::class, mappedBy: 'actor', orphanRemoval: true)]
    private Collection $raitings;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $products;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->raitings = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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
            $raiting->setActor($this);
        }

        return $this;
    }

    public function removeRaiting(Raiting $raiting): static
    {
        if ($this->raitings->removeElement($raiting)) {
            // set the owning side to null (unless already changed)
            if ($raiting->getActor() === $this) {
                $raiting->setActor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setAuthor($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAuthor() === $this) {
                $product->setAuthor(null);
            }
        }

        return $this;
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
}
