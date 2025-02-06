<?php

namespace Repositories;

use Lib\DataBase;
use Models\Product;
use PDOException;
use PDO;

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

    /**
     * Funcion para almacenar un producto
     */
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
    
    /**
     * Función para actualizar un producto
     * @param Product $product
     * @return string
     */
    public function update($product)
    {
        try {
            // Preparamos la consulta para actualizar el producto
            $this->sql = $this->conection->prepareSQL(
                "UPDATE productos SET 
                    nombre = :nombre, 
                    categoria_id = :categoria_id, 
                    descripcion = :descripcion, 
                    precio = :precio, 
                    stock = :stock, 
                    oferta = :oferta, 
                    fecha = :fecha, 
                    imagen = :imagen 
                WHERE id = :id"
            );
    
            // Asignamos los valores de las propiedades del producto
            $this->sql->bindValue(":nombre", $product->getNombre());
            $this->sql->bindValue(":categoria_id", $product->getCategoriaId());
            $this->sql->bindValue(":descripcion", $product->getDescripcion());
            $this->sql->bindValue(":precio", $product->getPrecio());
            $this->sql->bindValue(":stock", $product->getStock());
            $this->sql->bindValue(":oferta", $product->getOferta());
            $this->sql->bindValue(":fecha", $product->getFecha());
            $this->sql->bindValue(":imagen", $product->getImagen());
            $this->sql->bindValue(":id", $product->getId()); // Aquí se debe pasar el ID para saber qué producto actualizar
    
            // Ejecutamos la consulta
            $this->sql->execute();
            $result = null;
        } catch (PDOException $e) {
            $result = $e->getMessage();
        }
    
        $this->sql->closeCursor();
        return $result;
    }
    
    /**
     * Función para eliminar un producto
     */
    public function delete($product)
    {
        
        try {
            // Preparamos la consulta para marcar el producto como borrado
            $this->sql = $this->conection->prepareSQL(
                "UPDATE productos SET borrado = 1 WHERE id = :id"
            );
            $this->sql->bindValue(":id", $product->getId()); // Asignamos el ID del producto
            $this->sql->execute();
            $result = null;
        } catch (PDOException $e) {
            $result = $e->getMessage();
        }
    
        $this->sql->closeCursor();
        return $result;
    }
    
    public function findActive()
    {
        try {
            $this->conection->querySQL("SELECT * FROM productos WHERE borrado = 0");
            $productosData = $this->conection->allRegister();
            foreach ($productosData as $productoData) {
                $productos[] = Product::fromArray($productoData);
            }
        } catch (PDOException $e) {
            $productos = null;
        }
        return $productos;
    }

    public function reactive($product)
    {

        try {
            $this->sql = $this->conection->prepareSQL(
                "UPDATE productos SET borrado = 0 WHERE id = :id"
            );
            $this->sql->bindValue(":id", $product->getId());
            $this->sql->execute();
            $result = null;
        } catch (PDOException $e) {
            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        return $result;
    }

    public function findById(int $id)
    {
        try {
            $this->sql = $this->conection->prepareSQL("SELECT * FROM productos WHERE id = :id");
            $this->sql->bindValue(":id", $id);
            $this->sql->execute();
            $productData = $this->sql->fetch(PDO::FETCH_ASSOC) ?: null;
            if ($productData) {
                return Product::fromArray($productData); // Devuelve un objeto Product
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
        $this->sql->closeCursor();
    }
}
