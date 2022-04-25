<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archivos extends CI_Controller {

    function __construct(){
        parent::__construct();

        $this->load->model("Pdf_model");
		$this->load->library(array('general'));
		$this->validateSession();
    }

    function certificado($data){
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false); 

        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
        $pdf->SetTitle('CERTIFICADO');
        // $pdf->SetSubject('Pagos autorizados por Dirección General');
        // $pdf->SetKeywords('LISTA, CIUDAD MADERAS, PAGOS, AUTORIZA, DG');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);    
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, 0);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter();
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetFont('times', 'BI', 20, '', 'false');
        $pdf->SetMargins(0, 0, 0, true);
        $pdf->AddPage('L', 'LETTER LANDSCAPE');
        $pdf->Image(base_url("assets/img/Certificate2.png"), $x = '', $y = '', $w = 330, $h = 230, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = 'C', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());

        $facturas = $this->Pdf_model->get_datos_para_certificado($data);
        $html_facturas = '';
 
        if( $clientes->num_rows() > 0 ){
            foreach( $facturas->result()  as $row ){
                $html_facturas .= '
                 <tr>
           <th colspan="2">&nbsp;</th>
           <th colspan="2">&nbsp;</th>
           <th colspan="2" style="font-size:8em;">&nbsp;</th>
           </tr> 

           <tr>
           <th colspan="2">&nbsp;</th>
           <th colspan="2">&nbsp;</th>
           <th colspan="2"><label style="font-size:4em;color:#95E8DA;">&nbsp;</label></th>
           </tr>

           <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td colspan="2" style="font-size:16em;color:gray;" align="left">&nbsp;
           </td>
           </tr>


           <tr>
           <td>&nbsp;</td>
           <td colspan="4" style="font-size:5em;color:gray;font-family:Times-Italic;" align="center">'.$facturas->row()->nombre.'</td>
           </tr>


            <tr>
           <td>&nbsp;</td>
           <td colspan="4" style="font-size:3em;color:gray;" align="left"><br><p align="justify">Como cliente de <i>BODY EFFECT</i> me doy  por satisfecho(a) con el  servicio recibido en cuanto a la eliminación definitiva de vello, así mismo conforme se me notifica que he terminado mi tratamiento y en este acto me dan de alta las áreas: <B>'.$facturas->row()->valor.'</B>, con fecha <b>'.$facturas->row()->fecha_letra.'</b> a las <b>'.$facturas->row()->hora_letra.'</b>
           </p> 
           </td>
           </tr>


           <tr>
           <td colspan="2" style="font-size:12em;color:gray;" align="left"></td>
           <td colspan="2" style="font-size:12em;color:gray;" align="left"></td>
           <td colspan="2" style="font-size:12em;color:gray;" align="left"></td>
           </tr>

           <tr align="center">
           <td colspan="2" style="font-size:4em;color:gray;">Ventas</td>
           <td colspan="2" style="font-size:4em;color:gray;">Enfermera</td>
           <td colspan="2" style="font-size:4em;color:gray;">Cliente</td>
           </tr>';
                  
            }
        }

        $html = '<table width="100%" border="1">
                    <tbody>'.$html_facturas.'</tbody>
                </table>';

        $pdf->SetFont('Helvetica', '', 5, '', true);
        $pdf->writeHTMLCell(0, 0, $x = '', $y = '30', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);        
 
        $pdf->Output(utf8_decode("CERTIFICADO_".$facturas->row()->nombre."_ALTA.pdf"), 'I');
     
}

    function contrato($data, $id_contrato){       
        $engancheT = 0;
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false); 
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas CM');
        $pdf->SetTitle('CONTRATO');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);    
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, 0);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter();
        $pdf->setFontSubsetting(true);
        // $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(15, 15, 15, true);
        $pdf->AddPage('A4', 'PORTRAIT');
        $pdf->SetFont('Helvetica', '', 8, '', true);

        $todayF = date("d_m_Y");

        $contrato = $this->Pdf_model->get_contrato($id_contrato);
        $titular = $this->Pdf_model->get_titular($data);
        $clientes = $this->Pdf_model->get_clients($id_contrato, $contrato->row()->tipo);
        $pago = $this->Pdf_model->get_datos_pago($id_contrato);
        $cobros = $this->Pdf_model->get_cobros($id_contrato);
        $noMensualidades = $pago->row()->mensualidad;
        $quincenas = $this->Pdf_model->get_quincenas($id_contrato);
        $nombreTitular = $titular->row()->nombre;
        $correoTitular = $titular->row()->correo;
        $domicilioTitular = $titular->row()->domicilio;
        $prosa = $cobros->row()->prosa;
        $numeroTarjeta = '';
        $banco = '';

        $lenghtArr = COUNT($clientes->result());
        $lenghtArr2 = COUNT($pago->result());
        $lengthCobros = COUNT($cobros->result());
        $area = $pago->row()->servicio;
        $formadepago = $cobros->row()->forma_pago;
        $fecha = $pago->row()->fecha_cobro;
        $cantidad = $pago->row()->cantidad;

        $quincenaValue = 0;

        if($area==1) $ar = 'DL'; 
        else $ar = 'M';
        
        for ($i = 0; $i < $lenghtArr2; $i++) {
            $engancheT = $engancheT + $cobros->row($i)->enganche;
        }
        
        $saldoPendiente = ($formadepago==5) ? '0 (CONVENIO INFLUENCER)' : $cantidad - $engancheT;
        $html_contrato = '';
        $html_contrato_plus = '';

        //Datos fijos
        $firmaizq = "EL CLIENTE";
        $firmader = "EL PRESTADOR";
        $blank = "_______________________________";
        $blank2 = "__________________________________________";
        $firmader2 = "COSOMI S.A DE C.V. representado en este acto por Fabiola Guerrero Abrego";
        
        setlocale(LC_TIME, "spanish");
        if( $clientes->num_rows() > 0 ){
            $html_contrato .=  '
            <link rel="stylesheet" media="print" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
            <style media="print">
                label { 
                    color: black; 
                    border-bottom:10em;
                }
                u {
                    text-decoration: none;
                    border-bottom: 10px solid black;
                }​
            </style>';
            $html_contrato .=  '
            <table>
                <tr>
                    <td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td>
                    <td style="font-size:12px;"><div align="right"><b>FOLIO: </b>MT-0000'.$contrato->row()->id_contrato.'</div><div align="right"><b>ID CLIENTE: </b>'.$titular->row()->id_cliente.'</div></td>
                </tr>
            </table>
            <br>
            <p align="center" style="font-size:12px;">'.strftime("%e del mes de  %B del año %Y").'</p>
            <p align="justify" style="font-size:12px;">';

            $contador = 1;
            for ($i = 0; $i < $lenghtArr; $i++) {
                $html_contrato .=  '
                <input type="text" value""/>
                <br><b>Nombre del cliente '.$contador.': </b><label><u>'.$clientes->row($i)->nombre.'</u></label>';
                $contador ++;
            }

            $html_contrato .=  '<br><br><b>TRATAMIENTO</b>';
            $contador2 = 1;
            $allAreas = '';
            for ($a = 0; $a < $lenghtArr; $a++) {
                $html_contrato .=  '
                    <br><b>Cliente '.$contador2.': </b>'.$this->general->cleanArray($clientes->row($a)->areas).'';
                $allAreas .= ' ' . $this->general->cleanArray($clientes->row($a)->areas);
                $contador2 ++;
            }

            $visa = "____";
            $mc = "____";
            $ae = "____";
            if ( $prosa == 1 ){
                $tarjeta = $this->Pdf_model->get_datos_tarjeta($id_contrato);
                $numeroTarjeta = $tarjeta->row()->numero_tarjeta;
                $banco = $tarjeta->row()->banco;
                if ($tarjeta->row()->compania == "VISA") {
                    $visa = "_X_";
                } else if ($tarjeta->row()->compania == "Mastercard") {
                    $mc = "_X_";
                } else if ($tarjeta->row()->compania == "American Express") {
                    $ae = "_X_";
                }
                //Condición tarjeta crédito o débito
                if($tarjeta->row()->tipo_tarjeta == 1){
                    $html_contrato .= '<br><br><b>Tarjeta de crédito</b>';
                }
                else{
                    $html_contrato .= '<br><br><b>Tarjeta de débito</b>';
                }
                $html_contrato .=  '     <u>'.$numeroTarjeta.'</u>     <b>Banco:</b> <u>'.$banco.'</u>
                <br><b>Tipo: &nbsp;</b>VISA<u>'.$visa.'</u>&nbsp;MASTERCARD<u>'.$mc.'</u>&nbsp;AMERICAN EXPRESS<u>'.$ae.'</u>
                <br><b>Fecha vencimiento:</b>   <u>'.$tarjeta->row()->mm.'/'.$tarjeta->row()->aa.'</u>
                </p>
                <br>';
                
            }
            $a = 0;
            $html_contrato .= '<p align="justify" style="font-size:12px;">
            <br><b>Costo total del servicio:</b>  <u>$'.number_format($pago->row()->cantidad, 2).' </u>
            <br><b>Anticipo:</b> 		<u>$'.number_format($engancheT, 2).'</u>
            <br><b>Saldo restante a cubrir:</b>  <u>$'.number_format($saldoPendiente, 2).'</u>
            </p>';

            $quincenasValues = $quincenas->result_array();
            $quincenasCounter = 0;
            $quincenasDetail = '';
            for ($q = 0; $q < COUNT($quincenasValues); $q ++) {
                $quincenasDetail .= '(' . $quincenasValues[$q]['importe'] . ' - '. $quincenasValues[$q]['fecha_pago'] . '), ';
                $quincenasCounter ++;
            }

            if($noMensualidades == 0){
                $html_contrato .= '<p align="justify" style="font-size:12px;"><br><br><b>COSTO DE SERVICIO LIQUIDADO</b>';
                $fecha_inicial = '-----';
            }
            else{
                if($formadepago == 5){
                    $html_contrato .= '<p align="justify" style="font-size:12px;"><br><br><b>COSTO DE SERVICIO LIQUIDADO</b>';
                    $id_cobro_u =  $cobros->row($lenghtArr2-1)->id_cobro;               
                    $fecha_inicial =  $this->Pdf_model->get_first_payment($id_cobro_u)->row()->inicial_fecha_pago;
                }else{
                 $html_contrato .= '<p align="justify" style="font-size:12px;">
                <br><br><b>'. $quincenasCounter /*$quincenas->row()->total_quincenas*/ .' pagos a cubrir </b>'. substr($quincenasDetail, 0, -2) /*$quincenas->row()->fechas .')'*/; 
                $id_cobro_u =  $cobros->row($lenghtArr2-1)->id_cobro;               
                $fecha_inicial =  $this->Pdf_model->get_first_payment($id_cobro_u)->row()->inicial_fecha_pago;
            }
            $quincenaValue = $quincenas->row()->importe;
        }
            
            $html_contrato .=  '
            <br><br>OBSERVACIONES:&nbsp;<u>'.$contrato->row()->observaciones.'</u>
            <br><br><b>DIRECCIÓN SUCURSAL DONDE CONTRATÓ: </b>MIDTOWN JALISCO AV. ADOLFO LÓPEZ MATEOS NORTE 2405, COL. ITALIA PROVIDENCIA, ENTRE CALLE VENECIA Y COLOMOS C.P. 44650 GUADALAJARA JALISCO LOCAL 53-A<br><br><br><br><br><br><br><br></p>';      
        }
		
        //Se retornan los diferentes contratos dependiente del tipo de areas que contenga dicho contrato.
        if($formadepago != 5){
            if ($area == 1){
                $html_contrato_plus = $this->contratoDepilacion($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $noMensualidades, $prosa, $fecha_inicial, $quincenaValue);
            }
            else if ($area == 2){
                $html_contrato_plus = $this->contratoMoldeo($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $noMensualidades, $prosa, $fecha_inicial, $quincenaValue);
            }
            else if ($area == 3){
                $html_contrato_plus = $this->contratoDepMol($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $noMensualidades, $prosa, $fecha_inicial, $quincenaValue);
            }
            else if($area == 4){
                $html_contrato_plus = $this->contratoFacial($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $noMensualidades, $prosa, $fecha_inicial, $allAreas, $quincenaValue, $correoTitular, $domicilioTitular);
            }
            else if($area == 5){
                $html_contrato_plus = $this->contratoFacMol($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $prosa, $fecha_inicial, $allAreas, $quincenaValue, $correoTitular, $domicilioTitular);
            }
        }

        $html = '<div>'.$html_contrato.'</div>';
        
		if($formadepago == 5){
            $pdf->writeHTMLCell(0, 0, $x = '10', $y = '15', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            $pdf->MultiCell(80, 0, $firmaizq."\n\n\n\n".$blank."\n".$nombreTitular, 0, 'C', 0, 0, '', '', true, 0, false, true, 0);
            $pdf->MultiCell(80, 0, $firmader."\n\n\n\n".$blank2."\n".$firmader2, 0, 'C', 0, 0, '', '', true, 0, false, true, 0); 
		} 
        else {
            $pdf->writeHTMLCell(0, 0, $x = '10', $y = '15', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            $pdf->MultiCell(80, 0, $firmaizq."\n\n\n\n".$blank."\n".$nombreTitular, 0, 'C', 0, 0, '', '', true, 0, false, true, 0);
            $pdf->MultiCell(80, 0, $firmader."\n\n\n\n".$blank2."\n".$firmader2, 0, 'C', 0, 0, '', '', true, 0, false, true, 0); 
            $pdf->writeHTMLCell(0, 0, $x = '10', $y = '15', $html_contrato_plus, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            $pdf->MultiCell(80, 0, $firmaizq."\n\n\n\n".$blank."\n".$nombreTitular, 0, 'C', 0, 0, '', '', true, 0, false, true, 0);
            $pdf->MultiCell(80, 0, $firmader."\n\n\n\n".$blank2."\n".$firmader2, 0, 'C', 0, 0, '', '', true, 0, false, true, 0);
		}



        $file_name = $clientes->row()->nombre;
        //Se da esta ruta para saber de donde va a abrir el archivo cuando termine de enviar a la ruta
        $path_b = (base_url('assets/temporales/CONTRATOT/').'CONTRATOS'.$ar.'_'.$file_name.'_'.$todayF.'.pdf');
        $pdf->Output(FCPATH.'assets/temporales/CONTRATOT/'.'CONTRATOS'.$ar.'_'.$file_name.'_'.$todayF.'.pdf', 'F');
        //Abrimos el archivo que ya guardamos en la ruta x
        header('Location: '.$path_b);
    }

    function contratoDepilacion($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $prosa, $fecha_inicial, $quincenaValue){
        $html = '';
        $html .= '<p align="center" style="page-break-before:always; font-size:12px;">CONTRATO DE PRESTACIÓN DE SERVICIOS DE TRATAMIENTO ESTÉTICOS DE DEPILACIÓN LÁSER<br></p>';
        $html .= '<p align="justify" style="font-size:12px;">COSOMI S.A DE C.V. , con nombre comercial BODY EFFECT representada en este acto por la Srita. FABIOLA GUERRERO ABREGO a quien en lo sucesivo se le denominará “EL PRESTADOR”; y por otra parte <b>'.$nombreTitular.'</b> a quien en lo sucesivo se le denominará “El CLIENTE” celebran el presente Contrato de Prestación de Servicios, sometiéndose a las siguientes cláusulas.<br><br>Objeto.- Los servicios profesionales que ELPRESTADOR lleve en favor de EL CLIENTE de tratamiento exclusivamente estético (no médico) consistente en depilación láser en las áreas corporales elegidas por EL CLIENTE, servicio que constará de un mínimo de 10 diez sesiones.</p>';

        $html .= $this->leyendaProsa($prosa, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $fecha_inicial, $quincenaValue);

        $html .= '<p align="justify" style="font-size:12px;">III. Reembolsos:  EL CLIENTE se hace sabedor y acepta en este acto que no existen reembolsos totales ni parciales sobre los paquetes contratados, apegándose a dicha política.<br><br>IV. Garantía. - EL PRESTADOR otorga a EL CLIENTE una garantía de eliminar un 90 al 95% del vello en las áreas contratadas que aparecen en la carátula del presente instrumento.<br><br>En el supuesto de que posterior a la décima sesión de EL CLIENTE éste no cuente con la eliminación del vello grueso en el porcentaje antes mencionado (90% ó 95%), este último tendrá el derecho de ejercer su garantía en los términos que la presente clausula señala, por lo que las sesiones posteriores serán completamente gratis. Si aunado a lo anterior no se
        elimina el vello grueso de EL CLIENTE, éste podrá solicitar la devolución total de su dinero a partir de la veinteava
        sesión.<br><br><br>Al término del tratamiento LAS PARTES deberán celebrar la firma del alta de EL CLIENTE, donde manifieste su conformidad con los resultados obtenidos. En caso de que dentro del plazo de 90 noventa días naturales posteriores a la fecha de firma de dicha alta EL CLIENTE presentara aumento de vello en las áreas contratadas, podrá hacer uso de la garantía mencionada en el párrafo anterior.<br><br>LAS PARTES acuerdan que la garantía no podrá ser exigible bajo los siguientes casos: (i) En caso de no acudir de forma mensual a recibir su tratamiento, (ii) En caso de interrumpir su tratamiento por más de 60 sesenta o más días naturales, (iii) En caso de no acudir a la valoración a partir de la séptima sesión y bajo los términos indicados por el personal asignado por EL PRESTADOR, (iv) En caso de que celebrada el alta hayan transcurrido más de 90 noventa días naturales.<br><br>V. Retoques. EL PRESTADOR se obliga a brindar dos retoques en las áreas contratadas por EL CLIENTE, sin costo adicional para éste último. Dichos retoques serán aplicables el primero en un plazo de 90 noventa días posteriores a la firma del alta y el segundo retoque en un plazo de 180 ciento ochenta días posteriores a la firma del alta.<br><br>EL CLIENTE se hace sabedor que dichos retoques no son acumulables, transferibles, ni prorrogables, por lo que es su responsabilidad agendar las citas en los plazos antes citados, por lo que no podrá exigir ningún tipo de garantía, bonificación o reembolso en caso de no acudir a los retoques.<br><br>VI. De la valoración. De igual forma, a partir de la séptima sesión, EL CLIENTE deberá asistir a una valoración un día antes de su cita a efecto de constatar los resultados; en caso de no asistir, éste no podrá recibir el tratamiento y perderá su garantía.<br><br>VII. Suspensión de tratamiento. - EL CLIENTE por salir del País, por embarazo o por causa de fuerza mayor podrá suspender el tratamiento solo una vez, dando aviso mediante una carta sellada de recibido a EL PRESTADOR del porqué de su interrupción del tratamiento, pudiendo regresar después de un tiempo máximo de 1 año contando a partir del aviso de suspensión, para seguir recibiendo su tratamiento sin perder la garantía, siempre tomando en cuenta lo citado en la cláusula III anterior.<br><br>Una vez trascurrido el año posterior al aviso de suspensión de tratamiento, EL CLIENTE perderá el derecho a reanudar su tratamiento perdiendo en ese caso el 100% de cualquier pago o abono efectuado, así como garantía aplicable, por lo que en caso de que EL CLIENTE desee utilizar los servicios de EL PRESTADOR, se celebrará un nuevo contrato.<br><br>VIII. Responsabilidad.- Riesgo de lesión en la piel, EL CLIENTE desde este momento es sabedor y consiente de que aunque el láser que se maneja es de lo más seguro y aprobado para su uso en el país por COFEPRIS mediante el folio COS/DED2/2/OR/153301CO260100/2015, pudiera causar cierta dermatitis, enrojecimiento, mancha o algún tipo de quemadura en la piel, asumiendo conjuntamente el riesgo con la empresa, sin embargo en caso de presentarse alguna lesión, la empresa se compromete a darle apoyo mediante su médico dermatólogo de cabecera mediante las citas y medicamentos que se necesite para sanar dicha lesión.<br><br><br>En virtud de lo anterior, EL PRESTADOR no se hará responsable por cualquier efecto secundario que llegare a afectarle derivado del tratamiento objeto del presente contrato, deslindándose de cualquier daño o perjuicio derivado de ello. Para ello EL CLIENTE reconoce haber otorgado su consentimiento informado y declara que la información proporcionada es verídica, por lo cual exime a EL PRESTADOR de cualquier complicación o afectación que se suscite por haberle otorgado de forma imprecisa o falsa información o bien omitirla y que derive en complicaciones a su salud.<br><br>IX. Audio. - A efecto de evitar y, en su caso, castigar cualquier conducta indebida por parte del personal de EL PRESTADOR y/o del CLIENTE, desde este momento, éste otorga su consentimiento para que dentro de las cabinas se cuente con equipo de grabación de audio para monitorear, NO CÁMARAS, solo audio y evitar las citadas conductas indebidas, quedando prohibidas de igual forma las propinas a las enfermeras.<br><br>X. Aviso de privacidad y uso de datos personales: EL CLIENTE manifiesta conocer y aceptar los términos del AVISO DE PRIVACIDAD y el tratamiento que se le darán a los datos personales de los cuales es titular, incluyendo aquellos clasificados como datos sensibles, por lo que otorga su consentimiento total sobre la manera en que se recaban, y se hace sabedor de los derechos que tiene en su carácter de titular.<br><br>XI. Ambas partes manifiestan que, para dirimir cualquier controversia respecto al servicio, este se realizará en los tribunales de Querétaro, Querétaro; En la inteligencia de que las quejas o reclamaciones relativas a la competencia de la procuraduría federal del consumidor (PROFECO) atendiendo al ámbito federal que les compete, ambas partes están de acuerdo en dar cumplimiento a la mismas en razón de su respectivo domicilio.<br><br>XII. Cambio de áreas. - Una vez firmado el contrato no se aceptan cambios en las áreas a depilarse.<br><br>XIII. Cualquier acuerdo verbal será desconocido.<br><br><br><br><br><br><br><br></p>';
        return $html;
    }

    function contratoMoldeo($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $prosa, $fecha_inicial, $quincenaValue){
        $html = '';
        $html .= '<p align="center" style="page-break-before:always; font-size:12px;">CONTRATO DE PRESTACIÓN DE SERVICIOS DE TRATAMIENTO ESTÉTICOS DE MOLDEADO CORPORAL</p>';
        $html .= '<p align="justify" style="font-size:12px;">COSOMI S.A DE C.V. con nombre comercial BODY EFFECT, representada en este acto por el señor FABIOLA GUERRERO ABREGO, a quien en lo sucesivo se le denominará “PRESTADOR”; y por otra parte <b>'.$nombreTitular.'</b> a quien en lo sucesivo se le denominará “El CLIENTE” celebran el presente Contrato de Prestación de Servicios, sometiéndose a las siguientes cláusulas.<br><br>I.	Objeto. - Los servicios profesionales que EL PRESTADOR lleve en favor de EL CLIENTE de tratamiento exclusivamente estético (no médico) de moldeado corporal en las áreas contratadas por EL CLIENTE, el cual constará de un mínimo de 12 doce sesiones.</p>';

        $html .= $this->leyendaProsa($prosa, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $fecha_inicial, $quincenaValue);
        
        $html .= '<p align="justify" style="font-size:12px;">De igual forma, EL CLIENTE acepta que no habrá cancelaciones de pagos, anticipos, ni devoluciones de dinero por parte de EL PRESTADOR, del procesador de pagos respectivo, ni del Banco emisor de la tarjeta de los pagos y/o cobros efectuados posterior a la contratación objeto de este Contrato.<br><br>III.	Reembolsos. EL CLIENTE se hace sabedor y acepta en este acto que no existen reembolsos totales ni parciales sobre los paquetes contratados, apegándose a dicha política.<br><br>IV.	De la variabilidad de resultados. EL CLIENTE se hace sabedor que los resultados sobre el moldeado podrán variar de acuerdo a factores de (i) edad, (ii) sexo (iii) alimentación, (iv) actividad física, (v) zona de tratamiento (vi) número y frecuencia de sesiones (vii), factores genéticos, entre otros. Por lo cual se realizará un expediente donde obre el historial de registro de tratamiento entre cada sesión sin que exista garantía alguna del alcance de los resultados.<br><br>V. Audio. A efecto de evitar y, en su caso, castigar cualquier conducta indebida por parte del personal de EL PRESTADOR y/o del CLIENTE, desde este momento, éste otorga su consentimiento para que dentro de las cabinas se cuente con equipo de grabación de audio para monitorear, NO CÁMARAS, solo audio y evitar las citadas conductas indebidas, quedando prohibidas de igual forma las propinas a las enfermeras.<br><br>VI. Suspensión de tratamiento. El cliente por salir del país, por embarazo o por causa de fuerza mayor podrá suspender el tratamiento 1 vez solo una vez, dando aviso mediante una carta sellada de recibido a la empresa del porqué de su interrupción del tratamiento, pudiendo regresar después de un tiempo máximo de 1 año a seguir recibiendo su tratamiento sin perder la garantía, siempre tomando en cuenta lo citado en la cláusula III anterior.<br><br>Una vez trascurrido el año posterior al aviso de suspensión de tratamiento, EL CLIENTE no podrá reanudar el tratamiento aplicando el saldo de pagos a su favor, perdiendo el 100% de cualquier pago o abono, así como garantía aplicable, por lo que en caso de que EL CLIENTE desee utilizar los servicios de EL PRESTADOR, se celebrará un nuevo contrato.<br><br>VII.	Responsabilidad. Riesgo de lesión en la piel, El cliente desde este momento es sabedor y consiente de que aunque el láser que se maneja es de lo más seguro y aprobado para su uso en el país por COFEPRIS mediante el folio COS/DED2/2/OR/153301CO260100/2015, pudiera causar cierta dermatitis, enrojecimiento, mancha o algún tipo de quemadura en la piel, asumiendo conjuntamente el riesgo con la empresa, sin embargo en caso de presentarse alguna lesión, la empresa se compromete a darle apoyo mediante su médico dermatólogo de cabecera mediante las citas y medicamentos que se necesite para sanar dicha lesión.<br><br>En virtud de lo anterior, EL PRESTADOR no se hará responsable por cualquier efecto secundario que llegare a afectar a EL CLIENTE derivado del tratamiento objeto del presente contrato, deslindándose de cualquier daño o perjuicio derivado de ello. Para ello EL CLIENTE reconoce haber otorgado su consentimiento informado y declara que la información proporcionada es verídica, por lo cual exime a EL PRESTADOR de cualquier complicación o afectación que se suscite por haberle otorgado de forma imprecisa o falsa información o bien omitirla y que derive en complicaciones a su salud.<br><br>VIII.	Aviso de privacidad. EL CLIENTE manifiesta conocer y aceptar los términos del AVISO DE PRIVACIDAD y el tratamiento que se le darán a los datos personales de los cuales es titular, incluyendo aquellos clasificados como datos sensibles, por lo que otorga su consentimiento total sobre la manera en que se recaban, y se hace sabedor de los derechos que tiene en su carácter de titular.<br><br><br><br><br>IX. Ambas partes manifiestan que para dirimir cualquier controversia respecto al servicio, este se realizará en los tribunales de Querétaro, Querétaro; En la inteligencia de que las quejas o reclamaciones relativas a la competencia de la procuraduría federal del consumidor (PROFECO) atendiendo al ámbito federal que les compete, ambas partes están de acuerdo en dar cumplimiento a la mismas en razón de su respectivo domicilio.<br><br>X. Cambio de áreas. - Una vez firmado el contrato no se aceptan cambios en las áreas a moldearse.<br><br>XI. Cualquier acuerdo verbal será desconocido.<br><br><br><br><br><br><br><br></p>';
        return $html;
    }

    function contratoDepMol($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $prosa, $fecha_inicial, $quincenaValue){
        $html = '';
        $html .= '<p align="center" style="page-break-before:always; font-size:12px;">CONTRATO DE PRESTACIÓN DE SERVICIOS DE TRATAMIENTO ESTÉTICOS DE MOLDEADO CORPORAL Y DEPILACIÓN LASER</p>';
        $html .= '<p align="justify" style="font-size:12px;">COSOMI S.A DE C.V. con nombre comercial BODY EFFECT, representada en este acto por la Srita. FABIOLA GUERRERO ABREGO, a quien en lo sucesivo se le denominará “EL PRESTADOR”; y por otra parte <b>'.$nombreTitular.'</b> a quien en lo sucesivo se le denominará “El CLIENTE” celebran el presente Contrato de Prestación de Servicios, sometiéndose a las siguientes cláusulas.<br><br>I.	Objeto. <br> <ol style="list-style-type: lower-alpha;"><li>Los servicios profesionales que EL PRESTADOR lleve en favor de EL CLIENTE de tratamiento exclusivamente estético (no médico) de moldeado corporal en las áreas contratadas por EL CLIENTE, el cual constará de un mínimo de 10 diez sesiones.</li>
        <li>Los servicios profesionales que EL PRESTADOR lleve en favor de EL CLIENTE de tratamiento exclusivamente estético (no médico) de moldeado corporal en las áreas contratadas por EL CLIENTE, el cual constará de un mínimo de 12 doce sesiones.</li></ol>
        </p>';
        
        $html .= $this->leyendaProsa($prosa, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $fecha_inicial, $quincenaValue);

        $html .= '<p align="justify" style="font-size:12px;">De igual forma, EL CLIENTE acepta que no habrá cancelaciones de pagos, anticipos, ni devoluciones de dinero por parte de EL PRESTADOR, del procesador de pagos respectivo, ni del Banco emisor de la tarjeta de los pagos y/o cobros efectuados posterior a la contratación objeto de este Contrato.<br><br>III.	Reembolsos. - EL CLIENTE se hace sabedor y acepta en este acto que no existen reembolsos totales ni parciales sobre los paquetes contratados, apegándose a dicha política.<br><br>IV. Garantia en Depilación. - EL PRESTADOR otorga a EL CLIENTE una garantía de eliminar un 90 al 95% del vello en las áreas contratadas que aparecen en la carátula del presente instrumento.<br>En el supuesto de que posterior a la décima sesión de EL CLIENTE éste no cuente con la eliminación del vello grueso en el porcentaje antes mencionado (90% ó 95%), este último tendrá el derecho de ejercer su garantía en los términos que la presente cláusula señala, por lo que las sesiones posteriores serán completamente gratis. Si aunado a lo anterior no se elimina el vello grueso de EL CLIENTE, éste podrá solicitar la devolución total de su dinero a partir de la veinteava sesión.<br>Al término del tratamiento LAS PARTES deberán celebrar la firma del alta de EL CLIENTE, donde manifieste su conformidad con los resultados obtenidos. En caso de que dentro del plazo de 90 noventa días naturales posteriores a la fecha de firma de dicha alta EL CLIENTE presentara aumento de vello en las áreas contratadas, podrá hacer uso de la garantía mencionada en el párrafo anterior.<br><br>LAS PARTES acuerdan que la garantía no podrá ser exigible bajo los siguientes casos: (i) En caso de no acudir de forma mensual a recibir su tratamiento, (ii) En caso de interrumpir su tratamiento por más de 60 sesenta o más días naturales, (iii) En caso de no acudir a la valoración a partir de la séptima sesión y bajo los términos indicados por el personal asignado por EL PRESTADOR, (iv) En caso de que celebrada el alta hayan transcurrido más de 90 noventa días naturales.<br><br>V. Retoques en Depilación. - EL PRESTADOR se obliga a brindar dos retoques en las áreas contratadas por EL CLIENTE, sin costo adicional para éste último. Dichos retoques serán aplicables el primero en un plazo de 90 noventa días posteriores a la firma del alta y el segundo retoque en un plazo de 180 ciento ochenta días posteriores a la firma del alta.<br>EL CLIENTE se hace sabedor que dichos retoques no son acumulables, transferibles, ni prorrogables, por lo que es su responsabilidad agendar las citas en los plazos antes citados, por lo que no podrá exigir ningún tipo de garantía, bonificación o reembolso en caso de no acudir a los retoques.<br><br>VI. De la valoración en la depilación. - De igual forma, a partir de la séptima sesión, EL CLIENTE deberá asistir a una valoración un día antes de su cita a efecto de constatar los resultados; en caso de no asistir, éste no podrá recibir el tratamiento y perderá su garantía.<br><br>VII. De la variabilidad de resultados en moldeo. - EL CLIENTE se hace sabedor que los resultados sobre el moldeado podrán variar de acuerdo a factores de (i) edad, (ii) sexo (iii) alimentación, (iv) actividad física, (v) zona de tratamiento (vi) número y frecuencia de sesiones (vii), factores genéticos, entre otros. Por lo cual se realizará un expediente donde obre el historial de registro de tratamiento entre cada sesión sin que exista garantía alguna del alcance de los resultados.<br><br>VIII. Suspensión del tratamiento ambos servicios. - EL CLIENTE por salir del País, por embarazo o por causa de fuerza mayor podrá suspender el tratamiento solo una vez, dando aviso mediante una carta sellada de recibido a EL PRESTADOR del porqué de su interrupción del tratamiento, pudiendo regresar después de un tiempo máximo de 1 año contando a partir del aviso de suspensión, para seguir recibiendo su tratamiento sin perder la garantía, siempre tomando en cuenta lo citado en la cláusula III anterior.<br>Una vez trascurrido el año posterior al aviso de suspensión de tratamiento, EL CLIENTE perderá el derecho a reanudar su tratamiento perdiendo en ese caso el 100% de cualquier pago o abono efectuado, así como garantía aplicable, por lo que en caso de que EL CLIENTE desee utilizar los servicios de EL PRESTADOR, se celebrará un nuevo contrato.<br><br>IX. Responsabilidad. - Riesgo de lesión en la piel, El cliente desde este momento es sabedor y consiente de que aunque el láser que se maneja es de lo más seguro y aprobado para su uso en el país por COFEPRIS mediante el folio COS/DED2/2/OR/153301CO260100/2015, pudiera causar cierta dermatitis, enrojecimiento, mancha o algún tipo de quemadura en la piel, asumiendo conjuntamente el riesgo con la empresa, sin embargo en caso de presentarse alguna lesión, la empresa se compromete a darle apoyo mediante su médico dermatólogo de cabecera mediante las citas y medicamentos que se necesite para sanar dicha lesión.<br><br>En virtud de lo anterior, EL PRESTADOR no se hará responsable por cualquier efecto secundario que llegare a afectar a EL CLIENTE derivado del tratamiento objeto del presente contrato, deslindándose de cualquier daño o perjuicio derivado de ello. Para ello EL CLIENTE reconoce haber otorgado su consentimiento informado y declara que la información proporcionada es verídica, por lo cual exime a EL PRESTADOR de cualquier complicación o afectación que se suscite por haberle otorgado de forma imprecisa o falsa información o bien omitirla y que derive en complicaciones a su salud.<br><br>X. Audio. - A efecto de evitar y, en su caso, castigar cualquier conducta indebida por parte del personal de EL PRESTADOR y/o del CLIENTE, desde este momento, éste otorga su consentimiento para que dentro de las cabinas se cuente con equipo de grabación de audio para monitorear, NO CÁMARAS, solo audio y evitar las citadas conductas indebidas, quedando prohibidas de igual forma las propinas a las enfermeras.<br><br>XI. Aviso de privacidad y uso de datos personales. - EL CLIENTE manifiesta conocer y aceptar los términos del AVISO DE PRIVACIDAD y el tratamiento que se le darán a los datos personales de los cuales es titular, incluyendo aquellos clasificados como datos sensibles, por lo que otorga su consentimiento total sobre la manera en que se recaban, y se hace sabedor de los derechos que tiene en su carácter de titular.<br><br>XII. Cambios de áreas. - Una vez firmado el contrato no se aceptan cambios en las áreas contratadas.<br><br>XIII. Controversia. - Ambas partes manifiestan que para dirimir cualquier controversia respecto al servicio, este se realizará en los tribunales de Querétaro, Querétaro; En la inteligencia de que las quejas o reclamaciones relativas a la competencia de la procuraduría federal del consumidor (PROFECO) atendiendo al ámbito federal que les compete, ambas partes están de acuerdo en dar cumplimiento a la mismas en razón de su respectivo domicilio.<br><br>XIV. Cualquier acuerdo verbal será desconocido.<br><br><br><br><br><br><br><br>';
        return $html;
    }

    function contratoFacial($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $prosa, $fecha_inicial, $allAreas, $quincenaValue, $correoTitular, $domicilioTitular){
        setlocale(LC_ALL,"es_ES");
        $html = '';
        $html .=  '
            <table style="page-break-before:always;">
                <tr>
                    <td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td>
                    <td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td>
                </tr>
            </table>
            <br>';
        $html .= '<br><p align="justify" style="font-size:13px;"><b>CONTRATO DE PRESTACIÓN DE SERVICIOS SOBRE MEDICINA ESTÉTICA, ANTIENVEJECIMIENTO Y SUS DIVERSOS TRATAMIENTOS QUE CELEBRAN POR UNA PARTE COSOMI&CO S.C., CON NOMBRE COMERCIAL BODY EFFECT, REPRESENTADA EN ESTE ACTO POR LA SEÑORA FABIOLA GUERRERO ABREGO A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “EL PRESTADOR”; Y POR OTRA PARTE EL/LA C. <u>'.$nombreTitular.'</u>, A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “EL CLIENTE”; “EL PRESTADOR” Y “EL CLIENTE” CONJUNTAMENTE DENOMINADAS “LAS PARTES” SE OBLIGAN AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:</b></p><br>';

        $html .= '<p align="center" style="font-size:13px;"><b>DECLARACIONES</b></p><br>';

        $html .= '<p align="justify" style="font-size:13px;"><b>I.- COSOMI&CO S.C por conducto de su representante manifiesta:</b><br><br>';

        $html .= '1.- Ser una sociedad civil constituida bajo las leyes mexicanas y en estricto apego a los ordenamientos legales conducentes, cuyo nombre comercial es “Body Effect”, tal y como lo acredita con la escritura pública número 15,837 de fecha 16 de octubre del 2019, pasada ante la fe del Lic. Leopoldo Mondragón González, Notario Titular de la Notaría número 29, en el Estado de Querétaro; y que cuenta con las facultades legales, autorizaciones e infraestructura correspondiente para celebrar el presente contrato. <br><br>

2. Que por escritura Pública número 15, 839 de fecha 16 de octubre del 2019, pasada ante la fe del Lic. Leopoldo Mondragón González, Notario Titular de la Notaría número 29, en el Estado de Querétaro., se le otorgó poder y facultades suficientes a la C. Fabiola Guerrero Abrego para otorgar el presente contrato en nombre y a cuenta de COSOMI&CO S.C. <br><br>

3. Que mediante este acto designa a la <b>DRA. DAYHAN MARGARITA HERNÁNDEZ GALLARDO</b> (en lo sucesivo <b>EL MEDICO</b>), médico cirujano con cédula profesional <b><u>11015834</u></b>, para que realice el procedimiento y tratamiento de medicina estética que elija <b>EL CLIENTE.</b> <br><br>

4. Su objeto social le permite celebrar el acto que por el presente contrato se materializa. <br><br>

5. Que su domicilio ésta ubicado en Plaza Midtown, Jalisco Local 53, Planta Alta, Italia Providencia, Municipio De Guadalajara, Estado De Jalisco, Código Postal 44648.<br><br>

6. Cuenta con capacidad económica, técnica, operativa, infraestructura y personal suficientes para asumir la prestación de servicios. <br><br>

7. En cumplimiento de la norma oficial <b>NOM-SSA1-1998</b> recibí del <b>CLIENTE</b>, su expediente clínico, del cual se agrega al presente instrumento como <b>ANEXO B.</b> <br><br>

8. En consecuencia, del <b>ARTÍCULO 15 DEL CÓDIGO PENAL FEDERAL</b> vigente, le entregué, expliqué y resolví todas las dudas al <b>CLIENTE</b> sobre el/los tratamientos a los que mediante el presente instrumento pretende someterse, mediante el consentimiento informado, por lo que el CLIENTE mostro conformidad mediante su firma por lo cual, se agrega al presente instrumento como <b>ANEXO C.</b> <br><br>

9. Que los productos suministrados por los <b>PROVEEDORES</b>, para la buena aplicación de la medicina estética, antienvejecimiento y sus diversos tratamientos, cuentan con los permisos sanitarios requeridos por la legislación mexicana.<br><br>

10. Declara que es su voluntad la celebración del presente contrato y que a la firma de este no existe ningún tipo de dolo, violencia o mala fe.</p>';

        $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table><p align="justify" style="font-size:13px;">';

        $html .= '<br><br><b>II.- EL CLIENTE manifiesta:</b><br><br>';

        $html .= '1. Ser una persona física, con capacidad legal para celebrar el presente contrato, mayor de edad y conocedora de los alcances del objeto de este contrato. <br><br>

2. Que se ha hecho de su conocimiento los riesgos que implica el presente tratamiento de medicina estética mencionados en los consentimientos informados, previamente firmados por <b>EL CLIENTE</b>, de los cuales se le entregará una copia y agrega al presente instrumento como <b>ANEXO A.</b> <br><br>

3. Después del tratamiento puede presentarse comúnmente, dolor, de leve a moderado, secreción de las incisiones, hinchazón, hematomas y entumecimiento. <br><br>

4. En cumplimiento de la norma oficial <b><u>NOM-SSA1-1998</u></b> no altere, modifique u omití algún dato o información importante dentro de mi expediente clínico, el cual fue previamente entregado al <b>“PRESTADOR”</b>, y se agrega al presente instrumento como <b>ANEXO B</b>. <br><br>

5. En consecuencia, del <b>ARTÍCULO 15 DEL CÓDIGO PENAL FEDERAL</b> vigente, se me entrego, explicó y comprendí el consentimiento informado previamente entregado por el <b>“PRESTADOR”</b>, del cual mostré total conformidad y se agrega al presente instrumento como <b>ANEXO C</b>. <br><br>

6. Como un hecho sobresaliente debe señalarse que la explicación del médico fue lo suficientemente clara para evidenciar los beneficios que el acto y tratamiento médico estético propuesto ofrecido a <b>EL CLIENTE</b>, respecto a otras opciones de manejo, sobresaliendo particularmente las ventajas positivas del procedimiento de atención. <br><br>

7. Sabiendo todo lo anterior, expresa su consentimiento para la celebración del mismo, asume los beneficios y posibles riesgos y consecuencias del tratamiento.
<br><br>';

        $html .= '<b>III.- LAS PARTES, manifiestan:</b><br><br>';

        $html .= '1. - Cuentan con facultades, para la celebración del presente contrato;<br><br>

2. Manifiestan que se reconocen mutua y recíprocamente la personalidad con que se ostentan para todos los efectos legales y contractuales a que haya lugar; <br><br>

3. Declaran reconocer que se pactaron los precios y previa cotización de los servicios que se encuentren establecidos en el presente instrumento;<br><br>

4. Con nuestras firmas validamos este documento, así como los anexos que forman parte del mismo, manifestando que, con un lenguaje simple y entendible, el médico, así como el personal del <b>“PRESTADOR”</b>, explicó el plan de manejo propuesto y aclaró cada una de las preguntas que <b>EL CLIENTE</b> le planteó, de tal forma que para ambos queda perfectamente claro que tomando en consideración las características personales, individuales de <b>EL CLIENTE</b>, el acto y tratamiento médico estético que se requiere, consiste en lo que a continuación se expresa, mediante las siguientes:</p><br><br>';

        $html.= '<p align="center" style="font-size:13px;"><b>CLÁUSULAS</b></p>';

        $html .= '<p align="justify" style="font-size:13px;"><b>PRIMERA.- OBJETO.- </b> Los servicios profesionales que <b>EL PRESTADOR</b> lleve en favor de <b>EL CLIENTE</b> de tratamiento de medicina  estética y antienvejecimiento en las áreas contratadas por <b>EL CLIENTE</b>, las cuales son: '.$allAreas.' mismas que no podrán modificarse o cambiarse, una vez firmado el presente contrato.</p>';

        $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table><p align="justify" style="font-size:13px;">';

        $html .= $this->leyendaProsa($prosa, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $fecha_inicial, $quincenaValue);

        $html .= '<p align="justify" style="font-size:13px;">De igual forma, <b>EL CLIENTE</b> acepta que no habrá cancelaciones de pagos, anticipos, ni devoluciones de dinero por parte de <b>EL PRESTADOR</b>, del procesador de pagos respectivo, ni del Banco emisor de la tarjeta de los pagos y/o cobros efectuados posterior a la contratación objeto de este Contrato, por tanto no existen reembolsos totales ni parciales sobre el objeto contratado.<br><br>';

        $html .= '<b>TERCERA.- DE LA VARIABILIDAD DE RESULTADOS. EL CLIENTE</b> se hace sabedor que los resultados sobre el tratamiento contratado podrán variar de acuerdo a factores de (i) edad, (ii) sexo (iii) alimentación, (iv) actividad física, (v) zona de tratamiento (vi) número y frecuencia de sesiones (vii), factores genéticos, entre otros. Por lo cual se realizará un expediente donde obre el historial de registro de tratamiento entre cada sesión sin que exista garantía alguna del alcance de los resultados. Por ende, las partes acuerdan que el presente contrato es de medios y no de resultados.<br><br>

<b>CUARTA. - RESPONSABILIDAD. - EL PRESTADOR</b> manifiesta que el servicio se brinda con calidad, profesionalismo e higiene, apegado a las buenas prácticas sobre el tratamiento contratado y por lo mismo, EL PRESTADOR no se hará responsable por cualquier efecto secundario que llegare a afectar a <b>EL CLIENTE</b> derivado del tratamiento objeto del presente contrato, deslindándose de cualquier daño o perjuicio derivado de ello.<br><br>

Para ello <b>EL CLIENTE</b> reconoce haber otorgado su consentimiento informado y declara que la información proporcionada es verídica, por lo cual exime a <b>EL PRESTADOR</b> de cualquier complicación o afectación que se suscite por haberle otorgado de forma imprecisa o falsa información o bien omitirla (sea de su conocimiento o no) y que derive en complicaciones a su salud.<br><br>

<b>QUINTA. - SUSPENSIÓN DE TRATAMIENTO. - EL CLIENTE</b> por salir del país, por embarazo o por causa de fuerza mayor podrá suspender el tratamiento por una sola ocasión, dando aviso mediante una carta sellada de recibido a la empresa, del porqué de su interrupción del tratamiento, pudiendo regresar después de un tiempo máximo de 1 año a seguir recibiendo su tratamiento sin perder la garantía.<br><br>

Una vez trascurrido el año posterior al aviso de suspensión de tratamiento, <b>EL CLIENTE</b> no podrá reanudar el tratamiento aplicando el saldo de pagos a su favor, perdiendo el <b><u>100% de cualquier pago o abono</u></b>, así como garantía aplicable, por lo que en caso de que <b>EL CLIENTE</b> desee utilizar los servicios de <b>EL PRESTADOR</b>, se celebrará un nuevo contrato.<br><br>

<b>SEXTA. - MODIFICACIONES. - LAS PARTES</b> acuerdan que son conocedoras de los alcances de lo aquí pactado, por lo tanto, están de acuerdo en que cualquier pacto verbal que no esté estipulado de manera expresa dentro del presente contrato no será válido y por tanto no obligará a ninguna de las partes.<br><br>

<b>SÉPTIMA.-. AUTORIZACIÓN PARA AUDIO.</b> A efecto de evitar y, en su caso, castigar cualquier conducta indebida por parte del personal de <b>EL PRESTADOR</b> y/o del <b>CLIENTE</b>, desde este momento, éste otorga su consentimiento para que dentro de las cabinas se cuente con equipo de grabación de audio para monitorear, NO CÁMARAS, solo audio y evitar las citadas conductas indebidas, quedando prohibidas de igual forma las propinas a las enfermeras.<br><br></p>';

 $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table><p align="justify" style="font-size:13px;">';

$html .= '<b>OCTAVA.– RESCISIÓN DE CONTRATO.-</b> Cualquier incumplimiento será considerado como causa suficiente para la rescisión de este instrumento, sin que para ello se requiera procedimiento o declaración judicial alguna. <br><br>

Para rescindir este contrato bastará con la notificación de recisión que realice <b>EL PRESTADOR</b> a <b>EL CLIENTE</b> en el domicilio y términos señalados en la cláusula que corresponda de este contrato.<br><br>

Asimismo, <b>“LAS PARTES”</b>, pactan que en caso de incumplimiento o causales de rescisión del presente contrato, <b>“EL PRESTADOR”</b>, realizará el cierre de cuenta inmediatamente, sin que este se encuentre obligado a regresar la cantidad de dinero aportada al acto y tratamiento médico estético que se establece en la cláusula primera del presente contrato, por lo que desde la firma del presente contrato <b>“EL CLIENTE”</b>, renuncia a cualquier acto o acción jurídica que pueda imponer en contra de <b>“EL PRESTADOR”</b>, dando por rescindido el presente instrumento.<br><br>

<b>OCTVA BIS.- SUBSISTENCIA DE OBLIGACIONES.–</b> La rescisión del presente contrato no afectaran las situaciones que legítimamente se hubieren en derivado del mismo, por lo que las partes se obligan a dar cumplimiento de las obligaciones estipuladas de este y que se encuentren pendientes de cumplir al momento de ocurrir dicha rescisión.<br><br>

<b>NOVENA.– DOMICILIOS Y NOTIFICACIONES.- “LAS PARTES”</b> establecen como domicilio y correo electrónico, para oír y recibir todo tipo de notificaciones relacionadas con el presente contrato, los siguientes: <b>“EL PRESTADOR”.–</b><br><br>';

            $html .= '<b>BODY EFFECT</b><br>
<u>Plaza Midtown, Jalisco Local 53-A, Planta Alta, Italia Providencia, Municipio De Guadalajara, Estado De Jalisco, Código Postal 44648.</u><br>
Correo electrónico. - <u>contacto@bodyeffect.com.mx</u><br><br>';

            $html .= '“<b>EL CLIENTE”. –</b><br>
Nombre Completo <u>'. $nombreTitular .'</u> <br>
Domicilio <u>'. $domicilioTitular .'</u> <br>
Correo electrónico <u>'. $correoTitular .'</u> <br><br>';

            $html .= 'Asimismo, <b>“LAS PARTES”</b> acuerdan que todas las notificaciones deberán ser por escrito o correo electrónico, sin justificación alguna. En caso, de no poder notificarse en los domicilios anteriormente señalados, bastará con la notificación de correo electrónico, asumiendo su total responsabilidad <b>LAS PARTES</b>, de estar constantemente al pendiente de su dirección de correo electrónico.<br><br>

<b>DÉCIMA.– PROPIEDAD INTELECTUAL E INDUSTRIAL DEL MATERIAL PUBLICITARIO.–</b> Todos los derechos derivados del producto aplicado, marcas, nombres comerciales y cualquier otro derecho de propiedad industrial e intelectual, incluyendo sin limitar cualquiera de sus derechos de autor, que entregue <b>EL PRESTADOR</b> a <b>EL CLIENTE</b>, será por cuenta exclusiva de la parte que haya hecho su entrega, sin que la otra parte adquiera ningún derecho de disposición, uso, goce o posesión sobre dicho material. <br><br>

<b>EL PRESTADOR</b>, está obligado a usar las marcas, logos, avisos comerciales, nombre comercial y diseños en la forma y términos en que los mismos han sido diseñados y registrados por su proveedor quedando expresamente prohibido modificarlos de forma alguna. <br><br>

<b>DÉCIMA PRIMERA.- PERSONAL DE LAS PARTES.– LAS PARTES</b>, están de acuerdo en que este contrato se suscribe en el entendido de que EL PRESTADOR cuenta con el personal necesario y los elementos propios para realizar el cumplimiento objeto del presente contrato, y, por tanto, EL CLIENTE acepta que ninguna de ellas se considerará como intermediario o parte patronal respecto la una a la otra. <br><br></p>';

$html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table><p align="justify" style="font-size:13px;">';

$html .= '<b>DÉCIMA SEGUNDA.- CONFIDENCIALIDAD.– LAS PARTES</b>, se obligan a mantener en estricta confidencialidad a información a la que con motivo de la presentación del servicio objeto del presente contrato tengan acceso, así como a que el personal contratado por el mantendrá absoluta confidencialidad sobre dicha información, por lo que asume la responsabilidad por el mal uso que dicho persona haga de la mencionada información durante y después de la terminación del presente contrato. <br><br>

Las obligaciones señaladas en la presente cláusula, permanecerán vigente durante los 2x años siguientes a la terminación por cualquier causa del presente contrato. Ninguna de las partes publicará ni permitirá que se publique cualquier comunicado de prensa o cualquier anuncio respecto del presente contrato o las operaciones contenidas en el mismo sin el previo consentimiento por escrito de las partes <br><br>

<b>DÉCIMA TERCERA.- AVISO DE PRIVACIDAD Y USO DE DATOS PERSONALES.- EL CLIENTE</b> manifiesta conocer y aceptar los términos del <b><u>AVISO DE PRIVACIDAD</u></b> y el tratamiento que se le darán a los datos personales de los cuales es titular, incluyendo aquellos clasificados como datos sensibles, por lo que otorga su consentimiento total sobre la manera en que se recaban, y se hace sabedor de los derechos que tiene en su carácter de titular.<br><br>

<b>DÉCIMA CUARTA.- PROTECCIÓN DE DATOS PERSONALES.–</b> LAS PARTES, se obligan a que todos los datos personales según se definen en la Ley Federal de Datos Personales de los Particulares y su Reglamento, serán tratados con la mayor cautela y de manera confidencial, resguardándolas en todo tiempo, manteniendo y estableciendo medidas de seguridad administrativas y técnicas que permitan proteger los datos personales contra daño, perdida, alteración, destrucción o el uso, acceso o tratamiento no autorizado, observando en todo tiempo principios de licitud, consentimiento, información, calidad, lealtad, proporcionalidad y responsabilidad sobre los datos. <br><br>

<b>DÉCIMA QUINTA.- ENCABEZADOS.–</b> Los encabezados de las cláusulas del presente contrato son exclusivamente por conveniencia de referencia y no deberán limitar o de alguna manera afectar el significado de alguna disposición de este contrato. <br><br>

<b>DÉCIMA PRIMERA.- COMPETENCIA.- LAS PARTES</b> manifiestan que para dirimir cualquier controversia respecto del objeto del presente contrato y las consecuencias inherentes al mismo, se designa a los tribunales competentes de Querétaro, Querétaro, renunciando a la jurisdicción que por domicilio les pudiese corresponder; en la inteligencia de que las quejas o reclamaciones relativas a la competencia de la Procuraduría Federal del Consumidor (PROFECO) atendiendo al ámbito federal que les compete, ambas partes están de acuerdo en dar cumplimiento a la mismas en razón de su respectivo domicilio. <br><br>

Leído en su totalidad el presente contrato y bien enteradas de su contenido y alcances legales <b>“LAS PARTES”</b>, lo firman por duplicado en la Ciudad de Santiago de Querétaro, Querétaro., el día ' . date("d") . ' de ' . strftime("%B") . ' del ' . date("Y") . '.<br><br><br><br>';


        return $html;
    }

    function contratoFacMol($nombreTitular, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $prosa, $fecha_inicial, $allAreas, $quincenaValue, $correoTitular, $domicilioTitular){
        $html = '
            <table style="page-break-before:always;">
                <tr>
                    <td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td>
                    <td style="font-size:12px;"><div align="right"><b>CONTRATO DE PRESTACIÓN DE<br>SERVICIOS DE MEDICINA ESTÉTICA<br> Y REMODELACIÓN CORPORAL</b></div></td>
                </tr>
            </table>
            <br>';
        $html .= '<br><p align="justify" style="font-size:13px;"><b>CONTRATO DE PRESTACIÓN DE SERVICIOS SOBRE MEDICINA ESTÉTICA, ANTIENVEJECIMIENTO, SUS DIVERSOS TRATAMIENTOS Y REMODELACIÓN CORPORAL QUE CELEBRAN POR UNA PARTE COSOMI&CO S.C., CON NOMBRE COMERCIAL BODY EFFECT, REPRESENTADA EN ESTE ACTO POR LA SEÑORA FABIOLA GUERRERO ABREGO A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “EL PRESTADOR”; Y POR OTRA PARTE EL/LA C. <u>' . $nombreTitular . '</u>, A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “EL CLIENTE”; “EL PRESTADOR” Y “EL CLIENTE” CONJUNTAMENTE DENOMINADAS “LAS PARTES” SE OBLIGAN AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:</b></p><br><p align="center" style="font-size:13px;">';

        $html .= '<b>DECLARACIONES</b></p><br><p align="justify" style="font-size:13px;"></p><br>';

        $html .= '<p align="justify" style="font-size:13px;"><b>I.- COSOMI&CO S.C por conducto de su representante manifiesta:</b><br><br>';

        $html .= '1. - Ser una sociedad civil constituida bajo las leyes mexicanas y en estricto apego a los ordenamientos legales conducentes, cuyo nombre comercial es “Body Effect”, tal y como lo acredita con la escritura pública número 15,837 de fecha 16 de octubre del 2019, pasada ante la fe del Lic. Leopoldo Mondragón González, Notario Titular de la Notaría número 29, en el Estado de Querétaro; y que cuenta con las facultades legales, autorizaciones e infraestructura correspondiente para celebrar el presente contrato. <br><br>

2. Que por escritura Pública número 15, 839 de fecha 16 de octubre del 2019, pasada ante la fe del Lic. Leopoldo Mondragón González, Notario Titular de la Notaría número 29, en el Estado de Querétaro., se le otorgó poder y facultades suficientes a la C. Fabiola Guerrero Abrego para otorgar el presente contrato en nombre y a cuenta de COSOMI&CO S.C. <br><br>

3. Que mediante este acto designa a la <b>DRA. DAYHAN MARGARITA HERNÁNDEZ GALLARDO</b> (en lo sucesivo <b>EL MEDICO</b>), médico cirujano con cédula profesional <b>11015834</b>, para que realice el procedimiento y tratamiento de medicina estética que elija <b>EL CLIENTE</b>. 

4. Su objeto social le permite celebrar el acto que por el presente contrato se materializa. <br><br>

5. Que su domicilio ésta ubicado en Plaza Midtown, Jalisco Local 53, Planta Alta, Italia Providencia, Municipio De Guadalajara, Estado De Jalisco, Código Postal 44648. <br><br>

6. Cuenta con capacidad económica, técnica, operativa, infraestructura y personal suficientes para asumir la prestación de servicios. <br><br>

7. En cumplimiento de la norma oficial <b>NOM-SSA1-1998</b> recibí del CLIENTE, su expediente clínico, y/o certificado médico el cual se agrega al presente instrumento como ANEXO B. <br><br>

8. En consecuencia, del ARTÍCULO 15 DEL CÓDIGO PENAL FEDERAL vigente, le entregué, expliqué y resolví todas las dudas al <b>CLIENTE</b> sobre el/los tratamientos a los que mediante el presente instrumento pretende someterse, mediante el consentimiento informado, por lo que el CLIENTE mostro conformidad mediante su firma por lo cual, se agrega al presente instrumento como <b>ANEXO C</b>. <br><br>

9. Que los productos suministrados por los <b>PROVEEDORES</b>, para la buena aplicación de la medicina estética, antienvejecimiento y sus diversos tratamientos, cuentan con los permisos sanitarios requeridos por la legislación mexicana. <br><br>

10. Declara que es su voluntad la celebración del presente contrato y que a la firma de este no existe ningún tipo de dolo, violencia o mala fe.<br></p><br>';

        $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table><p align="justify" style="font-size:13px;">';

        $html .= '<b>II.- EL CLIENTE manifiesta:</b> <br><br>
1. Ser una persona física, con capacidad legal para celebrar el presente contrato, mayor de edad y conocedora de los alcances del objeto de este contrato. <br><br>

2. Que se ha hecho de su conocimiento los riesgos que implica el presente tratamiento de medicina estética mencionados en los consentimientos informados, previamente firmados por <b>EL CLIENTE</b>, de los cuales se le entregará una copia y agrega al presente instrumento como <b>ANEXO A.</b><br><br>

3. Que conoce y entiende a la perfección los beneficios y efectos derivados de los tratamientos que ha solicitado se le realicen. <br><br>

4. En cumplimiento de la norma oficial <b>NOM-SSA1-1998</b> no altere, modifique u omití algún dato o información importante dentro de mi expediente clínico, el cual fue previamente entregado al <b>“PRESTADOR”</b>, y se agrega al presente instrumento como <b>ANEXO B.</b> <br><br>

5. En consecuencia, del <b>ARTÍCULO 15 DEL CÓDIGO PENAL FEDERAL</b> vigente, se me entrego, explicó y comprendí el consentimiento informado previamente entregado por el “PRESTADOR”, del cual mostré total conformidad y se agrega al presente instrumento como ANEXO C. <br><br>

6. Como un hecho sobresaliente debe señalarse que la explicación del médico fue lo suficientemente clara para evidenciar los beneficios que el acto y tratamiento médico estético propuesto ofrecido a <b>EL CLIENTE</b>, respecto a otras opciones de manejo, sobresaliendo particularmente las ventajas positivas del procedimiento de atención. <br><br>

7. Sabiendo todo lo anterior, expresa su consentimiento para la celebración del mismo, asume los beneficios y posibles riesgos y consecuencias del tratamiento.<br><br>';
            
            $html .= '<b>III. - LAS PARTES, manifiestan:</b> <br><br>

1. - Cuentan con facultades, para la celebración del presente contrato; <br><br>

2. Manifiestan que se reconocen mutua y recíprocamente la personalidad con que se ostentan para todos los efectos legales y contractuales a que haya lugar; <br><br>

3. Declaran reconocer que se pactaron los precios y previa cotización de los servicios que se encuentren establecidos en el presente instrumento;<br><br>

4. Con nuestras firmas validamos este documento, así como los anexos que forman parte del mismo, manifestando que, con un lenguaje simple y entendible, el médico, así como el personal del <b>“PRESTADOR”</b>, explicó el plan de manejo propuesto y aclaró cada una de las preguntas que <b>EL CLIENTE</b> le planteó, de tal forma que para ambos queda perfectamente claro que tomando en consideración las características personales, individuales de <b>EL CLIENTE</b>, el acto y tratamiento médico estético que se requiere, consiste en lo que a continuación se expresa, mediante las siguientes: <br>   </p>';

        $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table>';

        $html.= '<p align="center" style="font-size:13px;"><b>CLÁUSULAS</b></p><p align="justify" style="font-size:13px;">';

        $html .= '<b>PRIMERA.- OBJETO.- </b> Los servicios profesionales que <b>EL PRESTADOR</b> lleve en favor de <b>EL CLIENTE</b> de tratamiento de medicina  estética y antienvejecimiento en las áreas contratadas por <b>EL CLIENTE</b>, las cuales son: ' . $allAreas . ' mismas que no podrán modificarse o cambiarse, una vez firmado el presente contrato.';

        $html .= 'El servicio anterior es en conjunto con el tratamiento de remodelación corporal denominado <b>“VENUS LEGACY”</b>, en las áreas contratadas por <b>EL CLIENTE</b>, las cuales son: ' . $allAreas . ' mismas que no podrán modificarse o cambiarse, una vez firmado el presente contrato. El presente instrumento sólo es aplicable para los tratamientos de medicina estética denominados: <br><br>
a) Factores de crecimiento <br>
b) Smart Peeling <br>
c) Lipo Enzimas <br>
d) Faciales <br>
e) Sculptra <br><br>
De los cuales previamente están identificados en los consentimientos informados; y manifestando <b>EL CLIENTE</b>, el tratamiento de su elección.</p><br><br>';
        
        $html .= $this->leyendaProsa($prosa, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $fecha_inicial, $quincenaValue);

        $html .= '<p align="justify" style="font-size:13px;"><br>De igual forma, <b>EL CLIENTE</b> acepta que no habrá cancelaciones de pagos, anticipos, ni devoluciones de dinero por parte de EL PRESTADOR, del procesador de pagos respectivo, ni del banco emisor de la tarjeta de los pagos y/o cobros efectuados posterior a la contratación objeto de este Contrato, por lo tanto, no existen reembolsos totales ni parciales sobre el objeto contratado. <br><br>

