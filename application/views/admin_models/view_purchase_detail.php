<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><i class="fa fa-money" aria-hidden="true"></i>
	 	Rincian Pembelian 
	</h4>
</div>
<div class="modal-body">
	<div class="row">
 	 	<div class="box box-danger" id="print-section-1">
        	<div class="box-body">
        		 <div class="col-md-12">
		            <div class="pull pull-right margin">
		                <button onclick="printDiv('print-section-1')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
		            </div>
		        </div>
	         	<div class="col-md-12">
	         		<table class="table table-bordered table-striped">
	         			<tr>
	         				<td>No Invoice</td>
	         				<td><?php echo $single_purchase[0]->invoice_id; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Tanggal Pembelian</td>
	         				<td><?php echo $single_purchase[0]->date; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Supplier</td>
	         				<td>
	         				<?php 
	         					echo $this->db->get_where('mp_payee', array('id' =>$single_purchase[0]->supplier_id))->result_array()[0]['customer_name'] ; 
	         				?>	
	         				</td>
	         			</tr>
	         			<tr>
	         				<td>Total</td>
	         				<td><?php echo $single_purchase[0]->total_amount; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Jumlah Dibayar</td>
	         				<td><?php echo $single_purchase[0]->cash; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Sisa</td>
	         				<td><?php echo $single_purchase[0]->total_amount-$single_purchase[0]->cash; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Metode Pembayaran</td>
	         				<td><?php echo $single_purchase[0]->payment_type_id; ?></td>
	         			</tr>	
	         			<tr>
	         				<td>Tanggal pembayaran</td>
	         				<td><?php echo $single_purchase[0]->payment_date; ?></td>
	         			</tr>
	         			<tr>
	         				<td>Status</td>
	         				<td>
	         					<?php 
	         						if($single_purchase[0]->status == 0)
         							{
         								echo "Purchased";
         							}
         							else
         							{
         							 	echo "Purchased Return";	
         							} 
	         					?>	
	         				</td>
	         			</tr>
	         			<tr>
	         				<td>Toko</td>
	         				<td>
	         				<?php 
	         					echo $this->db->get_where('mp_stores', array('id' =>$single_purchase[0]->store))->result_array()[0]['name'] ; 
	         				?>	
	         				</td>
	         			</tr>
	         			<tr>
	         				<td>Keterangan</td>
	         				<td><?php echo $single_purchase[0]->description; ?></td>
	         			</tr>
	         		</table>			    		
	        	</div>
	        	<div class="col-md-12">
	        		<img style="width: 100%; height: auto;" src="<?php echo base_url('./uploads/purchase/'.$single_purchase[0]->cus_picture); ?>" name="" />
	        			
	        	</div>	        	
	        	<div class="col-md-12 text-center">
	        		<a href="<?php echo base_url('./uploads/purchase/'.$single_purchase[0]->cus_picture); ?>">Download Gambar</a>
	        	</div>	
     		</div>				  
		</div>
	</div>
</div>
<!-- Form Validation -->
<script src="<?php echo base_url(); ?>assets/dist/js/custom.js"></script>