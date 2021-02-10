<?php

return [

    /*
    |--------------------------------------------------------------------------
    | access Language Lines
    |--------------------------------------------------------------------------
    |
    | this following language lines are for items(provider,product,stock...)
    |
    */

    //category
    'category' => [
        'count' => ':count categorie(s) found.',
    ],
    //product
    'product' => [
        'count' => ':count product(s) found.',
    ],
    //product
    'stock' => [
        'count' => ':count stock(s) found.',
        'expired' => ':itemExpired/:stockItemLeft items expired :expiredDate, :daysAfterExpiration days ago.',
        'AlmostExpired' => ':itemLeft/:stockItemLeft  items will expire :expiredDate, in :daysBeforeExpiration days soon.',
    ],
    //provider
    'provider' => [
        'count' => ':count provider(s) found.',
    ],

];