<b>TERCERA.- DE LA VARIABILIDAD DE RESULTADOS. EL CLIENTE</b> se hace sabedor que los resultados sobre el tratamiento contratado podrán variar de acuerdo a factores de (i) edad, (ii) sexo (iii) alimentación, (iv) actividad física, (v) zona de tratamiento (vi) número y frecuencia de sesiones (vii), factores genéticos, entre otros. Por lo cual se realizará un expediente donde obre el historial de registro de tratamiento entre cada sesión sin que exista garantía alguna del alcance de los resultados. Por ende, las partes acuerdan que el presente contrato es de medios y no de resultados. <br><br></p>';

        $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table>';

        $html .= '<p align="justify" style="font-size:13px;"><b>CUARTA.- RESPONSABILIDAD.- EL PRESTADOR</b> manifiesta que el servicio se brinda con calidad, profesionalismo e higiene, apegado a las buenas prácticas sobre el tratamiento contratado y por lo mismo, <b>EL PRESTADOR</b> no se hará responsable por cualquier efecto secundario que llegare a afectar a <b>EL CLIENTE</b> derivado del tratamiento objeto del presente contrato, deslindándose de cualquier daño o perjuicio derivado de ello. <br><br>';

        $html .= 'Para ello <b>EL CLIENTE</b> reconoce haber otorgado su consentimiento informado y declara que la información proporcionada es verídica, por lo cual exime a <b>EL PRESTADOR</b> de cualquier complicación o afectación que se suscite por haberle otorgado de forma imprecisa o falsa información o bien omitirla (sea de su conocimiento o no) y que derive en complicaciones a su salud. <br><br>';

        

        $html .= '<b>QUINTA.- SUSPENSIÓN DE TRATAMIENTO.- EL CLIENTE</b> por salir del país, por embarazo o por causa de fuerza mayor podrá suspender el tratamiento por una sola ocasión, dando aviso mediante una carta sellada de recibido a la empresa, del porqué de su interrupción del tratamiento, pudiendo regresar después de un tiempo máximo de 1 año a seguir recibiendo su tratamiento sin perder la garantía. <br><br>';

        $html .= 'Una vez trascurrido el año posterior al aviso de suspensión de tratamiento, <b>EL CLIENTE</b> no podrá reanudar el tratamiento aplicando el saldo de pagos a su favor, perdiendo el <b>100% de cualquier pago o abono</b>, así como garantía aplicable, por lo que en caso de que <b>EL CLIENTE</b> desee utilizar los servicios de <b>EL PRESTADOR</b>, se celebrará un nuevo contrato. <br><br>

