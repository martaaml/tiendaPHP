<?php
namespace Services;
use Repositories\productsRepository;

class productsService{
    protected productsRepository $productRepository;
    function __construct()
    {
        $this->productRepository = new productsRepository();
    }
    public function findAll()
    {
        return $this->productRepository->findAll();
    }   
    public function store($product)
    {
        return $this->productRepository->store($product);
    }
    public function update($product)
    {
        return $this->productRepository->update($product);
    }
    public function delete($product)
    {
        return $this->productRepository->delete($product);
    }
    public function findActive()
    {
        return $this->productRepository->findActive();
    }
    public function reactive($product){
        return $this->productRepository->reactive($product);
    }
    public function findById(int $id)
    {
        return $this->productRepository->findById($id);
    }
}