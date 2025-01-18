<?php
namespace Repositories;
use Lib\DataBase;
use Models\Product;
use PDOException;

class productsRepository
{
    private DataBase $conection;
    private mixed $sql;
    public function __construct()
    {
        $this->conection = new DataBase();
    }
    public function findAll()
    {
        $products = [];
        try {
            $this->conection->querySQL("SELECT * FROM productos");
            $productsData = $this->conection->allRegister();
            foreach ($productsData as $productData) {
                $products[] = Product::fromArray($productData);
            }
        } catch (PDOException $e) {
            $products = null;
        }
        return $products;
    }
}