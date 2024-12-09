<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductService
{
    public function formatList(int $columnWidth, string $name, int $price): string{

        if (strlen($name) > $columnWidth - 10) { // Truncar si excede el ancho permitido
            $name = substr($name, 0, $columnWidth - 13) . '...';
        }

        $numberFormated = "$".number_format($price, 2); //Formatear el precio recibido
        $spaces = str_repeat(' ', $columnWidth - strlen($name) - strlen($numberFormated)); //Repetir un espacio con el widht dispónible restando los caracteres de nombre y precio.
        return $name . $spaces . $numberFormated . "\n";
    }

    public function getProducts()
    {
        try {
            return Product::all();
        } catch (\Throwable $th) {
            throw new HttpException(500, 'Error interno');
        }
    }

    public function printProducts(Collection $products)
    {
        $fileName = 'prueba.raw';
        $filePath = Storage::disk('public')->path($fileName);

        $conector = new NetworkPrintConnector('192.168.1.100');
        $printer = new Printer($conector);

        $printer->setTextSize(4, 4);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('Postresin' . PHP_EOL);
        $printer->setTextSize(1, 1);
        $printer->text(Date::now());
        $printer->feed(5);

        foreach ($products as $product) {
            // Establece un ancho fijo para las columnas
            $columnWidth = 30;
            $name = $product->name;
            $price = $product->price;

            // Imprime el producto formateado
            $printer->text($this->formatList($columnWidth, $name, $price));

            $printer->feed(2);
        }
        $printer->setEmphasis(true);
        $printer->text('Total de productos ' . $products->count());
        $printer->feed(5);

        $printer->setTextSize(1, 1);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text('Gracias por su compra :)');
        $printer->setEmphasis(true);
        $printer->cut();
        $printer->close();

        return $fileName;
    }
}