<b>SEXTA.- MODIFICACIONES. - LAS PARTES</b> acuerdan que son conocedoras de los alcances de lo aquí pactado, por lo tanto, están de acuerdo en que cualquier pacto verbal que no esté estipulado de manera expresa dentro del presente contrato no será válido y por tanto no obligará a ninguna de las partes. <br><br>

<b>SÉPTIMA.- . AUTORIZACIÓN PARA AUDIO.</b> A efecto de evitar y, en su caso, castigar cualquier conducta indebida por parte del personal de <b>EL PRESTADOR</b> y/o del <b>CLIENTE</b>, desde este momento, éste otorga su consentimiento para que dentro de las cabinas se cuente con equipo de grabación de audio para monitorear, NO CÁMARAS, solo audio y evitar las citadas conductas indebidas, quedando prohibidas de igual forma las propinas a las enfermeras. <br><br>

<b>OCTAVA.– RESCISIÓN DE CONTRATO.-</b> Cualquier incumplimiento será considerado como causa suficiente para la rescisión de este instrumento, sin que para ello se requiera procedimiento o declaración judicial alguna. 
Para rescindir este contrato bastará con la notificación de recisión que realice <b>EL PRESTADOR</b> a <b>EL CLIENTE</b> en el domicilio y términos señalados en la cláusula que corresponda de este contrato. <br><br>

