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
    public function store($product)
    {
        try {
            $this->sql = $this->conection->prepareSQL(
                "INSERT INTO productos(categoria_id,nombre,descripcion,precio,stock,oferta,fecha,imagen,borrado) VALUES (:categoria_id,:nombre,:descripcion,:precio,:stock,:oferta,:fecha,:imagen,:borrado)"
            );
            $this->sql->bindValue(":categoria_id", $product->getCategoriaId());
            $this->sql->bindValue(":nombre", $product->getNombre());
            $this->sql->bindValue(":descripcion", $product->getDescripcion());
            $this->sql->bindValue(":precio", $product->getPrecio());
            $this->sql->bindValue(":stock", $product->getStock());
            $this->sql->bindValue(":oferta", $product->getOferta());
            $this->sql->bindValue(":fecha", $product->getFecha());
            $this->sql->bindValue(":imagen", $product->getImagen());
            $this->sql->bindValue(":borrado", 0);
            $this->sql->execute();
            $result = null;

        } catch (PDOException $e) {
            
            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        return $result;
    }   
}