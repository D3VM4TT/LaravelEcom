<?php

namespace App\Permissions;

class Permissions
{
    public const CAN_LIST_PRODUCTS = 'product-list';
    public const CAN_CREATE_PRODUCTS = 'product-create';
    public const CAN_EDIT_PRODUCTS = 'product-edit';
    public const CAN_DELETE_PRODUCTS = 'product-delete';
    public const PRODUCT_PERMISSIONS = [
        self::CAN_LIST_PRODUCTS,
        self::CAN_CREATE_PRODUCTS,
        self::CAN_EDIT_PRODUCTS,
        self::CAN_DELETE_PRODUCTS
    ];


}
