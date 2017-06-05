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

    public $headerTitle;
    public $headerSubtitle;
    public $headerSubtitle2 = 'MENCION';
    
    public function Header()
    {
        $this->SetFont('Arial', 'B', 12);

        $posY = $this->GetY();
        $this->MultiCell(11, 0.7, $this->Image('../public/image/logo-ups-home.png', 2, 0.7, 6.5), 0, 'L');
        $this->SetXY($this->GetX()+11, $posY-2.2);
        $this->MultiCell(6, 0.7, $this->headerTitle, 0, 'R');
        $this->SetXY($this->GetX()+11, $posY-1.7);
        $this->MultiCell(6, 0.7, $this->headerSubtitle, 0, 'R');
        $this->SetXY($this->GetX()+11, $posY-1.2);
        $this->MultiCell(6, 0.7, $this->headerSubtitle2, 0, 'R');
        $this->Ln(1);
        //$this->Image('../public/image/logo-ups-home.png', 2, 0.7, 5);
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
