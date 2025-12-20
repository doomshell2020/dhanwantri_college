<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>sitesettings"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>sitesettings/add">Manage Profile</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add Profile setting</h3>
            <a class="pull-right btn btn-success" href="<?php echo ADMIN_URL; ?>Roles" style="margin-left:5px">Roles
              Manager</a>
            <a class="pull-right btn btn-success" href="<?php echo ADMIN_URL; ?>Template">Template Format Manager</a>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php //pr($page); die; ?>
          <?php echo $this->Flash->render(); ?>



          <?php
echo $this->Form->create($sitesetting, array(

    'class' => 'form-horizontal',
    'id' => 'sitesetting_form',
    'enctype' => 'multipart/form-data',
    'novalidate',
)); ?>

          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>

              <div class="col-sm-3">
                <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'first_name', 'required' => 'required', 'label' => false)); ?>

              </div>
              <label for="inputEmail3" class="col-sm-2 control-label">Last Name</label>

              <div class="col-sm-3">
                <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'last_name', 'label' => false, 'required' => 'required')); ?>

              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Mobile</label>
              <div class="col-sm-3">
                <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'maxlength' => '10', 'placeholder' => 'Mobile', 'label' => false, 'required' => 'required')); ?>

              </div>
              <label for="inputEmail3" class="col-sm-2 control-label">Contact Email</label>

              <div class="col-sm-3">
                <?php echo $this->Form->input('contact_email', array('class' => 'form-control', 'placeholder' => 'Contact Email', 'id' => 'contact_email', 'required' => 'required', 'label' => false)); ?>

              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Facebook URL</label>
              <div class="col-sm-3">
                <?php echo $this->Form->input('facebook_url', array('class' => 'form-control', 'placeholder' => 'Facebook URL', 'id' => 'facebook_url', 'label' => false)); ?>

              </div>
              <label for="inputEmail3" class="col-sm-2 control-label">Twitter URL</label>

              <div class="col-sm-3">
                <?php echo $this->Form->input('twitter_url', array('class' => 'form-control', 'placeholder' => 'Twitter URL', 'id' => 'twitter_url', 'label' => false)); ?>

              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Site Title</label>
              <div class="col-sm-3">
                <?php echo $this->Form->input('site_title', array('class' => 'form-control', 'placeholder' => 'Site Title', 'id' => 'site_title', 'label' => false)); ?>

              </div>
              <label for="inputEmail3" class="col-sm-2 control-label">Site Keywords</label>

              <div class="col-sm-3">
                <?php echo $this->Form->input('site_keywords', array('class' => 'form-control', 'placeholder' => 'Site Keywords', 'id' => 'site_keyword', 'label' => false)); ?>

              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Site Description</label>

              <div class="col-sm-3">
                <?php echo $this->Form->textarea('site_description', array('class' => 'form-control', 'placeholder' => 'Site Description', 'id' => 'site_description', 'label' => false)); ?>

              </div>



              
              <label for="inputEmail3" class="col-sm-2 control-label">Google Analytics</label>

              <div class="col-sm-3">
                <?php echo $this->Form->textarea('google_analytics', array('class' => 'form-control', 'placeholder' => 'Google Analytics', 'id' => 'google_analytics', 'label' => false)); ?>

              </div>
            </div>
            <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Attendence Update Time</label>

           
<div class="col-sm-3">
    <?php echo $this->Form->input('attendence_update', array('class' => 'form-control', 'type' => 'time',  'label' => false)); ?>

  </div>

