<?php
	
class Admin extends CI_Controller{

 	function __construct(){
 		parent :: __construct();
 			if(!$this->session->has_userdata('admin_id')) 
			redirect(site_url('Welcome/login'));
 	}

 	function index(){
 		$post = $this->input->post();
 		$this->form_validation->set_rules('custmer_name','Name','required');
 		$this->form_validation->set_rules('mobile','Mobile No',
 			array('required','NUMERIC','max_length[10]')
 		);

 		if ($this->form_validation->run() ) {


 			// echo '<pre>';
 			// print_r($post);
 			// echo '</pre>';	
 			$ttl_price = $ttl_items = 0;
 			$order_id = time();
 			foreach($post['item_id'] as $id){
 				$ttl_price += $post['price_'.$id] * $post['qty_'.$id];
 				$ttl_items++;
 			}

 			$this->db->insert('customer_details',['custmer_name'=>$post['custmer_name'],'mobile'=>$post['mobile']]);
 			$customer_id = $this->db->insert_id();
 			$this->db->insert('orders',[
 				'time' => $order_id,
 				'customer_id'=>$customer_id,
 				'total_items' => 	$ttl_items,//count($post['item_id']),
 				'total_price' => $ttl_price
 			]);

 			foreach($post['item_id'] as $id){
 				$this->db->insert('order_items',[
 					'order_id' => $order_id,
 					'item_id' => $id,
 					'qty' => $post['qty_'.$id],
 					'price' => $post['price_'.$id]
 				]);
 			}
 			redirect('Admin');
 		}
 		else{
 			$data['error'] = validation_errors('<div class-"alert alert-danger">','</div>');
			$this->load->view('index',$data); 
 		}
		//form design kyu bigad rhi hai pta hai ya form tag lagate hii apne app bigad gyai,,,,,,,, kyunki col-md sirf row k andar hi work karte hai aur unke beech form aa gya smjhe okkk  smjh  gye ys
	}
	

	

	function login(){
			$get = $this->login_model->login($user,$pass);
			if($get->num_rows()){
				$this->load->view('index');
			}
			else
				$this->load->view('login');

	}
	function logout(){
		$this->session->sess_destroy();
		redirect(site_url('Welcome/login'));
	}

	function view_bill(){
		$this->load->view('view_bill');
	}
	function print_bill($id){
		$this->load->view('print_bill',['id' => $id]);
	}
	function get_item_for_bill(){
		if($get = $this->input->get()){
			$id = $get['item_id'];

			$item = $this->db->get_where('item',['id' => $id])->row();

			echo 
			    '<tr class="item_'.$id.'" data-id="'.$id.'">
				 <td>'.
				 	form_hidden('item_id[]',$id).
				 	'<input type="hidden" name="price_'.$id.'" class="price_'.$id.'" value="'.$item->price.'">'.

				 $item->item.'</td>
				 <td>'.$item->price.' <i class="fa fa-rupee"></i></td>
				 <td>
				 	<div class="div-qty">
				 	  <button type="button" class="minus"><i class="fa fa-minus"></i></button>
				 	<input type="number" readonly name="qty_'.$id.'" class="item_qty item_qty_'.$id.'" value="1">

				 	  <button type="button" class="plus"><i class="fa fa-plus"></i>	</button>
				 	</div>
				 </td>
				 	
				 <td class="ttl_price_'.$id.'">'.$item->price .'</td>
				
			     </tr>';

		}
	}
	
