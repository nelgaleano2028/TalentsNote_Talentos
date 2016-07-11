<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
		
    function __construct()
    {
        parent::__construct();
    }
	
	
	 //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'afq.png';
        $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 100, 'http://www.finalwebsites.com', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->Cell(15, 15, ' AFA S.A.S ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

     public function Footer() {
		$this->SetY(-15);
		$this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
		$this->Cell(0, 10, 'finalwebsites.com - PHP Script Resource, PHP classes and code for web developer', 0, false, 'C');
	}
	
}

?>