</div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label"></label>
              <div class="col-sm-10 ">
                <h4 style="font-weight:bold;color:red;"> Do you wish to change password ?</h4>

              </div>

            </div>
            <div class="passdata" style="display:block;">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Current Password</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('current_password', array('class' => 'form-control', 'placeholder' => 'Current Password', 'id' => 'current_password', 'value' => $user['confirm_pass'], 'required' => 'required', 'label' => false)); ?>

                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">New Password</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('new_password', array('class' => 'form-control', 'placeholder' => 'New Password', 'id' => 'password', 'label' => false)); ?>

                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Confirm Password</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('confirm_pass', array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'id' => 'confirm_pass', 'label' => false)); ?>

                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                <div class="col-sm-10 ">
                  <h4 style="font-weight:bold;color:red;"> Book Setting </h4>

                </div>

              </div>





              
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Book Fine Rate</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('fine_rate', array('class' => 'form-control', 'placeholder' => 'Book Fine Rate', 'label' => false)); ?>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Book Renew Days</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('renew_days', array('class' => 'form-control', 'placeholder' => 'Book Renew Days', 'label' => false)); ?>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Challan Printed</label>
                <div class="col-sm-3" style="line-height: 32px;padding-left: 18px;">
                  <input type="checkbox" name="print" class="radio-inline" value="0"
                    <?php if ($sitesetting['print'] == "0") {echo "checked";}?>>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                <div class="col-sm-10 ">
                  <h4 style="font-weight:bold;color:red;"> Template Setting </h4>

                </div>

              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">General Template</label>
                <div class="col-sm-9" style="line-height: 32px;padding-left: 18px;">
                  <?php foreach ($tmp['General'] as $value) {?>

                  <input type="radio" name="general" class="radio-inline" value="<?php echo $value['id']; ?>"
                    <?php if ($sitesetting['general'] == $value['id']) {echo "checked";}?>><?php echo ucwords($value['name']);} ?>

                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">TC Template</label>
                <div class="col-sm-9" style="line-height: 32px;padding-left: 18px;">
                  <?php foreach ($tmp['TC'] as $value) {?>

                  <input type="radio" name="tc" class="radio-inline" value="<?php echo $value['id']; ?>"
                    <?php if ($sitesetting['tc'] == $value['id']) {echo "checked";}?>><?php echo ucwords($value['name']);} ?>

                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Receipt</label>
                <div class="col-sm-9" style="line-height: 32px;padding-left: 18px;">
                  <?php foreach ($tmp['Receipt'] as $value) {?>

                  <input type="radio" name="receipt" class="radio-inline" value="<?php echo $value['id']; ?>"
                    <?php if ($sitesetting['receipt'] == $value['id']) {echo "checked";}?>><?php echo ucwords($value['name']);} ?>

                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Id Cards</label>
                <div class="col-sm-9" style="line-height: 32px;padding-left: 18px;">
                  <?php foreach ($tmp['Id Card'] as $value) {?>

                  <input type="radio" name="id_card" class="radio-inline" value="<?php echo $value['id']; ?>"
                    <?php if ($sitesetting['id_card'] == $value['id']){ echo "checked"; }?>><?php echo ucwords($value['name']);} ?>

                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Employee Id Cards</label>
                <div class="col-sm-9" style="line-height: 32px;padding-left: 18px;">
                  <?php foreach ($tmp['Employee Id'] as $value) {?>

                  <input type="radio" name="employee_id" class="radio-inline" value="<?php echo $value['id']; ?>"
                    <?php if ($sitesetting['employee_id'] == $value['id']){ echo "checked"; }?>><?php echo ucwords($value['name']);} ?>

                </div>
              </div>
              <?php $i = 1;
