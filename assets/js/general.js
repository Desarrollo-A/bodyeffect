$("#reimprimirForm").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: general_base_url + 'index.php/Clientes/reimprimir_ticket',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        dataType: 'json',
        beforeSend: function(){
            $('#btnSubmit').attr("disabled","disabled");
            $('#btnSubmit').css("opacity",".5");
        },
        success: function(data) {				
            $('#btnSubmit').prop('disabled', false);
    $('#btnSubmit').css("opacity","1");
    if(data.length != 0){
      tipo_ticket(data);
    }
    else{
      $("#modalReimprimirTk").modal("hide");
      $("#modalError").modal("show");          
    }			
        },
        error: function(){
            $('#btnSubmit').prop('disabled', false);
            $('#btnSubmit').css("opacity","1");
            $("#modalError").modal("show");
        }
    });
});

function tipo_ticket(data){		      
  data['datos'][0].tipo_ticket == '2' ? reimprimir_ticket2(data) : reimprimir_recibo(data);
}

function reimprimir_ticket2(data)
  {
        var date = new Date();        
    var options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit'};
    var mywindow = window.open('', 'my div', 'height=750,width=720');
    var elementoG = '';
    var elementoU = '';
    var elementoD = '';
    /*let Decimal = data.total;
    let cantidad_dec = Decimal.substring(Decimal.indexOf(".")+1, Decimal .length);*/
    var a = data.total;
    var after_dot = (a.toString().split(".")[1]);
    TotalDevengado = a.replace(/,/g, "");

    date = new Date(data['datos'][0].fecha_creacion);

    elementoG += '<html><head></head><body style="text-align:center;font-family: Arial, Helvetica, sans-serif; font-size:12px"><img id="myImage" src="https://bodyeffect.gphsis.com/assets/img/logo.png" alt="logo" width="100%" />';
    elementoG += '<p>Plaza Midtown Jalisco, Local 53-A planta alta, Italia Providencia Guadalajara, Jal.<br>Teléfono: (332) 310 59 07<br>'
    +date.toLocaleDateString("es-ES", options)+'<p>';
    elementoG += '';
    elementoG += '<p>FOLIO: '+data['datos'][0].folio+' <br>REFERENCIA: '+data['datos'][0].referencias+' <br>Recibí de: <br>'+data['datos'][0].nombre_cliente+'</p>';
    elementoG += '<p>La cantidad de: <br><b>'+NumeroALetras(TotalDevengado)+' '+after_dot+'/100 M.N.</b></p>';
    elementoG += '<p>Forma de pago: <br>';
    var sep ='';
    /**/
    // for( b=0;b<data['forma_pago'].length;b++ ){
    //   if((b+1)<data['forma_pago'].length)
    //   {
    //       sep = ', ';
    //   }
    //   else
    //   {
    //     sep = '';
    //   }
    //   elementoG += '<b>'+data['forma_pago'][b]+sep+'</b>';
    // }
    elementoG += '<b>'+data['datos'][0].metodo_pagos+sep+'</b>';
    elementoG += '</p>';


    elementoG += '<p>Pago de servicios<br>';
    for( n=0;n<data['datos'].length;n++ ){
      sum = n +1;
      elementoG += sum+' pago  '+(data['datos'][n]['fecha_pago']).substr(0,10)+' $'+formatMoney(data['datos'][n]['importe'])+' '+(data['datos'][n]['concepto']).toUpperCase()+'<br>';
    }
    elementoG += '</p><br>';

    elementoG += '<div style="text-align:center !important">';
      elementoG += '<label>DESGLOSE DEL PAGO:</label><br>';
      var tc = 0; var td =0; var ef = 0; var efP =0; var infl =0; var tb =0;
      var array_metodo = [];
        /**/for(var i=0; i<data['metodos_usados'].length; i++)
        {
          // switch(data['metodos_usados'][i]['metodo']){
          //   case 'Tarjeta de crédito':
          //     tc =  tc+parseFloat(data['metodos_usados'][i]['cantidad']);
          //     array_metodo[0] = ['Tarjeta de crédito', tc];
          //   break;
          //   case 'Tarjeta de débito':
          //     td =  td+parseFloat(data['metodos_usados'][i]['cantidad']);
          //     array_metodo[1] = ['Tarjeta de débito', td];
          //   break;
          //   case 'Efectivo':
          //     ef =  ef+parseFloat(data['metodos_usados'][i]['cantidad']);
          //     array_metodo[2] = ['Efectivo', ef];
          //   break;
          //   case 'Efectivo + protegida':
          //     efP =  efP+parseFloat(data['metodos_usados'][i]['cantidad']);
          //     array_metodo[3] = ['Efectivo + protegida', efP];
          //   break;
          //   case 'Influencer':
          //     infl =  infl+parseFloat(data['metodos_usados'][i]['cantidad']);
          //     array_metodo[4] = ['Influencer', infl];
          //   break;
          //   case 'Transferencia bancaria':
          //     tb =  tb+parseFloat(data['metodos_usados'][i]['cantidad']);
          //     array_metodo[5] = ['Transferencia bancaria', tb];
          //   break;
          // }
          elementoG += "<b> " + (data['metodos_usados'][i]['metodo']).toUpperCase() +": </b>";
          elementoG += "$ "+formatMoney(data['metodos_usados'][i]['cantidad'])+"<br>";
        }
        array_metodo.forEach(function(element){
          elementoG += "<b> " + (element[0]).toUpperCase() +": </b>";
          elementoG += "$ "+formatMoney(element[1])+"<br>";
          }
        )        
       
    elementoG += '</div><br><br>';
    elementoG += '<p style="text-align:right!important;margin-left:10%" width="100%"><table width="100%" style="width:100%">';
    elementoG += '<tr>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"><b>SUBTOTAL:</b></p>';
    elementoG += '  </td>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"> $'+data.total+'</p>';
    elementoG += '  </td>';
    elementoG += '</tr>';
    elementoG += '<tr>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"><b>IVA:</b></p>';
    elementoG += '  </td>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"> $0.00</p>';
    elementoG += '  </td>';
    elementoG += '</tr>';
    elementoG += '<tr>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"><b>TOTAL:</b></p>';
    elementoG += '  </td>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;">$'+data.total+'</p>';
    elementoG += '  </td>';
    elementoG += '</tr>';
    elementoG += '</table></p><br>';
    elementoG += '<p style="font-size:12px!important">¡En Body Effect queremos lo mejor para ti!<br>Si requiere factura favor de solicitarla al momento o bien proporcionar sus datos fiscales al siguiente correo electrónico <b>facturacion@bodyeffect.com.mx</b> en un tiempo no mayor a 72 horas se le hará llegar su comprobante<br><br><br></p>';
    elementoU = '<p><i>(copia cliente)</i></p><hr><br>';
    elementoD = '<p><i>(copia administrador)</i></p><br><br><br><hr><br><br>';
    elementoG = elementoG + elementoU + elementoG + elementoD + '</body></html>';
    mywindow.document.write(elementoG);
      
      $(mywindow).ready(function() {  
      // Call Later In Stack - really should be onload events or base64 images inline
      setTimeout(
        function(){
          mywindow.document.write('</body></html>');
          mywindow.document.close(); // necessary for IE >= 10
          mywindow.focus(); // necessary for IE >= 10
          mywindow.print();
          mywindow.close();
        },(1000));
    });
  }
