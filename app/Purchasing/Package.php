<?php

namespace App\Purchasing;

use Illuminate\Support\Carbon;

class Package
{

    private int $price;
    private int $quantity;
    private ?int $expires;
    private string $trans_key;
    private string $id;
    private string $type;
    private string $description;
    private string $icon;
    private string $iconSize;

    public function __construct(array $configured)
    {
        $this->id = $configured['id'];
        $this->price = $configured['price'];
        $this->trans_key = $configured['trans_key'] ?? '';
        $this->type = $configured['type'];
        $this->quantity = $configured['quantity'] ?? 1;
        $this->description = $configured['description'] ?? '';
        $this->expires = $configured['expires'] ?? null;
        $this->icon = $configured['icon'] ?? '';
        $this->iconSize = $configured['icon_size'] ?? '';
    }

    public static function find(string $id): self
    {
        $from_config = collect(config("packages"))->first(fn($package) => $package['id'] === $id);

        if (!$from_config) {
            throw new \InvalidArgumentException("package with id {$id} does not exist");
        }

        return new Package($from_config);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPriceAsFloat(): float
    {
        return $this->price;
    }

    public function getName($lang = 'en'): string
    {
        return trans("{$this->trans_key}.name", [], $lang);
    }

    public function getDescription($lang = 'en'): string
    {
        return trans("{$this->trans_key}.description", [], $lang);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getExpiry(): Carbon
    {
        if(!$this->expires) {
            return now()->addCentury();
        }

        return now()->addDays($this->expires);
    }

    public function fields(): array
    {
        return [
            'Code'         => null,
            'IsDynamic'    => true,
            'PurchaseType' => 'PRODUCT',
            'Tangible'     => false,
            'Name'         => $this->getName(),
            'Price'        => [
                'PriceAmount' => $this->getPriceAsFloat(),
                'PriceType'   => 'CUSTOM',
            ],
        ];
    }

    public function present($lang = 'en'): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName($lang),
            'description' => $this->getDescription(),
            'price' => sprintf("US$%s.00", $this->getPrice()),
            'type' => $this->getType(),
            'selling_points' => trans("{$this->trans_key}.selling_points", [], $lang),
            'icon' => $this->icon,
            'icon_size' => $this->iconSize,
        ];
    }
}
