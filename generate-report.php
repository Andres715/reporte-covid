<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    include "./fpdf/fpdf.php";

    $url = "https://www.datos.gov.co/resource/gt2j-8ykr.json";
    $res = json_decode(file_get_contents($url));

    class PDF extends FPDF{
        function Header(){
            //header
            $this->SetY(0);
            $this->SetFont("Arial","B",30);
            $this->SetFillColor(14,22,61);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(0,30,"  Reporte Covid-19 CO", 0, 1, 'L', true);
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        }

        function ChapterTitle(){
            $this->SetY(31);
            $this->SetFont("Arial","B", 16);
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(14, 22, 61);
            $this->Cell(0,10,utf8_decode("Datos básicos de contagiados"), 0, 1, 'L', true);
        }

        function ChapterBody($M,$F, $promedioEdad, $comunitaria, $relacionado, $recuperados){
            //body
            $this->SetTextColor(0, 0, 0);
            $this->SetFont("Arial", "", 12);
            $this->SetFillColor(255,255,255);
            $this->Cell(0,6,"Total de Hombres: ". $M, 0, 1, 'L', true);
            $this->Cell(0,6,"Total de Mujeres: ". $F, 0, 1, 'L', true);
            $this->Cell(0,6,"Promedio de edad: ". $promedioEdad/25, 0, 1, 'L', true);
            $this->Cell(0,6,"Contagio comunitario: ". $comunitaria, 0, 1, 'L', true);
            $this->Cell(0,6,"Contagio Relacionado: ". $relacionado, 0, 1, 'L', true);
            $this->Cell(0,6,"Total de Recuperados: ". $recuperados, 0, 1, 'L', true);
            $this->Ln();
            $this->Cell(0,6,"Datos Recuperados de:", 0, 1, 'L', true);
            $this->SetTextColor(33,121,254);
            $this->Cell(0,6,"https://www.datos.gov.co/resource/gt2j-8ykr.json", 0, 1, 'L', true);

        }

        function FancyTable($res){
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(14,22,61);
        $this->SetDrawColor(238,156,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B', 12);
        $w = array(24,58,15,15,30,18,29);
        // Cabecera
        $this->Cell(24, 10, "ID", 0, 0, "C", 1);
        $this->Cell(58, 10, "Ciudad/Municipio", 0, 0, "L", 1);
        $this->Cell(15, 10, "Sexo", 0, 0, "C", 1);
        $this->Cell(15, 10, "Edad", 0, 0, "C", 1);
        $this->Cell(30, 10, "Contagio", 0, 0, "C", 1);
        $this->Cell(18, 10, "Estado", 0, 0, "C", 1);
        $this->Cell(30, 10, "Recuperado", 0, 0, "C", 1);
        $this->Ln();
        
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 12);
        // Datos
        $fill = false;
        $i = 0;
        $M = 0;
        $F = 0;
        $promedioEdad = 0;
        $comunitaria = 0;
        $relacionado = 0;
        $recuperados = 0;
        foreach($res as $row){
            
            $this->Cell(24,6, $row->id_de_caso,0,0,'C',$fill);
            $this->Cell(58,6, $row->ciudad_municipio_nom,0,0,'L',$fill);
            $this->Cell(15,6, $row->sexo,0,0,'C',$fill);
            $this->Cell(15,6, $row->edad,0,0,'C',$fill);
            $this->Cell(30,6, $row->fuente_tipo_contagio,0,0,'C',$fill);
            $this->Cell(18,6, $row->estado,0,0,'C',$fill);
            $this->Cell(30,6, $row->recuperado,0,0,'C',$fill);
            $this->Ln();
            $fill = !$fill;

            $M = $row->sexo == 'M' ? $M = $M + 1 : $M;
            $F = $row->sexo == 'F' ? $F = $F + 1 : $F;
            $promedioEdad = $promedioEdad + $row->edad;
            $comunitaria = $row->fuente_tipo_contagio == 'Comunitaria'? $comunitaria = $comunitaria + 1 : $comunitaria;
            $relacionado = $row->fuente_tipo_contagio == 'Relacionado'? $relacionado = $relacionado + 1 : $relacionado;
            $recuperados = $row->recuperado == "Recuperado"? $recuperados = $recuperados + 1: $recuperados;

            $i++;
            if($i == 25){
                break;
            }
        }
        // Línea de cierre
        $this->Cell(array_sum($w) + 1,6,'','T');

        $this->Ln();

        $this->ChapterBody($M,$F, $promedioEdad, $comunitaria, $relacionado, $recuperados);

    }

        function PrintChapter($res){
            $this->AddPage();
            $this->ChapterTitle();
            $this->FancyTable($res);
        }
    }

    //Objeto FPDF
    $pdf = new PDF();
    $pdf->PrintChapter($res);

    $pdf->Output();

?>