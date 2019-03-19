
$(function() {
	
	$('#id_producto_mp').on('change', onSelectMpChange);
	$('#id_producto_mp').on('click', onSelectMpChange);
	$(document).ready(onSelectMpChange);

	$('#pid_producto_pt').on('change', onSelectPtChange);
	$('#pid_producto_pt').on('click', onSelectPtChange);
	$(document).ready(onSelectPtChange);

	$('#id_producto_leader1').on('change', onSelectLeader1Change);
	$('#id_producto_leader1').on('click', onSelectLeader1Change);
	$(document).ready(onSelectLeader1Change);

	$('#id_producto_leader2').on('change', onSelectLeader2Change);
	$('#id_producto_leader2').on('click', onSelectLeader2Change);
    $('#id_producto_leader2').on('selected', onSelectLeader2Change);
	$(document).ready(onSelectLeader2Change);    

    
    $('#id_producto_leader2').trigger('click');

});



function onSelectMpChange() {

	datosM=document.getElementById("id_producto_mp").value.split('_');
    materia_id = datosM[0];
    materia_id_product = datosM[10];


    //alert(materia_id);

    //AJAX

    //class="form-control selectpicker "

    $.get('/api/'+materia_id_product+'/products', function (data){
    	var html_select = '';
    	for (var i=0; i<data.length; i++)
   			html_select+='<option value="'+data[i].id+"_"+data[i].etiqueta_prod+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+'">'+""+data[i].articulo+'</option>';
    	

    	$('#pid_producto_pt').html(html_select);
    	//console.log(html_select);
    });
	

    	//console.log(html_select);
	//alert(materia_id);
}

function onSelectPtChange() {

	datosP=document.getElementById("pid_producto_pt").value.split('_');
    pt_id   = datosP[0];
    pt_largo =datosP[3];
    pt_ancho = $("#total_desp_corrida").val();


    //console.log('ancho:...'+pt_ancho);

    //AJAX


    $.get('/api/'+pt_id+'/'+pt_largo+'/'+pt_ancho+'/products2', function (data){
    	var html_select = '';
    	for (var i=0; i<data.length; i++)
   			html_select+='<option value="'+data[i].id+"_"+data[i].etiqueta_prod+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+'">'+""+data[i].articulo+'</option>';
    	

    	$('#pid_producto_pt2').html(html_select);
    });
}

function onSelectLeader1Change() {

	// Obtiene la informacion del combo 1 o leader 1 para construir el combo 2 para leader 2
    // Obtiene como parametro 11 y 12 el id y etiqueta del leader 2 obtenidos de la tabla 
    // production_order

    datosl1=document.getElementById("id_producto_leader1").value.split('_');
    leader1_id = datosl1[0];

    // Datos a editar de leader 2
    if (datosl1[11] && datosl1[12]){
        l2_id = datosl1[11];
        l2_et = datosl1[12];    
    }
    else {
        l2_id = "";
        l2_et = "";
    }

    // Datos a editar de leader 3
    if (datosl1[13] && datosl1[14]){
        l3_id = datosl1[13];
        l3_et = datosl1[14];    
    }
    else {
        l3_id = "";
        l3_et = "";
    }


    bandera=0;
    vtempo="";

    datosl2="";
    leader2_id=0;
    
    $.get('/api/'+leader1_id+'/products3', function (data){
    	var html_select = '';
    	for (var i=0; i<data.length; i++){
   			html_select+='<option value="'+data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product+'">'+""+data[i].articulo+'</option>';
        }

        // Compara id y etiqueta del combo 2 o leader 2 y si es igual, lo pone como seleccionado
        for (var i=0; i<data.length; i++) {
            if(data[i].id_product==l2_id && data[i].etiqueta==l2_et){
                vtempo = data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product;
                bandera=1; 
            }
        }

        // Construye el combo
    	$('#id_producto_leader2').html(html_select);

        // Marca como seleccionado si la bandera esta activada
        if (bandera==1)
            $("#id_producto_leader2").val(vtempo);

    	//console.log(html_select);
        //console.log("bandera= "+bandera);
        //console.log("vtempo= "+vtempo);
        //console.log(document.getElementById("id_producto_leader2").value);  

        datosl2=document.getElementById("id_producto_leader2").value.split('_');
        leader2_id = datosl2[0];
        //console.log("leader2_id=" +leader2_id);

        $("#tempo_id_producto_leader2").val(datosl2[10]);
        $("#etiqueta_leader2").val(datosl2[1]);
        $("#ancho_leader2").val(datosl2[2]);
        $("#largo_leader2").val(datosl2[3]);
        $("#largo_leader2_original").val(datosl2[3]);
        unidad_leader2=datosl2[5]+'²';
        $("#unidad_leader2").val(unidad_leader2);  
        $("#leader2").val(datosl2[6]);      
        tot_leader2=$("#ancho_leader2").val()*$("#largo_leader2").val();
        $("#total_leader2").val(tot_leader2);
        $("#tempo_id_unidad_leader2").val(datosl2[7]);
        $("#tempo_precioc_leader2").val(datosl2[8]);
        $("#tempo_preciov_leader2").val(datosl2[9]); 

        
    });

    

    bandera=0;
    vtempo="";

    $.get('/api/'+leader1_id+'/'+leader2_id+'/products4', function (data){        
        var html_select = '';
        for (var i=0; i<data.length; i++){
            html_select+='<option value="'+data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product+'">'+""+data[i].articulo+'</option>';
        }

        // Compara id y etiqueta del combo 3 o leader 3 y si es igual, lo pone como seleccionado
        for (var i=0; i<data.length; i++) {
            if(data[i].id_product==l3_id && data[i].etiqueta==l3_et){
                vtempo = data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product;
                bandera=1; 
            }
        }

        // Construye el combo
        $('#id_producto_leader3').html(html_select);

        // Marca como seleccionado si la bandera esta activada
        if (bandera==1)
            $("#id_producto_leader3").val(vtempo);

        datosl3=document.getElementById("id_producto_leader3").value.split('_');

        $("#tempo_id_producto_leader3").val(datosl3[10]);
        $("#etiqueta_leader3").val(datosl3[1]);
        $("#ancho_leader3").val(datosl3[2]);
        $("#largo_leader3").val(datosl3[3]);
        $("#largo_leader3_original").val(datosl3[3]);
        unidad_leader3=datosl3[5]+'²';
        $("#unidad_leader3").val(unidad_leader3);  
        $("#leader3").val(datosl3[6]);      
        tot_leader3=$("#ancho_leader3").val()*$("#largo_leader3").val();
        $("#total_leader3").val(tot_leader3);
        $("#tempo_id_unidad_leader3").val(datosl3[7]);
        $("#tempo_precioc_leader3").val(datosl3[8]);
        $("#tempo_preciov_leader3").val(datosl3[9]); 

    });
}

