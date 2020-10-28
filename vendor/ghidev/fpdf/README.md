# FPDF

ghidev/fpdf es una clase para la generación dinámica de documentos PDF en PHP.
Además incluye las clases para crear tablas con multiceldas y realizar una rotación en torno a un centro determinado .

## Instalación con [Composer](https://packagist.org/packages/ghidev/fpdf)

Si usas composer para administrar tus paquetes, puedes usar

    $ composer require ghidev/fpdf:dev-master

o puedes incluir el siguiente codigo en tu archivo `composer.json`:

```json
{
    "require": {
        "ghidev/fpdf": "dev-master"
    }
}
```
Después, ejecuta `composer update` para descargarlo.

Agrega los  `service providers` a `app/config/app.php`, dentro del arreglo `providers`.

```php
'providers' => array(
	// ...
    
    Ghidev\Fpdf\FpdfServiceProvider::class,
    Ghidev\Fpdf\RotationServiceProvider::class,
    Ghidev\Fpdf\MC_TableServiceProvider::class,
)
```

Por último, agrega los  `alias` a `app/config/app.php`, dentro del arreglo `aliases`.

```php
'aliases' => array(
	// ...

	'Fpdf'      => Ghidev\Fpdf\Facades\Fpdf::class,
    'Rotation'    => Ghidev\Fpdf\Facades\Rotation::class,
    'MC_Table'  => Ghidev\Fpdf\Facades\MC_Table::class,
)
```

##Código de Ejemplo

```php
Route::get('pdf', function(){

    $fpdf = new Ghidev\Fpdf\Fpdf;
    $fpdf->AddPage();
    $fpdf->SetFont('Arial','B',16);
    $fpdf->Cell(40,10,'Hello World!');
    $fpdf->Output();
    exit;

});
```

##Ó

```php
Route::get('pdf', function(){

    Fpdf::AddPage();
    Fpdf::SetFont('Arial','B',16);
    Fpdf::Cell(40,10,'Hello World!');
    Fpdf::Output();
    exit;
});
```
