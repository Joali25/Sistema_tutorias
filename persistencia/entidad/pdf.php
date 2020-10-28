<?php

namespace Persistencia\Entidad;

use Ghidev\Fpdf\Fpdf;

class PDF extends Fpdf
{
    public $custom;

    public function __construct($nombre) {
        parent::__construct();
        $this->custom = $nombre;
    }

    function Header()
    {
        $this->SetFont('Arial','B',20);
        $this->Cell(20,5,$this->custom,0,0,'C');
        $this->Ln(5);
    }
         
}

?>