Asimismo, <b>“LAS PARTES”</b>, pactan que en caso de incumplimiento o causales de rescisión del presente contrato, <b>“EL PRESTADOR”</b>, realizará el cierre de cuenta inmediatamente, sin que este se encuentre obligado a regresar la cantidad de dinero aportada al acto y tratamiento médico estético que se establece en la cláusula primera del presente contrato, por lo que desde la firma del presente contrato <b>“EL CLIENTE”</b>, renuncia a cualquier acto o acción jurídica que pueda imponer en contra de <b>“EL PRESTADOR”</b>, dando por rescindido el presente instrumento. <br><br></p>';

        $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table><p align="justify" style="font-size:13px;">';

        $html .= '<b>OCTVA BIS.- SUBSISTENCIA DE OBLIGACIONES.–</b> La rescisión del presente contrato no afectaran las situaciones que legítimamente se hubieren en derivado del mismo, por lo que las partes se obligan a dar cumplimiento de las obligaciones estipuladas de este y que se encuentren pendientes de cumplir al momento de ocurrir dicha rescisión. <br><br>

<b>NOVENA.– DOMICILIOS Y NOTIFICACIONES.- “LAS PARTES”</b> establecen como domicilio y correo electrónico, para oír y recibir todo tipo de notificaciones relacionadas con el presente contrato, los siguientes: <b>“EL PRESTADOR”.–</b><br><br>';

        $html .= '<b>BODY EFFECT</b><br>