// function reimprimir_ticket(data){		 
//     var date = new Date(data[0].pago_realizado);    	
//     const options = { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'};
//     const options2 = { year: 'numeric', month: 'short', day: 'numeric' };
//     var mywindow = window.open('', 'my div', 'height=750,width=720');
//     var elementoG = '';
//     var elementoU = '';
//     var elementoD = '';
//     var total = 0;
//     for (i = 0; i<data.length; i++){
//         total += data[i].importe;			
//     }
//     var stringImporte = NumeroALetras(total);
//     elementoG += '<html><head></head><body style="text-align:center;font-family: Arial, Helvetica, sans-serif; font-size:12px"><img id="myImage" src="https://prueba.gphsis.com/bodyeff/assets/img/logo.png" alt="logo" width="100%" />';
//     elementoG += '<p>Plaza Midtown Jalisco, Local 53-A planta alta, Italia Providencia Guadalajara, Jal.<br>Teléfono: (332) 310 59 07<br>'+date.toLocaleDateString("es-ES", options)+'<p>';
//     elementoG += '';
//     elementoG += '<p>FOLIO: '+data[0].folio+' <br>REFERENCIA: '+data[0].referencias+' <br>Recibi de: <br>'+data[0].nombre_cliente+'</p>';
//     elementoG += '<p>La cantidad de: <br><b>'+stringImporte+' 0/0 CENTAVOS M.N</b></p>';
//     elementoG += '<p>Forma de pago: <br><b>'+data[0].metodo_pagos+'</b></p>';
//     elementoG += '<p>Pago de servicios<br>';
//     for( n=0;n<data.length;n++ ){
//         var date2 = new Date(data[n].fecha_pago);    	
//         sum = n +1;
//         elementoG += sum+' pago  '+date2.toLocaleDateString("es-ES", options2)+' $'+formatMoney(data[0].importe)+'<br>';
//     }
//     elementoG += '</p><br>';
//     elementoG += '<p style="text-align:right!important"><b>SUBTOTAL:</b> $'+formatMoney(total)+'<br>';
//     elementoG += '<b>IVA:</b> $0.00<br>';
//     elementoG += '<b>TOTAL:</b> $'+formatMoney(total)+'<br>';
//     elementoG += '<p style="font-size:12px!important">¡En Body Effect queremos lo mejor para ti!<br>Si requiere factura favor de solicitarla al momento o bien proporcionar sus datos fiscales al siguiente correo electrónico <b>facturacion@bodyeffect.com.mx</b> en un tiempo no mayor a 72 horas se le hará llegar su comprobante<br><br><br></p>';
//     elementoU = '<p><i>(copia cliente)</i></p><hr><br>';
//     elementoD = '<p><i>(copia administrador)</i></p><br><br><br><hr><br><br>';
//     elementoG = elementoG + elementoU + elementoG + elementoD + '</body></html>';
//     mywindow.document.write(elementoG);
    
