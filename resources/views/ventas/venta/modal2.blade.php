<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal2-delete-{{$venta->idventa}}">
	{{Form::Open(array('action'=>array('VentaController@destroy',$venta->idventa),'method'=>'delete'))}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <center><h4 class="modal-title">Cancelar Salida</h4></center>
			</div>
			<div class="modal-body">
				<center>
				<img src= "{{ asset('img/cancelar1.png') }}" width="100" height="100" alt="..." class="img-rounded">
				<br><br>
				<br>
				<p>¿Estas seguro de CANCELAR la orden de Salida?</p>
				</center>
			</div>
			<div class="modal-footer">
				<center>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
				</center>
			</div>
		</div>
	</div>
	{{Form::Close()}}

</div>