<?php
	$tanggal = date('Y-m-d');
foreach ($results['tr_spk'] as $tr_spk){
	
	
	}
	$get_stocklot = $this->db->get_where('stock_material',array('id_stock'=>$tr_spk->id_stock))->result();

?>

 <div class="box box-primary">
    <div class="box-body">
		<form id="data-form" method="post">
			<div class="col-sm-12">
				<div class="input_fields_wrap2">
			<div class="row">
		<center><label for="customer" ><h3>Aktual Produksi</h3></label></center>
		<div class='form-group row'>
			<label class='label-control col-sm-2'><b>Tanggal Produksi <span class='text-red'>*</span></b></label>
			<div class='col-sm-2'>
				<input type="text" name="date_production" id="date_production" value='<?= date('d-m-Y', strtotime($tr_spk->date_production))?>' class="form-control input-sm datepicker" placeholder="Tanggal Produksi" readonly />
			</div>
		</div>
		
        <div class="form-group row" >
		<div class="col-sm-12">
			<label>A.Material</label>
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-blue'>
			<th width='3%' hidden>ID Stok</th>
			<td width='15%'>No Lot</td>
            <td width='15%'>Nama Material</td>
            <td width='7%'>Thickness</td>
            <td width='7%'>Density</td>
            <td width='7%'>Length<br>Mother<br> Coil</td>
			<td width='7%'>Width<br>Mother<br> Coil</td>
            <td width='7%'>Weight<br> Packing<br> list</td>
            <td width='7%'>Weight <br> Actual<br> Mother<br> Coil</td>
            <td width='7%'>Plan<br> Weight<br> Sisa</td>
            <td width='7%'>Actual<br> Weight<br> Sisa</td>
			</tr>
			</thead>
		<tbody>
		<tr>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->no_surat?>' 	readonly id='no_surat' required name='no_surat'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_spkproduksi?>' 	readonly id='id_spk_produksi' required name='id_spk_produksi'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_tr_spk_produksi?>' 	readonly id='id_spk_aktual' required name='id_spk_aktual'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_stock?>' 	readonly id='id_stock' required name='id_stock'></th>
		<th><input type='text' class='form-control'  	   	value='<?= $tr_spk->lotno?>' 	readonly id='lotno' required name='lotno'></th>
		<th hidden><input type='text' class='form-control'  value='<?= $tr_spk->id_material?>' 	readonly id='id_material' required name='id_material'></th>
		<th><input type='text' class='form-control'  	   	value='<?= $tr_spk->nama_material?>' 	readonly id='nama_material' required name='nama_material'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->thickness?>'	readonly id='thickness' required name='thickness'></th>
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->density?>'	readonly id='density' required name='density'></th>
		
		
		<th><input type='text' class='form-control'  		value='<?= $tr_spk->length?>' 	readonly id='panjang'  required name='panjang'></th>
		
		<th><input type='text' class='form-control'   		value='<?= $tr_spk->width?>' 	readonly id='width'  required name='width'></th>
		
		<th><input type='text' class='form-control weight' 	id='weight' value='<?= $tr_spk->weight?>'  	readonly required name='weight'></th>
		
		<th><input type='text' class='form-control weight_actualpl' value='<?= $tr_spk->weight_actualpl?>'	id='weight_actualpl' onkeyup='hitungNGpackinglist()'required name='weight_actualpl'></th>
		
		<th><input type='text' class='form-control kg_sisa' id='kg_sisa'	value='<?= $tr_spk->kg_sisa?>'  	readonly required name='kg_sisa'></th>
		
		<th><input type='text' class='form-control kg_sisa_actual' 	id='kg_sisa_actual'  value='<?= $tr_spk->kg_sisa_actual?>' onkeyup='hitungActualweightproses()' required name='kg_sisa_actual'></th>		
		</tr>
		</tbody>
		
		
		<tfoot>
			<tr >
			<th width='3%' hidden></th>
			<td width='15%'></td>
            <td width='15%'></td>
            <td width='7%'></td>
            <td width='7%'></td>
            <td width='7%'></td>
			<td width='7%'></td>
            <td width='7%'><b>NG Packing list</b></td>
            <td width='7%'><input type='text' class='form-control ng_packinglist1' name='ng_packinglist1' value='<?= $tr_spk->ng_packinglist1?>' readonly></td>
            <td width='7%'><b>Actual weight proses</b></td>
            <td width='7%'><input type='text' class='form-control actualweightproses' name='actualweightproses' value='<?= $tr_spk->actualweightproses?>' readonly></td>
			</tr>
		</tfoot>


		</table>
		</div>
		</div>
		
		<div class="form-group row" >
		<div class="col-sm-12">
			<label>B.Produksi</label>
			<table class='table table-bordered table-striped'>
			<thead>
			<tr class='bg-yellow'>
            <th width='3%'>No</th>
            <th>SPK Marketing</th>
            <th width='15%'>Customer</th>
            <th width='7%'>Width Slitting</th>
            <th width='7%'>Weight Slitting</th>
            <th> Lot Number Slitting</th>
			<th width='7%'>Actual <br>Weight<br>Slitting</th>
			<th width='10%'>Delivery Date</th>
            </tr>
			</thead>
			<tbody id="list_spk">
			<?php $loop=0;
			foreach ($results['dt_spk'] as $dt_spk){$loop++; 
			
			// print_r($dt_spk);
			// exit;
			$surat = $dt_spk->no_surat;
			$nosurat = $this->db->query("SELECT a.*, b.no_surat as no_surat FROM dt_spkmarketing as a INNER JOIN tr_spk_marketing as b ON a.id_spkmarketing = b.id_spkmarketing WHERE a.id_dt_spkmarketing='$surat' ")->row();

			$spkmar = 'NONSPK';
			if($surat <> 'NONSPK'){
				$spkmar = $nosurat->no_surat;
			}
		
		                        echo "
								<tr id='tr_$loop'>
									<th>$loop</th>
									<th >
									<input type='text' class='form-control' 	value='$dt_spk->no_surat' 	readonly id='used_nosurat_$loop' required name='dt[$loop][nosurat]'>
									</th>
									<th hidden>
									<input type='text' class='form-control' 	value='$dt_spk->idcustomer' 	readonly id='used_idcustomer_$loop' required name='dt[$loop][idcustomer]'>
									</th>
									<th>
									<input type='text' class='form-control'  	   	value='$dt_spk->namacustomer' 	readonly id='used_namacustomer_$loop' required name='dt[$loop][namacustomer]'>
									</th>
									<th hidden>
									<input type='text' class='form-control' 		value='$dt_spk->nmmaterial'  	readonly id='used_nmmaterial_$loop' required name='dt[$loop][nmmaterial]'>
									</th>
									<th hidden> 
									<input type='text' class='form-control' 		value='$dt_spk->thickness' 		readonly id='used_thickness_$loop' required name='dt[$loop][thickness]'>
									</th>
									<th>
									<input type='text' class='form-control'   		value='$dt_spk->weight' 		readonly id='used_weight_$loop' required name='dt[$loop][weight]'>
									</th>
									
									<th>
									<input type='text' class='form-control'   		value='$dt_spk->width' 			readonly id='used_width_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][width][]'>
									<input type='hidden' class='form-control'   		value='$dt_spk->totalwidth' 		readonly id='used_totalwidth_$loop' required name='dt[$loop][totalwidth][]'>
									</th>
									
									<th>
									<input type='text' class='form-control'   		value='$tr_spk->lotno -$loop' 		readonly id='used_lot_slitting_$loop' required name='dt[$loop][lot_slitting][]'>
									</th>									

									<th class='text-center' hidden>
										<button type='button' class='btn btn-sm btn-success' title='Add' data-role='qtip'  onclick='addinput($loop)'>Add</button>
										<button type='button' class='btn btn-sm btn-danger' title='Delete' data-role='qtip'  onclick='removeinput($loop)'>Del</button>
									</th>
											
									<th hidden>
										<input type='number' class='form-control' value='$dt_spk->qtycoil' readonly id='used_qtycoil_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][qtycoil]'>
									</th>
									<th hidden>
									   <input  type='number' class='form-control'  	 value='1' 	 id='used_qtyaktual_$loop' onkeyup='HitungTotalCoil($loop)' required name='dt[$loop][qtyaktual][]'>
									</th>
									<th>
									<input type='text' class='form-control dt_qtywidth autoNumeric'  	onblur='HitungTotalberat($loop)'	value='$dt_spk->qtysatuan' 	 id='used_qtywidth_$loop' required name='dt[$loop][qtywidth][]'>
									<input type='hidden' class='form-control'   		value='$dt_spk->id_dt_spkproduksi' id='id_dt_spkproduksi_$loop' required name='dt[$loop][id_dt_spkproduksi][]'>
									<input type='hidden' class='form-control dt_width autoNumeric'  		value='$dt_spk->totalaktual' 	 id='used_totalaktual_$loop' required name='dt[$loop][totalaktual][]' readonly>
									</th>
									<th>
									<input type='text' class='form-control datepicker' readonly   		value='$dt_spk->delivery' 		readonly id='used_delivery_$loop' required name='dt[$loop][delivery][]'>
									</th>
									
								</tr>";
			}
			?>
			</tbody>
			<tfoot>
			
			
			<tr>
            <th width='3%'></th>
            <th></th>
            <th width='15%'>Actual width produksi </th>
            <th align='right' width='7%'><input type='text' class='form-control Number' id='widthproduksi'  value=<?= $tr_spk->widthproduksi?> required name='widthproduksi'  readonly></th>
            <th width='7%'></th>
           <th width='15%'>Actual Weight produksi </th>
			<th width='7%'><input type='text' class='form-control Number' id='weightproduksi'  required name='weightproduksi' value=<?= $tr_spk->weightproduksi?>  readonly></th>
			<th width='10%'></th>
            </tr>
			
			<tr>
            <th width='3%'></th>
            <th></th>
            <th width='15%'>Actual width Mother Coil </th>
            <th align='right' width='7%'><input type='text' class='form-control Number' id='widthmothercoil' value=<?= $tr_spk->widthmothercoil?> name='widthmothercoil'  readonly></th>
            <th width='7%'></th>
           <th width='15%'>Actual Weight Proses </th>
			<th width='7%'><input type='text' class='form-control Number' id='weightproses' value=<?= $tr_spk->weightproses?> required name='weightproses'  readonly></th>
			<th width='10%'></th>
            </tr>
			
			<tr>
            <th width='3%'></th>
            <th></th>
            <th width='15%'>Actual width sisa </th>
            <th align='right' width='7%'><input type='text' align='right' class='form-control' id='widthsisa' value=<?= $tr_spk->widthsisa?> name='widthsisa'  readonly></th>
            <th width='7%'></th>
           <th width='15%'>Actual Weight sisa </th>
			<th width='7%'><input type='text' class='form-control Number' id='weightsisa' value=<?= $tr_spk->weightsisa?> required name='weightsisa'  readonly></th>
			<th width='10%'></th>
            </tr>
			
			
			</tfoot>
			
			</table>
			</div>
			</div>
			</div>
			
			
			<div class="form-group row" >
		<div class="col-sm-12">
			<label>Summary</label>
			<table class='table table-bordered table-striped' width='50%'>
	
        <tr class='bg-blue'>
            <td width='7%'>No</td>
            <td width='15%'>Nama Material</td>
            <td width='15%'>Berat aktual</td>
           
         </tr>
		 <tr>
            <td width='7%'>1.</td>
            <td width='15%'>Packing list </td>
            <td width='15%'>
			<input type='number' class='form-control' value=<?= $tr_spk->bpackinglist?>  id='bpackinglist' onkeyup required name='bpackinglist' readonly >
			</td>
            
         </tr>
		 <tr>
            <td width='7%'>2.</td>
            <td width='15%'>Actual mother coil</td>
            <td width='15%'><input type='number' class='form-control' id='baktualmother' value=<?= $tr_spk->baktualmother?>   onkeyup required name='baktualmother' readonly  ></td>
            
        </tr>
	    <tr>
            <td width='7%'></td>
            <td width='15%'><b>NG Packing list</b></td>
            <td width='15%'><input type='text' class='form-control ng_packinglist' name='ng_packinglist'  value=<?= $tr_spk->ng_packinglist?> readonly></td>
            
        </tr>
		<tr>
            <td width='7%' colspan='3'></td>
                      
        </tr>
		
		<tr>
            <td width='7%'>1.</td>
            <td width='15%'>Actual Weight proses</td>
            <td width='15%'><input type='number' class='form-control' id='baktualweight_proses' value=<?= $tr_spk->baktualweight_proses?> onkeyup required name='baktualweight_proses' readonly ></td>
            
        </tr>
		<tr>
            <td width='7%'>2.</td>
            <td width='15%'>Sisa Mother Coil</td>
            <td width='15%'><input type='number' class='form-control' id='sisa_aktualweight_proses' value=<?= $tr_spk->sisa_aktualweight_proses?>  onkeyup required name='sisa_aktualweight_proses' readonly ></td>
            
        </tr>
	</table>
	</div>
	</div>
			
		
			
        <div class="form-group row" >
		<div class="col-sm-12">
			<label>C.Slitting</label>
			<table class='table table-bordered table-striped'>
	
        <tr class='bg-green'>
            <td width='7%'>No</td>
            <td width='15%'>Nama Material</td>
            <td width='15%'>Lebar aktual</td>
			<td width='15%'>Berat aktual</td>
           
         </tr>
		  <tr>
            <td width='7%'>1.</td>
            <td width='15%'>Finishgood</td>
            <td width='15%'><input type='number' class='form-control' id='lfinishgood' value=<?= number_format($tr_spk->lfinishgood,2)?> required name='lfinishgood' readonly ></td>
            <td width='15%'>
			<input type='number' class='form-control' value="0" id='bfinishgood' onkeyup required name='bfinishgood' value=<?= number_format($tr_spk->bfinishgood,2)?> readonly >
			</td>
            
         </tr>
		 <tr>
            <td width='7%'>2.</td>
            <td width='15%'>Sisa Potong (kembali ke warehouse)</td>
            <td width='15%'><input type='number' class='form-control' id='lsisa_aktual' value=<?= number_format($tr_spk->lsisa_aktual,2)?> onkeyup required name='lsisa_aktual'  ></td>
            <td width='15%'>
			<input type='number' class='form-control' value=<?= number_format($tr_spk->bsisa_aktual,2)?> id='bsisa_aktual' onkeyup required name='bsisa_aktual'  >
			</td>
            
         </tr>
		 <tr>
            <td width='7%'>3.</td>
            <td width='15%'>Scrap trimming + Scrap sisa</td>
            <td width='15%'><input type='number' class='form-control' id='lscrap_aktual' value=<?= number_format($tr_spk->lscrap_aktual,2)?>  onkeyup required name='lscrap_aktual'  ></td>
            <td width='15%'><input type='number' class='form-control' id='bscrap_aktual' value=<?= number_format($tr_spk->bscrap_aktual,2)?> onkeyup required name='bscrap_aktual'  ></td>
            
        </tr>
	    <tr>
            <td width='7%'>4.</td>
            <td width='15%'>NG Internal</td>
            <td width='15%'><input type='text' class='form-control autoNumeric' name='ngin_lebar[]' placeholder='Lebar' value=<?= number_format($tr_spk->lebar_ng_in,2)?> ></td>
            <td width='15%'><input type='text' class='form-control autoNumeric BeratAuto' name='ngin_berat[]' placeholder='Berat' value=<?= number_format($tr_spk->berat_ng_in,2)?> ></td>
            
        </tr>
		<tr>
            <td width='7%'>5.</td>
            <td width='15%'>NG Eksternal</td>
            <td width='15%'><input type='text' class='form-control autoNumeric' name='ngek_lebar[]' placeholder='Lebar'  value=<?= number_format($tr_spk->lebar_ng_ek,2)?>></td>
            <td width='15%'><input type='text' class='form-control autoNumeric BeratAuto' name='ngek_berat[]' placeholder='Berat' value=<?= number_format($tr_spk->berat_ng_ek,2)?> ></td>
            
        </tr>
		
		<tr>
            <td width='7%'></td>
            <td width='15%'><b>Total Weight Slitting</b></td>
            <td width='15%'></td>
            <td width='15%'><input type='text' class='form-control tweightslitting' name='tweightslitting'  id='tweightslitting' value=<?= number_format($tr_spk->tweightslitting,2)?> ></td>
            
        </tr>
	</table>
	</div>
	</div>
	
	<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="difference">LOST PENIMBANGAN</label>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="difference">Lost Penimbangan</label>
				</div>
				<div class="col-md-8" id="beda">
				<input type='number' class='form-control difference' id='difference' value=<?= number_format($tr_spk->difference,2)?> name='difference' readonly >
			</div>
			</div>
		</div>
		
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="differencepercent">Lost Penimbangan %</label>
				</div>
				<div class="col-md-8" id="bedapercent">
				<input type='number' class='form-control differencepercent' id='differencepercent' value=<?= number_format($tr_spk->differencepercent,2)?> name='differencepercent' readonly >
			</div>
			</div>
		</div>
		
		</div>
		
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="balance">BALANCE</label>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="balance">Balance</label>
				</div>
				<div class="col-md-8" id="selisih">
				<input type='number' class='form-control balance' id='balance' value=<?= number_format($tr_spk->balance,2)?> name='balance' readonly >
			</div>
			</div>
		</div>
		</div>
		
		
	
		
			
			
		
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="aktual"></label>
				</div>
				<div class="col-md-8" id="aktual">
				<input type='hidden' class='form-control aktual' id='aktual' value="0" name='aktual' readonly >
			</div>
			</div>
		</div>
		</div>		
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran"></label>
				</div>
				<div class="col-md-8" id="slot_pegangan">
				<input type='hidden' class='form-control' id='lpegangan' value="<?= $tr_spk->lpegangan ?>" onkeyup required name='lpegangan' readonly >
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran"></label>
				</div>
				<div class="col-md-8" id="slot_qcoil">
				<input type='hidden' class='form-control' id='qcoil' value="<?= $tr_spk->qcoil ?>" onkeyup required name='qcoil' readonly >
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12">
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran"></label>
				</div>
				<div class="col-md-8" id="slot_jpisau">
				<input type='hidden' class='form-control' id='jpisau' value="<?= $tr_spk->jpisau ?>" onkeyup required name='jpisau' readonly >
			</div>
			</div>
		</div>
		</div>
		<div class="col-sm-12" hidden>
		<div class="col-sm-6">
			<div class="form-group row">
				<div class="col-md-4">
					<label for="no_penawaran"></label>
				</div>
				<div class="col-md-8" id="slot_jpisau">
				<input type='hidden' class='form-control' id='terpakai' value="<?= $tr_spk->used ?>" onkeyup required name='terpakai' readonly >
			</div>
			</div>
		</div>
		</div>
		
			
				 </div>
			</div>
		</form>		  
	</div>
