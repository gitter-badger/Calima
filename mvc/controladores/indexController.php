<?php

class indexController extends Cf_Controlador
{
    private $_exc;
    private $_ayud;
    
    public function __construct() {
        parent::__construct();
        $this->cargaLib('PHPExcel');
        $this->_ayud = new PHPExcel;
        
        // cargamos la clase ayudantes para usar sus metodos de ayuda
        $this->cargaAyudante('PHPAyuda');
        $this->_ayud= new PHPAyuda;
        
    }
    
    public function index()
    {
        
        $datas = $this->cargaMod('prueba');
        $this->_vista->postear= $datas->llamarDatos();
        
        $this->_vista->titulo = 'CalimaFramework';
        $this->_vista->imprimirVista('index', 'inicio');
        
        //ejemplo de filtros para seguridad en formularios
        $this->filtro('<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>');
        $this->filtroEspeciales("<a href='test'>Test</a>");
        
    }
    
    public function pruebas()
    {
        $datas = $this->cargaMod('prueba');
        $this->_vista->postear= $datas->llamarDatos();
        
        $this->_vista->titulo = 'CalimaFramework';
        $this->_vista->imprimirVista('index', 'inicio');
    }
    
    public function filtro($texto){
        
       echo $this->_ayud->filtrarTexto($texto);
    }
    
    public function filtroEspeciales($texto){
    echo $this->_ayud->filtrarCaracteresEspeciales($texto);
    }
    
    public function ecx1(){
        
        error_reporting(0);
        // Establecer propiedades
$this->_exc->getProperties()
->setCreator("Cattivo")
->setLastModifiedBy("Cattivo")
->setTitle("Documento Excel de Prueba")
->setSubject("Documento Excel de Prueba")
->setDescription("Demostracion sobre como crear archivos de Excel desde PHP.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Pruebas de Excel");

// Agregar Informacion
$this->_exc->setActiveSheetIndex(0)
->setCellValue('A1', 'Valor 1')
->setCellValue('B1', 'Valor 2')
->setCellValue('C1', 'Total')
->setCellValue('A2', '10')
->setCellValue('C2', '=sum(A2:B2)');

// Renombrar Hoja
$this->_exc->getActiveSheet()->setTitle('Tecnologia Simple');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$this->_exc->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($_exc, 'Excel2007');
$objWriter->save('php://output');
exit;

        
    }
    
    
}
