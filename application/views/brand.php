<?php
	include 'header.php';
?>

<style type="text/css">
	tr:hover{
		background-color: lightblue;
	}

</style>
<div class="container">
	<div class="content-wrapper">
		<div class="content-header">
				      <div class="container">
				        <div class="row mb-2">
				          <div class="col-sm-6">
				            <h1 class="m-0"> 
				            	Create Brand  |  
				            		<small>A2Z Restaurant</small>
				            </h1>
				          </div><!-- /.col -->
				          <div class="col-sm-6">
				            <ol class="breadcrumb float-sm-right">
				              <li class="breadcrumb-item"><a href="<?=site_url('Admin/index')?>">Home</a></li>
				              <li class="breadcrumb-item"><a href="#">Properties</a></li>
				              <li class="breadcrumb-item active">Create Brand</li>
				            </ol>
				          </div><!-- /.col -->
				        </div><!-- /.row -->
				      </div><!-- /.container-fluid -->
		</div>
		<div class="col-md-12">
  			<div class="card card-primary">
 						<div class="card-header">
 								<i class="fa fa-concierge-bell"></i>
 						</div> 
			 			<div class="card-body">

				 			<?php
				 			echo validation_errors('<div class="alert alert-danger">','</div>');
				 				echo form_open('',['autocomplete'=>'off']);
				 			?>
				 					<div class="input-group input-group-sm">
				                  <!-- <input type="text" class="form-control" name="brand"> -->
				              <?php
				                 	echo form_input('brand','  ',['class'=>'form-control','required']);
				                 	
				              ?>
				              <span class="input-group-append">
				                    <button type="submit" class="btn btn-info btn-flat">Save Brand!</button>
				              </span>
				           </div>
				 			<?php
				 			 	echo form_close();
				 			?>
			      </div>
 				</div>		
		</div>


	 <div class="row">

	 		<?php 
	 				$list = $this->db->get('brand');
	 				foreach($list->result() as $row){
	 		
	 		  echo '<div class="col-lg-3 col-6">

            <!-- small box -->
            <div class="small-box ';
            if ($row->id%2==0) {
            	echo 'bg-primary';
            }
            elseif($row->id%3==0){
            	echo 'bg-success';
            }
            else
            	echo 'bg-danger';
           	
           	echo '">
         
            
              <div class="inner">
                <h3>'.$row->brand.'</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>';
        }
         ?>
	 </div>	  	

		  	<aside class="control-sidebar control-sidebar-dark">
		   
	</div>
</div> 


 	 		
<?php
	include 'footer.php';
?>