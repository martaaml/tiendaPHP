<?php
namespace Services;
use Repositories\pedidosRepository;

class pedidosService{
    protected pedidosRepository $pedidosRepository;
    function __construct()
    {
        $this->pedidosRepository = new pedidosRepository();
    }
    public function findAll():array
    {
        return $this->pedidosRepository->findAll();
    }   
    public function store($pedido)
    {
        return $this->pedidosRepository->store($pedido);
    }
    public function update($pedido)
    {
        return $this->pedidosRepository->update($pedido);
    }
    public function delete($pedido)
    {
        return $this->pedidosRepository->delete($pedido);
    }
    public function findActive()
    {
        return $this->pedidosRepository->findActive();
    }
    public function ver(int $id)
    {
        return $this->pedidosRepository->ver($id);
    }
}
?>