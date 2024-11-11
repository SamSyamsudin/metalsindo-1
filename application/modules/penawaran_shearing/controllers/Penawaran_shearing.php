<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Ichsan
 * @copyright Copyright (c) 2019, Ichsan
 *
 * This is controller for Master Supplier
 */

class Penawaran_shearing extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Inventory_4.View';
    protected $addPermission  	= 'Inventory_4.Add';
    protected $managePermission = 'Inventory_4.Manage';
    protected $deletePermission = 'Inventory_4.Delete';

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('Penawaran_shearing/Inventory_4_model',
                                 'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');


    }
    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data = $this->Inventory_4_model->CariPenawaran();
        $this->template->set('results', $data);
        $this->template->title('Penawaran Slitting');
        $this->template->render('index');
    }

		public function addHeader()
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inventory_4_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Inventory_4_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Inventory_4_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
		];
        $this->template->set('results', $data);
        $this->template->title('Add Penawaran Slitting');
        $this->template->render('AddHeader');

    }
	public function PrintHeader1($id){
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Inventory_4_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Inventory_4_model->PrintDetail($id);
		$this->load->view('PrintHeader',$data);
	}
	public function PrintHeader($id){
		ob_clean();
		ob_start();
        $this->auth->restrict($this->managePermission);
        $id = $this->uri->segment(3);
		$data['header'] = $this->Inventory_4_model->getHeaderPenawaran($id);
		$data['detail']  = $this->Inventory_4_model->PrintDetail($id);
		$this->load->view('PrintHeader',$data);
		$html = ob_get_contents();

		require_once('./assets/html2pdf/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->WriteHTML($html);
		ob_end_clean();
		$html2pdf->Output('aaa.pdf', 'I');
	}
		public function EditHeader()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head = $this->Inventory_4_model->get_data('tr_penawaran_shearing','id_shearing',$id);
		$detail = $this->Inventory_4_model->get_data('dt_penawaran_shearing_used','id_shearing',$id);
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inventory_4_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Inventory_4_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Inventory_4_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'head' => $head,
			'detail' => $detail
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran Slitting');
        $this->template->render('EditHeader');

    }
	    public function detail()
    {
		$id = $this->uri->segment(3);
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
		$deleted = '0';
        $detail = $this->Inventory_4_model->getpenawaran($id);
		$header = $this->Inventory_4_model->getHeaderPenawaran($id);
		$data = [
			'detail' => $detail,
			'header' => $header
		];
        $this->template->set('results', $data);
        $this->template->title('Penawaran');
        $this->template->render('detail');
    }

		public function editPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Inventory_4_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Inventory_4_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('editPenawaran');

    }



			public function ViewHeader($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$aktif = 'active';
		$deleted = '0';
		$head = $this->Inventory_4_model->get_data('tr_penawaran_shearing','id_shearing',$id);
		$detail = $this->Inventory_4_model->get_data('dt_penawaran_shearing_used','id_shearing',$id);
		$aktif = 'active';
		$deleted = '0';
		$customers = $this->Inventory_4_model->get_data('master_customers','deleted',$deleted);
		$karyawan = $this->Inventory_4_model->get_data('ms_karyawan','deleted',$deleted);
		$mata_uang = $this->Inventory_4_model->get_data('mata_uang','deleted',$deleted);
		$data = [
			'customers' => $customers,
			'karyawan' => $karyawan,
			'mata_uang' => $mata_uang,
			'head' => $head,
			'detail' => $detail
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('ViewHeader');

    }

			public function viewPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$penawaran = $this->Inventory_4_model->get_data('child_penawaran','id_child_penawaran',$id);
		$inventory_3 = $this->Inventory_4_model->get_data_category();
		$data = [
			'penawaran' => $penawaran,
			'inventory_3' => $inventory_3,
		];
        $this->template->set('results', $data);
        $this->template->title('Edit Penawaran');
        $this->template->render('viewPenawaran');

    }
	public function copyInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('copy_inventory');

    }
	public function viewInventory($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$deleted = '0';
		$inven = $this->Inventory_4_model->getedit($id);
		$komposisiold = $this->Inventory_4_model->get_data('child_inven_compotition','id_category3',$id);
		$komposisi = $this->Inventory_4_model->kompos($id);
		$dimensiold = $this->Inventory_4_model->get_data('child_inven_dimensi','id_category3',$id);
		$dimensi = $this->Inventory_4_model->dimensy($id);
		$supl = $this->Inventory_4_model->supl($id);
		$inventory_1 = $this->Inventory_4_model->get_data('ms_inventory_type','deleted',$deleted);
		$inventory_2 = $this->Inventory_4_model->get_data('ms_inventory_category1','deleted',$deleted);
		$inventory_3 = $this->Inventory_4_model->get_data('ms_inventory_category2','deleted',$deleted);
		$maker = $this->Inventory_4_model->get_data('negara');
		$id_bentuk = $this->Inventory_4_model->get_data('ms_bentuk');
		$id_supplier = $this->Inventory_4_model->get_data('master_supplier');
		$id_surface = $this->Inventory_4_model->get_data('ms_surface');
		$dt_suplier = $this->Inventory_4_model->get_data('child_inven_suplier','id_category3',$id);
		$data = [
			'inventory_1' => $inventory_1,
			'inventory_2' => $inventory_2,
			'inventory_3' => $inventory_3,
			'komposisi' => $komposisi,
			'dimensi' => $dimensi,
			'id_bentuk' => $id_bentuk,
			'inven' => $inven,
			'maker' => $maker,
			'supl' => $supl,
			'id_surface' => $id_surface,
			'id_supplier' => $id_supplier,
			'dt_suplier' => $dt_suplier
		];
        $this->template->set('results', $data);
        $this->template->title('Add Inventory');
        $this->template->render('view_inventory');

    }
	public function viewBentuk($id){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$bentuk = $this->db->get_where('ms_bentuk',array('id_bentuk' => $id))->result();
		$dimensi = $this->Bentuk_model->getDimensi($id);
		$data = [
			'bentuk' => $bentuk,
			'dimensi' => $dimensi,
		];
        $this->template->set('results', $data);
		$this->template->render('view_bentuk');
	}


	public function addPenawaran($id)
    {
		$this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-pencil');
		$headpenawaran = $this->Inventory_4_model->get_data('tr_penawaran','no_penawaran',$id);
		$inventory_3 = $this->Inventory_4_model->get_data_category();
		$data = [
			'inventory_3' => $inventory_3,
			'headpenawaran' => $headpenawaran
		];
        $this->template->set('results', $data);
        $this->template->title('Add Penawaran');
        $this->template->render('AddPenawaran');

    }


