<?php

namespace App\Models;

class Cart
{


    public function __construct(private array $items, private int $total = 0)
    {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getProductCount(): int
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item['quantity'];
        }

        return $total;
    }

    private function updateItem(Item $item)
    {
        $itemsInCart = $this->getItems();
        foreach ($itemsInCart as $key => $cartItem) {
            if ($cartItem->product->id == $item->product->id && $cartItem->color->id == $item->color->id) {
                $cartItem->quantity += $item->quantity;
                $cartItem->color = $item->color;
                $cartItem->total = $cartItem->product->price * $cartItem->quantity;
                $itemsInCart[$key] = $cartItem;
            }
        }
        $this->setItems($itemsInCart);
    }

    public function addItem(Item $item)
    {
        if (!$this->containsItem($item)) {
            $itemsInCart = $this->getItems();
            $itemsInCart[] = $item;
            $this->setItems($itemsInCart);
        } else {
            $this->updateItem($item);
        }

    }

    private function recalculateTotal()
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->product->price * $item->quantity;
        }
        $this->setTotal($total);

    }

    public function containsItem(Item $item): bool
    {
        foreach ($this->getItems() as $cartItem) {
            if ($cartItem->product->id == $item->product->id && $cartItem->color->id == $item->color->id) {
                return true;
            }
        }

        return false;
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items,
            'total' => $this->total,
        ];
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
        $this->recalculateTotal();
    }

    public function removeItem(Item $item)
    {

        $itemsInCart = $this->getItems();

        foreach ($itemsInCart as $key => $cartItem) {
            if ($cartItem->product->id == $item->product->id && $cartItem->color->id == $item->color->id) {
                unset($itemsInCart[$key]);
            }
        }

        $this->setItems($itemsInCart);

    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

}
