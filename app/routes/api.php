<?php

const V1 = '/api/v1/';

const API_ROUTES = [
    ["GET", V1 . "index", [\App\Controllers\AnimalController::class, "index"]],
    ["PUT", V1 . "store/{species}", [\App\Controllers\AnimalController::class, "store"]],
    ["DELETE", V1 . "delete", [\App\Controllers\AnimalController::class, "delete"]],
];