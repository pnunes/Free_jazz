<?php
require_once ("fpdf.php");
class PDF extends FPDF {
    var $nome;          // nome do relatorio
    var $soma;          // variavel soma
    var $cabecalho;     // cabecalho para as colunas
    function PDF($or = 'P') { // Construtor: Chama a classe FPDF
        $this->FPDF($or);
    }
    function SetCabecalho($cab) { // define o cabecalho
        $this->cabecalho = $cab;
    }
    function SetName($nomerel) { // nomeia o relatorio
       $this->nome = $nomerel;
    }
    function SetSoma($somarel) { // define a variavel soma
       $this->soma = $somarel;
    }
    function SetTotal($totarel) { // define a variavel total de quantidade
       $this->total = $totarel;
    }
    function Header() {
        $this->AliasNbPages(); // Define o numero total de paginas para a macro {nb}
        $this->Image('logo.jpg', 5, 5, 40); // importa uma imagem
        $this->SetFont('Arial', 'B', 9);
        $this->SetX(60);
        $this->Cell($this->GetStringWidth($this->nome), 10, $this->nome);
        $this->SetFont('Arial', '', 7);
        $this->SetX(-30);
        $this->Cell(30, 9, "Página: ".$this->PageNo()."/{nb}", 0, 1); // imprime página X/Total de Páginas
        $this->SetX(-10);
        $this->line(10, 18, $this->GetX(), 18); // Desenha uma linha
        if ($this->cabecalho) { // Se tem o cabecalho, imprime
            $this->SetFont('Arial', '', 8);//fonte do titulo da colunas
            $this->SetX(10);
            $this->Cell($this->GetStringWidth($this->cabecalho), 5, $this->cabecalho, 0, 1);
        }
        $this->SetXY(10, 25);
    }
    function Footer() { // Rodapé : imprime a hora de impressao e Copyright
        $this->SetXY(-30, -20);
        $this->SetX(120);
        $this->Cell($this->GetStringWidth($this->soma), 8, $this->soma);
        $this->SetX(40);
        $this->Cell($this->GetStringWidth($this->total), 8, $this->total);
        $this->SetXY(-15, -10);
        $this->line(10, $this->GetY()-2, $this->GetX(), $this->GetY()-2);
        $this->SetX(0);
        $this->SetFont('Courier', 'BI', 8);
        $data = strftime("%d/%m/%Y às %T");
        $this->Cell(100, 6, "(Transportes Free Jazz Ltda - Impresso : ".$data, 0, 0, 'R');
    }
}
?>
