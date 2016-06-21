<?php
    include 'src/functions/dbfunctions.php';
    require_once 'src/PHPExcel.php';
    $conexion = ConnectDB(); 
    $objXLS = new PHPExcel();
    $objSheet = $objXLS->setActiveSheetIndex(0);
    ////////////////////TITULOS///////////////////////////
    $objSheet->setCellValue('A1', 'Agricultor');
    $objSheet->setCellValue('B1', 'Fecha');
    $objSheet->setCellValue('C1', 'Especie');
    $objSheet->setCellValue('D1', 'Ubicacion');
    $objSheet->setCellValue('E1', 'Variedad');
    $objSheet->setCellValue('F1', 'Email');
    $objSheet->setCellValue('G1', 'Telefono');
    $objSheet->setCellValue('H1', 'Estado fenologico');
    $objSheet->setCellValue('I1', 'Estado de crecimiento');
    $objSheet->setCellValue('J1', 'Malezas');
    $objSheet->setCellValue('K1', 'Estado de Fitosanitario');
    $objSheet->setCellValue('L1', 'Poblacion');
    $objSheet->setCellValue('M1', 'Cosecha');
    $objSheet->setCellValue('N1', 'Malezas Principales');
    $objSheet->setCellValue('O1', 'Hongos/Bacterias/Virus');
    $objSheet->setCellValue('P1', 'Insectos/Plagas');
    $objSheet->setCellValue('Q1', 'Estado General');
    $objSheet->setCellValue('R1', 'Observaciones');
    $objSheet->setCellValue('S1', 'Recomendaciones');

        $numero=1;
        $can=mssql_query("SELECT a.agricultorNom as agricultor, f.fecha as fecha, e.especieNom as especie, a.agricultorUbicacion as ubicacion, f.formularioVariedad as nombrevariedad, a.agricultorEmail as email, a.agricultorFono as telefono, f.estaFenologico as estadofenologico, f.estaCrecimiento as estadocrecimiento, f.estaMalezas as malezas, f.estaFitosanitario as fitosanitario, f.poblacion as poblacion, f.cosecha as cosecha, f.malePrincipales as malezasprincipales, f.honBacVir as hongosbacterias, f.insectos as insectos, f.estadoGene as estadogeneral, f.Observaciones as observaciones, f.Recomendacioness as recomendaciones
                from formulario as f inner join agricultor as a on f.agricultorId = a.agricultorId inner join especie as e on e.especieId = f.especieId
            order by f.fecha desc", $conexion);
        while($dato=mssql_fetch_array($can)){
            $numero++;
            $objSheet->setCellValue('A'.$numero, $dato['agricultor']);
            $objSheet->setCellValue('B'.$numero, date_format(new DateTime($dato['fecha']), 'd-m-Y'));
            $objSheet->setCellValue('C'.$numero, $dato['especie']);
            $objSheet->setCellValue('D'.$numero, $dato['ubicacion']);
            $objSheet->setCellValue('E'.$numero, $dato['nombrevariedad']);
            $objSheet->setCellValue('F'.$numero, $dato['email']);
            $objSheet->setCellValue('G'.$numero, $dato['telefono']);
            $objSheet->setCellValue('H'.$numero, $dato['estadofenologico']);
            $objSheet->setCellValue('I'.$numero, $dato['estadocrecimiento']);
            $objSheet->setCellValue('J'.$numero, $dato['malezas']);
            $objSheet->setCellValue('K'.$numero, $dato['fitosanitario']);
            $objSheet->setCellValue('L'.$numero, $dato['poblacion']);
            $objSheet->setCellValue('M'.$numero, $dato['cosecha']);
            $objSheet->setCellValue('N'.$numero, $dato['malezasprincipales']);
            $objSheet->setCellValue('O'.$numero, $dato['hongosbacterias']);
            $objSheet->setCellValue('P'.$numero, $dato['insectos']);
            $objSheet->setCellValue('Q'.$numero, $dato['estadogeneral']);
            $objSheet->setCellValue('R'.$numero, $dato['observaciones']);
            $objSheet->setCellValue('S'.$numero, $dato['recomendaciones']);
        }
        
    $objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
    $objXLS->getActiveSheet()->setTitle('VENTAS');
    $objXLS->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="listadovegetales.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
    $objWriter->save('php://output');
?>