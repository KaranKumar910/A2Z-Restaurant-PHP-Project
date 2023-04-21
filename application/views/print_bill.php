<?php
	include 'header.php';
	// $bill = $this->db->where('order_id',$id)->get('order_items');
  $this->db->select('c.*,o.*');
  $this->db->from('orders as o');
  $this->db->join('customer_details as c','c.id=o.customer_id AND o.time="'.$id.'"' );
  $bill=$this->db->get();
	if ($bill->num_rows()) {
		$row = $bill->row();
    // print_r($row);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
 
  <!-- /.navbar -->

<div class="container">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=site_url('Admin/index')?>">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> A2Z Restaurant Private,(Ltd)
                    <small class="float-right">Date : <?php 
                     echo $row->time;
                   ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>A2Z Restaurant Private,(Ltd)</strong><br>
                    S.R.K PG COLLAGE<br>
                    Firozabad, 283203<br>
                    Phone: (91) 123-5432-258<br>
                    Website: perfact-karan.tk
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong></strong><br>
                    <br>
                    <?php
                      echo 'Customer Name: <b>'.$row->custmer_name.'</b><br>'.
                      $row->mobile;


                      
                    ?>
                    
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> <?php
                    echo '#'.$row->time;
                ?><br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Item Name</th>
                      <th>Brand</th>
                      <th>Price</th>
                      <th>Qty</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        $this->db->select('item.*,o_items.*');//ek hi param hota hai bhaai
                        $this->db->from('order_items  as o_items');
                        $this->db->join('item', 'item.id=o_items.item_id and o_items.order_id = '.$id);
                        $print = $this->db->get();
                       // echo $this->db->last_query();
                        foreach ($print->result() as $d) {
                          // print_r($d);
                          echo '<tr>
                                  <small>
                                    <td>'.$i++.'</td>
                                    <td>'.$d->item.'</td>
                                    <td>';
                                      $this->db->select('item.*,brand.*');
                                      $this->db->from('item');
                                      $this->db->join('brand','brand.id=item.brand_id and item.id ='.$d->item_id);
                                      $brand = $this->db->get()->row();
                                      echo $brand->brand;
                                      //echo $this->db->last_query();
                                      // foreach($brand->result() as $res){
                                      //   print_r($res);
                                      // }


                                      
                                   echo '</td>

                                    <td>'.$d->price.'<i class="fa fa-rupee-sign"></i></td>
                                    <td>'.$d->qty.'</td>
                                    <td>'.$d->price*$d->qty.'<i class="fa fa-rupee-sign"></i></td>
                                  </small>
                                </tr>';
                        }
                                                              

                    ?>
                   
                  
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Customer Sign:</p>
                  

                  
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                    
                     <tr>
                          <th style="width:50%">Subtotal:</th>

                          <td>
                          <?php
                              echo $row->total_price;
                          ?>
                          </td>
                        </tr>
                      
                      <tr>
                        <th>Tax (18.0%)</th>
                        <td>
                          <?php
                              echo round($row->total_price*(18/100));
                          ?>
                        </td>
                      </tr>
                     
                      <tr>
                        <th>Total:</th>
                        <td>
                          <?php
                            echo $row->total_price+round($row->total_price*(18/100))
                          ?>
                          <i class="fa fa-rupee-sign"></i>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="" rel="noopener" target="_blank" onclick="window.print()" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
  
</div>
  <!-- /.content-wrapper -->
  
</body>
</html>

<?php
}
else{
    echo 'data no found';
}
	include 'footer.php';

?>