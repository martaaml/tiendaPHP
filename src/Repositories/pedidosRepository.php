<?php
namespace Repositories;
use Lib\DataBase;
use Models\Pedido;
use PDOException;

class pedidosRepository
{
    private DataBase $conection;
    private mixed $sql; 
    public function __construct()
    {
        $this->conection = new DataBase();
    }
    public function findAll()
    {
        $pedidos = [];
        try {
            $this->conection->querySQL("SELECT * FROM pedidos");
            $pedidosData = $this->conection->allRegister();
            foreach ($pedidosData as $pedidoData) {
                $pedidos[] = Pedido::fromArray($pedidoData);
            }
        } catch (PDOException $e) {
            $pedidos = null;
        }
        return $pedidos;
    }
    public function store($pedido)
    {
        try {
            $this->sql = $this->conection->prepareSQL(
                "INSERT INTO pedidos(nombre,email,telefono,provincia,localidad,direccion,coste,estado,fecha,hora,borrado) VALUES (:nombre,:email,:telefono,:provincia,:localidad,:direccion,:coste,:estado,:fecha,:hora,:borrado)"
            );
            $this->sql->bindValue(":nombre", $pedido->getNombre());
            $this->sql->bindValue(":email", $pedido->getEmail());
            $this->sql->bindValue(":telefono", $pedido->getTelefono());
            $this->sql->bindValue(":provincia", $pedido->getProvincia());
            $this->sql->bindValue(":localidad", $pedido->getLocalidad());
            $this->sql->bindValue(":direccion", $pedido->getDireccion());
            $this->sql->bindValue(":coste", $pedido->getCoste());
            $this->sql->bindValue(":estado", $pedido->getEstado());
            $this->sql->bindValue(":fecha", $pedido->getFecha());
            $this->sql->bindValue(":hora", $pedido->getHora());
            $this->sql->bindValue(":borrado", 0);
            $this->sql->execute();
            $result = null;
        } catch (PDOException $e) {

            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        return $result;
    }
    public function update($pedido)
    {
        try {
            $this->sql = $this->conection->prepareSQL(                
                "UPDATE pedidos SET nombre = :nombre, email = :email, telefono = :telefono, provincia = :provincia, localidad = :localidad, direccion = :direccion, coste = :coste, estado = :estado, fecha = :fecha, hora = :hora, borrado = :borrado WHERE id = :id"
            );
            $this->sql->execute();
            $result = null;
        } catch (PDOException $e) {

            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        return $result;
    }
    public function delete($pedido)
    {
        try {
            $this->sql = $this->conection->prepareSQL(
                "UPDATE pedidos SET borrado = 1 WHERE id = :id"
            );
            $this->sql->bindValue(":id", $pedido->getId());
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
        $pedidos = [];
        try {
            $this->conection->querySQL("SELECT * FROM pedidos");
            $pedidosData = $this->conection->allRegister();
            foreach ($pedidosData as $pedidoData) {
                $pedidos[] = Pedido::fromArray($pedidoData);
            }
        } catch (PDOException $e) {
            $pedidos = null;
        }
        return $pedidos;
    }   

    public function ver(int $id)
    {
        $pedido = null;
        try {
            $this->conection->querySQL("SELECT * FROM pedidos WHERE id = :id");
            $pedidoData = $this->conection->allRegister();
            $pedido = Pedido::fromArray($pedidoData[0]);
        } catch (PDOException $e) {
            $pedido = null;
        }
        return $pedido;
    }
}