<?php

$factory->define('App\Url', function (Faker\Generator $faker) {
    return [
        'desktop_url' => $faker->url,
        'mobile_url' => $faker->url,
        'tablet_url' => $faker->url,
    ];
});
