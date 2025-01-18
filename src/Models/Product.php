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
        string $id = null,
        string $categoria_id,
        string $nombre,
        string $descripcion,
        float $precio,
        int $stock,
        string $oferta,
        string $fecha,
        string $imagen
    ) {
        $this->id = $id;
        $this->categoria_id = $categoria_id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->oferta = $oferta;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
        $this->borrado = false;
    }
    

    //GETTER DEL ID DEL PRODUCTO
    public function getId(): ?string
    {
        return $this->id;
    }

    //SETTER DEL ID DEL PRODUCTO
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    //GETTER DEL ID DE LA CATEGORIA DEL PRODUCTO
    public function getCategoriaId(): string
    {
        return $this->categoria_id;
    }

    //SETTER DEL ID DE LA CATEGORIA DEL PRODUCTO
    public function setCategoriaId(string $categoria_id): self
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }

    //GETTER DEL NOMBRE DEL PRODUCTO
    public function getNombre(): string
    {
        return $this->nombre;
    }

    //SETTER DEL NOMBRE DEL PRODUCTO
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    //GETTER DE LA DESCRIPCION DEL PRODUCTO
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    //SETTER DE LA DESCRIPCION DEL PRODUCTO
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    //GETTER DEL PRECIO DEL PRODUCTO
    public function getPrecio(): float
    {
        return $this->precio;
    }

    //SETTER DEL PRECIO DEL PRODUCTO
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    //GETTER DEL STOCK DEL PRODUCTO
    public function getStock(): int
    {
        return $this->stock;
    }

    //SETTER DEL STOCK DEL PRODUCTO
    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
    public function getOferta(): string
    {
        return $this->oferta;
    }

    //SETTER DEL OFERTA DEL PRODUCTO
    public function setOferta(string $oferta): self
    {
        $this->oferta = $oferta;

        return $this;
    }

    //GETTER DEL FECHA DEL PRODUCTO
    public function getFecha(): string
    {
        return $this->fecha;
    }

    //SETTER DEL FECHA DEL PRODUCTO
    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    //GETTER DEL IMAGEN DEL PRODUCTO
    public function getImagen(): string
    {
        return $this->imagen;
    }

    //SETTER DEL IMAGEN DEL PRODUCTO
    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    //GETTER DEL BORRADO DEL PRODUCTO
    public function getBorrado(): bool
    {
        return $this->borrado;
    }

    //SETTER DEL BORRADO DEL PRODUCTO
    public function setBorrado(bool $borrado): self
    {
        $this->borrado = $borrado;

        return $this;
    }
    //Metodo fromarray
    public static function fromArray(array $data): Product{
        return new Product(
            id: $data['id']??null,
            categoria_id: $data['categoria_id']??'',
            nombre: $data['nombre']??'',
            descripcion: $data['descripcion']??'',
            precio: $data['precio']??'',
            stock: $data['stock']??'',
            oferta: $data['oferta']??'',
            fecha: $data['fecha']??'',
            imagen: $data['imagen']??''
        );
    }

    //Metodo toArray
    public function toArray(): array
    {
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