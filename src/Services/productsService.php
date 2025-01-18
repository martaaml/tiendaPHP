<?php
namespace Services;
use Repositories\productsRepository;

class productsService{
    protected productsRepository $productRepository;
    function __construct()
    {
        $this->productRepository = new productsRepository();
    }
    public function allProducts()
    {
        return $this->productRepository->findAll();
    }   
    public function store($product)
    {
        return $this->productRepository->store($product);
    }
}