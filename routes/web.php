<?php

use App\Services\ProductService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

Route::get('/', function (ProductService $productService) {
    $products = $productService->getProducts(); 
    return response()->download(storage_path('app/public/'.$productService->printProducts($products)));
});
