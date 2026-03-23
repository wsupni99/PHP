<?php

class Product {
    public function __construct(
        private int $id,
        private string $title,
        private float $price
    ) {}

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getFormattedPrice(): string {
        return number_format($this->getPrice(), 2, '.', ' ') . ' руб.';
    }
}
