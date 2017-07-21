<?php

use Faker\Generator as Faker;

// Factory to create an Assembly model.
$factory->define(App\Models\Assembly::class, function (Faker $faker) {
    return [
        'id' => 'c',
        'name_en' => 'Parliament of Lolcats',
        'name_fr' => 'Parlement des lolcats',
        'name_nl' => 'Parlement van lolcats',
    ];
});