foreach ($boardarray as $board):  ?>
 
              <hr>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                <div class="col-sm-10 ">
                  <h4 style="font-weight:bold;color:red;"> Board <?php echo $i; ?></h4>

                </div>

              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Logo</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('logo[' . $board . ']', array('class' => 'form-control', 'type' => 'file', 'id' => '', 'label' => false)); ?>
                  <span style="color:red">Note:- Please select image size 100*100px</span><br>
                  
                  <img src="<?php echo SITE_URL; ?>images/<?php echo $sitesetting['logo'][$board];  ?>" alt=""
                    height="50" width="50" />

                </div>
                <label for="inputEmail3" class="col-sm-2 control-label">Sign</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('sign[' . $board . ']', array('class' => 'form-control', 'type' => 'file', 'id' => '', 'label' => false)); ?>
                  <img src="<?php echo SITE_URL; ?>images/<?php echo $sitesetting['sign'][$board]; ?>" alt=""
                    height="50" width="50" />

                </div>
              </div>



              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Small Logo</label>

                <div class="col-sm-3">
                  <?php //pr($sitesetting); die; ?>
                  <?php echo $this->Form->input('small_logo[' . $board . ']', array('class' => 'form-control', 'type' => 'file', 'id' => '', 'label' => false)); ?>
                  <span style="color:red">Note:- Please select image size 100*100px</span><br>
                  <img src="<?php echo SITE_URL; ?>images/<?php echo $sitesetting['small_logo'][$board]; ?>" alt=""
                    height="50" width="50" />

                </div>
                <label for="inputEmail3" class="col-sm-2 control-label">Website Logo</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('icon[' . $board . ']', array('class' => 'form-control', 'type' => 'file', 'id' => '', 'label' => false)); ?>
                  <img src="<?php echo SITE_URL; ?>images/<?php echo $sitesetting['icon'][$board]; ?>" alt=""
                    height="50" width="50" />

                </div>
              </div>



              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Header Logo</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('header_logo[' . $board . ']', array('class' => 'form-control', 'type' => 'file', 'id' => '', 'label' => false)); ?>
                  <span style="color:red">Note:- Please select image size 504*136px</span><br>
                  
                  <img src="<?php echo SITE_URL; ?>images/<?php echo $sitesetting['header_logo'][$board]; ?>" alt=""
                    height="50" width="50" />

                </div>
                <label for="inputEmail3" class="col-sm-2 control-label">TC Logo</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('tc_logo[' . $board . ']', array('class' => 'form-control', 'type' => 'file', 'id' => '', 'label' => false)); ?>
                  <img src="<?php echo SITE_URL; ?>images/<?php echo $sitesetting['tc_logo'][$board]; ?>" alt=""
                    height="50" width="50" />

                </div>

              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">School Code </label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('school_code[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'School Code', 'id' => 'school_code', 'label' => false, 'value' => $sitesetting['school_code'][$board])); ?>

                </div>
                <label for="inputEmail3" class="col-sm-2 control-label">Affiliation no.</label>

                <div class="col-sm-3">
                  <?php echo $this->Form->input('affiliation_no[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Affiliation no.', 'id' => 'affiliation_no', 'label' => false, 'value' => $sitesetting['affiliation_no'][$board])); ?>

                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Address Line 1</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('address1[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Address', 'label' => false, 'value' => $sitesetting['address1'][$board])); ?>
                </div>
                <label for="inputEmail3" class="col-sm-2 control-label">Address Line 2</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('address2[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Address', 'label' => false, 'value' => $sitesetting['address2'][$board])); ?>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Phone</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('phone[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Phone', 'label' => false, 'value' => $sitesetting['phone'][$board])); ?>
                </div>
                <label for="inputEmail3" class="col-sm-2 control-label">Fax</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('fax[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Fax', 'label' => false, 'value' => $sitesetting['fax'][$board])); ?>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('email[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Email', 'label' => false, 'value' => $sitesetting['email'][$board])); ?>
                </div>
                <label for="inputEmail3" class="col-sm-2 control-label">Web Site</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('website[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Web Site', 'label' => false, 'value' => $sitesetting['website'][$board])); ?>
                </div>
              </div>
              <div class="form-group">

                <label for="inputEmail3" class="col-sm-2 control-label">Subtitle 1</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('subtitle1[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Web Site', 'label' => false, 'value' => $sitesetting['subtitle1'][$board])); ?>
                </div>

                <label for="inputEmail3" class="col-sm-2 control-label">Subtitle 2</label>
                <div class="col-sm-3">
                  <?php echo $this->Form->input('subtitle2[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Web Site', 'label' => false, 'value' => $sitesetting['subtitle2'][$board])); ?>
                </div>

              </div>


              

              <?php
$i++;
endforeach;?>
 <?php //pr($sitesetting); die; ?>
