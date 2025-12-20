<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">×</span><span class="sr-only">Close</span>
    </button>
    <h4 class="modal-title" id="modalLabel"><i class="fa fa-calendar"></i>
        Assign Class</h4>
    <small>
</div>

<?php echo $this->Form->create('', array(
    'action' => 'update_staff_timetable',
    'class' => 'form-horizontal timestable_form',
    'enctype' => 'multipart/form-data',
    'validate'
)); ?>
<div class="modal-body">

    <div id="s-id">
        <div class="after-add-more" id="test">

            <div class="assets_container">
                <div class="form-group">
                    <div class="col-sm-3">
                        <?php echo $this->Form->input('class_id[]', array('class' => 'form-control class-id1 classes', 'type' => 'select', 'empty' => 'Select Class', 'required', 'options' => $classes, 'label' => false, 'data-id' => 1)); ?>
                    </div>
                    <div class="col-sm-3">
                        <?php echo $this->Form->input('section_id[]', array('class' => 'form-control section-id1 sections', 'type' => 'select', 'empty' => 'Select Section', 'required', 'value' => $classsec_id, 'label' => false, 'data-id' => 1)); ?>
                    </div>
                    <div class="col-sm-3">
                        <?php
                        echo $this->Form->input('subject_id[]', array('class' => 'form-control sub1 subjects', 'type' => 'select', 'empty' => 'Select Subject', 'value' => $val, 'label' => false, 'required', 'data-id' => '1'));
                        ?>
                    </div>
                    <?php echo $this->Form->input('classTimeId', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'classTime-id', 'required', 'value' => $classTimeId, 'label' => false)); ?>
                    <?php echo $this->Form->input('teacherId', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'classTime-id', 'required', 'value' => $teachId, 'label' => false)); ?>
                    <?php echo $this->Form->input('weekDay', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'classTime-id', 'required', 'value' => $weekDay, 'label' => false)); ?>

                    <div class="col-sm-2" class="subtype">
                        <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 15px;"><i class="fa fa-plus-circle"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> <!-- /. modal-body -->


<div class="modal-footer">
    <button type="submit" class="btn btn-primary pull-left">Update</button> <button type="button" class="btn btn-default" id="close-modal" data-dismiss="modal">Close</button>
</div> <!-- /. modal-footer -->
</form>

<script>
    /*$(document).ready(function(){ */

    var incments = '1';
    $(".add_field_butto").click(function() {
        var clsid = '<?php echo $clasid; ?>';
        incments++;
        $('.after-add-more').append(
            '<div class="assets_container asset2"> <div class="form-group"><div class="col-sm-3"><select data-id="' + incments + '" class="form-control classes class-id' + incments + '" name="class_id[]" required="required"><option value="" >Select Class</option><?php foreach ($classes as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select>  </div> <div class="col-sm-3"><select data-id="' + incments + '" class="form-control sections section-id' + incments + '" name="section_id[]" required="required"><option value="" >Select Select</option><?php foreach ($rty as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select></div> <div class="col-sm-3"><select data-id="' + incments + '" class="form-control subjects sub' + incments + '" name="subject_id[]" required="required"><option value="" >Select Subject</option><?php foreach ($rty as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select></div><div class="col-sm-2"><a href="javascript:void(0);" class="remove" style="font-weight: bold; font-size: 15px;"><i class="fa fa-minus-circle"></i></a></div></div></div>');
        $(".enm2" + incments).on('change', function() {
            var empid = $(this).val();
            var tid = '<?php echo $tt_id; ?>';
            var week = '<?php echo $weekname; ?>';
            var mh = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/teacheroccupy',
                data: {
                    'empid': empid,
                    'tid': tid,
                    'week': week
                },
                success: function(data) {
                    var arr = data.split('/');

                    var clsname = arr['1'];
                    var secname = arr['2'];
                    var clid1 = arr['3'];
                    var clid2 = arr['4'];
                    var emp = arr['5'];
                    if (data != '0') {
                        if (confirm("Teacher already assigned in class (" + clsname + " - " +
                                secname + "). Do you really want to assign this teacher?")) {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/teacherdelete',
                                data: {
                                    'clid1': clid1,
                                    'clid2': clid2,
                                    'emp': emp
                                },
                                success: function(data) {}

                            });
                        } else {
                            $(".enm2" + mh).val("");
                        }
                    }
                },
            });
        });

    });
    $("body").on("click", ".remove", function() {
        $(this).closest('.assets_container').remove();
    });
    $("body").on("click", "#close-modal", function() {
        $('.modal-content').html('<div class="modal-body"><div class="loader"><div class="es-spinner"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div></div></div>');
    });
    $("body").on("change", ".classes", function() {
        var dataId = $(this).data('id');
        var id = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/find_section',
            data: {
                'id': id
            },
            success: function(data) {
                $('.section-id' + dataId).empty();
                $('.section-id' + dataId).html(data);
            },

        });
        $.ajax({
            type: 'POST',
            url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/find_staff_subject',
            data: {
                'id': id
            },
            success: function(data) {
                $('.sub' + dataId).empty();
                $('.sub' + dataId).html(data);
            },

        });
    });
</script>

<script>
    $(document).on("click", ".globalModalss", function(e) {
        var href = $(this).attr('href');
        $('.modal-content').load(href, function() {
            $('#globalModal').modal({
                show: true
            });
        });
    });
</script>