<?php

namespace Lib;

use Exception;
use TCPDF;
use TCPDF_FONTS;

class PDF
{
    private $tcpdf;

    public function __construct()
    {

        $this->tcpdf = new TCPDF();
        $this->tcpdf->setPrintFooter(false);
        $this->tcpdf->setPrintHeader(false);
        $this->tcpdf->setPrintFooter(false);
        $this->tcpdf->SetMargins(15, 15, 15);
        $this->tcpdf->SetAutoPageBreak(true, 20);
    }

    public function generarPDF(array $order): string
    {
        // Validar que las variables de sesión necesarias existen
        if (!isset($_SESSION['usuario']['nombre'], $_SESSION['carrito'], $_SESSION['costeTotal'])) {
            throw new Exception("No se puede generar el pedido, debido a que faltan datos.");
        }

        $usuarioNombre = $_SESSION['usuario']['nombre'];
        $carrito = $_SESSION['carrito'];
        $precio = $_SESSION['coste'];
        $hora = $_SESSION['hora'];

        $this->tcpdf->AddPage();

        // Título principal
        $muestra = "<h1>Pedido realizado a nombre de $usuarioNombre</h1>";
        $muestra .= "<h2>Pedido número {$order[0]['id']}:</h2>";

        // Tabla de productos
        $muestra .= "<table border='1' cellpadding='5'>";
        $muestra .= "<tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>";

        foreach ($carrito as $product) {
            $muestra .= "<tr>
                            <td>{$product['nombre']}</td>
                            <td>{$product['cantidad']}</td>
                            <td>{$product['coste']}</td>
                          </tr>";
        }

        $muestra .= "</table>";

        //Hora de pedido
        $muestra .= "<p><strong> Hora de pedido: {$hora[0]['hora']}</strong></p>";

        // Estado y total
        $muestra .= "<p><strong>Estado: {$order[0]['estado']}</strong></p>";
        $muestra .= "<p><strong>Total: {$precio}</strong></p>";

        // Escribir contenido en PDF
        $this->tcpdf->writeHTML($muestra, true, false, true, false, '');

        // Ruta para guardar el PDF
        $filePath = __DIR__ . "/pedido_{$order[0]['id']}.pdf";

        // Guardar el PDF en el servidor
        $this->tcpdf->Output($filePath, 'F');

        return $filePath;
    }
}