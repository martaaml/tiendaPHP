<?php
namespace Services;
use Repositories\pedidosRepository;

class pedidosService{
    protected pedidosRepository $pedidosRepository;
    function __construct()
    {
        $this->pedidosRepository = new pedidosRepository();
    }
    public function allPedidos()
    {
        return $this->pedidosRepository->findAll();
    }   
}
?>