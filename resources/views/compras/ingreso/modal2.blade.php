<div class="modal fade " aria-hidden="true" role="dialog" tabindex="-1" id="modal2-delete-{{$ingreso->idingreso}}" aria-labelledby="modal2-delete-{{$ingreso->idingreso}}">
	{{Form::Open(array('action'=>array('IngresoController@destroy',$ingreso->idingreso),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close"aria-hidden="true">&times;</button>
                <center><h4 class="modal-title">Cancelar Ingreso</h4></center>
			</div>
			<div class="modal-body">
				<center>
				<img src= "{{ asset('img/cancelar1.png') }}" width="100" height="100" alt="..." class="img-rounded">
				<br><br>
				<br>
				<p>¿Estas seguro de CANCELAR la orden de Ingreso?</p>
				</center>
			</div>
			<div class="modal-footer">
				<center>
				<button type="button" class="btn btn-default " data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary ">Confirmar</button>
				</center>
			</div>
		</div>
	</div>
	{{Form::Close()}}
</div>

      
      
      