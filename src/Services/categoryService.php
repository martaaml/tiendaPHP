<?php
namespace Services;
use Repositories\categoryRepository;

class categoryService{
    protected categoryRepository $categoryRepository;
    function __construct()
    {
        $this->categoryRepository = new categoryRepository();
    }
    public function allCategories()
    {
        return $this->categoryRepository->findAll();
    }   
}   