<label >Taxsection</label>
<div style="border:1px solid #999; padding:20px; padding-bottom:0px;">
<div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
                <div class="col-sm-4">
                  <?php echo $this->Form->input('cname[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Company Name', 'label' => false, 'value' => $sitesetting['company_name'][$board])); ?>
                </div>


               <label for="inputEmail3" class="col-sm-2 control-label">Pan No</label>
                <div class="col-sm-4" style="margin-bottom:10px;">
                  <?php echo $this->Form->input('pan_no[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Pan No', 'label' => false, 'value' => $sitesetting['pan_number'][$board])); ?>
                </div>

              <label for="inputEmail3" class="col-sm-2 control-label">GST No</label>
                <div class="col-sm-4" style="margin-bottom:10px;">
                  <?php echo $this->Form->input('gst_no[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'GST No', 'label' => false, 'value' => $sitesetting['gst_no'][$board])); ?>
                </div>

                <label for="inputEmail3" class="col-sm-2 control-label">Tin Date</label>
                <div class="col-sm-4" style="margin-bottom:10px;">
                        
                        <?php echo $this->Form->input('tin_date', array('class' => 'form-control input1','label'=>false,'placeholder'=>'From Date','id'=>'datepicker1','autocomplete'=>'off','readonly','value'=>date('Y-m-d', strtotime($sitesetting['tin_date'][$board])))); ?>
               </div>

               <label for="inputEmail3" class="col-sm-2 control-label">Account No</label>
                <div class="col-sm-4" style="margin-bottom:10px;">
                  <?php echo $this->Form->input('account_number[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Account No', 'label' => false, 'value' => $sitesetting['account_number'][$board])); ?>
                </div>

                <label for="inputEmail3" class="col-sm-2 control-label">IFSC Code</label>
                <div class="col-sm-4" style="margin-bottom:10px;">
                  <?php echo $this->Form->input('ifsc[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'IFSC Code', 'label' => false, 'value' => $sitesetting['ifsc'][$board])); ?>
                </div>

                <label for="inputEmail3" class="col-sm-2 control-label">Address </label>
                <div class="col-sm-4" style="margin-bottom:10px;">
                  <?php echo $this->Form->input('address[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Address', 'label' => false, 'value' => $sitesetting['address'][$board])); ?>
                </div>


                <label for="inputEmail3" class="col-sm-2 control-label">Company Number </label>
                <div class="col-sm-4" style="margin-bottom:10px;">
                  <?php echo $this->Form->input('cmobile_no[' . $board . ']', array('class' => 'form-control', 'placeholder' => 'Company Number', 'label' => false, 'value' => $sitesetting['cmobile_no'][$board])); ?>
                </div>

                 <div style="clear:both"></div>
            </div>

            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">


            <?php
if (isset($sitesetting['id'])) {
    echo $this->Form->submit(
        'Update',
        array('class' => 'btn btn-info pull-right', 'title' => 'Update')
    );} else {
    echo $this->Form->submit(
        'Add',
        array('class' => 'btn btn-info pull-right', 'title' => 'Add')
    );
}
?><?php
echo $this->Html->link('Cancel', [
    'controller' => 'dashboards',
    'action' => 'index',

], ['class' => 'btn btn-default']); ?>
          </div>
          <!-- /.box-footer -->
          <?php echo $this->Form->end(); ?>
        </div>

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<script type="text/javascript">
$('#checkbox1').change(function() {
  if (this.checked)
    $('.passdata').show();
  else
    $('.passdata').hide();

});
</script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script>
   $(function() {
       var dateFormat = 'dd-mm-yy',
           from = $("#datepicker1")
           .datepicker({
               dateFormat: 'dd-mm-yy',
               changeMonth: true,
               numberOfMonths: 1
           })
           .on("change", function() {
               to.datepicker("option", "minDate", getDate(this));
           }),
           to = $("#datepicker2").datepicker({
               dateFormat: 'dd-mm-yy',
               changeMonth: true,
               numberOfMonths: 1
           })
           .on("change", function() {
               from.datepicker("option", "maxDate", getDate(this));
           });
   
       function getDate(element) {
           var date;
           try {
               date = $.datepicker.parseDate(dateFormat, element.value);
           } catch (error) {
               date = null;
           }
           return date;
       }
   });
</script>