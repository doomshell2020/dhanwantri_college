<style>
input[type=number]::-webkit-inner-spin-button, 

input[type=number]::-webkit-outer-spin-button { 

  -webkit-appearance: none; 

  margin: 0; 

}
</style>
<p style="text-align:center;margin:5px 0px 5px 0px;font-weight:600">CBSE (VATIKA-VIII) Result</p>

<?php echo $this->Form->create('Logins',array(                      
                       'id' => 'result_form',
                       )); ?>


      <div class="form-group has-feedback">
	<?php echo $this->Form->input('enroll',array('class'=>'form-control','type'=>'number','placeholder'=>'Enrollment Number','id'=>'enroll','label' =>false,'required'=>'required','autocomplete'=>"off",'maxlength'=>"5")); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
    
      <div class="row" style="text-align:center">
       
        <div class="col-xs-12">
            
            
	<?php
	echo $this->Form->submit(
	    'View Result', 
	    array('class' => 'btn btn-primary btn-block btn-flat', 'title' => 'View Result')
	); ?>
         
        </div>
        <!-- /.col -->
      </div>
   <?php echo $this->Form->end(); ?>


   <section class="">
   <p style="color:red;display:none; text-align:center; margin-top:10px;" id="message"></p>
   <table id="results" border="1" cellspacing="0" style="display:none; width:100%; margin-top:15px;" align="center">
   <thead>
     <th style="padding: 5px;font-weight:800;">Result Type</th>
     <th style="padding: 5px;font-weight:800;">Result Date</th>
     <th style="padding: 5px;font-weight:800;">Download</th>
   </thead>
   </table>
   </section>
   <script>
   $(document).ready(function(){
     var newUrl='https://www.sanskarjaipur.com/';
    $('.login-logo a').attr("href", newUrl);
    $('#message').hide()
    $('#results').hide();
        $('.login-box-msg').hide();
        $('#result_form').submit(function(e){
          $('#message').hide()
          $('#results').hide();
          $('#results tbody tr').remove();
            e.preventDefault();
            if($('#enroll').val()===''){
             alert('Please enter your Enrollment number');
             return false;
            }
            $.ajax({ 
       type: 'POST', 
       url: '<?php echo SITE_URL ;?>Homes/viewresult',
       data: $("#result_form").serialize(),
       success: function(data){
         var output=JSON.parse(data);
         var result=output.output;
         if(result!==null){
         result.map((value,i)=>{
          $('#results').append('<tr><td style="padding: 5px;">'+value.examname+'</td><td style="padding: 5px;">'+value.resultdeclare+'</td><td style="padding: 5px; text-align: center;"><a href="'+value.link+'" target="_blank" style="color:red"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td></tr>');
         });
         $('#results').show();
         }else{
           console.log(output.message)
         $('#message').html(output.message)
         $('#message').show()
         }
         console.log(output)
       }, 
       
   });

        })
   });
   </script>
