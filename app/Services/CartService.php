<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Http\Requests\ProductRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Item;
use App\Models\Product;

class CartService
{

    const SESSION_CART_NAME = 'cart';

    public function getCart(): ?Cart
    {
        $cart = session()->get(self::SESSION_CART_NAME);

        if (!$cart) {
            return null;
        }

        return new Cart($cart['items'], $cart['total']);
    }

    public function createNewCart(): ?Cart
    {
        $items = [];
        $total = 0;

        $cart = new Cart($items, $total);
        session()->put(self::SESSION_CART_NAME, $cart->toArray());
        return $cart;
    }


    public function addItemToCartSession(Item $item)
    {
        $cart = $this->getCart();

        if (!$cart) {
            $cart = $this->createNewCart();
        }

        $cart->addItem($item);

        session()->put(self::SESSION_CART_NAME, $cart->toArray());

        session()->flash('success', 'Item added to cart');

    }

    public function removeItemFromCartSession(Item $item): void
    {
        $cart = $this->getCart();

        if (!$cart) {
            $cart = $this->createNewCart();
        }

        $cart->removeItem($item);

        session()->put(self::SESSION_CART_NAME, $cart->toArray());

        session()->flash('success', 'Item removed from cart');

    }

    public function getItemByProductId(int $productId): ?Item
    {
        $cart = $this->getCart();

        if (!$cart) {
            return null;
        }

        foreach ($cart->getItems() as $item) {
            if ($item->product->id == $productId) {
                return $item;
            }
        }

        return null;
    }

    public function clearCart(): void
    {
        session()->forget(self::SESSION_CART_NAME);
        session()->flash('success', 'Item removed from cart');
    }


}
