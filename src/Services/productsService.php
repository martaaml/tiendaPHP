<?php

namespace Services;

use Repositories\productsRepository;

class productsService
{
    protected productsRepository $productRepository;
    function __construct()
    {
        $this->productRepository = new productsRepository();
    }

    /**
     * Función para obtener todos los productos
     * 
     */
    public function findAll()
    {
        return $this->productRepository->findAll();
    }

    /**
     * Función para almacenar un producto   
     * @param Product $product
     * @return string
     */
    public function store($product)
    {
        return $this->productRepository->store($product);
    }

    /**
     * Función para actualizar un producto  
     * @param Product $product
     * @return string
     */
    public function update($product)
    {
        return $this->productRepository->update($product);
    }

    /**
     * Función para borrar un producto  
     * @param Product $product
     * @return string
     */
    public function delete($product)
    {
        return $this->productRepository->delete($product);
    }

    /**
     * Funcion para obtener todos los productos activos 
     *  
     */
    public function findActive()
    {
        return $this->productRepository->findActive();
    }

    /**
     * Funcion para reactivar un producto
     *  
     */
    public function reactive($product)
    {
        return $this->productRepository->reactive($product);
    }
    /**
     * Funcion para obtener un producto por su id   
     * @param int $id con el id del producto
     * @return Product
     */
    public function findById(int $id)
    {
        return $this->productRepository->findById($id);
    }
}