<u>Plaza Midtown, Jalisco Local 53-A, Planta Alta, Italia Providencia, Municipio De Guadalajara, Estado De Jalisco, Código Postal 44648.</u><br>
Correo electrónico. - <u>contacto@bodyeffect.com.mx</u><br><br>';

            $html .= '“<b>EL CLIENTE”. –</b><br>
Nombre Completo <u>'. $nombreTitular .'</u> <br>
Domicilio <u>'. $domicilioTitular .'</u> <br>
Correo electrónico <u>'. $correoTitular .'</u> <br><br>';

        $html .= 'Asimismo, <b>“LAS PARTES”</b> acuerdan que todas las notificaciones deberán ser por escrito o correo electrónico, sin justificación alguna. En caso, de no poder notificarse en los domicilios anteriormente señalados, bastará con la notificación de correo electrónico, asumiendo su total responsabilidad <b>LAS PARTES</b>, de estar constantemente al pendiente de su dirección de correo electrónico.<br><br>';

        $html .= '<b>DÉCIMA.– PROPIEDAD INTELECTUAL E INDUSTRIAL DEL MATERIAL PUBLICITARIO.–</b> Todos los derechos derivados del producto aplicado, marcas, nombres comerciales y cualquier otro derecho de propiedad industrial e intelectual, incluyendo sin limitar cualquiera de sus derechos de autor, que entregue <b>EL PRESTADOR</b> a <b>EL CLIENTE</b>, será por cuenta exclusiva de la parte que haya hecho su entrega, sin que la otra parte adquiera ningún derecho de disposición, uso, goce o posesión sobre dicho material. <br><br>

