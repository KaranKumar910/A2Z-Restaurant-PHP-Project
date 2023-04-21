<?php
    include 'header.php';
?>
<div class="container">
  <div class="content-wrapper">
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"> List Of Bill <small>A2Z Restaurant</small></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?=site_url('Admin/index')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Layout</a></li>
                <li class="breadcrumb-item active">Top Navigation</li>
              </ol>
            </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
<!-- ***********************************************Middle Contant*************************************** -->
  <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">List of Bills</h3>
          
          <input type="search" name="" placeholder="Search" style="margin-left:800px;">

         <!--  <div class="card-tools">
          
          </div> -->
        </div>
        <div class="card-body ">
          <div class="table-responsive">
          <table class="projects table table-striped">
              <thead>
                  <tr>
                     <small>
                          <th>
                            #.
                          </th>
                     </small>
                      <small>
                          <th>
                            Order ID
                          </th>
                      </small>
                      <small>
                          <th >
                            Customer Name
                          </th>
                      </small>
                      <small>
                          <th>
                            Date
                          </th>
                      </small>
                      <small>
                          <th  >
                            Item's 
                          </th>
                      </small>
                      <small>
                          <th >
                             Total
                          </th>
                      </small>
                      <small>
                          <th>
                            View Bill
                          </th>
                      </small>
                  </tr>
              </thead>
              <tbody>
                <?php
                    $i = 1;
                    $this->db->select('customer_details.*,orders.*');
                    $this->db->from('orders');
                    $this->db->join('customer_details','customer_details.id = orders.customer_id');
                    $query=$this->db->get();
                    foreach($query->result() as $data){
                      // print_r($data);
                      echo '<tr>
                              <td>'.$i++.'</td>
                              <td>#'.$data->time.'</td>
                              <td>'.$data->custmer_name.'</td>
                              <td>'.date('d-m-Y',$data->time).'</td>
                              <td>';
                                $this->db->select('item.*,order_items.*');
                                $this->db->from('order_items');
                                $this->db->join('item','item.id = order_items.item_id AND order_items.order_id = '.$data->time);
                                $item = $this->db->get();
                                foreach($item->result() as $items){
                                  // print_r($items);
                                  echo '
                                            <li>'.$items->item.'</li>';

                                        
                                }
                                 
                             echo '</td>
                              <td>'.$data->total_price.'</td>
                              <td>

                                  <a href="'.site_url('Admin/print_bill/'.$data->time).'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Bill</a>
                                
                              </td>
                            </tr>';
                    }
                   
                ?>
                 
                  
              </tbody>

          </table>
        </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
</div>
<!-- ********************************************Middle Contant close ***************************** -->
<?php
    include 'footer.php';
?>