	function brand(){
		$post = $this->input->post();
		

      
		if ($post) {
    
      $this->form_validation->set_rules('brand', 'Brand Input', array('required', 'min_length[5]','is_unique[brand.brand]'),
      		array(
      				'required' => 'This %s is never empty, Please FIlled it.',
      				'is_unique' => $post['brand'].' is already Exists..'
      		)
    		);
	 if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('brand');
                }
                else
                {
                       $this->db->insert('brand',$post);
			redirect(site_url('Admin/brand'));
                }
		}
		else
			$this->load->view('brand');
	}
	function item(){

		$post = $this->input->post();
		if($post){
					$this->form_validation->set_rules('brand_id','This Brand Name',array('required'),
						array(
								'required' => '%s is Never Empty, Please Filled required',
								
						)
				);
					$this->form_validation->set_rules('item','This Item',array('required','is_unique[item.item]'),
							array(
								'required' => '%s is Never Empty, Please Filled required',
								'is_unique' => '%s is already Exists'
						)
				);
					$this->form_validation->set_rules('price','This Price',array('required'),
						array(
								'required' => '%s is Never Empty, Please Filled required',
								
						)
				);
	
				if ($this->form_validation->run() == FALSE)
	          {
	              $this->load->view('item');
	          }
				else
	          {
	               $this->db->insert('item',$post);
			redirect(site_url('Admin/item'));
	          }	
	}
else
		$this->load->view('item');
}
	function get_item_by_brand(){
		$brand_id = $this->input->post('value');
		
		
		echo '<div class="card">
				<div class="card-header">
					<strong></strong>
				</div>
				<div class="card-body">
					<table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#.</th>
                      <th>Item name</th>
                      <th>price</th>
                    </tr>
                  </thead>
                  <tbody>';
              
                   $i = 1;
                   $list = $this->db->where('brand_id',$brand_id)->get('item');
                   foreach($list->result() as $row1) {
                          // code...
                             
                   echo'<tr>
                          <td>'.$i++.'</td>
                          <td>'.$row1->item.'</td>
                          <td>'.$row1->price.'</td>
                        </tr>';
                    };
                  echo'
                  </tbody>
                </table>
				</div>
			</div>';
	}
	function edit_brand_form(){
		$return = ['html' => '','title' => 'Edit Item','footer' => form_button('submit','<i class="fa fa-save"></i> Save',['class' => 'btn btn-success']) ];
		if($post = $this->input->post()){
			$data = $this->db->get_where('item',['id' => $post['id']])->row_array();
			$return['html'] = $this->load->view('ajax/edit_item',$data,true);

		}
		echo json_encode($return);
	}
	function update_item(){
		if($post = $this->input->post())
		{
			$this->db->where('id',$id)->update('item',$post);
			$this->session->set_flashdata('msg','<div class="alert alert-success">Data Submitted Successfully.</div>');
			redirect(site_url('Admin/item'));// kya  hua
		}	
		else 
 		// code...
 	 	$this->load->view('edit_item',['table_id'=>$id]);
	 	// $this->session->set_flashdata('msg','<div class="alert alert-success">Data Edit Seccessfully..</div>');
	 	 redirect(site_url('Admin/item'));
	 }

	// function student(){
	// 	$post = $this->input->post();
	// 	if($post){
	// 		$this->db->insert('student',$post);
	// 		$this->session->set_flashdata('msg','<div class="alert alert-success">Data Submitted Successfully.</div>');
	// 		redirect(site_url('Admin/student'));// kya  hua
	// 	}
	// 	else 
	// 		$this->load->view('student');//ho nhi rha hai
	//  }
	//  function student_list(){
	//  	$post = $this->load->view('student_list');
	//  }

	//  function edit_student($id){
	//  	if($post = $this->input->post())
	// 	{
	// 		$this->db->where('id',$id)->update('student',$post);
	// 		$this->session->set_flashdata('msg','<div class="alert alert-success">Data Submitted Successfully.</div>');
	// 		redirect(site_url('Admin/student'));// kya  hua
	// 	}	
	// 	else 
 // 		// code...
 // 	 	$this->load->view('edit_student',['table_id'=>$id]);
	//  	// $this->session->set_flashdata('msg','<div class="alert alert-success">Data Edit Seccessfully..</div>');
	//  	// // redirect(site_url('Admin/student'));
	//  }
	//  function delete_student($id = 0){
	// 	$this->db->where('id',$id)->delete('student');
	// 	redirect(site_url('Admin/student_list'));
	// }
	}

?>