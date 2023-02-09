<?php

const V1 = '/api/v1/';

const API_ROUTES = [
    ["GET", V1 . "animals", [\App\Controllers\AnimalController::class, "index"]],
    ["PUT", V1 . "animals/{species}", [\App\Controllers\AnimalController::class, "store"]],
    ["DELETE", V1 . "animals", [\App\Controllers\AnimalController::class, "delete"]],
];