<b>EL PRESTADOR</b>, está obligado a usar las marcas, logos, avisos comerciales, nombre comercial y diseños en la forma y términos en que los mismos han sido diseñados y registrados por su proveedor quedando expresamente prohibido modificarlos de forma alguna. <br><br>

<b>DÉCIMA PRIMERA.- PERSONAL DE LAS PARTES.– LAS PARTES</b>, están de acuerdo en que este contrato se suscribe en el entendido de que <b>EL PRESTADOR</b> cuenta con el personal necesario y los elementos propios para realizar el cumplimiento objeto del presente contrato, y, por tanto, <b>EL CLIENTE</b> acepta que ninguna de ellas se considerará como intermediario o parte patronal respecto la una a la otra. <br><br>

<b>DÉCIMA SEGUNDA.- CONFIDENCIALIDAD.– LAS PARTES</b>, se obligan a mantener en estricta confidencialidad a información a la que con motivo de la presentación del servicio objeto del presente contrato tengan acceso, así como a que el personal contratado por el mantendrá absoluta confidencialidad sobre dicha información, por lo que asume la responsabilidad por el mal uso que dicho persona haga de la mencionada información durante y después de la terminación del presente contrato. <br><br>

Las obligaciones señaladas en la presente cláusula, permanecerán vigente durante los 2x años siguientes a la terminación por cualquier causa del presente contrato. Ninguna de las partes publicará ni permitirá que se publique cualquier comunicado de prensa o cualquier anuncio respecto del presente contrato o las operaciones contenidas en el mismo sin el previo consentimiento por escrito de las partes.<br><br></p>';

        $html .= '<table style="page-break-before:always;"><tr><td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td><td style="font-size:13px;"><div align="right"><b>CONTRATO DE PRESTACIÓN<br>DE SERVICIOS DE MEDICINA<br>ESTÉTICA, ANTIENVEJECIMIENTO<br>Y SUS DIVERSOS TRATAMIENTOS</b></div></td></tr></table><p align="justify" style="font-size:13px;">';

        $html .= '<b>DÉCIMA TERCERA.- AVISO DE PRIVACIDAD Y USO DE DATOS PERSONALES.- EL CLIENTE</b> manifiesta conocer y aceptar los términos del <b><u>AVISO DE PRIVACIDAD</u></b> y el tratamiento que se le darán a los datos personales de los cuales es titular, incluyendo aquellos clasificados como datos sensibles, por lo que otorga su consentimiento total sobre la manera en que se recaban, y se hace sabedor de los derechos que tiene en su carácter de titular. <br><br>

