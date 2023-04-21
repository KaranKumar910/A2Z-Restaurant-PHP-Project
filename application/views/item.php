<?php
	include 'header.php';
?>
<div class="container">
	  <div class="content-wrapper">
	 	    <div class="content-header">
	          <div class="container">
	          	<div class="row mb-2">
	            	<div class="col-sm-6">
	              		<h1 class="m-0"> Create Item  |   <small class="breadcrumb-item active" >A2Z Restaurant</small></h1>
	            	</div><!-- /.col -->
		            <div class="col-sm-6">
		              	<ol class="breadcrumb float-sm-right">
			                <li class="breadcrumb-item">
			                	<a href="<?=site_url('Admin/index')?>">Home</a>
			                </li>
			                <li class="breadcrumb-item">
			                	<a href="#">Item</a>
			                </li>
			                <li class="breadcrumb-item active">
			                	Top Navigation
			                </li>
		              	</ol>
		            </div><!-- /.col -->
	          	</div><!-- /.row -->
	          </div><!-- /.container-fluid -->
	     </div>
<!--**************************** Create Item content coding **************************************-->
	
<div class="row">
    <div class="col-md-6">
            <div class="card card-outline card-danger">
              <div class="card-header">
                <h2 class="card-title">Create Item</h2>
              </div>
              <div class="card-body">
                <?php
                  echo validation_errors('<div class="alert alert-danger">','</div>');
                	echo form_open('',['autocomplete'=>'off']);
                ?>
                <label for="">Select Brand :- </label>
                 <div class="input-group mb-3">

                  <div class="input-group-prepend">

                    <span class="input-group-text"><i class="fas fa-check"></i></span>
                  </div>

                 <select name="brand_id" onchange="list_item(this.value)" class="form-control">
                 			<option value="">Select Brand</option>
                 	<?php
                 			$list = $this->db->get('brand');
                     
                 			foreach($list->result() as $row){

	                 				echo '<option value="'.$row->id.'">'.$row->brand.'</option>';
	                   }
                   
                  ?>
                </select>
                </div>
                  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"></span>
                  </div>
                 <?php

                 			echo form_input('item','',['class'=>'form-control','placeholder'=>'Create Item']);
                 ?>
                </div>	
                   <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-rupee-sign"></i></span>
                  </div>
                 <?php

                 			echo form_input('price','',['class'=>'form-control','placeholder'=>'Enter Price'],'require');
                 ?>
                </div>
                 <div class="input-group mb-3">
                  
              		 <button type="submit" class="btn btn-block btn-outline-success">Creat Item</button>
                </div>
              </form>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </div>
    <div class="col-md-6 result">
      
    </div>

</div>


<!--**************************** list Item content coding **************************************-->
  <div class="content-header">
      <div class="container">
              <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> View Item  |   <small class="breadcrumb-item active">A2Z Restaurant</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item">
                        <a href="<?=site_url('Admin/index')?>">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="#">Item</a>
                      </li>
                      <li class="breadcrumb-item active">
                          view Item
                      </li>
                    </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
<div class="row">
<?php
foreach($list->result() as $row) {
          
echo'
      <div class="col-lg-4 col-6">
            <div class="card card-outline '; 
             if ($row->id%2==0) {
               echo 'card-primary';
             }
             else{
              if ($row->id%3==0) {
                echo 'card-danger';
              }
              else
                echo 'card-green';
             }

            echo'">
              <div class="card-header">
                <div class="inner">'
                ?>
                <?php
                  echo '<h3 class="card-title">'.$row->brand.'</h3>';
                //}
                ?>
              </div>
            </div>
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#.</th>
                      <th>Item name</th>
                      <th>price</th>
                      <th>Manage</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                   $i = 1;
                   $list1 = $this->db->where('brand_id',$row->id)->get('item');
                   // echo $list1->num_rows();
                   foreach($list1->result() as $row1) {
                          // code...
                             
                   echo'<tr data-id="'.$row1->id.'">
                          <td>'.$i++.'</td>
                          <td>'.$row1->item.'</td>
                          <td>'.$row1->price.'</td>
                          <td>
                             <button class="btn btn-xs btn-flat bg-primary edit-item"><i class="fa fa-edit"> </i></button>
                             <button class="btn btn-xs btn-flat bg-maroon"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>';
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        <?php
        }
        ?>

	    </div>
  </div>
</div>




<!-- ********************Pop Up Form **************************************************************-->
 
<?php
	include 'footer.php';
?>
<script type="text/javascript">
  function list_item(value){
    if(value!= ''){

      $.ajax({
          type:'post',
          url:'<?=site_url('Admin/get_item_by_brand')?>',
          data:{value : value},
          success:function(r){
            $('.result').html(r);
          }
      });
    }
    else
      $('.result').html('');
    
  }

  $('.edit-item').click(function(){
    //var id = $(this).parent().parent().data('id');
    var item_id = $(this).closest('tr').data('id');
    $.ajax({
      url : '<?=site_url('Admin/edit_brand_form')?>',
      method : 'post',
      data : {id:item_id},
      dataType : 'json',
      beforeSend:function(){

      },
      success : function(res){
        console.log(res);
        $('#modal-primary').
            find('.modal-header > h4').text(res.title).end()
            .find('.modal-body').html(res.html).end()
            .find('.modal-footer').html(res.footer).end().modal('show');
      },
      complete:function(){

      },
      error:function(a,b,c){
        console.log(a.responseText);
      }
    });
  });


</script>