
<head>

	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

	<style>
		.ui-autocomplete {
			max-height: 100px;
			overflow-y: auto;
			/* prevent horizontal scrollbar */
			overflow-x: hidden;
		}
	  
	  /* IE 6 doesn't support max-height
	   * we use height instead, but this forces the menu to always be this tall
	   */
	   * html .ui-autocomplete {
	   	height: 100px;
	   }
	</style>

</head>

<div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">
		<i class="fa fa-plus-square"></i> Issue Book
	</h4>
</div>

<?php echo $this->Form->create($issuebook, array('class'=>'form-horizontal')); ?>
<div class="modal-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<div class="col-sm-10">
					<label>Enter Acc. No.</label>
					<?php echo $this->Form->input('book_asn_no', array('id'=>'asnnobf','class'=>'form-control','placeholder'=>'Enter Book\'s Acc. No.', 'label' =>false)); ?>
				</div>
				<div class="col-sm-2">
					<button type="button" onClick="nend_docsd();" class="btn btn-success" style="margin-top: 25px; margin-left: 17px;">Find</button>
				</div>
			</div>
			<div id="issue-book-info">
				<!-- to be loaded using AJAX -->
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<?php
		echo $this->Form->submit(
			'Issue Book', 
			array('id'=>'issue-button', 'class' => 'btn btn-info pull-left','style'=>'margin-right: 10px; display:none;', 'title' => 'Issue Book')
		);
	?>
	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<?php echo $this->Form->end(); ?>

<script>
function nend_docsd() {          
            var number=document.getElementById("asnnobf").value;  
        	$.ajax({ 
            type: 'POST', 
            url:"<?php echo ADMIN_URL ;?>Issuebooks/issueBookInfo",
            data: {'asn_no':number},
            success: function(data){ 
            $("#issue-book-info").html(data);
        },    
    }); 
         return false;
}

</script>