function cari_pricelist()
    {
        $id_category3=$_GET['id_category3'];
		$mata_uang=$_GET['mata_uang'];
		$kurs	= $this->db->query("SELECT * FROM mata_uang WHERE kode = '$mata_uang' ")->result();
		$mu = $kurs[0]->kurs;
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$inven1 = $kategory3[0]->id_category1;
		if($inven1 == "I2000001"){
			$plquery	= $this->db->query("SELECT * FROM ms_pricelistfr WHERE id_category3 = '$id_category3' ")->result();
			if(empty($plquery)){
				echo "<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
					</tr>
					<tr>
						<td><center>
						Price List Untuk Material Ini Belum Terinput
						</center></td>
					</tr>
					</table>
					</div>
					</div>";
			}else{
		$bottom_price = $plquery[0]->bottom_price;
			echo "	<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
					</tr>
					<tr>
						<td><center>Rp. $bottom_price  ,-</center></td>
					</tr>
					</table>
					</div>
					</div>
					";};
		} elseif ($inven1 == "I2000002") {

			$plquery	= $this->db->query("SELECT * FROM ms_pricelistnfr WHERE id_category3 = '$id_category3' ")->result();
			if(empty($plquery)){
				echo "<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
						<th><center>LME 10 Hari</center></th>
						<th><center>LME 30 Hari</center></th>
						<th><center>LME SPOT</center></th>
					</tr>
					<tr>
						<td colspan='4'><center>
						Price List Untuk Material Ini Belum Terinput
						</center></td>
					</tr>
					</table>
					</div>
					</div>";
			}else{
		$bottom_price = number_format($plquery[0]->bottom_price*$mu,2);
		$bottom_price10 = number_format($plquery[0]->bottom_price10*$mu,2);
		$bottom_price30 = number_format($plquery[0]->bottom_price30*$mu,2);
		$bottom_pricespot = number_format($plquery[0]->bottom_pricespot*$mu,2);
			echo "	<div class='col-sm-12' align='center'>
					<label  for='forecast'>PRICELIST</label>
					</div>
					<div class='col-sm-12' align='center'>
					<div class='form-group row'>
					<table class='col-sm-12'>
					<tr>
						<th><center>Book Price<c/enter></th>
						<th><center>LME 10 Hari</center></th>
						<th><center>LME 30 Hari</center></th>
						<th><center>LME SPOT</center></th>
					</tr>
					<tr>
						<td><center>Rp. $bottom_price  ,-</center></td>
						<td><center>Rp. $bottom_price10  ,-</center></td>
						<td><center>Rp. $bottom_price30  ,-</center></td>
						<td><center>Rp. $bottom_pricespot  ,-</center></td>
					</tr>
					</table>
					</div>
					</div>
					";};
		};

	}
function cari_bentuk()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$id_bentuk = $kategory3[0]->id_bentuk;
		$bentukquery	= $this->db->query("SELECT * FROM ms_bentuk WHERE id_bentuk = '$id_bentuk' ")->result();
		$bentuk_material = $bentukquery[0]->nm_bentuk;
		echo "<div class='col-md-4'>
				<label for='customer'>Bentuk</label>
			  </div>
			  <div class='col-md-8'>
				<input type='text' class='form-control' readonly value='$bentuk_material' id='bentuk_material'  required name='bentuk_material' placeholder='Bentuk Material'>
			  </div>
			  <div class='col-md-8' hidden>
				<input type='text' class='form-control' readonly value='$id_bentuk' id='id_bentuk'  required name='id_bentuk' placeholder='Bentuk Material'>
			  </div>";
	}
function GetProduk()
    {
        $id_customer=$_GET['id_customer'];
		$dt1	= $this->db->query("SELECT * FROM tr_inquiry WHERE id_customer = '$id_customer' ")->result();
		$id_crcl = $dt1[0]->no_inquiry;
		$link = base_url('/transaksi_inquiry/');
		if(!empty($dt1)){
		$material = $this->Inventory_4_model->CariMaterial($id_crcl);
		echo "<select id='id_produk' name='id_produk' class='form-control select' onchange='get_properties()'  required>
						<option value=''>--Pilih Material--</option>";
				foreach($material as $material){
					echo"<option value='$material->id_dt_inquery'>$material->nama2-$material->nama3-$material->hardness</option>";
				}
		echo "</select>";}else{
			echo"<a class='btn btn-danger btn-sm' href='$link' title='CRCL'></i>CRCL Cusromer Ini Belum Dibuat Klik DIsini Untuk Membuat CRCL</i></a>";
		};
	}
function GetMaterial()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->id_category3;
		$nm	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_crcl' ")->result();
		$nama = $nm[0]->nama;
		echo "<input type='text' class='form-control' value='$nama' readonly id='material' required name='material'>";
	}