</div>	
	
<style>
	.select2 {
		width:100%!important;
	}
	.datepicker{
		cursor: pointer;
	}
</style>			  
				  
				  
<script type="text/javascript">
	//$('#input-kendaraan').hide();
	var base_url			= '<?php echo base_url(); ?>';
	var active_controller	= '<?php echo($this->uri->segment(1)); ?>';
	$(document).ready(function(){	
			var max_fields2      = 10; //maximum input boxes allowed
			var wrapper2         = $(".input_fields_wrap2"); //Fields wrapper
			var add_button2      = $(".add_field_button2"); //Add button ID	
			$('.select2').select2();
				$('.autoNumeric').autoNumeric();
				$('.datepicker').datepicker({
					dateFormat: 'yy-mm-dd',
					changeMonth:true,
					changeYear:true,
				});

	$('#simpan-com').click(function(e){
			e.preventDefault();
			var deskripsi	= $('#deskripsi').val();
			var image		= $('#image').val();
			var idtype		= $('#inventory_1').val();
			var date_production = $('#date_production').val();
			var lsisa_aktual = $('#lsisa_aktual').val();
			
			if (date_production == '') {
				swal({
					title: "Warning!",
					text: "Tanggal Produksi masih kosong!",
					type: "warning",
					timer: 3000
				});
				return false;
			}
			
			if (lsisa_aktual == '') {
				swal({
					title: "Warning!",
					text: "Lebar aktual masih kosong!",
					type: "warning",
					timer: 3000
				});
				return false;
			}
			
			var data, xhr;
			// if ($('#balance').val() != "0") {
			if (getNum($('#differencepercent').val()) > 0.5 ) {
            swal({
                title: "DIFFERENCE LEBIH DARI 0.5!",
                text: "SILAHKAN PERBAIKI DATA ANDA!",
                type: "warning",
                timer: 3000,
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: false
            });
            
			
			} else {
			swal({
				  title: "Are you sure?",
				  text: "You will not be able to process again this data!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, Process it!",
				  cancelButtonText: "No, cancel process!",
				  closeOnConfirm: true,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) {
						var formData 	=new FormData($('#data-form')[0]);
						var baseurl=siteurl+'spk_aktual/SaveEditHeader';
						$.ajax({
							url			: baseurl,
							type		: "POST",
							data		: formData,
							cache		: false,
							dataType	: 'json',
							processData	: false, 
							contentType	: false,				
							success		: function(data){								
								if(data.status == 1){											
									swal({
										  title	: "Save Success!",
										  text	: data.pesan,
										  type	: "success",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									window.location.href = base_url + active_controller;
								}else{
									
									if(data.status == 2){
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}
									
								}
							},
							error: function() {
								
								swal({
								  title				: "Error Message !",
								  text				: 'An Error Occured During Process. Please try again..',						
								  type				: "warning",								  
								  timer				: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						});
				  } else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				  }
			});
			
		}
		});
		
});
	function get_produk(){ 
        var id_stock=$("#id_stock").val();
		
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialName',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_material").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialWeight',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_weight").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialDensity',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_density").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialThickness',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_thickness").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialPanjang',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_panjang").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetSisaMaterial',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_sisa").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialWidth',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_width").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetMaterialHiden',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#hiden_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetPegangan',
            data:"id_stock="+id_stock,
            success:function(html){
               $("#slot_pegangan").html(html);
            }
        });
		
    }
	function GetSpk(){ 
		var jumlah	=$('#list_spk').find('tr').length;
		var id_stock=$("#id_stock").val();
		var thickness=$("#thickness").val();
		var nama_material=$("#nama_material").val();
		var id_material=$("#id_material").val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/GetSpk',
            data:"jumlah="+jumlah+"&id_stock="+id_stock+"&id_material="+id_material+"&thickness="+thickness+"&nama_material="+nama_material,
            success:function(html){
               $("#list_spk").append(html);
            }
        });
    }
	function CancelItem(id){
		var nmmaterial=$('#used_nmmaterial_'+id).val();
		var dtno_surat=$('#used_no_surat_'+id).val();
		var idcustomer=$('#used_idcustomer_'+id).val();
		var namacustomer=$('#used_namacustomer_'+id).val();
		var thickness=$('#used_thickness_'+id).val();
		var weight=$('#used_weight_'+id).val();
		var qtycoil=$('#used_qtycoil_'+id).val();
		var width=$('#used_width_'+id).val();
		var totalwidth=$('#used_totalwidth_'+id).val();
		var delivery=$('#used_delivery_'+id).val();
		var qcoil=$('#qcoil').val();
		var lpegangan=$('#lpegangan').val();
		var jpisau=$('#jpisau').val();
		var sisa=$('#sisa').val();
		var widthmother=$('#width').val();
		var used=$('#used').val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/MinusQtyCoil',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_qcoil").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/MinusJPisau',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_jpisau").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/MinusSisa',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_sisa").html(html);
            }
        });

		$('#list_spk #tr_'+id).remove();
    }
	function TambahItem(id){
		var nmmaterial=$('#used_nmmaterial_'+id).val();
		var dtno_surat=$('#used_no_surat_'+id).val();
		var idcustomer=$('#used_idcustomer_'+id).val();
		var namacustomer=$('#used_namacustomer_'+id).val();
		var thickness=$('#used_thickness_'+id).val();
		var weight=$('#used_weight_'+id).val();
		var qtycoil=$('#used_qtycoil_'+id).val();
		var width=$('#used_width_'+id).val();
		var totalwidth=$('#used_totalwidth_'+id).val();
		var delivery=$('#used_delivery_'+id).val();
		var id_material=$('#id_material').val();
		var qcoil=$('#qcoil').val();
		var lpegangan=$('#lpegangan').val();
		var jpisau=$('#jpisau').val();
		var sisa=$('#sisa').val();
		var widthmother=$('#width').val();
		var used=$('#used').val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariQtyCoil',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_qcoil").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CarijPisau',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_jpisau").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariSisa',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $("#slot_sisa").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/LockSpk',
            data:"id="+id+"&used="+used+"&widthmother="+widthmother+"&id_material="+id_material+"&namacustomer="+namacustomer+"&idcustomer="+idcustomer+"&dtno_surat="+dtno_surat+"&qcoil="+qcoil+"&lpegangan="+lpegangan+"&jpisau="+jpisau+"&sisa="+sisa+"&nmmaterial="+nmmaterial+"&thickness="+thickness+"&weight="+weight+"&qtycoil="+qtycoil+"&width="+width+"&totalwidth="+totalwidth+"&delivery="+delivery,
            success:function(html){
               $('#list_spk #tr_'+id).html(html);
            }
        });
    }

	function AksiDetail(id){
	    var hgdeal=$('#dp_hgdeal_'+id).val();
		var qty=$('#dp_qty_'+id).val();
		var weight=$('#dp_weight_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_marketing/totalw',
            data:"hgdeal="+hgdeal+"&qty="+qty+"&weight="+weight+"&id="+id,
            success:function(html){
               $('#total_weight_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_marketing/totalhg',
            data:"hgdeal="+hgdeal+"&qty="+qty+"&weight="+weight+"&id="+id,
            success:function(html){
               $('#total_harga_'+id).html(html);
            }
        });
	}
	function HitungTotalCoil(id){
	    var qtycoil=$('#used_qtycoil_'+id).val();
		var width=$('#used_width_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/HitungTotalWidth',
            data:"qtycoil="+qtycoil+"&width="+width+"&id="+id,
            success:function(html){
               $('#twidth_'+id).html(html);
            }
        });
	}
	
	function HitungTotalberat(id){
	    var qtycoil=$('#used_qtyaktual_'+id).val();
		var width=$('#used_qtywidth_'+id).val();
		
		var totalBerat = getNum(qtycoil) * getNum(width);
		
		$('#used_totalaktual_'+id).val(totalBerat);
		
		
		
		totalBalanced();
		
		
	}
	
	//SYAMSUDIN 01/03/2022
	
	function hitungNGpackinglist(){
		
	    var weight=$('#weight').val();
		var weightaktualpl=$('#weight_actualpl').val();
		
		var NGpl = getNum(weight) - getNum(weightaktualpl);
		var totalNgpl = NGpl;
		
		$('#bpackinglist').val(number_format(weight,2));
		$('#baktualmother').val(number_format(weightaktualpl,2));
		
		$('.ng_packinglist1').val(number_format(totalNgpl,2));
		$('.ng_packinglist').val(number_format(totalNgpl,2));
		//console.log(totalBerat);
		
		totalBalanced();
		
		
	}
	
	
	function hitungActualweightproses(){
		
	    var kg_sisa=$('#weight_actualpl').val();
		var kg_sisa_actual=$('#kg_sisa_actual').val();
		
		var weightProses = getNum(kg_sisa) - getNum(kg_sisa_actual);
		var totalWeightproses = weightProses;
		
		$('.actualweightproses').val(number_format(totalWeightproses,2));
		
		$('#baktualweight_proses').val(number_format(totalWeightproses,2));
		
		$('#sisa_aktualweight_proses').val(number_format(kg_sisa_actual,2));
		
		$('#weightproses').val(number_format(totalWeightproses,2));
		//console.log(totalBerat);
		
		totalBalanced();
		
		
	}
	
	//END SYAMSUDIN
	
	function Caristock(){
        var id_material=$("#id_material").val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/FindingStock',
            data:"id_material="+id_material,
            success:function(html){
               $("#lotnumbe_slot").html(html);
            }
        });

    }
	function CariDetail(id){
        var id_marketing=$('#used_no_surat_'+id).val();
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariIdCustomer',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#idcust_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariNamaCustomer',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#nmcust_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariW1material',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#weight_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariQrollmaterial',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#qtyproduk_'+id).html(html);
            }
        });
				$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariW2material',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#width_'+id).html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariTW2material',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#twidth_'+id).html(html);
            }
        });
				$.ajax({
            type:"GET",
            url:siteurl+'spk_produksi/CariDelivermaterial',
            data:"id_marketing="+id_marketing+"&id="+id,
            success:function(html){
               $('#delivery_'+id).html(html);
            }
        });	

    }
	function get_properties(){
        var id_produk=$("#id_produk").val();
		var lebar_coil=$("#lebar_coil").val();
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetThickness',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#thickness_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetDensity',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#density_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetSurface',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#surface_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetPotongan',
            data:"id_produk="+id_produk,
            success:function(html){
               $("#potongan_slot").html(html);
            }
        });
		$.ajax({
            type:"GET",
            url:siteurl+'penawaran_shearing/GetStock',
            data:"id_produk="+id_produk+"&lebar_coil="+lebar_coil,
            success:function(html){
               $("#stock_slot").html(html);
            }
        });

    }

	function HapusItem(id){
			$('#list_spk #tr_'+id).remove();
			
		}
		
	$(document).on('keyup', '.dt_width', function() {

		totalBalanced()
	   
	});
	$(document).on('blur', '#bsisa_aktual', function() {

		totalBalanced()
	   
	});
	$(document).on('blur', '#bscrap_aktual', function() {

		totalBalanced()
	   
	});

		$(document).on('keyup', '.BeratAuto', function() {
			totalBalanced()
		});

	function totalBalanced(){
		var material = $('.weight').val();
		var weightproses = $('#weightproses').val();
		
		// var width    = $('.dt_width').val();
		var sisa     = $('#bsisa_aktual').val();
		var scrap    = $('#bscrap_aktual').val();
		var SUMx = 0;
		$(".dt_width" ).each(function() {
			SUMx += Number($(this).val().split(",").join(""));
		});
		
		let SUM_ng = 0;
		$(".BeratAuto" ).each(function() {
			SUM_ng += Number($(this).val().split(",").join(""));
		});

		var totalDifference = getNum(material) - SUMx - getNum(sisa) - getNum(scrap) - SUM_ng;
		
		var differencePercent = getNum(totalDifference)/getNum(material);
		
		var totalBalance = getNum(material) - SUMx - getNum(sisa) - getNum(scrap) - SUM_ng - getNum(totalDifference);
		
		//console.log(differencePercent);
		
		var weightSisa = getNum(weightproses)-SUMx;
		
		
		
		
		$('.aktual').val(number_format(SUMx,2));
		$('#weightproduksi').val(number_format(SUMx,2));
		
		$('#bfinishgood').val(number_format(SUMx,2));
		
		$('.difference').val(number_format(totalDifference,2));
		$('.differencepercent').val(number_format(differencePercent,2));
		
		$('.balance').val(number_format(totalBalance,2));
		$('#weightsisa').val(number_format(weightSisa,2));
		
		
		var total = SUMx+getNum(sisa)+getNum(scrap)+SUM_ng;
		
		$('.tweightslitting').val(number_format(total,2));
	}
	
	function addinput(id){
		$(".datepicker").datepicker('destroy');

		// $(".clone_here1"+id).last().clone().appendTo(".clone_tr1"+id);
		$(".clone_here2"+id).last().clone().appendTo(".clone_tr2"+id);
		$(".clone_here3"+id).last().clone().appendTo(".clone_tr3"+id);
		$(".clone_here4"+id).last().clone().appendTo(".clone_tr4"+id);
		$(".clone_here5"+id).last().clone().appendTo(".clone_tr5"+id);
		$(".clone_here6"+id).last().clone().appendTo(".clone_tr6"+id);
		$(".clone_here7"+id).last().clone().appendTo(".clone_tr7"+id);
		$(".clone_here8"+id).last().clone().appendTo(".clone_tr8"+id);

		$(".datepicker").datepicker();
		totalBalanced();
		$('.autoNumeric').autoNumeric();
		
	}

	function removeinput(id){
		// $(".clone_here1"+id).last().remove();
		$(".clone_here2"+id).last().remove();
		$(".clone_here3"+id).last().remove();
		$(".clone_here4"+id).last().remove();
		$(".clone_here5"+id).last().remove();
		$(".clone_here6"+id).last().remove();
		$(".clone_here7"+id).last().remove();
		$(".clone_here8"+id).last().remove();
		totalBalanced();
	}
	
	function getNum(val) {
        if (isNaN(val) || val == '') {
            return 0;
        }
        return parseFloat(val);
    }

	function number_format (number, decimals, dec_point, thousands_sep) {
		// Strip all characters but numerical ones.
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}

	
	//CLONE
	$(document).on('click','.add_ngin', function(){
		var temp = "<div class='col-sm-12 ngINApp'>";
		 	temp += "			<div class='form-group row'>";
		 	temp += "				<div class='col-md-2'>";
		 	temp += "					<label></label>";
		 	temp += "				</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric' name='ngin_lebar[]' placeholder='Lebar'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric BeratAuto' name='ngin_berat[]' placeholder='Berat'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control ket' name='ngin_ket[]' placeholder='Keterangan'>";
			temp += "		</div>";
		 	temp += "		<div class='col-md-3'>";
		 	temp += "			<input type='file' class='form-control file' name='ngin_upload[]' placeholder='Upload'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-1'>";
		 	// temp += "			<button type='button' class='btn btn-sm btn-success add_ngin'><i class='fa fa-plus'></i></button>";
		 	temp += "			<button type='button' class='btn btn-sm btn-danger deletex'=''><i class='fa fa-trash'></i></button>";
			temp += "		</div>";
			temp += "	</div>";
		 	temp += "</div>";

		$(this).parent().parent().parent().after(temp);
		$('.autoNumeric').autoNumeric();
	});

	$(document).on('click','.add_ngek', function(){
		var temp = "<div class='col-sm-12 ngEKApp'>";
		 	temp += "			<div class='form-group row'>";
		 	temp += "				<div class='col-md-2'>";
		 	temp += "					<label></label>";
		 	temp += "				</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric' name='ngek_lebar[]' placeholder='Lebar'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control autoNumeric BeratAuto' name='ngek_berat[]' placeholder='Berat'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-2'>";
		 	temp += "			<input type='text' class='form-control ket' name='ngek_ket[]' placeholder='Keterangan'>";
			temp += "		</div>";
		 	temp += "		<div class='col-md-3'>";
		 	temp += "			<input type='file' class='form-control file' name='ngek_upload[]' placeholder='Upload'>";
		 	temp += "		</div>";
		 	temp += "		<div class='col-md-1'>";
		 	// temp += "			<button type='button' class='btn btn-sm btn-success add_ngek'><i class='fa fa-plus'></i></button>";
		 	temp += "			<button type='button' class='btn btn-sm btn-danger deletex'=''><i class='fa fa-trash'></i></button>";
			temp += "		</div>";
			temp += "	</div>";
		 	temp += "</div>";

		$(this).parent().parent().parent().after(temp);
		$('.autoNumeric').autoNumeric();
	});

	$(document).on('click','.deletex', function(){
		$(this).parent().parent().parent().remove();
	});
	
	
	//SYAMSUDIN
	$(document).on('click', '.plus', function() {
		var no = $(this).data('id');
		// var kolom	= parseFloat($(this).parent().parent().find("td:nth-child(1)").attr('rowspan')) + 1;
		var kolom = parseFloat($(".baris_1").find("td:nth-child(1)").attr('rowspan')) + 1;

		
        
		var urut = $(this).data('urut');
		var actionPlan = $('#action_plan' + urut).val();
		
		//console.log(urut);
		var nourut = parseInt(urut)+1;
		
		//console.log(nourut);
		
		// $(this).parent().parent().find("td:nth-child(1)").attr('rowspan', kolom);
		$(".baris_1").find("td:nth-child(1)").attr('rowspan', kolom);

		var Rows = "<tr>";
		Rows += "<td><textarea name='detail[" + no + "][detail][" + kolom + "][action_plan]' id='action_plan" + nourut + "' class='form-control input-md action_plan' placeholder='Action Plan' rows='3'>" + actionPlan + "</textarea>";
		Rows += "<input type='file' name='file_pendukung[]' class='form-control input-md' style='margin-top:5px;' accept='application/pdf, image/*'></td>";
		Rows += "<td>";
		Rows += "	<select name='detail[" + no + "][detail][" + kolom + "][pic]' class='form-control input-md pic select2'>";
		Rows += "		<option value='0'>Pilih PIC</option><?= $results['users'] ?>";
		Rows += "	</select>";
		Rows += "</td>";
		Rows += "<td><input type='text' name='detail[" + no + "][detail][" + kolom + "][due_date]' class='form-control text-center input-md tanggal due_date' readonly placeholder='Due Date'></td>";
		Rows += "<td>";
		Rows += "	<select name='detail[" + no + "][detail][" + kolom + "][approval]' class='form-control input-md approval select2'>";
		Rows += "		<option value='0'>Pilih Approval</option><?= $results['users'] ?>";
		Rows += "	</select>";
		Rows += "</td>";
		Rows += "<td align='left'>";
		Rows += "<button type='button' class='btn btn-md btn-success plus' data-id='1' data-urut='" + nourut + "' title='Add Action Plan'><i class='fa fa-plus'></i></button>";
		Rows += "<button type='button' class='btn btn-md btn-danger delete' style='margin-top:5px;' title='Delete' data-id='" + no + "'><i class='fa fa-trash'></i></button>";
		Rows += "</td>";
		Rows += "</tr>";
		// alert(Rows);
		$(this).parent().parent().after(Rows);
		$('.select2').select2();
		$('.tanggal').datepicker({
			format: 'dd-M-yyyy',
			startDate: '0',
			autoclose: true,
			todayHighlight: true
		});
	});
	
</script>