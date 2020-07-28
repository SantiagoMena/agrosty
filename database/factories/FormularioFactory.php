<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Formulario;
use Faker\Generator as Faker;

$factory->define(Formulario::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'email' => $faker->email,
        'asunto' => 'Reclamo',
        'mensaje' => $faker->realText(200, 2),
        'es_spam' => false,
    ];
});