function GetThickness()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->thickness;
		echo "<input type='text' class='form-control' value='$id_crcl' readonly id='thickness' required name='thickness'>";
	}
function GetDensity()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$density = $dt1[0]->density;
		echo "<input type='text' class='form-control' value='$density' readonly id='density' required name='density'>";
	}
function GetSurface()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->id_category3;
		$nm	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_crcl' ")->result();
		$nama = $nm[0]->id_surface;
		$id_surface	= $this->db->query("SELECT * FROM ms_surface WHERE id_surface = '$nama' ")->result();
		$isi_surface = $id_surface[0]->nm_surface;
		echo "<input type='text' class='form-control' value='$isi_surface' readonly id='surface' required name='surface'>";
	}
function HitungPisau()
    {
        $qty=$_GET['qty'];
		$id=$_GET['id'];
		$quantity = $qty+1;
		$pisau=$quantity*2;
		echo "<input type='text' class='form-control' readonly value='$pisau' id='stok_jmlpisau_$id' required name='stok[$id][jmlpisau]'>";
	}
function GetPotongan()
    {
        $id_produk=$_GET['id_produk'];
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->thickness;
		if($id_crcl > 0.2){
			$potongan='1';
		}else{
			$potongan='2';
		};
		echo "<input type='text' class='form-control' value='$potongan' readonly id='potongan_pinggir' required name='potongan_pinggir'>";
	}
function HitungWProses()
    {
        $hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish =$hasil*$fspeed;
		echo "<input type='number' class='form-control' value='$finish' id='wproses' readonly required name='wproses' >";
	}
function HitungTPanjang()
    {
        $hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil = $total_panjang+$hasilpanjang;
		echo "<input type='number' class='form-control' value='$hasil' id='total_panjang' readonly required name='total_panjang' >";
	}
function HitungJPisau()
    {
        $jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$hasil = $jml_pisau+$jumlahpisau;
		echo "<input type='number' class='form-control' value='$hasil' id='jml_pisau' readonly required name='jml_pisau' >";
	}
function HitungSTPisau()
    {
        $jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu = '3';
		$hasil = $jml_pisau+$jumlahpisau;
		$finish=$hasil*$waktu;
		echo "<input type='number' class='form-control' value='$finish' id='spisau' readonly required name='spisau' >";
	}
function HitungJMother()
    {
        $jml_mother=$_GET['jml_mother'];
		$hasil = $jml_mother+1;
		echo "<input type='number' class='form-control' value='$hasil' id='jml_mother' readonly required name='jml_mother' >";
	}
function HitungGcoil()
    {
        $jml_mother=$_GET['jml_mother'];
		$waktu = '21';
		$hasil = $jml_mother+1;
		$finish = $waktu*$hasil;
		echo "<input type='number' class='form-control' value='$finish' id='gcoil' readonly required name='gcoil' >";
	}
