<?php require_once RESOURCES."/Templates/header.php"; ?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>/pagination.css">

<div class="container py-5">
	<div class="row align-items-center justify-content-center">
		<div class="col-11">
			<div class="card">
				<div class="card-header text-black-50 raleway-bold">
					Listado
				</div>
				<div class="card-body">
					<form class="form-search" method="get" action="<?php echo URL; ?>/User/Pagination" data-url-change="<?php echo URL; ?>/User/Listing">
							<div class="md-form input-group">
								<div class="input-group-prepend">
									<select id="input_whr" name="input_whr" class="browser-default form-control btn green waves-effect white-text">
										<option value="id">ID<option>
										<option value="name" selected>Nombre<option>
										<option value="slug">Slug<option>
									</select>
								</div>
								<input type="text" id="value_whr" name="value_whr" class="form-control" value="" placeholder="Búsqueda" aria-describedby="value_whr aria-label=">
								<div class="input-group-prepend">
									<button type="submit" id="btn-search" class="btn btn-green btn-sm waves-effect m-0">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>
						</form>

						<div class="errors-delete"></div>

						<table class="table table-hover">
							<thead class="green white-text">
								<th>Código</th>
								<th>Nombre</th>
								<th>Email</th>
								<th>Rol</th>
								<th>Actualizado el</th>
								<th colspan="2"></th>
							</thead>
							<tbody class="content-pagination">
								<?php echo $params['list']; ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">
										Por página <b class="raleway-bold"><?php echo LIMIT_PER_PAGE; ?></b> | Total: <b class="raleway-bold"><?php echo $params['cant']; ?></b>
									</td>
									<td colspan="4" class="render-pagination">
										<?php echo $params['render']; ?>
									</td>
								</tr>
							</tfoot>
						</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm modal-notify modal-danger" role="document">
			<div class="modal-content text-center">
				<div class="modal-header d-flex justify-content-center">
					<p class="heading">¿Está seguro de eliminar?</p>
				</div>
				<div class="modal-body">
					<i class="fa fa-times fa-4x animated rotateIn"></i>
				</div>
				<div class="modal-footer flex-center">
					<input type="hidden" id="id-form-delete" id-form-delete="name">
					<a id="btn-form-delete" class="form-delete btn btn-outline-danger">Si</a>
					<a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once RESOURCES."/Templates/footer.php"; ?>
<script type="text/javascript" src="<?php echo JS; ?>/pagination.js"></script>