//     $(mywindow).ready(function() {  
//     // Call Later In Stack - really should be onload events or base64 images inline
//     setTimeout(
//         function(){
//         mywindow.document.close(); // necessary for IE >= 10
//         mywindow.focus(); // necessary for IE >= 10
//         mywindow.print();
//         mywindow.close();
//         },(1000));
//     });
// }

function reimprimir_recibo(data){
index_ticket = $('#id_ticket').val();
window.open(url+"index.php/Archivos/reimprimir_recibo/"+index_ticket); 
}

 function NumeroALetras(num,centavos){
    var data = {
      numero: num,
      enteros: Math.floor(num),
      centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
      letrasCentavos: "",
    };
    if(centavos == undefined || centavos==false) {
      data.letrasMonedaPlural="PESOS";
      data.letrasMonedaSingular="PESO";
    }else{
      data.letrasMonedaPlural="CENTIMOS";
      data.letrasMonedaSingular="CENTIMO";
    }

    if (data.centavos > 0)
      data.letrasCentavos = "CON " + NumeroALetras(data.centavos,true);

    if(data.enteros == 0)
      return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
    if (data.enteros == 1)
      return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
    else
      return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
  }//NumeroALetras()

  function Miles(num){
    divisor = 1000;
    cientos = Math.floor(num / divisor)
    resto = num - (cientos * divisor)

    strMiles = Seccion(num, divisor, "MIL", "MIL");
    strCentenas = Centenas(resto);

    if(strMiles == "") return strCentenas;

    return strMiles + " " + strCentenas;
  //return Seccion(num, divisor, "UN MIL", "MIL") + " " + Centenas(resto);
  }//Miles()

  function Millones(num){
    divisor = 1000000;
    cientos = Math.floor(num / divisor)
    resto = num - (cientos * divisor)

    strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
    strMiles = Miles(resto);

    if(strMillones == "") return strMiles;

    return strMillones + " " + strMiles;

  }//Millones()

   //Funciones para conversor de número a letras
    function Unidades(num){
        switch(num){
            case 1: return "UN";
            case 2: return "DOS";
            case 3: return "TRES";
            case 4: return "CUATRO";
            case 5: return "CINCO";
            case 6: return "SEIS";
            case 7: return "SIETE";
            case 8: return "OCHO";
            case 9: return "NUEVE";
        }
        return "";
  }

  function Decenas(num){
    decena = Math.floor(num/10);
    unidad = num - (decena * 10);

    switch(decena){
      case 1:
        switch(unidad){
          case 0: return "DIEZ";
          case 1: return "ONCE";
          case 2: return "DOCE";
          case 3: return "TRECE";
          case 4: return "CATORCE";
          case 5: return "QUINCE";
          default: return "DIECI" + Unidades(unidad);
        }
      case 2:
        switch(unidad){
          case 0: return "VEINTE";
          default: return "VEINTI" + Unidades(unidad);
        }
      case 3: return DecenasY("TREINTA", unidad);
      case 4: return DecenasY("CUARENTA", unidad);
      case 5: return DecenasY("CINCUENTA", unidad);
      case 6: return DecenasY("SESENTA", unidad);
      case 7: return DecenasY("SETENTA", unidad);
      case 8: return DecenasY("OCHENTA", unidad);
      case 9: return DecenasY("NOVENTA", unidad);
      case 0: return Unidades(unidad);
    }
  }//Unidades()

  function DecenasY(strSin, numUnidades){
    if (numUnidades > 0)
      return strSin + " Y " + Unidades(numUnidades)

    return strSin;
  }//DecenasY()

  function Centenas(num){
    centenas = Math.floor(num / 100);
    decenas = num - (centenas * 100);

    switch(centenas){
      case 1:
        if (decenas > 0)
          return "CIENTO " + Decenas(decenas);
        return "CIEN";
      case 2: return "DOSCIENTOS " + Decenas(decenas);
      case 3: return "TRESCIENTOS " + Decenas(decenas);
      case 4: return "CUATROCIENTOS " + Decenas(decenas);
      case 5: return "QUINIENTOS " + Decenas(decenas);
      case 6: return "SEISCIENTOS " + Decenas(decenas);
      case 7: return "SETECIENTOS " + Decenas(decenas);
      case 8: return "OCHOCIENTOS " + Decenas(decenas);
      case 9: return "NOVECIENTOS " + Decenas(decenas);
    }
    return Decenas(decenas);
  }//Centenas()

  function Seccion(num, divisor, strSingular, strPlural){
    cientos = Math.floor(num / divisor)
    resto = num - (cientos * divisor)

    letras = "";
    if (cientos > 0)
      if (cientos > 1) letras = Centenas(cientos) + " " + strPlural;
      else letras = strSingular;

    if (resto > 0) letras += "";

    return letras;
  }//Seccion()