function HitungTWProses()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$last= $finish1+$finish2+finish3;
		echo "<input type='number' class='form-control' value='$last' id='twproses' readonly required name='twproses' >";
	}
	function HitungHandling()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		echo "<input type='number' class='form-control' value='$handling' id='handling' readonly required name='handling' >";
	}
	function HitungTWaktu()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		echo "<input type='number' class='form-control' value='$done' id='twaktu' readonly required name='twaktu' >";
	}
		function HitungBProses()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		echo "<input type='number' class='form-control' value='$bproses' id='bproses' readonly required name='bproses' >";
	}
			function HitungProfit()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		echo "<input type='number' class='form-control' value='$profit' id='profit' readonly required name='profit' >";
	}
	function HitungHtotal()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		$htotal=$profit+$bproses;
		echo "<input type='number' class='form-control' value='$htotal' id='ttlhgpenawaran' readonly required name='ttlhgpenawaran' >";
	}
	function HitungHRp()
    {
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		$htotal=$profit+$bproses;
		$hrp=$htotal/$done;
		echo "<input type='number' class='form-control' value='$hrp' id='hgpkgrp' readonly required name='hgpkgrp' >";
	}
		function HitungHdl()
    {
		$carikurs = $this->db->query("SELECT * FROM mata_uang WHERE kode='IDR' ")->result();
		$nilai_kurs = $carikurs[0]->kurs;
		$hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$hasil1 = $total_panjang+$hasilpanjang;
		$fspeed = '31,5';
		$finish1 =$hasil1*$fspeed;
		$jml_pisau=$_GET['jml_pisau'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$waktu1 = '3';
		$hasil2 = $jml_pisau+$jumlahpisau;
		$finish2=$hasil2*$waktu1;
        $jml_mother=$_GET['jml_mother'];
		$waktu2 = '21';
		$hasil3 = $jml_mother+1;
		$finish3 = $waktu2*$hasil3;
		$persen = 60/100;
		$last= $finish1+$finish2+finish3;
		$handling = $last*$persen;
		$done = $handling+$last;
		$rman = '2601';
		$relectrical='674';
		$rkmain='434';
		$tkinv='181';
		$jrate=$rman+$relectrical+$rkmain+$tkinv;
		$bproses=$jrate*$done ;
		$pestenprofit=15/100;
		$profit=$bproses*$pestenprofit;
		$htotal=$profit+$bproses;
		$hrp=$htotal/$done;
		$hdolat=number_format($hrp/$nilai_kurs,2);
		echo "<input type='number' class='form-control' value='$hdolat' id='hgpkgdl' readonly required name='hgpkgdl' >";
	}
function HitungTBerat()
    {
         $hasilpanjang=$_GET['hasilpanjang'];
		$total_panjang=$_GET['total_panjang'];
		$thickness=$_GET['thickness'];
		$lebarcc=$_GET['lebarcc'];
		$density=$_GET['density'];
		$hpanjang = $total_panjang+$hasilpanjang;
		$hasil= $hpanjang*$density*$lebarcc*$thickness;
		echo "<input type='number' value='$hasil' class='form-control' id='total_berat' readonly required name='total_berat' >";
	}
function GetStock()
    {
        $id_produk=$_GET['id_produk'];
		if(!empty($_GET['lebar_coil'])){
			$lebar_coil=$_GET['lebar_coil'];
			}else{
			$lebar_coil= '1';
			};
		$dt	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$thickness = $dt[0]->thickness;
		if($thickness > 0.2){
			$potongan='1';
		}else{
			$potongan='2';
		};
		$ppinggir=$potongan^2;
		$dt1	= $this->db->query("SELECT * FROM dt_inquery_transaksi WHERE id_dt_inquery = '$id_produk' ")->result();
		$id_crcl = $dt1[0]->id_category3;
		$nm	= $this->Inventory_4_model->caristok($id_crcl);
		$loop=0;
		foreach( $nm as $nama){
			$loop++;
			$panjangmaterial = $nama->width*$nama->density*$thickness;
			$hasilpanjang = number_format($nama->totalweight/$panjangmaterial,2) ;
			$firstcount = $nama->width*$ppinggir;
			$jcc = $firstcount/$lebar_coil;
			$lastcount = $lebar_coil*$jcc;
			$sp= number_format($firstcount-$lastcount,2);
		echo "
		<tr id='tabel_stok_$loop'>
			<th hidden><input type='text' class='form-control' value='$nama->id_stock' readonly id='stok_idstk_$loop' required name='stok[$loop][idstk]'></th>
			<th><input type='text' class='form-control' value='$nama->lotno' readonly id='stok_lotno_$loop' required name='stok[$loop][lotno]'></th>
			<th><input type='text' class='form-control' value='$nama->nama_material' readonly id='stok_namamaterial_$loop' required name='stok[$loop][namamaterial]'></th>
			<th><input type='text' class='form-control' value='$nama->weight' readonly id='stok_weight_$loop' required name='stok[$loop][weight]'></th>
			<th><input type='text' class='form-control' value='$nama->density' readonly id='stok_density_$loop' required name='stok[$loop][density]'></th>
			<th><input type='text' class='form-control' value='$hasilpanjang' readonly id='stok_hasilpanjang_$loop' required name='stok[$loop][hasilpanjang]'></th>
			<th><input type='text' class='form-control' value='$nama->width' readonly id='stok_width_$loop' required name='stok[$loop][width]'></th>
			<th><input type='text' class='form-control' value='$lebar_coil' readonly id='stok_lebarcc_$loop' required name='stok[$loop][lebarcc]'></th>
			<th><input type='text' class='form-control' value='$jcc' readonly id='stok_jumlahcc_$loop' required name='stok[$loop][jumlahcc]'></th>
			<th><input type='text' class='form-control' value='$sp' readonly id='stok_sisapotongan_$loop' required name='stok[$loop][sisapotongan]'></th>
			<th><input type='text' class='form-control'   id='stok_qty_$loop' data-role='qtip' onkeyup='return HitungPisau($loop);' required name='stok[$loop][qty]'></th>
			<th id='pisau_$loop'><input type='text' class='form-control' readonly  id='stok_jmlpisau_$loop' required name='stok[$loop][jmlpisau]'></th>
			<th><button type='button' class='btn btn-sm btn-success' title='Ambil' id='tambah_$loop' data-role='qtip' onClick='return TambahItem($loop);'><i class='fa fa-plus-square'></i></button></th>
		</tr>
		";
		};
	}
function GetUsed()
    {
        $idstk=$_GET['idstk'];
		$lotno=$_GET['lotno'];
		$namamaterial=$_GET['namamaterial'];
		$weight=$_GET['weight'];
		$density=$_GET['density'];
		$hasilpanjang=$_GET['hasilpanjang'];
		$width=$_GET['width'];
		$lebarcc=$_GET['lebarcc'];
		$jumlahcc=$_GET['jumlahcc'];
		$sisapotongan=$_GET['sisapotongan'];
		$qtystock=$_GET['qtystock'];
		$jumlahpisau=$_GET['jumlahpisau'];
		$loop=$_GET['jumlah']+1;
		echo "
		<tr id='tabel_stok_$loop'>
			<th hidden><input type='text' class='form-control' value='$idstk' readonly id='used_idstk_$loop' required name='used[$loop][idstk]'></th>
			<th><input type='text' class='form-control' value='$lotno' readonly id='used_lotno_$loop' required name='used[$loop][lotno]'></th>
			<th><input type='text' class='form-control' value='$namamaterial' readonly id='used_namamaterial_$loop' required name='used[$loop][namamaterial]'></th>
			<th><input type='text' class='form-control' value='$weight' readonly id='used_weight_$loop' required name='used[$loop][weight]'></th>
			<th><input type='text' class='form-control' value='$density' readonly id='used_density_$loop' required name='used[$loop][density]'></th>
			<th><input type='text' class='form-control' value='$hasilpanjang' readonly id='used_hasilpanjang_$loop' required name='used[$loop][hasilpanjang]'></th>
			<th><input type='text' class='form-control' value='$width' readonly id='used_width_$loop' required name='used[$loop][width]'></th>
			<th><input type='text' class='form-control' value='$lebarcc' readonly id='used_lebarcc_$loop' required name='used[$loop][lebarcc]'></th>
			<th><input type='text' class='form-control' value='$jumlahcc' readonly id='used_jumlahcc_$loop' required name='used[$loop][jumlahcc]'></th>
			<th><input type='text' class='form-control' value='$sisapotongan' readonly id='used_sisapotongan_$loop' required name='used[$loop][sisapotongan]'></th>
			<th><input type='text' class='form-control' value='$qtystock'  readonly id='used_qty_$loop' required name='used[$loop][qty]'></th>
			<th><input type='text' class='form-control' value='$jumlahpisau' readonly  id='used_jmlpisau_$loop' required name='used[$loop][jmlpisau]'></th>
		</tr>
		";
	}
function getsales()
    {
        $id_customer=$_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM master_customers WHERE id_customer = '$id_customer' ")->result();
		$id_karyawan = $kategory3[0]->id_karyawan;
		$karyawan	= $this->db->query("SELECT * FROM ms_karyawan WHERE id_karyawan = '$id_karyawan' ")->result();
		$nama_karyawan = $karyawan[0]->nama_karyawan;
		echo "	<div class='col-md-8' hidden>
					<input type='text' class='form-control' id='nama_sales' value='$id_karyawan' required name='nama_sales' readonly placeholder='Sales Marketing'>
				</div>
				<div class='col-md-8'>
					<input type='text' class='form-control' id='id_sales' value='$nama_karyawan'  required name='id_sales' readonly placeholder='Sales Marketing'>
				</div>";
	}
function getpic()
    {
        $id_customer=$_GET['id_customer'];
		$kategory3	= $this->db->query("SELECT * FROM child_customer_pic WHERE id_customer = '$id_customer' ")->result();
		echo "<select id='pic_customer' name='pic_customer' class='form-control select' required>
				<option value=''>--Pilih--</option>";
				foreach($kategory3 as $pic){
		echo "<option value='$pic->name_pic'>$pic->name_pic</option>";
				}
		echo "</select>";
	}

function cari_thickness()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM child_inven_dimensi WHERE id_category3 = '$id_category3' ")->result();
		$thickness = $kategory3[0]->nilai_dimensi;
		echo "<input type='text' class='form-control' readonly id='thickness' value='$thickness' required name='thickness' placeholder='Bentuk Material'>";
	}
