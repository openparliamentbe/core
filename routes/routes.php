<?php

Route::resource('/assemblies', 'AssembliesController', [
    'only' => ['index']
]);
