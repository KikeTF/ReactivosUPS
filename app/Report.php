<?php
/**
 * Created by PhpStorm.
 * User: Neptali Torres F
 * Date: 01/05/2017
 * Time: 14:42
 */

namespace ReactivosUPS;

use Ghidev\Fpdf\Fpdf;

class Report extends Fpdf
{

    public function Header()
    {
        $this->Image('../public/image/logo-ups-home.png', 2, 0.7, 5);
    }

    public function Footer()
    {
        $user = utf8_decode(\Auth::user()->FullName);
        $date = date('Y-m-d h:i:s');

        $this->SetY(-6);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,$date.' / '.$user,0,0,'L');
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
    }

}