function cari_density()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$density = $kategory3[0]->density;
		echo "<input type='text' class='form-control' readonly id='density' value='$density' required name='density' placeholder='Bentuk Material'>";
	}
function hitung_komisi()
    {
        $bottom=$_GET['bottom'];
		$komisi=$_GET['bottom']*$_GET['komisi']/100;
		$hasil=$bottom+$komisi;
		echo "<input type='text' class='form-control' value='$hasil' id='harga_penawaran'  required name='harga_penawaran' placeholder='Bentuk Material'>";
	}
function cari_inven1()
    {
        $id_category3=$_GET['id_category3'];
		$kategory3	= $this->db->query("SELECT * FROM ms_inventory_category3 WHERE id_category3 = '$id_category3' ")->result();
		$inven1 = $kategory3[0]->id_category1;
		echo "<input type='text' class='form-control' id='inven1' value='$inven1'  required name='inven1' placeholder='Bentuk Material'>";
	}
	public function delDetail(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		// print_r($id);
		// exit();
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];

		$this->db->trans_begin();
		$this->db->where('id_dimensi',$id)->update("ms_dimensi",$data);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);
		}

  		echo json_encode($status);
	}

	public function deleteInventory(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$data = [
			'deleted' 		=> '1',
			'deleted_by' 	=> $this->auth->user_id()
		];

		$this->db->trans_begin();
		$this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);
		}

  		echo json_encode($status);
	}
		function get_inven2()
    {
        $inventory_1=$_GET['inventory_1'];
        $data=$this->Inventory_4_model->level_2($inventory_1);
        echo "<select id='inventory_2' name='hd1[1][inventory_2]' class='form-control onchange='get_inv3()'  input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category1' set_select('inventory_2', $st->id_category1, isset($data->id_category1) && $data->id_category1 == $st->id_category1)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }
		function get_inven3()
    {
        $inventory_2=$_GET['inventory_2'];
        $data=$this->Inventory_4_model->level_3($inventory_2);

        // print_r($data);
        // exit();
        echo "<select id='inventory_3' name='hd1[1][inventory_3]' class='form-control input-sm select2'>";
        echo "<option value=''>--Pilih--</option>";
                foreach ($data as $key => $st) :
				      echo "<option value='$st->id_category2' set_select('inventory_3', $st->id_category2, isset($data->id_category2) && $data->id_category2 == $st->id_category2)>$st->nama
                    </option>";
                endforeach;
        echo "</select>";
    }
		public function saveNewPenawaran()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$this->db->trans_begin();
		$code = $post['no_penawaran'];
		$data = [
							'id_child_penawaran'	=> $code,
							'id_category3'			=> $post['id_category3'],
							'no_penawaran'			=> $post['no_penawaran'],
							'bentuk_material'		=> $post['bentuk_material'],
							'id_bentuk'				=> $post['id_bentuk'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'lotno'					=> $post['lotno'],
							'width'					=> $post['width'],
							'forecast'				=> $post['forecast'],
							'inven1'				=> $post['inven1'],
							'bottom'				=> $post['bottom'],
							'dasar_harga'			=> $post['dasar_harga'],
							'komisi'				=> $post['komisi'],
							'keterangan'			=> $post['keterangan'],
							'harga_penawaran'		=> $post['harga_penawaran'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('child_penawaran',$data);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }


	public function SaveNewHeader()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Inventory_4_model->generate_code();
		$no_surat = $this->Inventory_4_model->BuatNomor();
		$this->db->trans_begin();
		$data = [
							'id_shearing'			=> $code,
							'no_surat'				=> $no_surat,
							'tgl_penawaran'			=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'id_produk'				=> $post['id_produk'],
							'material'				=> $post['material'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'surface'				=> $post['surface'],
							'lebar_coil'			=> $post['lebar_coil'],
							'qty'					=> $post['qty'],
							'mata_uang'				=> $post['mata_uang'],
							'potongan_pinggir'		=> $post['potongan_pinggir'],
							'total_panjang'			=> $post['total_panjang'],
							'jml_pisau'				=> $post['jml_pisau'],
							'jml_mother'			=> $post['jml_mother'],
							'total_berat'			=> $post['total_berat'],
							'wproses'			=> $post['wproses'],
							'spisau'			=> $post['spisau'],
							'gcoil'			=> $post['gcoil'],
							'twproses'			=> $post['twproses'],
							'handling'			=> $post['handling'],
							'twaktu'			=> $post['twaktu'],
							'bproses'			=> $post['bproses'],
							'ttlhgpenawaran'			=> $post['ttlhgpenawaran'],
							'hgpkgrp'			=> $post['hgpkgrp'],
							'hgpkgdl'			=> $post['hgpkgdl'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->insert('tr_penawaran_shearing',$data);
		$numb1 =0;
		foreach($_POST['used'] as $use){
		$numb1++;        
                $stokpakai =  array(
							'id_shearing'		    	=> $code,
							'id_used_syock_penawaran'	=> $code.'-'.$numb1,
							'idstk'		    			=> $use[idstk],
							'lotno'		        		=> $use[lotno],
							'namamaterial'		        => $use[namamaterial],
							'weight'		        	=> $use[weight],
							'density'		        	=> $use[density],
							'hasilpanjang'		        => $use[hasilpanjang],
							'width'		    			=> $use[width],
							'lebarcc'					=> $use[lebarcc],
							'jumlahcc'		    		=> $use[jumlahcc],
							'sisapotongan'		    	=> $use[sisapotongan],
							'qty'		    			=> $use[qty],
							'jmlpisau'		    		=> $use[jmlpisau]
                            );
                    $this->db->insert('dt_penawaran_shearing_used',$stokpakai);
			
		    }
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }
		public function SaveEditHeader()
    {
  $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $post['id_shearing'];
		$this->db->trans_begin();
		$data = [
							'tgl_penawaran'			=> date('Y-m-d'),
							'id_customer'			=> $post['id_customer'],
							'id_produk'				=> $post['id_produk'],
							'material'				=> $post['material'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'surface'				=> $post['surface'],
							'lebar_coil'			=> $post['lebar_coil'],
							'qty'					=> $post['qty'],
							'mata_uang'				=> $post['mata_uang'],
							'potongan_pinggir'		=> $post['potongan_pinggir'],
							'total_panjang'			=> $post['total_panjang'],
							'jml_pisau'				=> $post['jml_pisau'],
							'jml_mother'			=> $post['jml_mother'],
							'total_berat'			=> $post['total_berat'],
														'wproses'			=> $post['wproses'],
							'spisau'			=> $post['spisau'],
							'gcoil'			=> $post['gcoil'],
							'twproses'			=> $post['twproses'],
							'handling'			=> $post['handling'],
							'twaktu'			=> $post['twaktu'],
							'bproses'			=> $post['bproses'],
							'ttlhgpenawaran'			=> $post['ttlhgpenawaran'],
							'hgpkgrp'			=> $post['hgpkgrp'],
							'hgpkgdl'			=> $post['hgpkgdl'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
			$this->db->where('id_shearing',$code)->update("tr_penawaran_shearing",$data);
			$this->db->delete('dt_penawaran_shearing_used', array('id_shearing' => $code));
			
		$numb1 =0;
		foreach($_POST['used'] as $use){
		$numb1++;        
                $stokpakai =  array(
							'id_shearing'		    	=> $code,
							'id_used_syock_penawaran'	=> $code.'-'.$numb1,
							'idstk'		    			=> $use[idstk],
							'lotno'		        		=> $use[lotno],
							'namamaterial'		        => $use[namamaterial],
							'weight'		        	=> $use[weight],
							'density'		        	=> $use[density],
							'hasilpanjang'		        => $use[hasilpanjang],
							'width'		    			=> $use[width],
							'lebarcc'					=> $use[lebarcc],
							'jumlahcc'		    		=> $use[jumlahcc],
							'sisapotongan'		    	=> $use[sisapotongan],
							'qty'		    			=> $use[qty],
							'jmlpisau'		    		=> $use[jmlpisau]
                            );
                    $this->db->insert('dt_penawaran_shearing_used',$stokpakai);
			
		    }
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $code,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $code,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);


    }
	public function saveEditPenawaran()
    {
        $this->auth->restrict($this->addPermission);
		$post = $this->input->post();
		$code = $this->Inventory_4_model->generate_code();
		$this->db->trans_begin();
		$id = $post['id_child_penawaran'];
		$data = [
							'id_category3'			=> $post['id_category3'],
							'bentuk_material'		=> $post['bentuk_material'],
							'id_bentuk'				=> $post['id_bentuk'],
							'thickness'				=> $post['thickness'],
							'density'				=> $post['density'],
							'forecast'				=> $post['forecast'],
							'inven1'				=> $post['inven1'],
							'bottom'				=> $post['bottom'],
							'dasar_harga'			=> $post['dasar_harga'],
							'komisi'				=> $post['komisi'],
							'keterangan'			=> $post['keterangan'],
							'harga_penawaran'		=> $post['harga_penawaran'],
							'created_on'			=> date('Y-m-d H:i:s'),
							'created_by'			=> $this->auth->user_id()
                            ];
            //Add Data
               $this->db->where('id_child_penawaran',$id)->update("child_penawaran",$data);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }
public function deletePenawaran(){
		$this->auth->restrict($this->deletePermission);
		$id = $this->input->post('id');
		$this->db->trans_begin();
		$this->db->delete('child_penawaran', array('id_child_penawaran' => $id));

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);
		}

  		echo json_encode($status);
	}

	public function saveEditInventory()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id = $_POST['hd1']['1']['id_category3'];
		$id_bentuk = $_POST['hd1']['1']['id_bentuk'];
		$numb1 =0;
		foreach($_POST['hd1'] as $h1){
		$numb1++;
                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0'
                            );
                     $this->db->where('id_category3',$id)->update("ms_inventory_category3",$header1);

		    }

		if(empty($_POST['data1'])){
		}else{
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		$numb2 =0;

		foreach($_POST['data1'] as $d1){
		$numb2++;
              $data1 =  array(
			                    'id_category3'=>$id,
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);

		    }
		}

		if(empty($_POST['compo'])){
		}else{
		$this->db->delete('child_inven_compotition', array('id_category3' => $id));
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;
              $comp =  array(
			                    'id_category3'=>$id,
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);

		    }
		}

		if(empty($_POST['dimens'])){
		}else{
		$this->db->delete('child_inven_dimensi', array('id_category3' => $id));
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;
              $dms =  array(
			                    'id_category3'=>$id,
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);

		    }
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'code' => $id_bentuk,
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }
		function get_compotition_new()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_dimensi()
    {
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk($id_bentuk);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($dim as $key => $ensi): $numb++;
				      echo "<tr>
					  <td align='left' hidden>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$ensi->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_compotition_old()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition_edit($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	function get_dimensi_old()
    {
        $id_bentuk=$_GET['id_bentuk'];
        $dim=$this->Inventory_4_model->bentuk_edit($id_bentuk);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($dim as $key => $ensi): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='dimens[$numb][id_dimensi]' readonly class='form-control'  value='$cmp->id_dimensi'>
					  </td>
					  <td align='left'>
					  $ensi->nm_dimensi
					  </td>
					  <td align='left'>
					  <input type='text' name='dimens[$numb][nilai_dimensi]' class='form-control'>
					  </td>
                    </tr>";
                endforeach;
        echo "</select>";
    }
	public function saveEditInventorylama()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
		$numb1++;

                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0'
                            );
            //Add Data
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);

		    }
		$this->db->delete('child_inven_suplier', array('id_category3' => $id));
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;
              $data1 =  array(
			                    'id_category3'=>$code,
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);

		    }
		}
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;
              $comp =  array(
			                    'id_category3'=>$code,
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);

		    }
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;
              $dms =  array(
			                    'id_category3'=>$code,
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);

		    }
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }
	public function saveEditInventoryOld()
    {
        $this->auth->restrict($this->addPermission);
		$session = $this->session->userdata('app_session');
		$code = $this->Inventory_4_model->generate_id();
		$this->db->trans_begin();
		$id =$_POST['hd1']['1']['id_category3'];
		$numb1 =0;
		//$head = $_POST['hd1'];
		foreach($_POST['hd1'] as $h1){
		$numb1++;

                $header1 =  array(
							'id_type'		        => $h1[inventory_1],
							'id_category1'		    => $h1[inventory_2],
							'id_category2'		    => $h1[inventory_3],
							'nama'		        	=> $h1[nm_inventory],
							'maker'		        	=> $h1[maker],
							'density'		        => $h1[density],
							'hardness'		        => $h1[hardness],
							'id_bentuk'		        => $h1[id_bentuk],
							'id_surface'		    => $h1[id_surface],
							'mountly_forecast'		=> $h1[mountly_forecast],
							'safety_stock'		    => $h1[safety_stock],
							'order_point'		    => $h1[order_point],
							'maksimum'		    	=> $h1[maksimum],
							'aktif'					=> 'aktif',
							'created_on'		=> date('Y-m-d H:i:s'),
							'created_by'		=> $this->auth->user_id(),
							'deleted'			=> '0'
                            );
            //Add Data
              $this->db->where('id_category3',$id)->update("ms_inventory_category3",$data);

		    }
		if(empty($_POST['data1'])){
		}else{
		$numb2 =0;
		foreach($_POST['data1'] as $d1){
		$numb2++;
              $data1 =  array(
			                    'id_category3'=>$id,
								'id_suplier'=>$d1[id_supplier],
								'lead'=>$d1[lead],
								'minimum'=>$d1[minimum],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_suplier',$data1);

		    }
		}
		if(empty($_POST['compo'])){
		}else{
		$numb3 =0;
		foreach($_POST['compo'] as $c1){
		$numb3++;
              $comp =  array(
			                    'id_category3'=>$id,
								'id_compotition'=>$c1[id_compotition],
								'nilai_compotition'=>$c1[jumlah_kandungan],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_compotition',$comp);

		    }
		}
		if(empty($_POST['dimens'])){
		}else{
		$numb4 =0;
		foreach($_POST['dimens'] as $dm){
		$numb4++;
              $dms =  array(
			                    'id_category3'=>$id,
								'id_dimensi'=>$dm[id_dimensi],
								'nilai_dimensi'=>$dm[nilai_dimensi],
								'deleted' =>'0',
							    'created_on' => date('Y-m-d H:i:s'),
								'created_by' => $this->auth->user_id(),
                            );
            //Add Data
              $this->db->insert('child_inven_dimensi',$dms);

		    }
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();
			$status	= array(
			  'pesan'		=>'Success Save Item. invenThanks ...',
			  'status'	=> 1
			);
		}

  		echo json_encode($status);

    }

		function get_compotition()
    {
        $inventory_2=$_GET['inventory_2'];
        $comp=$this->Inventory_4_model->compotition($inventory_2);
		$numb = 0;
        // print_r($data);
        // exit();
                foreach ($comp as $key => $cmp): $numb++;
				      echo "<tr>
					  <td hidden align='left'>
					  <input type='text' name='compo[$numb][id_compotition]' readonly class='form-control'  value='$cmp->id_compotition'>
					  </td>
					  <td align='left'>
					  $cmp->name_compotition
					  </td>
					  <td align='left'>
					  <input type='text' name='compo[$numb][jumlah_kandungan]' class='form-control'>
					  </td>
					  <td align='left'>%</td>
                    </tr>";
                endforeach;
        echo "</select>";
    }

}
