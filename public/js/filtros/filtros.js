
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
    	console.log(html_select);
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

	datosl1=document.getElementById("id_producto_leader1").value.split('_');
    leader1_id = datosl1[0];

    $.get('/api/'+leader1_id+'/products3', function (data){
    	var html_select = '';
    	for (var i=0; i<data.length; i++)
   			html_select+='<option value="'+data[i].id+"_"+data[i].etiqueta+"_"+data[i].ancho_prod+"_"+data[i].cantidad_prod+"_"+data[i].formula+"_"+data[i].unidad+'">'+""+data[i].articulo+'</option>';

    	$('#id_producto_leader2').html(html_select);
    	console.log(html_select);
    });
}

