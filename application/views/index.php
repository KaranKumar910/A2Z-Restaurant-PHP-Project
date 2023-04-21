<?php
	include 'header.php';
?>
<div class="container">
<div class="content-wrapper">
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"> Take Order <small>A2Z Restaurant</small></h1>
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



<!-- *********************************Middle contant start here *********************************** -->
<!--  -->
<div class="row">
   <!-- /.col -->
          <?php
          echo '<div class="col-md-12">'.$error.'</div>';
      $list = $this->db->get('brand');
      foreach($list->result() as $row) {
          ?>
          <?php
        echo'
          <div class="col-lg-3 col-6">
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
             echo '">';
             ?>
              <div class="card-header">
                <div class="inner">
                <?php
                  echo '
                <h3 class="card-title">'.$row->brand.'</h3>';
                //}
                ?>
              </div>
            </div>
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <small>
                        <th><small>#.</small></th>
                        <th><small>ITEM</small></th>
                        <th><small>PRICE</small></th>
                        <th><i class="fa fa-check"></i></th>
                      </small>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                   $i = 1;
                   $list = $this->db->where('brand_id',$row->id)->get('item');
                   foreach($list->result() as $row1) {
                          // code...
                             
                   echo'<tr>
                          <td><small>'.$i++.'</small></td>
                          
                          <td><small>'.$row1->item.'</small></td>
                          <td><small>'.$row1->price.' <i class="fa fa-rupee-sign"></i></small></td>
                          <td><small><input value="'.$row1->id.'" class="select-item" type="checkbox"></small></td>
                        
                        </tr>';
                    };
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
  

<!-- *********************************Middle contant start here *********************************** -->
<style type="text/css">
  input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  .bill-view{
    position: absolute;
    right: 1px;
    bottom: 1px;
    width: 420px;
    /*height: 0;*/
    display: none;
  }
  .item_qty{
    width: 40px
  }
  .div-qty{
    width: 97px;
    border: 1px solid black;
  }
  .div-qty .minus,.div-qty .plus{
    width: 23px;
    border: none;
    color: white;
  }
  .div-qty input{
    border: none;
    outline: none;
  }
  .div-qty .minus{
    background-color: red;
    border-right: 1px solid black;
  }
  .div-qty .plus{
    background-color: green;
    border-left: 1px solid black;
  }
</style>
<?php
    echo form_open('',['autocomplete'=>'off']);
    echo validation_errors('<div class="alert alert-danger">','</div>')
?>
     <div class="bill-view">
        <div class="card card-primary">
             <div class="card-header">
                <i class="fa fa-list"></i> List Item(s)
                :-  <span class="ttl_items">0</span>
             </div>
             <div class="card-body">

                <table class="table table-striped table-bordered">
                  <thead>
                      <tr>
                          <th>Item Name</th>
                          <th>Price</th>
                          <th>QTY</th>
                          <th>Total</th>
                      </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
             </div>
             <div class="card-footer">
                <table class="table table-bordered">
                  <tr>
                      <th>Total Items</th>
                        <td class="ttl_items">0</td>
                      <th>Total Amount</th>
                        <td class="ttl_amount">0</td>
                  </tr>
                 

                </table>

             
             <div class="row">
                <div class="col-md-5">
                   <div class="form-group ">
                      <?php 
                          echo form_input('custmer_name','',['class' => 'form-control','placeholder' => 'Enter Name'],'require'); 
                      ?>
                   </div>
                </div>
                 <div class="col-md-5">
                    <div class="form-group">
                      <?php 
                          echo form_input('mobile','',['class' => 'form-control','placeholder' => 'Enter Mobile'],'require'); 
                      ?>
                    </div>
                    
                 </div>
                 <div class="col-md-2">
                      <button type="submit" class="btn btn-block btn-outline-primary">Go</button>
                  </div>
             </div>
             </div>
        </div>
     </div>
<?php
  echo form_close()
?>

    </div>
  </div>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
<?php
	include 'footer.php';
?>
<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','.div-qty button',function(){
        var input = $(this).closest('.div-qty').find('.item_qty');
        var value = $(input).val();

        if($(this).attr('class') == 'minus'){
          //alert(value);
          if(value != 1)
            value--;
        }
        else
            value++;
        $(input).val(value).trigger('keyup');
    });
    /*
    $(document).on('click','.div-qty .minus',function(){
        var input = $(this).closest('.div-qty').find('.item_qty');
        var value = $(input).val();
        if(value <= 0)
            value = 0;
        else
            value--;

        $(input).val(value).trigger('keyup');
    });


    $(document).on('click','.div-qty .plus',function(){
        var input = $(this).closest('.div-qty').find('input');
        var value = $(input).val();
        
            value++;

        $(input).val(value).trigger('keyup');
    });
    */

    $('.select-item').click(function(){
      var id = $(this).val();
      var selected = $('.select-item:checked').length;
      

      if($(this).is(':checked')){

          $.ajax({
                url : '<?=site_url('Admin/get_item_for_bill')?>',
                data : {item_id : id},
                success : function(res){
                  $('.bill-view').find('.card-body tbody').append(res);
                  return calAmount();
                }
          });
      }
      else{
        $('.item_'+id).remove();
      }




      if(selected){
          $('.bill-view').slideDown(1000);
      }
      else{
          $('.bill-view').slideUp(1000);
      }


      $('.bill-view').find('.ttl_items').text(selected);

      return calAmount();
    });

    function calAmount(){
       var allItems = $(document).find("input[name='item_id[]']");
       var ttl =0;
        allItems.each(function(i,val){
            var id = $(val).val(),
                price = $('.price_'+id).val();
                qty = $('.item_qty_'+id).val()
                ttl += Number(qty) * Number(price);
        });

        $('.ttl_amount').html(ttl+' <i class="fa fa-rupee"></i>');

    }

    $(document).on('keypress keyup','.item_qty',function(){
        var qty = $(this).val(),
          item_id = $(this).closest('tr').data('id'),
          price = $('.price_'+item_id).val();
          var ttl_price = Number(qty) * Number(price);
          $('.ttl_price_'+item_id).html(ttl_price);
         return calAmount();
    })

  });

</script>