
<div class="box box-success">
	<div class="box-body" style="">
		<table id="my-grid" class="table table-striped table-bordered table-hover table-condensed" width="100%">
			<tbody>
				<tr>
					<td class="text-left">Input Step</td>
					<td class="text-left">
						<?php
							echo form_input(array('type'=>'text','id'=>'step_name','name'=>'step_name','class'=>'form-control input-sm'));
						?>
					</td>
				</tr>
			</tbody>
		</table><br>
		<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','style'=>'min-width:100px; float:right;','value'=>'save','content'=>'Save','id'=>'addStepSave')).' ';
		?>
	</div>
</div>

<style>
	.inSp{
		text-align: center;
	}
	.inSpL{
		text-align: left;
	}

</style>
