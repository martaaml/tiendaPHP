<?php
namespace Repositories;
use Lib\DataBase;
use Models\Category;
use PDOException;

class categoryRepository
{
    private DataBase $conection;
    private mixed $sql;

    public function __construct()
    {
        $this->conection = new DataBase();

    }
    public function findAll()
    {
        $categories = [];
        try {
            $this->conection->querySQL("SELECT * FROM categorias");
            $categoriesData = $this->conection->allRegister();
            foreach ($categoriesData as $categoryData) {
                $categories[] = Category::fromArray($categoryData);
            }
        } catch (PDOException $e) {
            $categories = null;
        }
        return $categories;
    }

    public function store($category)
    {
        try {
            $this->sql = $this->conection->prepareSQL(
                "INSERT INTO categorias(nombre,borrado) VALUES (:nombre,:borrado)"
            );
            $this->sql->bindValue(":nombre", $category->getNombre());
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