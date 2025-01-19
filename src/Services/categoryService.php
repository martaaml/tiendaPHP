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
    public function store($category)
    {
        return $this->categoryRepository->store($category);
    }
    public function update($category)
    {
        return $this->categoryRepository->update($category);
    }
        public function delete($category)
    {
        return $this->categoryRepository->delete($category);
    }
    public function findActive()
    {
        return $this->categoryRepository->findActive();
    }
    public function reactive($category){
        return $this->categoryRepository->reactive($category);
    }
}   