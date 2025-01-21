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
}