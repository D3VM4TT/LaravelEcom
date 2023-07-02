<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;

class CartService
{

    public function getCart(): mixed
    {
        return session()->get('cart');
    }

    public function createCart(): void
    {
        session()->put('cart', [
            'items' => [],
            'total' => 0,
        ]);
    }

    public function cartContainsItem($item): bool
    {
        $cart = $this->getCart();

        foreach ($cart['items'] as $cartItem) {
            if ($cartItem['product_id'] == $item['product_id'] && $cartItem['color'] == $item['color']) {
                return true;
            }
        }

        return false;
    }

    public function addOrUpdateItemInCart($item)
    {
        $cart = $this->getCart();


        if (!$cart) {
            $this->createCart();
        }

        if ($this->cartContainsItem($item)) {
            return $this->updateItemInCart($item);
        }

        session()->flash('success', 'Item added to cart');

        return $this->createItemInCart($item);


    }

    private function updateItemInCart($item)
    {

        $cart = $this->getCart();


        foreach ($cart['items'] as $key => $cartItem) {
            if ($cartItem['product_id'] == $item['product_id'] && $cartItem['color'] == $item['color']) {
                $cartItem['color'] = $item['color'];
                $cartItem['quantity'] += $item['quantity'];
                $cart['items'][$key] = $cartItem;
            }
        }
        session()->put('cart', $cart);
    }

    private function createItemInCart($item)
    {
        $cart = $this->getCart();

        $cart['items'][] = $item;

        session()->put('cart', $cart);
    }

}
