@extends('layout.default')
@section('content')
  <script src="jquery-1.11.1.min.js"></script>
  <div class="modal-dialog" style="margin-top: 150px;" >
    <div class="modal-content">

      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="">&times;</button>
          <h4 class="modal-title">Standalone Create Payment</h4>
      </div>
      <div class="modal-body">
          <span style="font-weight:bold;">Amount</span><br/>
          <input type="text" class="form-control" placeholder="amount" name="amount" /><br />
      </div>
      <div class="modal-footer">
          <!-- <input type="submit" name="submit" class="btn btn-success btn-lg marginbot-50 btn-block" value="Pay" > -->
          <div name="payment" class="btn btn-info btn-lg col-sm-2 payment">
              <span class="glyphicon">Pay</span>  
          </div>
      </div>
    </div> 
  </div><!-- /.modal-dialog -->
  <script>
    $(function(){
      $('.payment').click(function(e){
        e.preventDefault();

        var amount = $("input[name='amount']").val();

        if(amount == '' ) {
          alert('Amount is empty.');
          return;
        }
        else if(amount <= 0) {
          alert('Amount is less than or equal zero.');
          return;
        }
        amount = parseInt(amount);
        var merchant_email = 'standalone_merchant@test.com';
        var order_id = 1;

        $.post("http://128.199.212.108:8000/payment",{payment:{amount:amount,merchant_email:merchant_email,order_id:order_id}},
          function(res,data,xhr){
            if(res.fail){
            }
            if(xhr.status==201) {
              var url = xhr.getResponseHeader('Location');
              window.location.href = url+"/accept";
            }
          }).fail(function(res,data,xhr){
            if(res.status == 400) alert(res.responseText);
          });
        });
      });
    </script>
@endsection