function onSelectLeader2Change() {
    // Obtiene la informacion del combo 1 o leader 1 para construir el combo 2 para leader 2
    // Obtiene como parametro 11 y 12 el id y etiqueta del leader 2 obtenidos de la tabla 
    // production_order

    datosl1=document.getElementById("id_producto_leader1").value.split('_');
    leader1_id = datosl1[0];

    // Datos a editar de leader 2
    if (datosl1[11] && datosl1[12]){
        l2_id = datosl1[11];
        l2_et = datosl1[12];    
    }
    else {
        l2_id = "";
        l2_et = "";
    }

    // Datos a editar de leader 3
    if (datosl1[13] && datosl1[14]){
        l3_id = datosl1[13];
        l3_et = datosl1[14];    
    }
    else {
        l3_id = "";
        l3_et = "";
    }


    bandera=0;
    vtempo="";

    datosl2="";
    leader2_id=0;
    
    $.get('/api/'+leader1_id+'/products3', function (data){
        var html_select = '';
        for (var i=0; i<data.length; i++){
            html_select+='<option value="'+data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product+'">'+""+data[i].articulo+'</option>';
        }

        // Compara id y etiqueta del combo 2 o leader 2 y si es igual, lo pone como seleccionado
        for (var i=0; i<data.length; i++) {
            if(data[i].id_product==l2_id && data[i].etiqueta==l2_et){
                vtempo = data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product;
                bandera=1; 
            }
        }

        // Construye el combo
        $('#id_producto_leader2').html(html_select);

        // Marca como seleccionado si la bandera esta activada
        if (bandera==1)
            $("#id_producto_leader2").val(vtempo);

        
        datosl2=document.getElementById("id_producto_leader2").value.split('_');
        leader2_id = datosl2[0];

        $("#tempo_id_producto_leader2").val(datosl2[10]);
        $("#etiqueta_leader2").val(datosl2[1]);
        $("#ancho_leader2").val(datosl2[2]);
        $("#largo_leader2").val(datosl2[3]);
        $("#largo_leader2_original").val(datosl2[3]);
        unidad_leader2=datosl2[5]+'²';
        $("#unidad_leader2").val(unidad_leader2);  
        $("#leader2").val(datosl2[6]);      
        tot_leader2=$("#ancho_leader2").val()*$("#largo_leader2").val();
        $("#total_leader2").val(tot_leader2);
        $("#tempo_id_unidad_leader2").val(datosl2[7]);
        $("#tempo_precioc_leader2").val(datosl2[8]);
        $("#tempo_preciov_leader2").val(datosl2[9]); 

    });

    

    bandera=0;
    vtempo="";

    $.get('/api/'+leader1_id+'/'+leader2_id+'/products4', function (data){        
        var html_select = '';
        for (var i=0; i<data.length; i++){
            html_select+='<option value="'+data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product+'">'+""+data[i].articulo+'</option>';
        }

        // Compara id y etiqueta del combo 3 o leader 3 y si es igual, lo pone como seleccionado
        for (var i=0; i<data.length; i++) {
            if(data[i].id_product==l3_id && data[i].etiqueta==l3_et){
                vtempo = data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+"_"+data[i].articulo+"_"+data[i].id_unidad+"_"+data[i].precioc+"_"+data[i].preciov+"_"+data[i].id_product;
                bandera=1; 
            }
        }

        // Construye el combo
        $('#id_producto_leader3').html(html_select);

        // Marca como seleccionado si la bandera esta activada
        if (bandera==1)
            $("#id_producto_leader3").val(vtempo);

        
        datosl3=document.getElementById("id_producto_leader3").value.split('_');

        $("#tempo_id_producto_leader3").val(datosl3[10]);
        $("#etiqueta_leader3").val(datosl3[1]);
        $("#ancho_leader3").val(datosl3[2]);
        $("#largo_leader3").val(datosl3[3]);
        $("#largo_leader3_original").val(datosl3[3]);
        unidad_leader3=datosl3[5]+'²';
        $("#unidad_leader3").val(unidad_leader3);  
        $("#leader3").val(datosl3[6]);      
        tot_leader3=$("#ancho_leader3").val()*$("#largo_leader3").val();
        $("#total_leader3").val(tot_leader3);
        $("#tempo_id_unidad_leader3").val(datosl3[7]);
        $("#tempo_precioc_leader3").val(datosl3[8]);
        $("#tempo_preciov_leader3").val(datosl3[9]); 


    });

}