<b>DÉCIMA CUARTA.- PROTECCIÓN DE DATOS PERSONALES.– LAS PARTES</b>, se obligan a que todos los datos personales según se definen en la Ley Federal de Datos Personales de los Particulares y su Reglamento, serán tratados con la mayor cautela y de manera confidencial, resguardándolas en todo tiempo, manteniendo y estableciendo medidas de seguridad administrativas y técnicas que permitan proteger los datos personales contra daño, perdida, alteración, destrucción o el uso, acceso o tratamiento no autorizado, observando en todo tiempo principios de licitud, consentimiento, información, calidad, lealtad, proporcionalidad y responsabilidad sobre los datos. <br><br>';


        $html .= '<b>DÉCIMA QUINTA.- ENCABEZADOS.–</b> Los encabezados de las cláusulas del presente contrato son exclusivamente por conveniencia de referencia y no deberán limitar o de alguna manera afectar el significado de alguna disposición de este contrato. <br><br>

<b>DÉCIMA PRIMERA.- COMPETENCIA.-</b> LAS PARTES manifiestan que para dirimir cualquier controversia respecto del objeto del presente contrato y las consecuencias inherentes al mismo, se designa a los tribunales competentes de Querétaro, Querétaro, renunciando a la jurisdicción que por domicilio les pudiese corresponder; en la inteligencia de que las quejas o reclamaciones relativas a la competencia de la Procuraduría Federal del Consumidor (PROFECO) atendiendo al ámbito federal que les compete, ambas partes están de acuerdo en dar cumplimiento a la mismas en razón de su respectivo domicilio. Leído en su totalidad el presente contrato y bien enteradas de su contenido y alcances legales <b>“LAS PARTES”</b>, lo firman por duplicado en la Ciudad de Santiago de Querétaro, Querétaro., el día' . date("d") . ' de ' . strftime("%B") . ' del ' . date("Y") . '.<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

        return $html;
    }

    function leyendaProsa($prosa, $numeroTarjeta, $banco, $saldoPendiente, $mensualidad, $fecha_inicial, $quincenaValue){
        $html = '';
        if ( $prosa == 1 ){
            $html .= '<p align="justify" style="font-size:13px;"><b>SEGUNDA.- CONTRAPRESTACIÓN.- EL CLIENTE</b> solicita y autoriza al <b>PRESTADOR</b>, que por medio de la empresa <b>COSOMI S.A DE C.V.</b> o por cualquier otro procesador de pagos, realice cargos recurrentes a su tarjeta <b>No.</b> <b><u>'.$numeroTarjeta.'</u></b> del Banco <b><u>'.$banco.'</u></b> por la cantidad Total de <b><u>$'.number_format($saldoPendiente, 2).'</u></b>, en parcialidades consecutivas, cada una por la cantidad de <b><u>'.$quincenaValue.'</u></b>, a partir del día <b><u>'.date("d-m-Y",strtotime($fecha_inicial)).'</u></b>. <br><br>De igual forma autoriza a que los cobros se puedan realizar en un solo momento o en parcialidades en caso de que la cuenta no cuente con los fondos suficientes, pudiendo <b>EL PRESTADOR</b> y la empresa Procesadora de pagos realizar el intento de cobro las veces que sean necesarios hasta lograr el cargo total respectivo, independientemente de que <b>EL CLIENTE</b> asista o no a sus sesiones y/o tratamiento objeto del presente contrato.</p>';
        }
        else{
            $html .= '<p align="justify" style="font-size:13px;"><b>SEGUNDA.- CONTRAPRESTACIÓN.- EL CLIENTE</b> solicita y autoriza al <b>PRESTADOR</b>, que por medio de la empresa <b>COSOMI S.A DE C.V.</b> o por cualquier otro procesador de pagos, realice cargos recurrentes a su tarjeta <b>No.</b>--------- del Banco --------- por la cantidad Total de --------- en parcialidades consecutivas, cada una por la cantidad de --------- a partir del día ---------. <br><br>De igual forma autoriza a que los cobros se puedan realizar en un solo momento o en parcialidades en caso de que la cuenta no cuente con los fondos suficientes, pudiendo <b>EL PRESTADOR</b> y la empresa Procesadora de pagos realizar el intento de cobro las veces que sea necesarios hasta lograr el cargo total respectivo, independientemente de que <b>EL CLIENTE</b> asista o no a sus sesiones y/o tratamiento objeto del presente contrato.</p>';
        }
        return $html;
    }

    function carta($id_contrato){
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('CARTA PROSA');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetFont('times', 'BI', 20, '', 'false');
        $pdf->SetMargins(15, 15, 15, true);
        $pdf->AddPage('A4', 'PORTRAIT');

        $today = date("d/m/Y");
        $todayF = date("d_m_Y");
        $cobros = $this->Pdf_model->get_cobros($id_contrato);
        $lengthCobros = COUNT($cobros->result());
        $html_carta = '';
        $id_cobro_u =  $cobros->row($lengthCobros-1)->id_cobro; 
        $fecha_final =  $this->Pdf_model->get_last_payment($id_cobro_u)->row()->ultima_fecha_pago;
        $tarjeta = $this->Pdf_model->get_datos_tarjeta($id_contrato);

        $html_carta .= '<div align="center"><img src="'.base_url("assets/img/banco-de-mexico-logo.png").'" style="width:250px;"></div>';
        $html_carta .= '<p align="center" style="font-size:14px;"><b><u>FORMATO PARA CONTRATAR CARGOS RECURRENTES</u></b></p><br><p align="right" style="font-size:14px;">Fecha: <b><u>'.$today.'</u></b></p><br><br>';
        $html_carta .= '<p align="left"; style="font-size:14px;">______________________________<br>(NOMBRE DEL DESTINATARIO)<br><br><br></p>';
        $html_carta .= '<p align="left"; style="font-size:14px;">Solicito el cargo recurrente materia de esta autorización con base en la información que a continuación se indica:</p><br>';
        $html_carta .= '<p align="left"; style="font-size:14px;"><b>1.</b> Nombre del proveedor: <u>COSOMI S.A DE C.V.</u></p><br><br>';
        $html_carta .= '<p align="left"; style="font-size:14px;"><b>2.</b> Descripción del bien o servicio objeto del cargo recurrente: _________________________________.</p>';
        $html_carta .= '<p align="left"; style="font-size:14px;"><b>3.</b> Duración del periodo de facturación (Ejemplo: semanal, quincenal, mensual, bimestral, trimestral, semestral, anual, etc.): ___________________________________.</p>';
        $html_carta .= '<p align="left"; style="font-size:14px;"><b>4.</b> Nombre de la emisora de la tarjeta de Crédito o Débito: <u>'.$tarjeta->row()->banco.'</u> </p>';
        $html_carta .= '<p align="left"; style="font-size:14px;"><b>5.</b> Número de la tarjeta de Crédito o Débito (16 dígitos): <u>'.$tarjeta->row()->numero_tarjeta.'</u>.</p><br>';
        $html_carta .='<p align="left"; style="font-size:14px;"><u><b>INFORMACIÓN OPCIONAL PARA EL TARJETAHABIENTE:</b></u><br></p>';
        $html_carta .='<p align="left"; style="font-size:14px;">Número de identificación generado por el proveedor:<br></p>';
        $html_carta .='<p align="left"; style="font-size:14px;">Del cliente__________;<br>De la referencia__________, o<br>Del contrato__________.<br></p>';
        $html_carta .= '<p align="left"; style="font-size:14px;">Estoy enterado de que en cualquier momento podré pedir a la Emisora que cancele sin costo la realización del cargo recurrente solicitado.<br><br><br></p>';
        $html_carta .= '<p align="center"; style="font-size:14px;">Atentamente<br><br><br><br>_______________________________<br><b>'.$tarjeta->row()->nombre.'</b></p><br><br><br>';
    

        $html = '<div>'.$html_carta.'</div>';
        $pdf->SetFont('Helvetica', '', 5, '', true);
        $pdf->writeHTMLCell(0, 0, $x = '10', $y = '15', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

        $file_name = $cobros->row()->nombre_cliente;

        //Se da esta ruta para saber de donde va a abrir el archivo cuando termine de enviar a la ruta
        $path_b = (base_url('assets/temporales/CPROSAT/').'CPROSA_'.$file_name.'_'.$todayF.'.pdf');
        $pdf->Output(FCPATH.'assets/temporales/CPROSAT/'.'CPROSA_'.$file_name.'_'.$todayF.'.pdf', 'F');
        //Abrimos el archivo que ya guardamos en la ruta x
        header('Location: '.$path_b);
    }

    function recibo($id_contrato){
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('RECIBO DE PAGO');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetFont('times', 'BI', 20, '', 'false');
        $pdf->SetMargins(15, 15, 15, true);
        $pdf->AddPage('A4', 'PORTRAIT');

        $html_recibo = '';
        $engancheT = 0;
        $strPago = '';
        $strClaveRastreo = ''; 
        $todayF = date("d_m_Y");
        $cobros = $this->Pdf_model->get_cobros($id_contrato);
        $titular = $this->Pdf_model->get_titular($cobros->row()->id_cliente);
        $lengthCobros = COUNT($cobros->result());
        $folio_pago = $this->Pdf_model->get_oldest_ticket($id_contrato);

        for ($i = 0; $i < $lengthCobros; $i++) {
			if ($cobros->row($i)->forma_pago == 1)
				$strPago .= 'Tarjeta de crédito (Ref. ' .$cobros->row($i)->referencia. '), ';
			if ($cobros->row($i)->forma_pago == 2)
				$strPago .= 'Tarjeta de débito (Ref. ' .$cobros->row($i)->referencia. '), ';
            if ($cobros->row($i)->forma_pago == 3)
				$strPago .= 'Efectivo, ';
            if ($cobros->row($i)->forma_pago == 6){
                $strPago .= 'Transferencia bancaria (Clave: ' .$cobros->row($i)->clave_rastreo. '), ';                             
            }
		}

        for ($i = 0; $i < $lengthCobros; $i++) {
            $engancheT = $engancheT + $cobros->row($i)->enganche;
        }
        $saldoPendiente = $cobros->row()->cantidad - $engancheT;
        
        if( $strClaveRastreo == '' || $strClaveRastreo == 'undefined'){
        $html_recibo .='
            <table><tbody>
                <tr>
                    <td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td><p align="right"; style="font-size:12px;"><b>SUCURSAL</b><br>Plaza Midtown Jalisco, Local 53-A planta alta, Italia Providencia Guadalajara, Jal.</p></td>
                                </tr>
                                <tr>
                                    <td><p align="right"; style="font-size:12px;"><b>EXPEDIDO</b><br>Guadalajara, Jal. '.strftime("%e de  %B del año %Y").' '. date("h:i:sa").', <b>Forma de pago:</b> '.$strPago.' <b>Recibo:</b> #'.$folio_pago->row()->id_oldest.'</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody></table><br>';
        }
        $html_recibo .='<p align="left"; style="font-size:14px;"><b>CONCEPTO:</b></p>';
        $html_recibo .='<table><tbody><tr><td><p align="left"; style="font-size:14px;"><b>ANTICIPO DE PAGO </b></p></td><td><p align="right"; style="font-size:14px;"><b>$'.number_format($engancheT, 2).'<br>IVA: $0.00<br>Saldo restante a pagar: $'.number_format($saldoPendiente, 2).'</b></p></td></tr></tbody></table>';
        $html_recibo .='<p align="center"; style="font-size:12px;">RECIBIMOS DE <b>'.$titular->row()->nombre.'</b>, LA CANTIDAD DE <b>( $'.number_format($engancheT, 2).' )</b> LE ATENDIÓ <b>'.strtoupper($this->session->userdata("inicio_sesion")['nombre']).'.</b> GRACIAS POR SU PAGO.<br>¡TENGA UN EXCELENTE DÍA!</p>';
        $html_recibo .='<p align="center"; style="font-size:12px;">Si requiere factura favor de solicitarla al momento o bien proporcionar sus datos fiscales al siguiente correo electrónico: <b>facturacion@bodyeffect.com.mx</b> en un tiempo no mayor a 72 horas se le hará llegar su comprobante.<br>Para conocer más sobre nuestros servicios visita nuestra página web <b>www.bodyeffect.com.mx</b></p>';
    //Adjuntamos dos veces el html creado para forma dos copias (cliente y admin)
        $copia_cliente = '<div>'.$html_recibo.'</div><div><p align="center"; style="font-size:10px;">(copia cliente)<br><br><hr></p></div>';
        $copia_admin = '<div>'.$html_recibo.'</div><div><p align="center"; style="font-size:10px;">(copia administrador)</p></div>';
        $html = '<div>'.$copia_cliente.'</div><div>'.$copia_admin.'</div>';
        $pdf->SetFont('Helvetica', '', 5, '', true);
        $pdf->writeHTMLCell(0, 0, $x = '', $y = '30', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true); 
        
        $file_name = $titular->row()->nombre;

        //Se da esta ruta para saber de donde va a abrir el archivo cuando termine de enviar a la ruta
        $path_b = (base_url('assets/temporales/RECIBOT/').'RECIBO_'.$file_name.'_'.$todayF.'.pdf');
        $pdf->Output(FCPATH.'assets/temporales/RECIBOT/'.'RECIBO_'.$file_name.'_'.$todayF.'.pdf', 'F');
        //Abrimos el archivo que ya guardamos en la ruta x
        header('Location: '.$path_b);
    }

    function reimprimir_recibo($id_folio){
        date_default_timezone_set("America/Mexico_City");
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('RECIBO DE PAGO');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetFont('times', 'BI', 20, '', 'false');
        $pdf->SetMargins(15, 15, 15, true);
        $pdf->AddPage('A4', 'PORTRAIT');
        
        $html_recibo = '';
        $engancheT = 0;
        $strPago = '';
        $recibo = $this->Pdf_model->get_old_recibo($id_folio);
        $lengthCobros = COUNT($recibo->result());
        for ($i = 0; $i < $lengthCobros; $i++) {			
			if ($recibo->row($i)->forma_pago == 1)
				$strPago .= 'Tarjeta de crédito (Ref. ' .$recibo->row($i)->referencia. '), ';
			if ($recibo->row($i)->forma_pago == 2)
				$strPago .= 'Tarjeta de débito (Ref. ' .$recibo->row($i)->referencia. '), ';
            if ($recibo->row($i)->forma_pago == 3)
				$strPago .= 'Efectivo, ';
            if ($recibo->row($i)->forma_pago == 6){
                $strPago .= 'Transferencia bancaria (Clave: ' .$recibo->row($i)->clave_rastreo. '), ';                             
            }
		}
        for ($i = 0; $i < $lengthCobros; $i++) {
            $engancheT = $engancheT + $recibo->row($i)->enganche;
        }
        $saldoPendiente = $recibo->row()->cantidad - $engancheT;      
        $todayF = date("d_m_Y");        
        $html_recibo .='
            <table><tbody>
                <tr>
                    <td><img src="'.base_url("assets/img/logo.png").'" style="width:250px; height:75px;"></td>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td><p align="right"; style="font-size:12px;"><b>SUCURSAL</b><br>Plaza Midtown Jalisco, Local 53-A planta alta, Italia Providencia Guadalajara, Jal.</p></td>
                                </tr>
                                <tr>
                                    <td><p align="right"; style="font-size:12px;"><b>EXPEDIDO</b><br>Guadalajara, Jal. '.$recibo->row()->fecha_contrato.', <b>Forma de pago:</b> '.$strPago.' <b>Recibo:</b> #'.$recibo->row()->id_hpagos.'</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody></table><br>';
        $html_recibo .='<p align="left"; style="font-size:14px;"><b>CONCEPTO:</b></p>';
        $html_recibo .='<p align="right"; style="font-size:14px;"><b>ANTICIPO DE PAGO: $'.number_format($engancheT, 2).'<br>IVA: $0.00<br>Saldo restante a pagar: $'.number_format($saldoPendiente, 2).'</b></p>';
        $html_recibo .='<p align="center"; style="font-size:12px;">RECIBIMOS DE <b>'.$recibo->row()->cliente.'</b>, LA CANTIDAD DE <b>( $'.number_format($engancheT, 2).' )</b> LE ATENDIÓ <b>'.$recibo->row()->usuario.'.</b> GRACIAS POR SU PAGO.<br>¡TENGA UN EXCELENTE DÍA!</p>';
        $html_recibo .='<p align="center"; style="font-size:12px;">Si requiere factura favor de solicitarla al momento o bien proporcionar sus datos fiscales al siguiente correo electrónico: <b>facturacion@bodyeffect.com.mx</b> en un tiempo no mayor a 72 horas se le hará llegar su comprobante.<br>Para conocer más sobre nuestros servicios visita nuestra página web <b>www.bodyeffect.com.mx</b></p>';
        //Adjuntamos dos veces el html creado para forma dos copias (cliente y admin)
        $copia_cliente = '<div>'.$html_recibo.'</div><div><p align="center"; style="font-size:10px;">(copia cliente)<br><br><hr></p></div>';
        $copia_admin = '<div>'.$html_recibo.'</div><div><p align="center"; style="font-size:10px;">(copia administrador)</p></div>';
        $html = '<div>'.$copia_cliente.'</div><div>'.$copia_admin.'</div>';
        $pdf->SetFont('Helvetica', '', 5, '', true);
        $pdf->writeHTMLCell(0, 0, $x = '', $y = '30', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true); 
        
        $file_name = $recibo->row()->cliente;

        //Se da esta ruta para saber de donde va a abrir el archivo cuando termine de enviar a la ruta
        $path_b = (base_url('assets/temporales/RECIBOT/').'RECIBO_'.$file_name.'_'.$todayF.'.pdf');
        $pdf->Output(FCPATH.'assets/temporales/RECIBOT/'.'RECIBO_'.$file_name.'_'.$todayF.'.pdf', 'F');
        //Abrimos el archivo que ya guardamos en la ruta x
        header('Location: '.$path_b);
    }
    function amountToWords($amount){
        $formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
        $cents = '100';
        $parts = explode(',', (string) $amount);
        $amountStr = $formatterES->format($parts[0]);
        if(count($parts)>1) $cents = substr(strval($parts[1]), 0, 2);
        $stringFinal = strtolower($amountStr)." pesos con 00/".$cents." m.n.";
        return $stringFinal;
    }


public function review_files(){
        setlocale(LC_TIME,"es_MX");
        $contratoT = FCPATH."assets/temporales/CONTRATOT/";
        $cprosaT = FCPATH."assets/temporales/CPROSAT/";
        $reciboT = FCPATH."assets/temporales/RECIBOT/";

        $directorios[0] = $contratoT;
        $directorios[1] = $cprosaT;
        $directorios[2] = $reciboT;

        for($i = 0; $i < count($directorios); $i++)
        {
            if ($handle = opendir($directorios[$i])) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        /*2 meses*/
                        $filename = $directorios[$i].$entry;
                        $fecha_archivo =  date("Y-m-d", filemtime($filename));
                        $hoy = date('Y-m-d');

                        if($this->dateDifference($hoy , $fecha_archivo , $differenceFormat = '%m' ) <= 2)
                        {
                            echo " NO SE ELIMINARA: ".filemtime($filename);
                            echo "<br>";
                            echo "Último cambio: ".$fecha_archivo." : ".$entry." - DIFF: ".$this->dateDifference($hoy , $fecha_archivo , $differenceFormat = '%m' )."<br>";
                        }
                        else{
                            chown($filename, 666);
                            if (unlink($filename)) {
                                echo 'SE ELIMINÓ: '.$filename."<br>";
                            } else {
                                echo 'Error al borrar el archivo '.$filename;
                            }
                        }
                    }
                }
                closedir($handle);
            }
        }
        exit;

    }
    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }
    

    public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }
    
}