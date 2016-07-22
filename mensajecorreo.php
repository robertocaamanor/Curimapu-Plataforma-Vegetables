<?php 
	function correo($id, $especie, $fecha){
		include 'src/php2pdf/class.ezpdf.php';
		include('src/php2pdf/class.backgroundpdf.php');
		$conn = ConnectDB();
		$result = detallevegetales($id,$conn);
		$row = mssql_fetch_array($result);

		$pdf = new backgroundPDF('letter', 'portrait', 'image', array('img' => 'img/curivegetables.jpg', 'width' => 522, 'height' => 331, 'xpos' =>50, 'ypos' => 350));
		$pdf->selectFont('src/php2pdf/fonts/Helvetica.afm');

		$datacreator = array (
		'Title'=>'Informe Visita Cultivo');

		$pdf->addInfo($datacreator);
		$pdf->ezText("\n".utf8_decode("N° Formulario: ").$id,12,array('justification'=>'right'));
		$pdf->ezImage("http://i.imgur.com/rtowucy.jpg", 0, 100, 'none', 'left');
		$pdf->ezText("\nINFORME VISITA CULTIVO",20,array('justification'=>'center'));
		 

		$pdf->ezText("\n",12); 
		$data = array(
		array('name'=>"Fecha: ".date_format(new DateTime($row['Fecha']), 'Y-m-d'),'type'=>utf8_decode("Comuna:").$row['Ubicacion'])
		,array('name'=>"Agricultor: ".utf8_decode($row['Agricultor']),'type'=>utf8_decode("Telefono:").$row['telefono'])
		,array('name'=>utf8_decode("Especie: ".$row['especie']),'type'=>"Email: ".utf8_decode($row['email']))
		,array('name'=>"Variedad: ".utf8_decode($row['nombreVariedad']))
		);
		$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
			  ,'width'=>500,'fontSize' => 12,'showLines'=>1, 'cols'=>array("name" => array('width'=>250), "type" => array('width'=>250))));

		$pdf->ezText("\n",12); 
		$data = array(
		array('name'=>'Estado Fenologico:','type'=>$row['estadofenologico'])
		,array('name'=>utf8_decode("Estado de Crecimiento (Nota de 1 a 10):"),'type'=>$row['estadocrecimiento'])
		,array('name'=>'Malezas: ','type'=>$row['malezas'])
		,array('name'=>'Estado de Fitosanitario (Nota de 1 a 10): ','type'=>$row['fitosanitario'])
		,array('name'=>'Poblacion: ','type'=>$row['poblacion'].' (pL/m)')
		,array('name'=>utf8_decode("Cosecha:"),'type'=>$row['cosecha'])
		,array('name'=>utf8_decode("Malezas Principales:"),'type'=>$row['malezasprincipales'])
		,array('name'=>utf8_decode("Hongos/Bacterias/Virus:"),'type'=>$row['hongosbacterias'])
		,array('name'=>utf8_decode("Insectos:"),'type'=>$row['insectos'])
		,array('name'=>utf8_decode("Estado general de cultivo (Nota de 1 a 10):"),'type'=>$row['estadogeneral'])
		);
		$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
			  ,'width'=>500,'fontSize' => 12,'showLines'=>1, 'cols'=>array("name" => array('width'=>250), "type" => array('width'=>250))));

		$pdf->ezText("\nObservaciones:\n".utf8_decode($row['observaciones']),12,array('left'=>30)); 
		$pdf->ezText("\nRecomendaciones:\n".utf8_decode($row['recomendaciones']),12,array('left'=>30)); 
		ob_end_clean();
		$documento_pdf = $pdf->ezOutput();
		$fichero = fopen('pdfvisitas/informevisita'.$id.'.pdf','wb');
		fwrite ($fichero, $documento_pdf);
		fclose ($fichero);

		if (!class_exists("phpmailer")) {
			require_once('src/phpmailer/class.phpmailer.php');
		}
    	//include("src/phpmailer/class.phpmailer.php");

    	if (!class_exists("smtp")) {
			require_once('src/phpmailer/class.smtp.php');
		}

    	$f= date("d-m-Y H:i:s");

	  $mensaje = "Se adjunta archivo del reporte PDF de Visita Cultivo numero ".$id."<br/><br/>Fecha: ".$fecha."<br/>Especie: ".$especie;

	    $mails = strtolower($mails);

	    $sql = "SELECT correo FROM correos";

	    $correos = query($conn, $sql);

	    while($row = parse($correos)){

		$mails=$row['correo'];

		}

	    $mail=new PHPMailer();

		$mail->Mailer="IMAP";

		$mail->Helo = "www.xhost.cl"; //Muy importante para que llegue a hotmail y otros

		$mail->SMTPAuth=false;

		$mail->Host="webserver01.xhost.cl";

		$mail->Port=993; //depende de lo que te indique tu ISP. El default es 25, pero nuestro ISP lo tiene puesto al 26

		$mail->Username="rcaamano@xhost.cl";

		$mail->Password="roberto09101992";

		$mail->From="rcaamano@xhost.cl";

		$mail->FromName="E-MAIL DE PRUEBA";

		$mail->Timeout=60;

		$mail->IsHTML(true);

		//Enviamos el correo

		//$mail->AddAddress('raristides.caamano@gmail.com'); //Puede ser Hotmail

		//$mail->AddAddress($emailagricultor);

		$lista1 = "SELECT * FROM correos";
		$lista2 = query($conn, $lista1);
		while($listadomails = parse($lista2)){
			$mail->AddAddress($listadomails['correo']);
		}

		$mail->Subject='Vegetables - Visita Cultivo, '.$especie.', '.$fecha.'';

		$mail->Body=$mensaje;

		$mail->addAttachment('pdfvisitas/informevisita'.$id.'.pdf');

		//$mail->AltBody="Texto que debe decir lo mismo que el Body, pero sin etiquetas HTML";

		$exito = $mail->Send();

		if($exito){

		     $mail->ClearAddresses();


		     $d = "UPDATE formulario SET bandera = '1' WHERE formularioId='".$id."'";

		     $qd = query($conn, $d);
		     

		}else {

		     echo "El correo ha fallado";

		    $fallido = "UPDATE formulario SET bandera = '2' WHERE formularioId='".$id."'";

		     $qfallido = query($conn, $fallido);


		}
	}

 ?>