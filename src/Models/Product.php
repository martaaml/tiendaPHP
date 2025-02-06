<?php
namespace Models;

class Product
{
    private string $id;
    private string $categoria_id;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private string $oferta;
    private string $fecha;
    private string $imagen;
    private bool $borrado;

    public function __construct(
        string $id,
        string $nombre,
        string $descripcion,
        string $categoria_id,
        float $precio,
        int $stock,
        string $oferta,
        string $fecha,
        string $imagen,
        bool $borrado
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria_id = $categoria_id;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->oferta = $oferta;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
        $this->borrado = $borrado;
    }

    // Métodos GETTERS y SETTERS
    public function getId(): ?string { return $this->id; }
    public function setId(?string $id): self { $this->id = $id; return $this; }
    
    public function getCategoriaId(): string { return $this->categoria_id; }
    public function setCategoriaId(string $categoria_id): self { $this->categoria_id = $categoria_id; return $this; }
    
    public function getNombre(): string { return $this->nombre; }
    public function setNombre(string $nombre): self { $this->nombre = $nombre; return $this; }
    
    public function getDescripcion(): string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): self { $this->descripcion = $descripcion; return $this; }
    
    public function getPrecio(): float { return $this->precio; }
    public function setPrecio(float $precio): self { $this->precio = $precio; return $this; }
    
    public function getStock(): int { return $this->stock; }
    public function setStock(int $stock): self { $this->stock = $stock; return $this; }
    
    public function getOferta(): string { return $this->oferta; }
    public function setOferta(string $oferta): self { $this->oferta = $oferta; return $this; }
    
    public function getFecha(): string { return $this->fecha; }
    public function setFecha(string $fecha): self { $this->fecha = $fecha; return $this; }
    
    public function getImagen(): string { return $this->imagen; }
    public function setImagen(string $imagen): self { $this->imagen = $imagen; return $this; }
    
    public function getBorrado(): bool { return $this->borrado; }
    public function setBorrado(bool $borrado): self { $this->borrado = $borrado; return $this; }

    // Método fromArray
    public static function fromArray(array $data): Product {
        return new Product(
            id: $data['id'] ?? '',
            nombre: $data['nombre'] ?? '',
            descripcion: $data['descripcion'] ?? '',
            categoria_id: $data['categoria_id'] ?? '',
            precio: isset($data['precio']) ? (float) $data['precio'] : 0.0,
            stock: isset($data['stock']) ? (int) $data['stock'] : 0,
            oferta: $data['oferta'] ?? '',
            fecha: $data['fecha'] ?? '',
            imagen: $data['imagen'] ?? '',
            borrado: isset($data['borrado']) ? (bool) $data['borrado'] : false
        );
    }

    // Método toArray
    public function toArray(): array {
        return [
            'id' => $this->id,
            'categoria_id' => $this->categoria_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => $this->stock,
            'oferta' => $this->oferta,
            'fecha' => $this->fecha,
            'imagen' => $this->imagen,
            'borrado' => $this->borrado
        ];
    }
}
