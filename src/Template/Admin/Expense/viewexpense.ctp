<style>
    h4 {
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }
    table td .close span{ font-size: 21px !important;}
    .modal h4.modal-title{ text-align: left;}
</style>

<div class="modal-header" style="background:#3399CC;">

    <h4 class="modal-title">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span
                aria-hidden="true">×</span></button>
        Expense Details
    </h4>

</div>
&nbsp;
<div class="col-sm-12">

    <table class="table table-bordered " id="followdetails">
        <tr>
            <th>S.No.</th>
            <th>Payment</th>
            <th>Pay Date</th>
            <th>Description</th>
            <th>Notes</th>
            <th>Action</th>

        </tr>
        <tbody>
            <?php $i = 1;
            foreach ($ExpenseDetail as $value) { 
                $expancedetails = $this->Comman->findexpansediscription($value['description']);
                ?>
                <tr>
                    <td style="text-align: left;" ><?php echo $i; ?></td>
                    <td style="text-align: left;" ><?php echo $value['amount']; ?></td>
                    <td style="text-align: left;" ><?php echo date('d-m-Y', strtotime($value['add_date'])); ?></td>
                    <td style="text-align: left;" ><?php echo $expancedetails['title']; ?></td>
                    <td style="text-align: left;" ><?php echo $value['notes']; ?></td>
                    <td style="text-align: left;" > <?php echo $this->Html->link('', ['action' => 'expensedelete', $value->id], ['title' => 'Delete', 'class' => 'fa fa-trash', 'style' => 'color:#FF0000; margin-left: 13px; font-size: 19px !important;', "onClick" => "javascript: return confirm('Are you sure do you want to delete this Expense')"]); ?>
                    </td>
                </tr>
                <?php $i++;
            } ?>
        </tbody>

    </table>
</div>
<div class="modal-footer">

</div>

</form>

<script>
    $('#enqiry_date').datepicker({
        // format: "yyyy/mm/dd"
        minDate: 0,
        autoclose: true,
    })
    $(".jq_datepicker").datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: 2
    });


    function showhide() {
        var div = document.getElementById("sec");
        if (div.style.display == "none") {
            div.style.display = "block";
            document.getElementById('scton').required = true;
        }

    }

    function showunhide() {

        $("#sec").css({
            display: "none"
        });

        document.getElementById('scton').required = false;
    };

    function showunhideaa() {
        $(".OpenEnquiry").click(function () {
            $("#NextFollowupDate").show();
            $('.NextFollowupDate').prop('required', true);
        });
        $(".CloseEnquiry").click(function () {
            $("#NextFollowupDate").hide();
            $('.NextFollowupDate').prop('required', false);
        });

    };

</script>
<script>

</script>

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>