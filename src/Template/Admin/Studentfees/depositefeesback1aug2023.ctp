<style>
   #personal-tab a:hover {
      color: #fff !important;
      background: #333 !important;
   }
</style>
<?php
$admission_year_st  = $students['admissionyear'];
$admission_year_user  = $db['academic_year'];
?>
<div class="content-wrapper">
   <section class="content-header">
      <h1 style="margin: 0;
    font-size: 0px;
    color: aliceblue;">
         <ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="">
            <li class="active" id="personal-tab">
               <a style="background: #00C0EF;color:#fff"><i class="fa fa-street-view"></i> Fee Structure <? echo $academic_year; ?></a>
            </li>
            <? if ($students['category'] == "RTE") { ?>
               <li class="" id="personal-tab">
                  <a style="background: #00C0EF;color:#fff" title="Tution Fees Acknowledgement  <?php echo $students['acedmicyear']; ?>" target="_blank" href="<?php echo SITE_URL; ?>admin/report/feeacknowledgement/<?php echo $students['id']; ?>/<?php echo $students['acedmicyear']; ?>"> Fee Acnowledgement <?php echo $students['acedmicyear']; ?></a>
               </li>
            <?php }
            if ($db['is_transport'] == 'N') {
            ?>
               <li id="personal-tab">
                  <a style="background: #00C0EF;color:#fff" id="" class="" href="<?php echo SITE_URL; ?>admin/studentfees/is_transport/<? echo $students['id']; ?>" data-target="#globalModal" data-toggle="modal" data-modal-size="modal-lg">
                     <i class="fa fa-plus"></i>Is Transport</a>
               </li>
            <?php } ?>
         </ul>
         Take Fee
      </h1>
      <!------------------------------------------------- For Loader CSS------------------------------------>
   </section>
   <!------------------------------------------------- For Loader Script------------------------------------>
   <script>
      document.onreadystatechange = function() {
         var state = document.readyState
         if (state == 'complete') {
            document.getElementById('interactive');
            document.getElementById('load').style.visibility = "hidden";
         }
      }
   </script>
   <!------------------------------------------------- For Caution Money Script------------------------------------>
   <script type="text/javascript">
      $(function() {

         window.checkpaper = function(sid, id, discount, dat) {

            $("#loader").show();
            //   alert(id)
            if ($('.lnm:checked').length == '4') {
               $('#fulldiscount').css("display", "inline-block");
            }

            if ($('.lnm:not(:checked)').length == '1') {
               $("#fulldiscount").prop('checked', false);
               $('#fulldiscount').css("display", "none");
            }

            $('.quatyid').prop('disabled', true);
            $('.tamount').text('0');
            $('.newamnt').text('0');
            $('.discnt').text('0');
            $('.newamnts').val('0');
            $('#sum1').html('0');
            $('#dueextras').val('0');
            $('#lfines').val('0');

            $('#otherfeeamts').val('0');
            $('.after-add-more').html('');
            $('.afdiscount').val('0');
            var discount = $("#chkdiscountcateg option:selected").val();
            var ck = 'chk' + sid + '-' + id;
            var cks = 's' + sid + '-' + id;
            var id1 = 'pd' + sid + id;
            var chkbox = document.getElementById(ck);
            var selec = $("#" + ck).attr('class');
            if (sid == 1) {

               $('input[id^="s1-"]').prop('disabled', false);

               $('input[id^="chk1-"]').prop('disabled', false);

            } else if (sid == 41) {
               $('input[id^="s41-"]').prop('disabled', false);

               $('input[id^="chk41-"]').prop('disabled', false);
            } else if (sid == 2) {

               $('input[id^="s2-"]').prop('disabled', false);

               $('input[id^="chk2-"]').prop('disabled', false);

            } else if (sid == 3) {

               $('input[id^="s3-"]').prop('disabled', false);

               $('input[id^="chk3-"]').prop('disabled', false);

            } else if (sid == 4) {

               $('input[id^="s4-"]').prop('disabled', false);

               $('input[id^="chk4-"]').prop('disabled', false);

            }

            if (chkbox.checked) {

               $('.news').prop('checked', false);
               $('.news').prop('disabled', true);
               $('.StuAttendCk').prop('checked', false);
               $('.StuAttendCk').prop('disabled', true);
               $('#chkdiscountcateg').prop('selectedIndex', 0);
               $('#chkotherfee').prop('selectedIndex', 0);
               $('#chkotherfee').prop('disabled', true);
               $('.StuAttendCkrg').prop('disabled', true);
               $('.StuAttendCkrg').prop('checked', false);
               $('#chkdiscountcateg').prop('disabled', true);

               $.ajax({
                  type: 'POST',
                  url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
                  data: {
                     'pos': dat
                  },
                  beforeSend: function(xhr) {
                     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                  },
                  success: function(data) {
                     var pluss = parseInt($('#lfines').val()) + parseInt(data);
                     $('#lfines').val(pluss);
                     $(".addgen").css("display", "block");
                     if (discount > 0) {
                        var idf = id;
                        idf = parseInt($('.tamount').text()) + parseInt(idf);
                        $('.tamount').text(idf);
                        var newamount = idf;
                        $('.newamnt').text(newamount);
                        var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                        $('.newamnts').val(cat);
                        $('.afdiscount').val(newamount);

                     } else {
                        var idf = id;
                        idf = parseInt($('.tamount').text()) + parseInt(idf);
                        $('.tamount').text(idf);
                        var newamount = idf;
                        $('.newamnt').text(idf);
                        var cat = parseInt($('#lfines').val()) + parseInt(idf);
                        $('.newamnts').val(cat);

                        $('.afdiscount').val(idf);
                     }
                     document.getElementById(cks).disabled = false;
                  },

               });
            } else {
               $('.news').prop('disabled', false);
               $('.StuAttendCk').prop('disabled', false);
               $('#chkdiscountcateg').prop('disabled', false);
               $('#chkotherfee').prop('disabled', false);
               $('.StuAttendCkrg').prop('disabled', false);

               $.ajax({
                  type: 'POST',
                  url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
                  data: {
                     'pos': dat
                  },
                  beforeSend: function(xhr) {
                     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                  },
                  success: function(data) {

                     var pluss = parseInt($('#lfines').val()) - parseInt(data);

                     $('#lfines').val(pluss);

                     if ($('.news').length == $('.news:checked').length) {

                     } else {

                     }
                     var idf = '0';
                     $('.tamount').text(idf);
                     if (discount > 0) {
                        var newamount = 0;
                        $('.newamnt').text(newamount);
                        var cat = parseInt(newamount);
                        $('.newamnts').val(cat);
                        $('.afdiscount').val(newamount);
                        if (newamount == '0') {
                           $('.discnt').text('0');

                        }
                     } else {
                        var idsf = '0';
                        $('.newamnt').text(idsf);
                        var cat = parseInt(idsf);
                        $('.newamnts').val(cat);
                        $('.afdiscount').val(cat);
                        if (idsf == '0') {
                           $('.discnt').text('0');

                        }

                     }
                     document.getElementById(cks).disabled = true;

                  },

               });
            }

            if ($('.news').length == $('.news:checked').length) {

            } else {

            }
            if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
               $('.check-all').prop('checked', true);

            } else {}
         };
      });
   </script>
   <!------------------------------------------------- For General Fee Script------------------------------------>
   <script type="text/javascript">
      $(function() {
         $('.check-all').click(function() {
            $('#sum1').html('0');
            $('#dueextras').val('0');
            if (this.checked) {
               $('input:checkbox[id^="chk"]').trigger("click");
               $(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
               $(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
               $(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);
            } else {
               $('.tamount').text('0');
               $('.newamnt').text('0');
               $('.newamnts').val('0');
               $('.afdiscount').val('0');
               $('.discnt').text('0' + '%');
               $(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
               $(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
               $(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
            }
         });

         $('.remove_special').click(function() {
            $("#recipitno").val('0');
            $(this).closest('td').find("input[type=text]").val('0');
            $(".addgen").css("display", "block");
            var ids = $(this).closest('td').find("input[type=text]").attr('id');
            if (ids == "amoun2") {
               if ($("#" + ids).closest('tr').find('td:first').find('.StuAttendCks').prop('checked') == true) {
                  $("#" + ids).closest('tr').find('td:first').find('.StuAttendCks').trigger("click");
               }

               $("#" + ids).closest('tr').find('td:first').find('.StuAttendCks').val('0');
               var id = $("#" + ids).closest('tr').find('td:first').find('.StuAttendCks').val();
               var idf = parseInt($('.tamount').text()) + parseInt(id);
               $("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());
               $('#chkdiscountcateg').prop('selectedIndex', 0);
               $('.discnt').html('0');
               $('#fees_discount').val('0');
               $("#" + ids).closest('tr').find('td:first').find('.StuAttendCks').prop('checked', true);
               $("#" + ids).closest('tr').hide();
               $('.StuAttendCks').prop('disabled', false);
               setTimeout(function() {
                  $("#" + ids).closest('tr').find('td:eq(1)').find('.quatyid').prop('disabled', false);
               }, 2000);
            } else {
               if ($("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').prop('checked') == true) {
                  $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').trigger("click");
               }
               $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').val('0');
               var id = $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').val();

               var idf = parseInt($('.tamount').text()) + parseInt(id);
               $("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());
               $('#chkdiscountcateg').prop('selectedIndex', 0);
               $('.discnt').html('0');
               $('#fees_discount').val('0');

               $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').prop('checked', true);
               $("#" + ids).closest('tr').hide();

               setTimeout(function() {
                  $("#" + ids).closest('tr').find('td:eq(1)').find('.quatyid').prop('disabled', false);

               }, 2000);
            }
         });

         $('.check-alls').click(function() {
            $('#sum1').html('0');
            $('#dueextras').val('0');
            $('.remove_special').css('display', 'inline-block');
            $('#chkdiscountcateg').prop('disabled', false);
            $('#chkotherfee').prop('disabled', false);
            $('.StuAttendCkrg').prop('disabled', false);
            $("#fulldiscount").prop('checked', false);
            $('#additionaldis').val('0');
            $('.StuAttendCkrg').prop('disabled', false);
            $('#chkotherfee').prop('disabled', false);
            $('.amounedit').prop('readonly', true);
            if (this.checked) {
               if ($('.StuAttendCks').prop('checked') == true) {
                  var remamt = parseInt($('.tamount').text()) - parseInt($('.cautionedit').val());
                  $('.tamount').text(remamt);

               }
               var totlamto = $('.tamount').text();
               $('.newamnt').text(totlamto);
               $('.newamnts').val(totlamto);
               $('.discnt').text('0');
               $('#fees_discount').val('0');

               $("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());
               $('#chkdiscountcateg').prop('selectedIndex', 0);
               $('.amounedit').prop('readonly', false);
               var dat = '0';
               var sum = 0;
               $(".discnt").html('0');

               $('.StuAttendCk').prop('disabled', false);
               $('.news').prop('disabled', false);
               $('.paper').prop('checked', false);
               $('.paper').prop('required', false);


            } else {

               location.reload();
            }

         });
         $(".amounedit").on("keyup", function() {

            var ids = this.id;
            if ($('.check-alls').prop('checked') == true) {
               $("#loader").show();
               calculateSumks(ids);

            }
         });

         function calculateSumks(ids) {
            var sumks = 0;

            $('#chkdiscountcateg').prop('disabled', false);
            $("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());
            $('#chkdiscountcateg').prop('selectedIndex', 0);
            $("#" + ids).each(function() {

               if (isNaN(this.value) || this.value < 0) {

                  this.value = '0';
               } else if (!isNaN(this.value) && this.value.length != 0) {


                  sumks += parseFloat(this.value);

               } else if (this.value.length != 0) {

               }
            });

            if (sumks == '') {

               $("#" + ids).val('0');

            }

            if ($("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').prop('checked') == true) {
               $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').trigger("click");
            }

            $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').val(sumks);
            var id = $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').val();
            $(".addgen").css("display", "block");
            var idf = parseInt($('.tamount').text()) + parseInt(id);
            $("#" + ids).closest('tr').find('td:first').find('.StuAttendCk').prop('checked', true);
            $('.tamount').text(idf);
            $('.newamnt').text(idf);
            $('.newamnts').val(idf);
            $('.afdiscount').val(idf);
            $('.discnt').html('0');
            $('#fees_discount').val('0');

            setTimeout(function() {
               $("#" + ids).closest('tr').find('td:eq(1)').find('.quatyid').prop('disabled', false);
               $("#loader").hide();
            }, 2000);
         }

         window.check = function(sid, id, discount, dat) {

            if ($('.lnm:checked').length == '4') {
               $('#fulldiscount').css("display", "inline-block");

            }

            // if($('.lnm:not(:checked)').length=='1'){

            // }

            if ($('.lnm:not(:checked)').length == '1') {
               $("#fulldiscount").prop('checked', false);
               $('#fulldiscount').css("display", "none");
            }
            $('#sum1').html('0');
            $('#dueextras').val('0');
            $('.news').prop('required', false);
            if ($(".check-alls").prop('checked') == true) {

            } else {

            }
            $('#chkotherfee').prop('disabled', false);
            $('.StuAttendCkrg').prop('disabled', false);

            var discount = $("#chkdiscountcateg option:selected").val();

            var ck = 'chk' + sid + '-' + id;
            // alert(ck)
            var cks = 's' + sid + '-' + id;
            var id1 = 'pd' + sid + id;
            var chkbox = document.getElementById(ck);
            var selec = $("#" + ck).attr('class');
            var isd = $("#" + ck).val();
            var id = isd;

            if (sid == 1) {

               $('input[id^="s1-"]').prop('disabled', false);

               $('input[id^="chk1-"]').prop('disabled', false);

            } else if (sid == 41) {

               $('input[id^="s41-"]').prop('disabled', false);
               $('input[id^="chk41-"]').prop('disabled', false);

            } else if (sid == 2) {

               $('input[id^="s2-"]').prop('disabled', false);

               $('input[id^="chk2-"]').prop('disabled', false);

            } else if (sid == 3) {

               $('input[id^="s3-"]').prop('disabled', false);

               $('input[id^="chk3-"]').prop('disabled', false);

            } else if (sid == 4) {

               $('input[id^="s4-"]').prop('disabled', false);

               $('input[id^="chk4-"]').prop('disabled', false);

            }

            var ih = $("#" + ck).closest('tr').find('td:last').find('.amoun').val();

            if (chkbox.checked) {
               $.ajax({
                  type: 'POST',
                  url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
                  data: {
                     'pos': dat
                  },
                  beforeSend: function(xhr) {
                     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                  },
                  success: function(data) {

                     var pluss = parseInt($('#lfines').val()) + parseInt(data);

                     $('#lfines').val(pluss);

                     $(".addgen").css("display", "block");

                     var idf = id;
                     idf = parseInt($('.tamount').text()) + parseInt(idf);

                     if (discount > 0) {

                        $('.tamount').text(idf);
                        var myselectedid = ck;
                        var vale = $('#' + ck).val();
                        var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                        var ffheads = $('#' + cleanUrl).val();
                        var selectedValue = discount;

                        $.ajax({
                           type: 'POST',
                           url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                           data: {
                              'ffheads': ffheads,
                              'sevalue': selectedValue,
                              'amty': vale
                           },
                           beforeSend: function(xhr) {
                              xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                           },
                           success: function(data) {

                              if (data > 0) {
                                 var toi = parseInt($('.tamount').text());
                                 var additionaldis = parseInt($('#additionaldis').val());
                                 var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);
                                 $('#fees_discount').val(fdiscou);
                                 var discounts = fdiscou;
                                 var newamount = toi - discounts;
                                 if (additionaldis != '0' && newamount >= additionaldis) {
                                    var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);
                                    $('#sum1').html('0');
                                    $('#dueextras').val('0');
                                 } else {
                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);
                                 }
                                 $('.afdiscount').val(newamount);
                                 $(".disfee").html(discounts);
                                 var discounts = discounts;
                                 $(".discnt").html(discounts);

                              } else {
                                 var toi = parseInt($('.tamount').text());
                                 var additionaldis = parseInt($('#additionaldis').val());
                                 var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);
                                 $('#fees_discount').val(fdiscou);
                                 var discounts = fdiscou;
                                 var newamount = toi - discounts;

                                 if (additionaldis != '0' && newamount >= additionaldis) {
                                    var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);
                                    $('#sum1').html('0');
                                    $('#dueextras').val('0');
                                 } else {
                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);
                                 }
                                 $('.afdiscount').val(newamount);
                                 $(".disfee").html(discounts);
                                 var discounts = discounts;
                                 $(".discnt").html(discounts);
                              }
                           },
                        });


                     } else {
                        var idf = id;
                        idf = parseInt($('.tamount').text()) + parseInt(idf);
                        $('.tamount').text(idf);
                        var newamount = idf;
                        $('.newamnt').text(idf);
                        var cat = parseInt($('#lfines').val()) + parseInt(idf);

                        $('.newamnts').val(cat);

                        $('.afdiscount').val(idf);
                     }

                     document.getElementById(cks).disabled = false;

                     if (selec == "StuAttendCk imp news") {

                        if (sid == '41') {

                           $('input[id^="s41-"]').prop('disabled', false);
                           var dev = $('input[id^="chk41-"]').val();
                           var toi = parseInt($('.tamount').text()) + parseInt(dev);
                           $('.tamount').text(toi);
                           if (discount > 0) {
                              $('.tamount').text(toi);
                              var myselectedid = ck;
                              var vale = $('#' + ck).val();
                              var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                              var ffheads = $('#' + cleanUrl).val();
                              var selectedValue = discount;

                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                 data: {
                                    'ffheads': ffheads,
                                    'sevalue': selectedValue,
                                    'amty': vale
                                 },
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                 },
                                 success: function(data) {

                                    if (data > 0) {

                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());

                                       var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);
                                       $('#fees_discount').val(fdiscou);
                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);

                                    } else {
                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());

                                       var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

                                       $('#fees_discount').val(fdiscou);

                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;


                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);

                                    }
                                 },
                              });

                           } else {
                              $('.tamount').text(toi);
                              $('.newamnt').text(toi);
                              var cat = parseInt($('#lfines').val()) + parseInt(toi);
                              $('.newamnts').val(cat);
                              $('.afdiscount').val(toi);

                           }
                        } else if (sid == '31') {
                           $('input[id^="s31-"]').prop('disabled', false);
                           var dev = $('input[id^="chk31-"]').val();
                           var toi = parseInt($('.tamount').text()) + parseInt(dev);

                           if (discount > 0) {

                              $('.tamount').text(toi);
                              var myselectedid = ck;
                              var vale = $('#' + ck).val();
                              var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                              var ffheads = $('#' + cleanUrl).val();
                              var selectedValue = discount;

                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                 data: {
                                    'ffheads': ffheads,
                                    'sevalue': selectedValue,
                                    'amty': vale
                                 },
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                 },
                                 success: function(data) {
                                    if (data > 0) {
                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());
                                       var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);
                                       $('#fees_discount').val(fdiscou);
                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);

                                    } else {
                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());
                                       var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);
                                       $('#fees_discount').val(fdiscou);
                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);

                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);

                                    }
                                 },
                              });
                           } else {
                              $('.tamount').text(toi);
                              $('.newamnt').text(toi);
                              var cat = parseInt($('#lfines').val()) + parseInt(toi);
                              $('.newamnts').val(cat);
                              $('.afdiscount').val(toi);
                           }
                        }
                     }



                  },

               });


               var clsid = '<?php echo $students['class_id']; ?>';
               if (sid == 1 || sid == 2 || sid == 3 || sid == 4) {
                  if (clsid == 12 || clsid == 13 || clsid == 15 || clsid == 17 || clsid == 20 || clsid == 22 || clsid == 26 || clsid == 27) {

                     //$('#sum1').html('0');
                     //$('#dueextras').val('0');
                     //	$('.practica').hide();
                     $('select option[value="5"]').attr("selected", true);
                     $("#otherfeeamts").attr("readonly", false);

                     var opt = '5';

                     if (opt == '') {
                        $("#otherfeeamts").attr("readonly", true);
                     }
                     if (opt == '1') {

                        $("#formnos1").css("display", "inline-block");
                        $("#formnos1").css("width", "100%");
                        document.getElementById("formnos").required = true;

                     } else {
                        $("#formnos1").css("display", "none");
                        $("#formnos1").css("width", "100%");
                        document.getElementById("formnos").required = false;

                     }
                     var boardst = '<? echo $students['board_id']; ?>';
                     $(".addgen").css("display", "block");
                     $(".addgen23").css("display", "none");

                     $.ajax({
                        type: 'POST',
                        url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                        data: {
                           'opt': opt,
                           'boardst': boardst
                        },
                        beforeSend: function(xhr) {
                           xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                        },
                        success: function(data) {

                           var discount = $("#chkdiscountcateg option:selected").val();
                           if (discount > 0) {
                              if (opt == '5') {
                                 $('.practica').show();
                                 var ssum = 0;
                                 $('.practicald').each(function() {

                                    if ($(this).attr('checked')) {
                                       ssum += parseInt($(this).val());

                                    }
                                 });

                                 data = ssum;

                                 data = parseInt($('#otherfeeamts').val()) + parseInt(data);
                              }
                              if ($('#otherfeeamts').val() != '0') {

                                 var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

                              } else {

                                 var idf = parseInt($('.tamount').text()) + parseInt(data);
                              }


                              if ($('#otherfeeamts').val() != '0') {

                                 var newamntdf = parseInt($('.newamnt').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

                              } else {

                                 var newamntdf = parseInt($('.newamnt').text()) + parseInt(data);
                              }

                              $('#otherfeeamts').val(data);
                              $('.tamount').text(idf);
                              $('.newamnt').text(newamntdf);
                              var cat = parseInt($('#lfines').val()) + parseInt(newamntdf);
                              $('.newamnts').val(cat);
                              $('.afdiscount').val(newamntdf);
                              //$('#sum1').html('0');
                              $('#dueextras').val('0');
                              var vale = $('#otherfeeamts').val();
                              var selectedValue = discount;
                              var ffheads = opt;

                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                 data: {
                                    'ffheads': ffheads,
                                    'sevalue': selectedValue,
                                    'amty': vale
                                 },
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                 },
                                 success: function(data) {
                                    if (data > 0) {

                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());

                                       var fdiscou = parseFloat(data);

                                       $('#fees_discount').val(fdiscou);
                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                          //	$('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);

                                    } else {

                                       $('#additionaldis').val('0');

                                    }
                                 },
                              });

                           } else {

                              if (opt == '5') {

                                 $('.practica').show();
                                 var ssum = 0;
                                 $('.practicald').each(function() {

                                    if ($(this).attr('checked')) {
                                       ssum += parseInt($(this).val()); // Or this.innerHTML, this.innerText

                                    }
                                 });

                                 data = ssum;
                                 data = parseInt($('#otherfeeamts').val()) + parseInt(data);

                              }

                              if ($('#otherfeeamts').val() != '0') {

                                 var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

                              } else {

                                 var idf = parseInt($('.tamount').text()) + parseInt(data);
                              }

                              $('#otherfeeamts').val(data);

                              $('.tamount').text(idf);

                              var additionaldis = parseInt($('#additionaldis').val());
                              var newamount = idf;

                              if (additionaldis != '0' && newamount >= additionaldis) {
                                 var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                 //$('.newamnt').text(newamount);
                                 $('.newamnt').text(newamount);
                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                 $('.newamnts').val(cat);
                                 //$('#depositamt').val(newamounts);
                                 //	$('#sum1').html('0');
                                 $('#dueextras').val('0');
                                 $('.afdiscount').val(newamount);

                              } else {
                                 $('.newamnt').text(newamount);
                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                 $('.newamnts').val(cat);
                                 //$('#depositamt').val(newamount);
                                 $('.afdiscount').val(newamount);

                              }

                           }
                        },
                     });

                  }
               }

            } else {
               var id = isd;
               $.ajax({
                  type: 'POST',
                  url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
                  data: {
                     'pos': dat
                  },
                  beforeSend: function(xhr) {
                     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                  },
                  success: function(data) {

                     var pluss = parseInt($('#lfines').val()) - parseInt(data);
                     $('#lfines').val(pluss);
                     if ($('.news').length == $('.news:checked').length) {} else {}
                     var idf = $('.tamount').text() - id;
                     $('.tamount').text(idf);
                     if (discount > 0) {
                        var myselectedid = ck;
                        var vale = $('#' + ck).val();
                        var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                        var ffheads = $('#' + cleanUrl).val();
                        var selectedValue = discount;

                        $.ajax({
                           type: 'POST',
                           url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                           data: {
                              'ffheads': ffheads,
                              'sevalue': selectedValue,
                              'amty': vale
                           },
                           beforeSend: function(xhr) {
                              xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                           },
                           success: function(data) {
                              if (data > 0) {
                                 var toi = parseInt($('.tamount').text());
                                 var additionaldis = parseInt($('#additionaldis').val());
                                 var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);
                                 $('#fees_discount').val(fdiscou);

                                 var discounts = fdiscou;
                                 var newamount = toi - discounts;
                                 if (additionaldis != '0' && newamount >= additionaldis) {
                                    var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);

                                    $('#sum1').html('0');
                                    $('#dueextras').val('0');
                                 } else {
                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);
                                 }
                                 $('.afdiscount').val(newamount);
                                 $(".disfee").html(discounts);
                                 var discounts = discounts;
                                 $(".discnt").html(discounts);

                              } else {
                                 var toi = parseInt($('.tamount').text());
                                 var additionaldis = parseInt($('#additionaldis').val());
                                 var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);
                                 $('#fees_discount').val(fdiscou);
                                 var discounts = fdiscou;
                                 var newamount = toi - discounts;
                                 if (additionaldis != '0' && newamount >= additionaldis) {
                                    var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);
                                    $('#sum1').html('0');
                                    $('#dueextras').val('0');
                                 } else {
                                    $('.newamnt').text(newamount);
                                    var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                    $('.newamnts').val(cat);
                                 }
                                 $('.afdiscount').val(newamount);
                                 $(".disfee").html(discounts);
                                 var discounts = discounts;
                                 $(".discnt").html(discounts);
                              }
                           },
                        });
                     } else {
                        var idsf = $('.newamnt').text() - id;
                        $('.newamnt').text(idsf);
                        var cat = parseInt($('#lfines').val()) + parseInt(idsf);
                        $('.newamnts').val(cat);
                        $('.afdiscount').val(cat);
                        if (idsf == '0') {
                           $('.discnt').text('0');
                        }

                     }
                     if (selec == "StuAttendCk imp news") {
                        if (sid == '41') {
                           $('input[id^="s41-"]').prop('disabled', true);
                           var dev = $('input[id^="chk41-"]').val();
                           var toi = parseInt($('.tamount').text()) - parseInt(dev);

                           if (discount > 0) {
                              $('.tamount').text(toi);
                              var myselectedid = ck;
                              var vale = $('#' + ck).val();
                              var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                              var ffheads = $('#' + cleanUrl).val();
                              var selectedValue = discount;

                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                 data: {
                                    'ffheads': ffheads,
                                    'sevalue': selectedValue,
                                    'amty': vale
                                 },
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                 },
                                 success: function(data) {
                                    if (data > 0) {
                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());
                                       var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);
                                       $('#fees_discount').val(fdiscou);
                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);

                                    } else {
                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());
                                       var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);
                                       $('#fees_discount').val(fdiscou);

                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);
                                    }
                                 },
                              });
                           } else {
                              $('.tamount').text(toi);
                              $('.newamnt').text(toi);
                              var cat = parseInt($('#lfines').val()) + parseInt(toi);
                              $('.newamnts').val(cat);
                              $('.afdiscount').val(toi);
                           }
                        } else if (sid == '31') {
                           $('input[id^="s31-"]').prop('disabled', true);
                           var dev = $('input[id^="chk31-"]').val();
                           var toi = parseInt($('.tamount').text()) - parseInt(dev);
                           if (discount > 0) {
                              $('.tamount').text(toi);
                              var myselectedid = ck;
                              var vale = $('#' + ck).val();
                              var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                              var ffheads = $('#' + cleanUrl).val();
                              var selectedValue = discount;

                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                 data: {
                                    'ffheads': ffheads,
                                    'sevalue': selectedValue,
                                    'amty': vale
                                 },
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                 },
                                 success: function(data) {
                                    if (data > 0) {
                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());
                                       var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);
                                       $('#fees_discount').val(fdiscou);

                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);

                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);
                                    } else {

                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());
                                       var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);
                                       $('#fees_discount').val(fdiscou);
                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);

                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);
                                    }
                                 },
                              });
                           } else {
                              $('.tamount').text(toi);
                              $('.newamnt').text(toi);
                              var cat = parseInt($('#lfines').val()) + parseInt(toi);
                              $('.newamnts').val(cat);
                              $('.afdiscount').val(toi);


                           }
                        }
                     }
                     document.getElementById(cks).disabled = true;
                  },

               });



               var clsid = '<?php echo $students['class_id']; ?>';
               if (sid == 1 || sid == 2 || sid == 3 || sid == 4) {
                  if (clsid == 12 || clsid == 13 || clsid == 15 || clsid == 17 || clsid == 20 || clsid == 22 || clsid == 26 || clsid == 27) {


                     $('select option[value="5"]').attr("selected", true);
                     $("#otherfeeamts").attr("readonly", false);

                     var opt = '5';

                     if (opt == '') {
                        $("#otherfeeamts").attr("readonly", true);
                     }
                     if (opt == '1') {

                        $("#formnos1").css("display", "inline-block");
                        $("#formnos1").css("width", "100%");
                        document.getElementById("formnos").required = true;

                     } else {
                        $("#formnos1").css("display", "none");
                        $("#formnos1").css("width", "100%");
                        document.getElementById("formnos").required = false;

                     }
                     var boardst = '<? echo $students['board_id']; ?>';
                     $(".addgen").css("display", "block");
                     $(".addgen23").css("display", "none");

                     $.ajax({
                        type: 'POST',
                        url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                        data: {
                           'opt': opt,
                           'boardst': boardst
                        },
                        beforeSend: function(xhr) {
                           xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                        },
                        success: function(data) {

                           var discount = $("#chkdiscountcateg option:selected").val();
                           if (discount > 0) {
                              if (opt == '5') {
                                 $('.practica').show();
                                 var ssum = 0;
                                 $('.practicald').each(function() {

                                    if ($(this).attr('checked')) {
                                       ssum += parseInt($(this).val());

                                    }
                                 });

                                 data = ssum;

                              }
                              if ($('#otherfeeamts').val() != '0' && data != 0) {
                                 if ($('.tamount').text() != '0') {
                                    var idf = parseInt($('.tamount').text()) - parseInt(data);
                                 }
                              } else if (data != 0) {
                                 if ($('.tamount').text() != '0') {
                                    var idf = parseInt($('.tamount').text()) - parseInt(data);
                                 }
                              }


                              if ($('#otherfeeamts').val() != '0') {
                                 if ($('.newamnt').text() != '0') {
                                    var newamntdf = parseInt($('.newamnt').text()) - parseInt(data);
                                 }

                              } else {
                                 if ($('.newamnt').text() != '0') {
                                    var newamntdf = parseInt($('.newamnt').text()) - parseInt(data);
                                 }
                              }
                              if ($('#otherfeeamts').val() != '0') {
                                 data = parseInt($('#otherfeeamts').val()) - parseInt(data);
                                 $('#otherfeeamts').val(data);
                              }

                              $('.tamount').text(idf);
                              $('.newamnt').text(newamntdf);
                              var cat = parseInt($('#lfines').val()) + parseInt(newamntdf);
                              $('.newamnts').val(cat);
                              $('.afdiscount').val(newamntdf);
                              //$('#sum1').html('0');
                              $('#dueextras').val('0');
                              var vale = $('#otherfeeamts').val();
                              var selectedValue = discount;
                              var ffheads = opt;

                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                 data: {
                                    'ffheads': ffheads,
                                    'sevalue': selectedValue,
                                    'amty': vale
                                 },
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                 },
                                 success: function(data) {
                                    if (data > 0) {

                                       var toi = parseInt($('.tamount').text());
                                       var additionaldis = parseInt($('#additionaldis').val());
                                       var fdiscou = parseFloat(data);

                                       $('#fees_discount').val(fdiscou);
                                       var discounts = fdiscou;
                                       var newamount = toi - discounts;
                                       if (additionaldis != '0' && newamount >= additionaldis) {
                                          var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                          //	$('#sum1').html('0');
                                          $('#dueextras').val('0');
                                       } else {
                                          $('.newamnt').text(newamount);
                                          var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                          $('.newamnts').val(cat);
                                       }
                                       $('.afdiscount').val(newamount);
                                       $(".disfee").html(discounts);
                                       var discounts = discounts;
                                       $(".discnt").html(discounts);

                                    } else {

                                       $('#additionaldis').val('0');

                                    }
                                 },
                              });

                           } else {

                              if (opt == '5') {

                                 $('.practica').show();
                                 var ssum = 0;
                                 $('.practicald').each(function() {

                                    if ($(this).attr('checked')) {
                                       ssum += parseInt($(this).val()); // Or this.innerHTML, this.innerText

                                    }
                                 });

                                 data = ssum;


                              }
                              if ($('#otherfeeamts').val() != '0' && data != 0) {
                                 if ($('.tamount').text() != '0') {
                                    var idf = parseInt($('.tamount').text()) - parseInt(data);
                                 }
                              } else if (data != 0) {
                                 if ($('.tamount').text() != '0') {
                                    var idf = parseInt($('.tamount').text()) - parseInt(data);
                                 }
                              }


                              if ($('#otherfeeamts').val() != '0') {
                                 if ($('.newamnt').text() != '0') {
                                    var newamntdf = parseInt($('.newamnt').text()) - parseInt(data);
                                 }

                              } else {
                                 if ($('.newamnt').text() != '0') {
                                    var newamntdf = parseInt($('.newamnt').text()) - parseInt(data);
                                 }
                              }
                              if ($('#otherfeeamts').val() != '0') {
                                 data = parseInt($('#otherfeeamts').val()) - parseInt(data);
                                 $('#otherfeeamts').val(data);
                              }
                              $('.tamount').text(idf);

                              var additionaldis = parseInt($('#additionaldis').val());
                              var newamount = idf;

                              if (additionaldis != '0' && newamount >= additionaldis) {
                                 var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                 //$('.newamnt').text(newamount);
                                 $('.newamnt').text(newamount);
                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                 $('.newamnts').val(cat);
                                 //$('#depositamt').val(newamounts);
                                 //	$('#sum1').html('0');
                                 $('#dueextras').val('0');
                                 $('.afdiscount').val(newamount);

                              } else {
                                 $('.newamnt').text(newamount);
                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                 $('.newamnts').val(cat);
                                 //$('#depositamt').val(newamount);
                                 $('.afdiscount').val(newamount);

                              }

                           }
                        },
                     });

                  }
               }



            }
            if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
               $('.check-all').prop('checked', true);

            } else {
               $('.check-all').prop('checked', false);
            }
         };

      });
   </script>
   <!----------------------------------------For Mode SelectionScript----------------------------------------->
   <script type="text/javascript">
      $(function() {

         window.checks = function(id) {
            //    alert('Hello');


            var doc = $('input[name="mode"]:checked').val();
            if (doc == "CASH") {
               $("#che").css("display", "none");
               $("#ref").hide();
               $("#bnk").css("display", "none");

               document.getElementById('chequno').required = false;
               document.getElementById('bank').required = false;
               document.getElementById('refno').required = false;


            } else if (doc == "CHEQUE") {

               $("#che").show();
               $("#ref").hide();
               $("#bnk").show();
               var lastchequ = '<? echo $student_datasmaxssss; ?>';
               $("#chequno").val(lastchequ);
               var lastbank = '<? echo $student_databank; ?>';
               $("#bank").val(lastbank);
               document.getElementById('chequno').required = true;
               document.getElementById('bank').required = true;
               document.getElementById('refno').required = false;

            } else if (doc == "DD") {

               $("#che").show();

               $("#ref").hide();
               $("#bnk").show();
               var lastchequ = '<? echo $student_datasmaxssss; ?>';
               $("#chequno").val(lastchequ);
               var lastbank = '<? echo $student_databank; ?>';
               $("#bank").val(lastbank);
               document.getElementById('chequno').required = true;
               document.getElementById('bank').required = true;
               document.getElementById('refno').required = false;

            } else if (doc == "NETBANKING") {

               $("#ref").show();
               $("#che").hide();
               var lastref = '<? echo $student_datasmref_no; ?>';
               $("#bnk").hide();
               $("#refno").val(lastref);
               document.getElementById('chequno').required = false;
               document.getElementById('refno').required = true;
               document.getElementById('bank').required = false;

            } else if (doc == "Credit Card/Debit Card/UPI") {

               $("#ref").show();

               $("#che").hide();
               $("#bnk").hide();
               var lastref = '<? echo $student_datasmref_no; ?>';
               $("#refno").val(lastref);
               document.getElementById('chequno').required = false;
               document.getElementById('refno').required = true;
               document.getElementById('bank').required = false;

            } else {

               $("#che").show();
               $("#bnk").show();

               document.getElementById('chequno').required = true;
               document.getElementById('bank').required = true;

            }

         }

         $('.stuattendance-sa_date').datepicker({

            maxDate: 0,
            changeMonth: true,
            dateFormat: 'dd-mm-yy',
            onSelect: function() {
               $('#stud-attendance-form').submit();
            }
         });
         $('.stuattendance-sa_date1').datepicker({

            maxDate: 0,
            changeMonth: true,
            dateFormat: 'dd-mm-yy',
            onSelect: function() {
               $('#stud-attendance-form').submit();
            }
         });
         $('.stuattendance-sa_date2').datepicker({

            maxDate: 0,
            changeMonth: true,
            dateFormat: 'dd-mm-yy',
            onSelect: function() {
               $('#stud-attendance-form').submit();
            }
         });

      });
   </script>
   <?php if ($selectid) { ?>
      <script>
         var id = '<?php echo $selectid; ?>';
         $(document).ready(function() {

            $('#personal-tab').removeClass('active');
            $('.tab-pane').removeClass('active');
            $('#' + id + '-tab').addClass('active');
            $('#' + id).addClass('active');

         });
      </script>
   <?php } ?>
   <!----------------------------------------------------- For Pending Fee Take Script------------------------------------->
   <script type="text/javascript">
      $(function() {
         window.checkpending = function(sid, id, discount) {
            $('#sum1').html('0');
            $('#dueextras').val('0');

            var discount = $("#fees_discount").val();
            var ck = 'chk' + sid + '-' + id;
            var cks = 's' + sid + '-' + id;
            var id1 = 'pd' + sid + id;
            var chkbox = document.getElementById(ck);
            var selec = $("#" + ck).attr('class');
            $(".addgen").css("display", "block");
            if (chkbox.checked) {
               $(".addgen").css("display", "block");
               if (discount > 0) {
                  var idf = id;

                  idf = parseInt($('.tamount').text()) + parseInt(idf);
                  $('.tamount').text(idf);

                  var newamount = idf - discount;
                  $('.newamnt').text(newamount);

                  var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                  $('.newamnts').val(cat);
                  $('.discnt').text(discount);
                  $('.afdiscount').val(newamount);

               } else {
                  var idf = id;
                  idf = parseInt($('.tamount').text()) + parseInt(idf);
                  $('.tamount').text(idf);
                  var newamount = idf;
                  $('.newamnt').text(idf);
                  var cat = parseInt($('#lfines').val()) + parseInt(idf);
                  $('.newamnts').val(cat);

                  $('.afdiscount').val(idf);
               }

               document.getElementById(cks).disabled = false;


            } else {

               if (discount > 0) {
                  var idf = parseInt($('.tamount').text()) - parseInt(id);

                  $('.tamount').text(idf);

                  var newamount = idf - discount;

                  $('.newamnt').text(newamount);

                  var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                  $('.newamnts').val(cat);
                  $('.afdiscount').val(newamount);
                  $('.discnt').text(discount);
                  if (newamount == '0') {
                     $('.discnt').text('0');

                  }

                  $('.afdiscount').val(newamount);
               } else {
                  var idsf = parseInt($('.tamount').text()) - parseInt(id);
                  $('.tamount').text(idsf);
                  $('.newamnt').text(idsf);
                  var cat = parseInt($('#lfines').val()) + parseInt(idsf);
                  $('.newamnts').val(cat);

                  if (idsf == '0') {
                     $('.discnt').text('0');

                  }
                  $('.afdiscount').val(idsf);

               }
               document.getElementById(cks).disabled = true;
               document.getElementById(id1).disabled = true;
               document.getElementById(id1).required = false;
            }

            if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
               $('.check-all').prop('checked', true);

            } else {
               $('.check-all').prop('checked', false);
            }
         };
      });
   </script>
   <!----------------------------------------- Main Content Start----------------------------------------------->
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-info">
               <div class="box-body">
                  <?php echo $this->Flash->render(); ?>
                  <div class="box box-solid">
                     <div class="box-header left-align text-xs-center">
                        <div class="user-block col-sm-12 no-padding">
                           <?php
                           if ($students['board_id'] == '1') {
                              $bordd = "";
                           } else if ($students['board_id'] == '2') {
                              $bordd = "CAM";
                           } else if ($students['board_id'] == '3') {

                              $bordd = "IB";
                           }


                           $filename = IMAGE_URL . $db['db'] . 'img/' . $students['file'];

                           $file_headers = @get_headers($filename);

                           if ($file_headers && strpos($file_headers[0], '200 OK')) { ?>
                              <img style="width: 85px; height: 85px; float: left; margin-top: -17px;" class="center-block img-circle img-thumbnail profile-img" src="<?php echo $filename; ?>" alt="No Image">
                           <?php } else { ?>
                              <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?>images/stu-image.png" alt="No Image">
                           <?php } ?>
                           <span class="username">
                              <a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>"><?php echo ucfirst($students['fname']); ?> <?php echo ucfirst($students['middlename']); ?> <?php echo ucfirst($students['lname']); ?></a> (<b style="color:green;"><?php echo $students['enroll']; ?></b>) <? if ($students['location_id']) { ?> <i class="fa fa-bus" href="<?php echo SITE_URL; ?>admin/studentfees/is_droptrans/<? echo $students['id']; ?>/<? echo $students['acedmicyear']; ?>" data-target="#globalModaldrop" data-toggle="modal" data-modal-size="modal-lg" aria-hidden="true"> </i> <? } ?></span>
                           <span class="description">
                              <strong>Class </strong> : <?php echo $students['class']['title']; ?> |
                              <strong>Section </strong> : <?php echo $students['section']['title']; ?> |
                              <!-- <strong>House </strong> : <?php $house = $this->Comman->findhouse($students['h_id']);
                                                               echo $house['name']; ?> | -->
                              <strong>Father Name </strong> : <?php echo $students['fathername']; ?> | <strong>Mobile No. : </strong> <?php echo $students['mobile']; ?> </span>
                           <div class="text-right">
                              <? $findpendings = $this->Comman->studentshistoryagain($students['id']);
                              $findenroll = $this->Comman->findri($students['oldenroll']);
                              $findpendings23 = $this->Comman->studentshistory($findenroll['id']);

                              if (!empty($findpendings)) {
                                 foreach ($findpendings as $kkt => $rtt) {  ?> <?php $abcObj = new \App\Controller\Admin\ReportController;
                                                               $fetchdetail = $abcObj->defaultersearchbyidhistory($rtt['stud_id'], $rtt['acedmicyear']);
                                                               if ($fetchdetail != '--') {  ?>
                                       <strong class="pull-right" style="color:red; margin-right: -135px;"> Pending Submit? <span class="text-black">₹ </span> <? echo $fetchdetail; ?></strong>
                                    <? } ?>
                                    &nbsp;<a href="<? echo ADMIN_URL; ?>studentfees/view/<? echo $rtt['stud_id']; ?>" class="btn btn-info pull-right" style="margin-left: 15px;"><? echo $rtt['acedmicyear']; ?> </a>&nbsp; <? }
                                                                                                                                                                                                                        } else if ($findpendings23['stud_id']) { ?>
                                 <a href="<? echo ADMIN_URL; ?>studentfees/view/<? echo $findpendings23['stud_id']; ?>" class="btn btn-info pull-right"> <? echo $findpendings23['acedmicyear']; ?> </a>
                                 <!-- &nbsp;<a href="<? //echo ADMIN_URL; 
                                                      ?>studentfees/history/<? //echo $rtt['stud_id']; 
                                    ?>/<? //echo $rtt['acedmicyear']; 
                  ?>" class="btn btn-info pull-right" style="margin-left: 15px;"><? //echo $rtt['acedmicyear']; 
                                                                              ?> </a>&nbsp; <? //} } else if ($findpendings23['stud_id']) { 
                              ?>
              <a href="<? //echo ADMIN_URL; 
                        ?>studentfees/history/<? //echo $findpendings23['stud_id']; 
                                       ?>/<? //echo $findpendings23['acedmicyear']; 
                     ?>" class="btn btn-info pull-right"> <? //echo $findpendings23['acedmicyear']; 
                                                      ?> </a>  -->
                              <? } ?>
                              <?php if ($students['due_fees'] !== NULL && $students['due_fees'] !== 0 && $this->request->session()->read('Auth.User.db') != "sanskar") { ?>
                                 <a href="javascript:void(0);" class="btn btn-info " style="color: #fff !important;font-weight: bold;"><?php echo "Previous Year Due- "; ?><span class="text-black">₹ </span><?php echo $students['due_fees']; ?><span style="color:red;">***</span> </a>
                              <?php } ?>
                           </div>
                           <!---------------------------------------------------- For RTE CSS----------------------------------->
                           <? if ($students['category'] == "RTE") { ?>
                              <style>
                                 #mytable2 {
                                    position: relative;
                                 }

                                 #mytable2::after {
                                    content: '';
                                    content: '';
                                    display: block;
                                    background-color: rgba(0, 0, 0, 0.5);
                                    position: absolute;
                                    left: 0px;
                                    right: 0px;
                                    bottom: 0px;
                                    top: 0px;
                                    z-index: 999;
                                 }
                              </style>
                              <span style="font-size:20px;color:red;float: right;font-weight: bold;">***RTE STUDENT***</span><? } ?>
                           <? if ($students['category'] == "Migration") { ?>
                              <style>
                                 #mytable2 {
                                    position: relative;
                                 }

                                 #mytable2::after {
                                    content: '';
                                    content: '';
                                    display: block;
                                    background-color: rgba(0, 0, 0, 0.5);
                                    position: absolute;
                                    left: 0px;
                                    right: 0px;
                                    bottom: 0px;
                                    top: 0px;
                                    z-index: 999;
                                 }
                              </style>
                              <span style="font-size:20px;color:red;float: right;font-weight: bold;">***Migrated STUDENT***</span><? } ?>
                        </div>
                     </div>
                     <section class="content">
                        <div class="row edusec-user-profile">
                           <div class="col-sm-12">
                              <?php if ($is_transport == '1') { ?>
                                 <!---------------------------------------------------- For Transport Enable -------------------------------------------------->
                                 <!--<ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="">
              <li id="guardians-tab"><a href="<?php //echo ADMIN_URL; 
                                                ?>studentfees/index/<?php //echo $id; 
                                    ?>/<?php //echo $academic_year; 
                     ?>?id=guardians" ><i class="fa fa-bed"></i> Transport Fee</a></li>
                    </ul>-->
                              <?php } ?>
                              <div id="content" class="tab-content responsive ">
                                 <!---------------------------------------------------- For Submit Form Script  -------------------------------------------------->
                                 <script type="text/javascript">
                                    $(document).ready(function() {
                                       $('#sevice_form').submit(function(event) {
                                          $('.addgen').hide();
                                          $('.addgen23').hide();
                                          if ($('#bankcharged').val()) {
                                             if (confirm("Do You Want To Cancel Receipt ?")) {
                                                $('input[name=hdfb]').val('1');
                                                $('input[name=hdfb]').val('2');
                                                return true;

                                             } else {
                                                $('input[name=hdfb]').val('2');

                                                return false;
                                             }

                                          } else {

                                             $('input[name=hdfb]').val('1');

                                          }


                                       });
                                    });
                                 </script>
                                 <!---------------------- For Deposit amount Edit Box Script---------------------->
                                 <script>
                                    $(document).ready(function() {

                                       calculateSum();

                                       $("#depositamt").on("keydown keyup", function() {
                                          calculateSum();
                                       });
                                    });

                                    function calculateSum() {
                                       var sum = 0;

                                       $("#depositamt").each(function() {
                                          if (!isNaN(this.value) && this.value.length != 0) {

                                             var newamount = $(".newamnt").text();
                                             if ($("#additionaldis").val() == '') {
                                                var additionaldis = $("#additionaldis").val('0');

                                             } else {

                                                var additionaldis = $("#additionaldis").val();
                                             }


                                             if ($("#lfines").val() == '') {
                                                var lfines = $("#lfines").val('0');

                                             } else {

                                                var lfines = $("#lfines").val();
                                             }
                                             var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                             var cat = parseInt(lfines) + parseInt(newamounts);

                                             sum += parseFloat(cat) - parseFloat(this.value);
                                             $(this).css("background-color", "#FEFFB0");
                                          } else if (this.value.length != 0) {
                                             $(this).css("background-color", "red");
                                          }
                                       });

                                       $("#dueextras").val(sum.toFixed(2));

                                       $("#sum1").html(sum.toFixed(2));

                                    }
                                 </script>
                                 <!--------------------------------------------- For Input type Allowed Number Script &&  Additonal Discount Script-------->
                                 <script>
                                    var myInput = document.querySelectorAll("input[type=number]");

                                    function keyAllowed(key) {
                                       var keys = [8, 9, 13, 16, 17, 18, 19, 20, 27, 46, 48, 49, 50,
                                          51, 52, 53, 54, 55, 56, 57, 91, 92, 93
                                       ];
                                       if (key && keys.indexOf(key) === -1)
                                          return false;
                                       else
                                          return true;
                                    }

                                    myInput.forEach(function(element) {
                                       element.addEventListener('keypress', function(e) {
                                          var key = !isNaN(e.charCode) ? e.charCode : e.keyCode;
                                          if (!keyAllowed(key))
                                             e.preventDefault();
                                       }, false);

                                       element.addEventListener('paste', function(e) {
                                          var pasteData = e.clipboardData.getData('text/plain');
                                          if (pasteData.match(/[^0-9]/))
                                             e.preventDefault();
                                       }, false);
                                    });
                                    $(function() {

                                       $(".StuAttendCk").on('change', function() {

                                          $("#fulldiscount").prop('checked', false);
                                          $('#additionaldis').val('0');


                                       });
                                       $(".news").change(function() {

                                          $("#fulldiscount").prop('checked', false);
                                          $('#additionaldis').val('0');


                                       });


                                       $("#lfines").on('blur', function() {
                                          if ($('#lfines').val() == '') {
                                             $('#lfines').val('0');
                                          }
                                          if ($('.newamnt').text() != '') {
                                             var totl = parseInt($('#lfines').val()) + parseInt($('.newamnt').text());




                                             var additionalamt = parseInt($('#additionaldis').val());
                                             if (totl >= additionalamt) {
                                                var totl = parseInt(totl) - parseInt(additionalamt);


                                             }

                                             $('#depositamt').val(totl);
                                             $('#sum1').html('0');
                                             $('#dueextras').val('0');

                                          }
                                       });

                                       $("#additionaldis").on('change', function() {
                                          if ($('#additionaldis').val() == '') {
                                             $('#additionaldis').val('0');
                                          }

                                          var depositamt = parseInt($('.newamnt').text());
                                          $('#sum1').html('0');
                                          $('#dueextras').val('0');
                                          var additionalamt = parseInt($('#additionaldis').val());


                                          if (additionalamt == '0') {
                                             var caa = $('.afdiscount').val();

                                             var totl = parseInt($('#lfines').val());


                                             caa = parseInt(caa) + parseInt(totl);


                                             $('#depositamt').val(caa);

                                          } else if (depositamt >= additionalamt) {
                                             var remain = parseInt(depositamt) - parseInt(additionalamt);

                                             var totl = parseInt($('#lfines').val());


                                             caa = parseInt(remain) + parseInt(totl);

                                             $('#depositamt').val(caa);

                                          }
                                       });


                                    });
                                 </script>
                                 <!-----------------------------Fee Deposit Form Start----------------------------------->
                                 <div class="tab-pane active" id="personal">
                                    <? if ($students['category'] != "") {  ?>
                                       <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/add">
                                          <input type="hidden" name="token" value=<?php echo uniqid(); ?>>
                                          <?php
                                          $quasu = array();
                                          foreach ($studentfees as $ku => $valueu) {
                                             $quasu[] = unserialize($valueu['quarter']);
                                          }

                                          $quafu = array();
                                          foreach ($quasu as $hu => $valeu) {

                                             $quafu = array_merge($quafu, $valeu);
                                          }
                                          $rtu = array();
                                          foreach ($quafu as $ju => $tu) {

                                             $quau[] = $ju;
                                          }
                                          if ($students['is_special'] == 'Y') {  ?>
                                             <!------------------- For Is Special Click --------------->
                                             <script>
                                                $(document).ready(function() {
                                                   $('.check-alls').trigger("click");

                                                });
                                             </script>
                                             <?php }
                                          // hide is special category from canvas all
                                          $dbname = $this->request->session()->read('Auth.User.db');
                                          $branch = explode("_", $dbname);

                                          if ($branch[0] != 'canvas') {

                                             if ($students['category'] != "RTE") { ?>
                                                <p class="text-left"><input type="checkbox" name="is_special" value="1" class="check-alls"><span style="font-size:20px;"> Is Special</span> </p>
                                          <? }
                                          } ?>
                                          <div class="row">
                                             <div class="col-lg-6">
                                                <? $def = 0;
                                                $quas = array();
                                                // pr($quarsgh);exit;

                                                if ($studentfees2s) {

                                                   foreach ($studentfees2s as $ks => $values) {
                                                      $quasw[] = unserialize($values['quarter']);
                                                   }

                                                   $quaflj = array();

                                                   foreach ($quasw as $hlj => $valelj) {

                                                      $quaflj = array_merge($quaflj, $valelj);
                                                   }
                                                   $rtlj = array();
                                                   foreach ($quaflj as $jlj => $tlj) {

                                                      if ($jlj == "Admission / Prosspectus" || $jlj == "Annual Charges" ||  $jlj == "Pocket Articles" || $jlj == "Books" || $jlj == "Pocket Articles" || $jlj == "Quater1" || $jlj == "Quater2" || $jlj == "Quater3" || $jlj == "Quate4" || $jlj == "Uniform" || $jlj == "Collage Caution Money (Refundable)" || $jlj == "Enrollment Fees" || $jlj == "Hostel Caution Money" || $jlj == "Transportation Fees") {
                                                         $qua[] = $jlj;
                                                      }
                                                   }
                                                }

                                                if ($quarsgh) {

                                                   foreach ($quarsgh as $th => $tt) {
                                                      $qua[] = $tt;
                                                   }
                                                }

                                                $quas2 = array();

                                                foreach ($studentfees as $k => $value) {
                                                   $quas[] = unserialize($value['quarter']);
                                                }

                                                foreach ($studentfees1 as $ks => $values) {
                                                   $quas2[] = unserialize($values['quarter']);
                                                }

                                                $quaf2s = array();

                                                foreach ($quas2 as $h2s => $vale2s) {

                                                   $quaf2s = array_merge($quaf2s, $vale2s);
                                                }

                                                $rt2s = array();
                                                foreach ($quaf2s as $j2s => $t2s) {
                                                   $qua2s[] = $j2s;
                                                }

                                                $quaf = array();

                                                foreach ($quas as $h => $vale) {

                                                   $quaf = array_merge($quaf, $vale);
                                                }

                                                $rt = array();
                                                foreach ($quaf as $j => $t) {

                                                   $qua[] = $j;
                                                }

                                                $quas2 = array();
                                                foreach ($studentfees2 as $k2 => $value2) {
                                                   $quas2[] = unserialize($value2['quarter']);
                                                }

                                                $quaf2 = array();

                                                foreach ($quas2 as $h2 => $vale2) {

                                                   $quaf2 = array_merge($quaf2, $vale2);
                                                }

                                                $rt2 = array();
                                                foreach ($quaf2 as $j2 => $t2) {

                                                   $qua2[] = $j2;
                                                }


                                                if (in_array("Admission / Prosspectus", $qua2s) || in_array("Health Insurance", $qua2s) || in_array("Pocket Articles", $qua2s) || in_array("Collage Caution Money (Refundable)", $qua2s) || in_array("Transportation Fees", $qua2s) || in_array("Health Insurance", $qua2s)) {
                                                   // pr('sdf');exit;

                                                   if (in_array("Admission / Prosspectus", $qua2s) &&  !in_array("Admission / Prosspectus", $qua)) {
                                                      $qua[] = "Admission / Prosspectus";
                                                   }

                                                   if (in_array("Collage Caution Money (Refundable)", $qua2s) &&  !in_array("Collage Caution Money (Refundable)", $qua)) {

                                                      $qua[] = "Collage Caution Money (Refundable)";
                                                   }

                                                   if (in_array("Pocket Articles", $qua2s) &&  !in_array("Pocket Articles", $qua)) {

                                                      $qua[] = "Pocket Articles";
                                                   }

                                                   if (in_array("Books", $qua2s) &&  !in_array("Books", $qua)) {

                                                      $qua[] = "Books";
                                                   }
                                                   if (in_array("Health Insurance", $qua2s) &&  !in_array("Health Insurance", $qua)) {

                                                      $qua[] = "Health Insurance";
                                                   }
                                                }

                                                // pr($qua2s);exit;


                                                if (!in_array("Admission / Prosspectus", $qua) || !in_array("Pocket Articles", $qua) || !in_array("Books", $qua)  || !in_array("Pocket Articles", $qua) || !in_array("Annual Charges", $qua)  || !in_array("Quater1", $qua)  || !in_array("Quater2", $qua) || !in_array("Quater3", $qua) || !in_array("Quater4", $qua)) {

                                                ?>
                                                   <div class="table-responsive">
                                                      <? if ($students['category'] == "RTE" || $students['category'] == "Migration") { ?>
                                                         <table class="table table-striped table-hover table-condensed
                          table-responsive" id="mytable2">
                                                         <? } else {  ?>
                                                            <table class="table table-striped table-hover table-condensed
                          table-responsive" id="mytable">
                                                            <? } ?>
                                                            <tbody>
                                                               <tr class="table_header">
                                                                  <th class="bg-teal color-palette"></th>
                                                                  <th class="text-left bg-teal color-palette"> Heads </th>
                                                                  <th class="text-left bg-teal color-palette"> Last Date </th>
                                                                  <th class="text-center bg-teal color-palette"> Fee </th>
                                                               </tr>
                                                               <?php if (isset($classfee) && !empty($classfee)) {
                                                                  $jk = 1;
                                                                  $y = 1;
                                                                  // pr($classfee);
                                                                  // pr($preclassfee);
                                                                  // exit;
                                                                  foreach ($preclassfee as $krt => $value) {

                                                                     if ($value['qu' . $jk . '_fees'] == null || $value['qu' . $jk . '_fees'] == '0') {
                                                                        $styles = 'style="display: none;"';
                                                                     } ?>
                                                                     <?php $findfee = $this->Comman->findfeeheadsname($value['fee_h_id']);
                                                                     // pr($findfee['name']);
                                                                     ?>

                                                                     <tr <?php echo $styles; ?>>
                                                                        <input type="hidden" name="student_id" value="<?php echo $id; ?>">
                                                                        <input type="hidden" name="hdfb" id="hdfbd" value="2">

                                                                        <!-- Checkbok Start here -->
                                                                        <? if ($findfee['name'] == "Uniform") {
                                                                           if ((!in_array("Uniform", $qua)) && (!in_array("Uniform", $qua2))) {   ?>
                                                                              <td>
                                                                                 <label>
                                                                                    <input type="checkbox" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 </label>
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Admission / Prosspectus") {

                                                                           if ((!in_array("Admission / Prosspectus", $qua)) && (!in_array("Admission / Prosspectus", $qua2))) {

                                                                           ?>
                                                                              <?php //if ($admission_year_st == $admission_year_user) {  
                                                                              ?>
                                                                              <td><label> <input type="checkbox" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" value="<?php echo $value['qu' . $jk . '_fees']; ?>"></label></td>
                                                                           <? //}
                                                                           }
                                                                        } else if ($findfee['name'] == "Books") {
                                                                           if ((!in_array("Books", $qua))  && (!in_array("Books", $qua2))) {  ?>
                                                                              <td>
                                                                                 <label>
                                                                                    <input type="checkbox" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 </label>
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Collage Caution Money (Refundable)") {
                                                                           if ((!in_array("Collage Caution Money (Refundable)", $qua))  && (!in_array("Collage Caution Money (Refundable)", $qua2))) {  ?>
                                                                              <td>
                                                                                 <label>
                                                                                    <input type="checkbox" onclick="checkpaper(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCks paper" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 </label>
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Pocket Articles") {
                                                                           if (!in_array("Pocket Articles", $qua)) {  ?>
                                                                              <td>
                                                                                 <label>
                                                                                    <input type="checkbox" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 </label>
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Library Card / ID Card Fees") {
                                                                           if (!in_array("Library Card / ID Card Fees", $qua)) {  ?>
                                                                              <td>
                                                                                 <label>
                                                                                    <input type="checkbox" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 </label>
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Enrollment Fees") {
                                                                           if (!in_array("Enrollment Fees", $qua)) {  ?>
                                                                              <td>
                                                                                 <label>
                                                                                    <input type="checkbox" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 </label>
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Hostel Caution Money") {
                                                                           if (!in_array("Hostel Caution Money", $qua)) {  ?>
                                                                              <td>
                                                                                 <label>
                                                                                    <input type="checkbox" onclick="checkpaper(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" id="chk<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCks paper" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 </label>
                                                                              </td>
                                                                        <? }
                                                                        } ?>
                                                                        <!-- Checkbok End here -->




                                                                        <!-- Text Start here -->
                                                                        <? if ($findfee['name'] == "Uniform") {
                                                                           if ((!in_array("Uniform", $qua)) && (!in_array("Uniform", $qua2))) {   ?>
                                                                              <td>
                                                                                 <input type="text" style="background-color:
                                          transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo
                                                                                                         $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="quatyid" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Admission / Prosspectus") {
                                                                           if ((!in_array("Admission / Prosspectus", $qua)) && (!in_array("Admission / Prosspectus", $qua2))) {   ?>
                                                                              <?php //if ($admission_year_st == $admission_year_user) {  
                                                                              ?>
                                                                              <td>
                                                                                 <input type="text" style="background-color:
                                          transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo
                                                                                                         $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="quatyid" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                           <? //}
                                                                           }
                                                                        } else if ($findfee['name'] == "Books") {
                                                                           if ((!in_array("Books", $qua))  && (!in_array("Books", $qua2))) {  ?>
                                                                              <td>
                                                                                 <input type="text" style="background-color:
                                          transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="paper1 quatyid" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Collage Caution Money (Refundable)") {
                                                                           if ((!in_array("Collage Caution Money (Refundable)", $qua))  && (!in_array("Collage Caution Money (Refundable)", $qua2))) {   ?>
                                                                              <td>
                                                                                 <input type="text" style="background-color:
                                          transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" class="quatyid" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Pocket Articles") {
                                                                           if (!in_array("Pocket Articles", $qua)) {  ?>
                                                                              <td>
                                                                                 <input type="text" class="quatyid" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Library Card / ID Card Fees") {
                                                                           if (!in_array("Library Card / ID Card Fees", $qua)) {  ?>
                                                                              <td>
                                                                                 <input type="text" class="quatyid" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Enrollment Fees") {
                                                                           if (!in_array("Enrollment Fees", $qua)) { ?>
                                                                              <td>
                                                                                 <input type="text" class="quatyid" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                           <? }
                                                                        } else if ($findfee['name'] == "Hostel Caution Money") {
                                                                           if (!in_array("Hostel Caution Money", $qua)) { ?>
                                                                              <td>
                                                                                 <input type="text" class="quatyid" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
                                                                                 <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?>-<?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
                                                                              </td>
                                                                        <? }
                                                                        }  ?>
                                                                        <!-- Text End here -->


                                                                        <!-- Last Date Start here -->
                                                                        <?php
                                                                        $feeMessages = array(
                                                                           "Uniform" => "Uniform",
                                                                           "Admission / Prosspectus" => "Admission / Prosspectus",
                                                                           "Books" => "Books",
                                                                           "Collage Caution Money (Refundable)" => "Collage Caution Money (Refundable)",
                                                                           "Pocket Articles" => "Pocket Articles",
                                                                           "Library Card / ID Card Fees" => "Library Card / ID Card Fees",
                                                                           "Enrollment Fees" => "Enrollment Fees",
                                                                           "Hostel Caution Money" => "Hostel Caution Money"
                                                                        );

                                                                        $feeName = $findfee['name'];

                                                                        if (isset($feeMessages[$feeName]) && !in_array($feeName, $qua) && !in_array($feeName, $qua2)) {
                                                                           $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
                                                                           echo '<td>' . (($dat != '1970-01-01') ? date('d-m-Y', strtotime($dat)) : "not-set") . '</td>';
                                                                        }
                                                                        ?>
                                                                        <!-- Last Date End here -->


                                                                        <!-- Fee Amount Show Start here -->

                                                                        <?php
                                                                        // pr($findfee['id']);exit;

                                                                        if ($feeName == "Uniform" && (!in_array("Uniform", $qua)) && (!in_array("Uniform", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>



                                                                        <? } else if ($feeName == "Admission / Prosspectus" && (!in_array("Admission / Prosspectus", $qua)) && (!in_array("Admission / Prosspectus", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>


                                                                        <? } else if ($feeName == "Books" && (!in_array("Books", $qua)) && (!in_array("Books", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>


                                                                        <? } else if ($feeName == "Collage Caution Money (Refundable)" && (!in_array("Collage Caution Money (Refundable)", $qua)) && (!in_array("Collage Caution Money (Refundable)", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>


                                                                        <? } else if ($feeName == "Pocket Articles" && (!in_array("Pocket Articles", $qua)) && (!in_array("Pocket Articles", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>

                                                                        <? } else if ($feeName == "Library Card / ID Card Fees" && (!in_array("Library Card / ID Card Fees", $qua)) && (!in_array("Library Card / ID Card Fees", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>


                                                                        <? } else if ($feeName == "Enrollment Fees" && (!in_array("Enrollment Fees", $qua)) && (!in_array("Enrollment Fees", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>

                                                                        <? } else if ($feeName == "Hostel Caution Money" && (!in_array("Hostel Caution Money", $qua)) && (!in_array("Hostel Caution Money", $qua2))) { ?>

                                                                           <td align="center" <?php echo $styles; ?>>
                                                                              <span class="text-black">&#8377; </span>
                                                                              <?php if ($dat != '1970-01-01') : ?>
                                                                                 <input type="text" name="amountl[]" id="amoun<?php echo $y; ?>" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="quatyid" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
                                                                                 &nbsp;&nbsp;
                                                                                 <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px; color: red; display: none;"><i class="fa fa-times"></i>
                                                                                 </a>
                                                                              <?php else : ?>
                                                                                 not-set
                                                                              <?php endif; ?>
                                                                           </td>


                                                                        <? } ?>

                                                                     <?php $y++;
                                                                  } ?>

                                                                     <!-- Fee Amount Show End here -->


                                                                     </tr>

                                                                  <?php  } ?>





                                                                  <?php for ($i = 1; $i < 9; $i++) {
                                                                     $fees_check_data = $classfee[0]['qu' . $i . '_fees'];

                                                                     if ($i > 4) {
                                                                        $trans = 'transporttr';
                                                                        if ($students['location_id'] == null) {
                                                                           $style = 'style="display: none;"';
                                                                        }
                                                                     } ?>

                                                                     <tr class="fdsfsdfdsaf <? echo $trans; ?>" <?php echo $style; ?>>
                                                                        <input type="hidden" name="student_id" value="<?php echo $id; ?>">
                                                                        <?php
                                                                        $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                        $currentdoate = strtotime(date('d-m-Y'));
                                                                        $clodate = strtotime(date('Y-m-d', strtotime($rg['qu' . $i . '_date'])));
                                                                        $kb = $i - 1;
                                                                        $clodateprev = strtotime(date('Y-m-d', strtotime($rg['qu' . $kb . '_date'])));

                                                                        if ($i == 1 && $students['section_id'] == 1) {

                                                                           $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                           if (!in_array("Quater" . $i, $qua)) {
                                                                              if ($classfee[0]['qu' . $i . '_fees'] != 0) {
                                                                                 $def = 1;
                                                                                 $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                 if ($dat != '1970-01-01') {
                                                                        ?>

                                                                                    <td style="width:4px;">
                                                                                       <label>
                                                                                          <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo
                                                                                                                                          $classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk lnm" name="amount[]" <?php if ($clodate < $currentdoat) { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } else { ?> onclick="check(<?php echo $i;
                                                                                                                                                                                                                                                                                                                                                         ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <?   } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                 } ?>
                                                                                       </label>
                                                                                    </td>

                                                                                 <? } else  if ($i == 2 && $students['section_id'] == 2) { ?>
                                                                                    <?php $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                                    if (!in_array("Quater" . $i, $qua)) {
                                                                                       if ($classfee[0]['qu' . $i . '_fees'] != 0) {
                                                                                          $def = 1;
                                                                                          $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                          if ($dat != '1970-01-01') {
                                                                                    ?>
                                                                                             <td style="width:4px;">
                                                                                                <label>
                                                                                                   <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo
                                                                                                                                                   $classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk <?
                                                                                             if ($i == 1) { ?>news <? } ?> lnm" name="amount[]" <?php if (in_array("Quater1", $qua) || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         } ?>
                                                                                                </label>
                                                                                             </td>
                                                                                          <? } else  if ($i == 3 && $students['section_id'] == 3) { ?>
                                                                                             <?php $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                                             if (!in_array("Quater" . $i, $qua)) {
                                                                                                if ($classfee[0]['qu' . $i . '_fees'] != 0) {
                                                                                                   $def = 1;
                                                                                                   $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                                   if ($dat != '1970-01-01') {
                                                                                             ?>
                                                                                                      <td style="width:4px;">
                                                                                                         <label>
                                                                                                            <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo
                                                                                                                                                            $classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk <?
                                                                                                      if ($i == 1) { ?>news <? } ?> lnm" name="amount[]" <?php if (in_array("Quater2", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']) ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         } ?>
                                                                                                         </label>
                                                                                                      </td>
                                                                                                   <? } else  if ($i == 4 && $students['section_id'] == 4) { ?>
                                                                                                      <?php $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                                                      if (!in_array("Quater" . $i, $qua)) {
                                                                                                         if ($classfee[0]['qu' . $i . '_fees'] != 0) {
                                                                                                            $def = 1;
                                                                                                            $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                                            if ($dat != '1970-01-01') {
                                                                                                      ?>
                                                                                                               <td style="width:4px;">
                                                                                                                  <label>
                                                                                                                     <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo
                                                                                                                                                                     $classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk <? if ($i == 1) { ?>news <? } ?> lnm" name="amount[]" <?php if (in_array("Quater3", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } ?>
                                                                                                                  </label>
                                                                                                               </td>
                                                                                                               <!-- For transport  -->
                                                                                                               <? } else  if ($i == 5) {
                                                                                                               if (!in_array("Transport" . $i, $qua)) {
                                                                                                                  $currentdoate = strtotime(date('d-m-Y'));
                                                                                                                  $clodate = strtotime(date('Y-m-d', strtotime($transportfees['fee_sub_q1'])));

                                                                                                               ?>
                                                                                                                  <td style="width:4px;">
                                                                                                                     <label>
                                                                                                                        <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo $transportfees['quarter1']; ?>" class="StuAttendCk <? if ($i == 1) { ?>news <? } ?> lnm" name="amount[]" <?php if (in_array("Quater1", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter1']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q1']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter1']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q1']); ?>)" <? } ?>value="<?php echo $transportfees['quarter1']; ?>">
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else  if ($i == 6) {
                                                                                                               if (!in_array("Transport" . $i, $qua)) {
                                                                                                                  // $rg=$this->Comman->findtranportfee($academic_year);
                                                                                                                  $currentdoate = strtotime(date('d-m-Y'));
                                                                                                                  $clodate = strtotime(date('Y-m-d', strtotime($transportfees['fee_sub_q2'])));

                                                                                                               ?>
                                                                                                                  <td style="width:4px;">
                                                                                                                     <label>
                                                                                                                        <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo $transportfees['quarter2']; ?>" class="StuAttendCk <? if ($i == 1) { ?>news <? } ?> lnm" name="amount[]" <?php if (in_array("Quater2", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter2']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q2']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter2']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q2']); ?>)" <? } ?>value="<?php echo $transportfees['quarter2']; ?>">
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else  if ($i == 7) {
                                                                                                               if (!in_array("Transport" . $i, $qua)) {
                                                                                                                  // $rg=$this->Comman->findtranportfee($academic_year);
                                                                                                                  $currentdoate = strtotime(date('d-m-Y'));
                                                                                                                  $clodate = strtotime(date('Y-m-d', strtotime($transportfees['fee_sub_q3'])));

                                                                                                               ?>
                                                                                                                  <td style="width:4px;">
                                                                                                                     <label>
                                                                                                                        <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo $transportfees['quarter3']; ?>" class="StuAttendCk <? if ($i == 1) { ?>news <? } ?> lnm" name="amount[]" <?php if (in_array("Quater3", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter3']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q3']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter3']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q3']); ?>)" <? } ?>value="<?php echo $transportfees['quarter3']; ?>">
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else if ($i == 8) {
                                                                                                               if (!in_array("Transport" . $i, $qua)) {
                                                                                                                  // $rg=$this->Comman->findtranportfee($academic_year);
                                                                                                                  $currentdoate = strtotime(date('d-m-Y'));
                                                                                                                  $clodate = strtotime(date('Y-m-d', strtotime($transportfees['fee_sub_q4'])));
                                                                                                                  // pr($clodate);exit;
                                                                                                               ?>
                                                                                                                  <td style="width:4px;">
                                                                                                                     <label>
                                                                                                                        <input type="checkbox" id="chk<?php echo $i; ?>-<?php echo $transportfees['quarter4']; ?>" class="StuAttendCk <? if ($i == 1) { ?>news <? } ?> lnm" name="amount[]" <?php if (in_array("Quater4", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter4']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q4']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $transportfees['quarter4']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($transportfees['fee_sub_q4']); ?>)" <? } ?>value="<?php echo $transportfees['quarter4']; ?>">
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            }
                                                                                                            $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                                                            //   pr($qua);exit;
                                                                                                            if ($i == 1 && $students['section_id'] == 1) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                  <td>
                                                                                                                     <input type="text" style="background-color: transparent;border: none;" value="1st Year" readonly>
                                                                                                                     <?php if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                        <input type="hidden" style="background-color: transparent;border:
                                none;" name="quater[]" id="s<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" class="quatyid" value="Quater<?php echo $i; ?>" readonly disabled="">
                                                                                                                        <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="2" readonly disabled="">
                                                                                                                     <?php } ?>
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else if ($i == 2 && $students['section_id'] == 2) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                  <td>
                                                                                                                     <input type="text" style="background-color: transparent;border: none;" value="2nd Year" readonly>
                                                                                                                     <?php if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                        <input type="hidden" style="background-color: transparent;border:
                                none;" name="quater[]" id="s<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" class="quatyid" value="Quater<?php echo $i; ?>" readonly disabled="">
                                                                                                                        <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="2" readonly disabled="">
                                                                                                                     <?php } ?>
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else if ($i == 3 && $students['section_id'] == 3) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) { ?>
                                                                                                                  <td>
                                                                                                                     <input type="text" style="background-color: transparent;border: none;" value="3rd Year" readonly>
                                                                                                                     <?php if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                        <input type="hidden" style="background-color: transparent;border:
                                none;" name="quater[]" id="s<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" class="quatyid" value="Quater<?php echo $i; ?>" readonly disabled="">
                                                                                                                        <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="2" readonly disabled="">
                                                                                                                     <?php } ?>
                                                                                                                  </td>
                                                                                                                  <!-- Here condition check forth quater fees not eqaul zero by Rupam -->
                                                                                                               <? }
                                                                                                            } else if ($i == 4 && $students['section_id'] == 4) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) { ?>
                                                                                                                  <td>
                                                                                                                     <input type="text" style="background-color: transparent;border: none;" value="4th Year" readonly>
                                                                                                                     <?php if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                        <input type="hidden" style="background-color: transparent;border:
                                none;" name="quater[]" id="s<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" class="quatyid" value="Quater<?php echo $i; ?>" readonly disabled="">
                                                                                                                        <input type="hidden" class="fehaedf" style="background-color: transparent;border: none;" id="sp<?php echo $i; ?>-<?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="2" readonly disabled="">
                                                                                                                     <?php } ?>
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            }
                                                                                                            $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                                                            if ($i == 1 && $students['section_id'] == 1) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) {   ?>
                                                                                                                  <td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                                                        if ($dat != '1970-01-01') {
                                                                                                                           echo date('d-m-Y', strtotime($dat));
                                                                                                                        } else {
                                                                                                                           echo "not-set";
                                                                                                                        } ?></td>
                                                                                                               <? }
                                                                                                            } else if ($i == 2 && $students['section_id'] == 2) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                  <td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                                                        if ($dat != '1970-01-01') {
                                                                                                                           echo date('d-m-Y', strtotime($dat));
                                                                                                                        } else {
                                                                                                                           echo "not-set";
                                                                                                                        } ?></td>
                                                                                                               <? }
                                                                                                            } else if ($i == 3 && $students['section_id'] == 3) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) { ?>
                                                                                                                  <td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                                                        if ($dat != '1970-01-01') {
                                                                                                                           echo date('d-m-Y', strtotime($dat));
                                                                                                                        } else {
                                                                                                                           echo "not-set";
                                                                                                                        } ?></td>
                                                                                                               <? }
                                                                                                            } else if ($i == 4 && $students['section_id'] == 4) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) { ?>
                                                                                                                  <td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
                                                                                                                        if ($dat != '1970-01-01') {
                                                                                                                           echo date('d-m-Y', strtotime($dat));
                                                                                                                        } else {
                                                                                                                           echo "not-set";
                                                                                                                        } ?></td>
                                                                                                                  <!-- for transport  -->


                                                                                                               <? }
                                                                                                            }
                                                                                                            $rg = $this->Comman->findclassfee($academic_class, $academic_year);
                                                                                                            if ($i == 1 && $students['section_id'] == 1) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) {   ?>
                                                                                                                  <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                                                              if ($dat != '1970-01-01') {

                                                                                                                                                                              ?><input type="text" style="width: 34%;" maxlength="6" minlength="1" readonly="readonly" class="amounedit" name="amountl[]" id="amoun5" value="<? echo $classfee[0]['qu' . $i . '_fees']; ?>">&nbsp;&nbsp;
                                                                                                                        <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px;color:red;display:none;"><i class="fa fa-times"></i></a>
                                                                                                                     <?
                                                                                                                                                                              } else {
                                                                                                                                                                                 echo "not-set";
                                                                                                                                                                              } ?>
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else if ($i == 2 && $students['section_id'] == 2) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) {  ?>
                                                                                                                  <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                                                              if ($dat != '1970-01-01') {
                                                                                                                                                                              ?><input type="text" style="width: 34%;" name="amountl[]" id="amoun6" maxlength="6" minlength="1" readonly="readonly" class="amounedit" value="<? echo $classfee[0]['qu' . $i . '_fees']; ?>">&nbsp;&nbsp;
                                                                                                                        <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px;color:red;display:none;"><i class="fa fa-times"></i></a>
                                                                                                                     <? } else {
                                                                                                                                                                                 echo "not-set";
                                                                                                                                                                              } ?>
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else if ($i == 3 && $students['section_id'] == 3) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) { ?>
                                                                                                                  <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                                                              if ($dat != '1970-01-01') {
                                                                                                                                                                              ?><input type="text" style="width: 34%;" name="amountl[]" id="amoun7" maxlength="6" minlength="1" readonly="readonly" class="amounedit" value="<? echo $classfee[0]['qu' . $i . '_fees']; ?>">&nbsp;&nbsp;
                                                                                                                        <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px;color:red;display:none;"><i class="fa fa-times"></i></a>
                                                                                                                     <?
                                                                                                                                                                              } else {
                                                                                                                                                                                 echo "not-set";
                                                                                                                                                                              } ?>
                                                                                                                  </td>
                                                                                                               <? }
                                                                                                            } else if ($i == 4 && $students['section_id'] == 4) {
                                                                                                               if (!in_array("Quater" . $i, $qua)) { ?>
                                                                                                                  <td align="center"><span class="text-black">&#8377; </span><?php
                                                                                                                                                                              if ($dat != '1970-01-01') {

                                                                                                                                                                              ?><input type="text" style="width: 34%;" name="amountl[]" id="amoun8" maxlength="6" minlength="1" readonly="readonly" class="amounedit" value="<? echo $classfee[0]['qu' . $i . '_fees']; ?>">&nbsp;&nbsp;
                                                                                                                        <a href="javascript:void(0);" class="remove_special" style="font-weight: bold; font-size: 16px;color:red;display:none;"><i class="fa fa-times"></i></a>
                                                                                                                     <?
                                                                                                                                                                              } else {
                                                                                                                                                                                 echo "not-set";
                                                                                                                                                                              } ?>
                                                                                                                  </td>
                                                                                                            <? }
                                                                                                            }  ?>

                                                                     </tr>
                                                               <?php }
                                                               } ?>
                                                            </tbody>
                                                            </table>
                                                         <?php  } ?>
                                                   </div>









                                                   <!-----------------------Other Fee Script----------------------->
                                                   <script>
                                                      function toggleCheckbox(value) {

                                                         let tnstotal = 0;
                                                         $.each($("input[name='tranportcheckbox']:checked"), function() {
                                                            tnstotal += parseInt($(this).val());

                                                         });

                                                         var absd = parseInt($('.tamount').text()) + parseInt(tnstotal);
                                                         $('.tamount').text(absd);
                                                      }

                                                      $(function() {

                                                         window.chkotherfsees = function(sid) {
                                                            // alert('Hello');                                    
                                                            $('#sum1').html('0');
                                                            $('#dueextras').val('0');
                                                            $('.practica').hide();
                                                            $("#otherfeeamts").attr("readonly", false);
                                                            var opt = $("#" + sid + " option:selected").val();
                                                            //End Transport

                                                            // alert(opt)
                                                            if (opt == '') {
                                                               $("#otherfeeamts").attr("readonly", true);
                                                            }
                                                            if (opt == '1') {

                                                               $("#formnos1").css("display", "inline-block");
                                                               $("#formnos1").css("width", "100%");
                                                               document.getElementById("formnos").required = true;

                                                            } else {

                                                               $("#formnos1").css("display", "none");
                                                               $("#formnos1").css("width", "100%");
                                                               document.getElementById("formnos").required = false;

                                                            }

                                                            var boardst = '<? echo $students['board_id']; ?>';
                                                            $(".addgen").css("display", "block");
                                                            $(".addgen23").css("display", "none");

                                                            $.ajax({
                                                               type: 'POST',
                                                               url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                               data: {
                                                                  'opt': opt,
                                                                  'boardst': boardst
                                                               },
                                                               beforeSend: function(xhr) {
                                                                  xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                               },
                                                               success: function(data) {
                                                                  data = parseInt(data);
                                                                  var discount = $("#chkdiscountcateg option:selected").val();
                                                                  if (discount > 0) {
                                                                     if (opt == '5') {
                                                                        $('.practica').show();
                                                                        var ssum = 0;
                                                                        $('.practicald').each(function() {

                                                                           if ($(this).attr('checked')) {
                                                                              ssum += parseInt($(this).val());

                                                                           }

                                                                        });

                                                                        data = ssum;
                                                                     }
                                                                     if ($('#otherfeeamts').val() != '0') {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

                                                                     } else {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data);
                                                                     }


                                                                     if ($('#otherfeeamts').val() != '0') {

                                                                        var newamntdf = parseInt($('.newamnt').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

                                                                     } else {

                                                                        var newamntdf = parseInt($('.newamnt').text()) + parseInt(data);
                                                                     }


                                                                     $('#otherfeeamts').val(data);
                                                                     $('.tamount').text(idf);
                                                                     $('.newamnt').text(newamntdf);
                                                                     var cat = parseInt($('#lfines').val()) + parseInt(newamntdf);
                                                                     $('.newamnts').val(cat);
                                                                     $('.afdiscount').val(newamntdf);
                                                                     $('#sum1').html('0');
                                                                     $('#dueextras').val('0');
                                                                     var vale = $('#otherfeeamts').val();
                                                                     var selectedValue = discount;
                                                                     var ffheads = opt;

                                                                     $.ajax({
                                                                        type: 'POST',
                                                                        url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                                                        data: {
                                                                           'ffheads': ffheads,
                                                                           'sevalue': selectedValue,
                                                                           'amty': vale
                                                                        },
                                                                        beforeSend: function(xhr) {
                                                                           xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                        },
                                                                        success: function(data) {
                                                                           if (data > 0) {

                                                                              var toi = parseInt($('.tamount').text());
                                                                              var additionaldis = parseInt($('#additionaldis').val());
                                                                              var fdiscou = parseFloat(data);

                                                                              $('#fees_discount').val(fdiscou);
                                                                              var discounts = fdiscou;
                                                                              var newamount = toi - discounts;
                                                                              if (additionaldis != '0' && newamount >= additionaldis) {
                                                                                 var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                                 $('.newamnt').text(newamount);
                                                                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                 $('.newamnts').val(cat);
                                                                                 $('#sum1').html('0');
                                                                                 $('#dueextras').val('0');
                                                                              } else {
                                                                                 $('.newamnt').text(newamount);
                                                                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                 $('.newamnts').val(cat);
                                                                              }
                                                                              $('.afdiscount').val(newamount);
                                                                              $(".disfee").html(discounts);
                                                                              var discounts = discounts;
                                                                              $(".discnt").html(discounts);

                                                                           } else {

                                                                              $('#additionaldis').val('0');

                                                                           }
                                                                        },
                                                                     });

                                                                  } else {

                                                                     if (opt == '5') {

                                                                        $('.practica').show();
                                                                        var ssum = 0;
                                                                        $('.practicald').each(function() {

                                                                           if ($(this).attr('checked')) {

                                                                              ssum += parseInt($(this).val()); // Or this.innerHTML, this.innerText


                                                                           }
                                                                        });

                                                                        data = ssum;
                                                                     }

                                                                     if ($('#otherfeeamts').val() != '0') {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

                                                                     } else {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data);
                                                                     }

                                                                     $('#otherfeeamts').val(data);

                                                                     $('.tamount').text(idf);

                                                                     var additionaldis = parseInt($('#additionaldis').val());
                                                                     var newamount = idf;

                                                                     if (additionaldis != '0' && newamount >= additionaldis) {
                                                                        var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                                                        //$('.newamnt').text(newamount);
                                                                        $('.newamnt').text(newamount);
                                                                        var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                        $('.newamnts').val(cat);
                                                                        //$('#depositamt').val(newamounts);
                                                                        $('#sum1').html('0');
                                                                        $('#dueextras').val('0');
                                                                        $('.afdiscount').val(newamount);

                                                                     } else {
                                                                        $('.newamnt').text(newamount);
                                                                        var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                        $('.newamnts').val(cat);
                                                                        //$('#depositamt').val(newamount);
                                                                        $('.afdiscount').val(newamount);

                                                                     }

                                                                  }
                                                               },
                                                            });
                                                         };

                                                      });

                                                      $(function() {

                                                         window.chkotherfseesj = function(sid) {
                                                            $('#sum1').html('0');
                                                            $('#dueextras').val('0');
                                                            $('.practica').hide();

                                                            $("#otherfeeamts" + sid).attr("readonly", false);
                                                            var opt = $("#chkotherfee" + sid + " option:selected").val();
                                                            if (opt == '') {
                                                               $("#otherfeeamts" + sid).attr("readonly", true);
                                                            }
                                                            if (opt == '1') {

                                                               $("#formnos1").css("display", "inline-block");
                                                               $("#formnos1").css("width", "100%");
                                                               document.getElementById("formnos").required = true;

                                                            } else {
                                                               $("#formnos1").css("display", "none");
                                                               $("#formnos1").css("width", "100%");
                                                               document.getElementById("formnos").required = false;

                                                            }
                                                            var boardst = '<? echo $students['board_id']; ?>';
                                                            $(".addgen").css("display", "block");
                                                            $(".addgen23").css("display", "none");

                                                            $.ajax({
                                                               type: 'POST',
                                                               url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                               data: {
                                                                  'opt': opt,
                                                                  'boardst': boardst
                                                               },
                                                               beforeSend: function(xhr) {
                                                                  xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                               },
                                                               success: function(data) {
                                                                  var discount = $("#chkdiscountcateg option:selected").val();
                                                                  if (discount > 0) {
                                                                     if (opt == '5') {

                                                                        $('.practica').show();
                                                                        var ssum = 0;
                                                                        $('.practicald').each(function() {

                                                                           if ($(this).attr('checked')) {
                                                                              ssum += parseInt($(this).val());

                                                                           }
                                                                        });

                                                                        data = ssum;
                                                                     }
                                                                     if ($('#otherfeeamts' + sid).val() != '0') {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts' + sid).val());

                                                                     } else {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data);
                                                                     }

                                                                     if ($('#otherfeeamts' + sid).val() != '0') {

                                                                        var newamntdf = parseInt($('.newamnt').text()) + parseInt(data) - parseInt($('#otherfeeamts' + sid).val());

                                                                     } else {

                                                                        var newamntdf = parseInt($('.newamnt').text()) + parseInt(data);
                                                                     }

                                                                     $('#otherfeeamts' + sid).val(data);
                                                                     $('.tamount').text(idf);
                                                                     $('.newamnt').text(newamntdf);
                                                                     var cat = parseInt($('#lfines').val()) + parseInt(newamntdf);
                                                                     $('.newamnts').val(cat);
                                                                     $('.afdiscount').val(newamntdf);
                                                                     $('#sum1').html('0');
                                                                     $('#dueextras').val('0');
                                                                     var vale = $('#otherfeeamts' + sid).val();
                                                                     var selectedValue = discount;
                                                                     var ffheads = opt;

                                                                     $.ajax({
                                                                        type: 'POST',
                                                                        url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                                                        data: {
                                                                           'ffheads': ffheads,
                                                                           'sevalue': selectedValue,
                                                                           'amty': vale
                                                                        },
                                                                        beforeSend: function(xhr) {
                                                                           xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                        },
                                                                        success: function(data) {

                                                                           if (data > 0) {
                                                                              var toi = parseInt($('.tamount').text());
                                                                              var additionaldis = parseInt($('#additionaldis').val());
                                                                              var fdiscou = parseFloat(data);
                                                                              $('#fees_discount').val(fdiscou);
                                                                              var discounts = fdiscou;
                                                                              var newamount = toi - discounts;
                                                                              if (additionaldis != '0' && newamount >= additionaldis) {
                                                                                 var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                                                                 $('.newamnt').text(newamount);
                                                                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                 $('.newamnts').val(cat);
                                                                                 $('#sum1').html('0');
                                                                                 $('#dueextras').val('0');
                                                                              } else {
                                                                                 $('.newamnt').text(newamount);
                                                                                 var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                 $('.newamnts').val(cat);
                                                                              }
                                                                              $('.afdiscount').val(newamount);
                                                                              $(".disfee").html(discounts);
                                                                              var discounts = discounts;
                                                                              $(".discnt").html(discounts);
                                                                           } else {

                                                                              $('#additionaldis').val('0');
                                                                           }
                                                                        },
                                                                     });

                                                                  } else {

                                                                     if (opt == '5') {

                                                                        $('.practica').show();
                                                                        var ssum = 0;
                                                                        $('.practicald').each(function() {

                                                                           if ($(this).attr('checked')) {
                                                                              ssum += parseInt($(this).val());

                                                                           }
                                                                        });

                                                                        data = ssum;
                                                                     }

                                                                     if ($('#otherfeeamts' + sid).val() != '0') {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts' + sid).val());

                                                                     } else {

                                                                        var idf = parseInt($('.tamount').text()) + parseInt(data);
                                                                     }

                                                                     $('#otherfeeamts' + sid).val(data);
                                                                     $('.tamount').text(idf);

                                                                     var additionaldis = parseInt($('#additionaldis').val());
                                                                     var newamount = idf;

                                                                     if (additionaldis != '0' && newamount >= additionaldis) {
                                                                        var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                        $('.newamnt').text(newamount);
                                                                        var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                        $('.newamnts').val(cat);

                                                                        $('#sum1').html('0');
                                                                        $('#dueextras').val('0');
                                                                        $('.afdiscount').val(newamount);

                                                                     } else {
                                                                        $('.newamnt').text(newamount);
                                                                        var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                        $('.newamnts').val(cat);

                                                                        $('.afdiscount').val(newamount);

                                                                     }
                                                                  }
                                                               },
                                                            });


                                                         };
                                                      });
                                                   </script>
                                                   <!----------------------------- For Paid Recipet Show--------------->
                                                   <div class="table-responsive">
                                                      <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                         <tbody>
                                                            <tr class="table_header">
                                                               <th class="bg-teal color-palette"></th>
                                                               <th style="width: 27%;" class="bg-teal color-palette">Reference No.</th>
                                                               <th class="text-left bg-teal color-palette">Paydate </th>
                                                               <th class="text-left bg-teal color-palette"> Amount </th>
                                                               <th class="text-left bg-teal color-palette"> Print </th>
                                                            </tr>
                                                            <!------------------------------- For Cancel Recipet Script------------------------------------->
                                                            <script type="text/javascript">
                                                               $(function() {
                                                                  window.checkcancel = function(sid) {
                                                                     var ck = 'ref' + sid;
                                                                     var chkbox = document.getElementById(ck);
                                                                     var selec = $("#" + ck).attr('class');

                                                                     if (chkbox.checked) {
                                                                        $('.StuAttendCk').prop('checked', false);
                                                                        $('#depositamt').prop('required', true);
                                                                        $('#sum1').html('0');
                                                                        $('#dueextras').val('0');
                                                                        $('#chkotherfee').prop('required', true);
                                                                        $(".addgen").css("display", "none");
                                                                        $(".addgen23").css("display", "block");
                                                                     }

                                                                     if ($('.StuAttendCkcancel:checked').length == 0) {
                                                                        $('#chkotherfee').prop('required', false);

                                                                        $(".addgen23").css("display", "none");
                                                                     } else {

                                                                        $('#chkotherfee').prop('required', true);
                                                                        $(".addgen23").css("display", "block");
                                                                     }
                                                                  };
                                                               });
                                                            </script>
                                                            <? if ($studentfeesk) {
                                                               $quass = array();
                                                               foreach ($studentfeesk as $valsf) {
                                                                  $quass = unserialize($valsf['quarter']);
                                                                  $rst = array();
                                                                  foreach ($quass as $sj => $dt) {
                                                                     $rst[] = $sj;
                                                                  } ?>
                                                                  <tr>
                                                                     <td><label></label></td>
                                                                     <td><?php echo $valsf['recipetno'];
                                                                           if (in_array("Bank Cancellation Charge", $rst)) {
                                                                              echo "<strong  title='Bank Cancellation Charge' style='color:red;'>*</strong>";
                                                                           }  ?></td>
                                                                     <td>
                                                                        <?php $dats = date('Y-m-d', strtotime($valsf['paydate']));
                                                                        if ($dats != '1970-01-01') {
                                                                           echo date('d-m-Y', strtotime($dats));
                                                                        } else {
                                                                           echo "not-set";
                                                                        } ?>
                                                                     </td>
                                                                     <td>
                                                                        <?= $this->Html->script('admin/confirmation.js') ?>
                                                                        <span class="text-black">₹ </span><?php echo $valsf['deposite_amt']; ?>
                                                                     </td>
                                                                     <td>
                                                                        <?php
                                                                        $quass = array();
                                                                        if ($valsf['refrencepending'] == '0') {
                                                                           $quass[] = unserialize($valsf['quarter']);

                                                                           $quafs = array();

                                                                           foreach ($quass as $h => $vales) {

                                                                              $quafs = array_merge($quafs, $vales);
                                                                           }
                                                                           $rt = array();
                                                                           $quas = array();
                                                                           foreach ($quafs as $sjs => $ts) {

                                                                              $quas[] = $sjs;
                                                                           }
                                                                        } else {
                                                                           $quas = array();
                                                                           $quas[] = $valsf['quarter'];
                                                                        }

                                                                        if (in_array("Caution Money", $quas)) {
                                                                        ?>
                                                                           <a title="Print Caution Money" target="_blank" href="<? echo ADMIN_URL; ?>studentfees/printscaution/<?php echo $valsf['id']; ?>/<?php echo $academic_year; ?>"><i class="fa fa-file-text-o"></i></a>
                                                                           <a title="Cancel Receipt" class="modalcancel" data-toggle="modal" data-val="<?php echo $valsf['id']; ?>" data-id="<?php echo $valsf['recipetno']; ?>" data-options="<?php echo $academic_year; ?>" data-target="#myModal"><i class="fa fa-remove"></i></a>
                                                                        <? } else {  ?>
                                                                           <a title="Print Receipt" target="_blank" href="<? echo ADMIN_URL; ?>studentfees/newprintsadmission/<?php echo $valsf['id']; ?>/<?php echo $academic_year; ?>"><i class="fa fa-file-text-o"></i></a>
                                                                           <?php
                                                                           $dbname = $this->request->session()->read('Auth.User.db');
                                                                           $branch = explode("_", $dbname);
                                                                           if ($branch[0] != 'canvas') { ?>
                                                                              <a title="Cancel Receipt" class="modalcancel" data-toggle="modal" data-val="<?php echo $valsf['id']; ?>" data-id="<?php echo $valsf['recipetno']; ?>" data-options="<?php echo $academic_year; ?>" data-target="#myModal"><i class="fa fa-remove"></i></a>
                                                                        <? }
                                                                        } ?>
                                                                        <script>
                                                                           $('a[tooltip]').tooltip({
                                                                              title: function() {
                                                                                 return $(this).attr("tooltip-title");
                                                                              }
                                                                           });


                                                                           $('a[confirmation]').confirmation({
                                                                              title: function() {
                                                                                 return $(this).attr("confirm-title");
                                                                              }
                                                                           });
                                                                        </script>
                                                                     </td>
                                                                  </tr>
                                                               <?php }
                                                            } else { ?>
                                                               <tr>
                                                                  <td colspan="5" class="text-center">No Deposit Fees Yet</td>
                                                               </tr>
                                                            <?php } ?>
                                                         </tbody>
                                                      </table>
                                                   </div>

                                                   <!------------------------- For Paid Recipet Show before Migration------------------------->
                                                   <div class="table-responsive">
                                                      <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                         <tbody>
                                                            <tr class="table_header">
                                                               <th class="bg-teal color-palette"></th>
                                                               <th style="width: 27%;" class="bg-teal color-palette">Before Migration Reference No.<br>(In Current Year)</th>
                                                               <th class="text-left bg-teal color-palette">Paydate </th>
                                                               <th class="text-left bg-teal color-palette"> Amount </th>
                                                               <th class="text-left bg-teal color-palette"> Print </th>
                                                            </tr>
                                                            <!----------------------------------------------------- For Cancel Recipet Script------------------------------------->
                                                            <? if ($studentfees2s) {
                                                               $quass34 = array();
                                                               foreach ($studentfees2s as $valsf) {
                                                                  if ($valsf['recipetno'] != '0') {
                                                                     $quass34 = unserialize($valsf['quarter']);
                                                                     $rst34 = array();
                                                                     foreach ($quass34 as $sj => $dt) {

                                                                        $rst34[] = $sj;
                                                                     } ?>
                                                                     <tr>
                                                                        <td><label></label></td>
                                                                        <td>
                                                                           <?php echo $valsf['recipetno'];
                                                                           if (in_array("Bank Cancellation Charge", $rst34)) {
                                                                              echo "<strong  title='Bank Cancellation Charge' style='color:red;'>*</strong>";
                                                                           }  ?>
                                                                        </td>
                                                                        <td>
                                                                           <?php $dats = date('Y-m-d', strtotime($valsf['paydate']));
                                                                           if ($dats != '1970-01-01') {
                                                                              echo date('d-m-Y', strtotime($dats));
                                                                           } else {
                                                                              echo "not-set";
                                                                           } ?>
                                                                        </td>
                                                                        <td>
                                                                           <?= $this->Html->script('admin/confirmation.js'); ?>
                                                                           <span class="text-black">₹ </span><?php echo $valsf['deposite_amt']; ?>
                                                                        </td>
                                                                        <td>
                                                                           <?php
                                                                           $quass = array();

                                                                           if ($valsf['refrencepending'] == '0') {
                                                                              $quassl[] = unserialize($valsf['quarter']);

                                                                              $quafsl = array();

                                                                              foreach ($quassl as $h => $vales) {

                                                                                 $quafsl = array_merge($quafsl, $vales);
                                                                              }
                                                                              $rt = array();
                                                                              $quasl = array();
                                                                              foreach ($quafsl as $sjs => $ts) {

                                                                                 $quasl[] = $sjs;
                                                                              }
                                                                           } else {
                                                                              $quasl = array();
                                                                              $quasl[] = $valsf['quarter'];
                                                                           }

                                                                           if (in_array("Caution Money", $quasl)) {
                                                                           ?>
                                                                              <a title="Print Caution Money" target="_blank" href="<? echo ADMIN_URL; ?>studentfees/printscaution/<?php echo $valsf['id']; ?>/<?php echo $valsf['acedmicyear']; ?>"><i class="fa fa-file-text-o"></i></a>
                                                                           <? } else {  ?>
                                                                              <a title="Print Receipt" target="_blank" href="<? echo ADMIN_URL; ?>studentfees/newprintsadmission/<?php echo $valsf['id']; ?>/<?php echo $academic_year; ?>"><i class="fa fa-file-text-o"></i></a>
                                                                           <? } ?>
                                                                           <script>
                                                                              $('a[tooltip]').tooltip({
                                                                                 title: function() {
                                                                                    return $(this).attr("tooltip-title");
                                                                                 }
                                                                              });


                                                                              $('a[confirmation]').confirmation({
                                                                                 title: function() {
                                                                                    return $(this).attr("confirm-title");
                                                                                 }
                                                                              });
                                                                           </script>
                                                                        </td>
                                                                     </tr>
                                                               <?  }
                                                               }
                                                            } else { ?>
                                                               <tr>
                                                                  <td colspan="5" class="text-center">No Deposit Fees Yet</td>
                                                               </tr>
                                                            <? } ?>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                   <!---------------------- For Sibling Data Show------------------------>
                                                   <div class="table-responsive">
                                                      <? if (isset($student_dataftf) && !empty($student_dataftf)) { ?>
                                                         <table class="table table-striped table-hover table-condensed
                          table-responsive">
                                                            <tbody>
                                                               <tr>
                                                                  <th class="bg-teal color-palette"></th>
                                                                  <th style="width: 27%;" class="bg-teal color-palette">Sibling's Detail </th>
                                                                  <th class="text-left bg-teal color-palette">Sr.No.</th>
                                                                  <th class="text-left bg-teal color-palette"> Class </th>
                                                                  <th class="text-left bg-teal color-palette"> Action </th>
                                                               </tr>
                                                               <?php
                                                               $counter = 1;
                                                               if (isset($student_dataftf) && !empty($student_dataftf)) {
                                                                  foreach ($student_dataftf as $key => $element) {
                                                                     $s_id = $element['class_id'];
                                                                     $c_id = $element['section_id'];
                                                               ?>
                                                                     <tr>
                                                                        <td></td>
                                                                        <td><?php $studentname = $element['fname'] . " " . $element['middlename'] . " " . $element['lname'];
                                                                              echo $studentname; ?></td>
                                                                        <td><?php echo $element['enroll'];  ?></td>
                                                                        <td><?php $class = $this->Comman->findclasses($s_id);
                                                                              echo $class[0]['title'];
                                                                              ?>-<?php
                                                                     $section = $this->Comman->findsections($c_id);
                                                                     echo $section[0]['title'];
                                    ?>
                                                                        </td>
                                                                        <td><a title="Deposit-Fees" href="<?php echo SITE_URL; ?>admin/studentfees/view/<?php echo $element['id']; ?>"><img style="width: 22%;" src="<?php echo SITE_URL; ?>images/payment.png"></a>
                                                                        </td>
                                                                     </tr>
                                                                  <?php
                                                                     $counter++;
                                                                  }
                                                               } else { ?>
                                                                  <td colspan="8" style="text-align:center;">No Siblings data find</td>
                                                               <?php  } ?>
                                                         </table>
                                                      <?php } ?>
                                                   </div>
                                             </div>






                                             <!-------------------------- For Pending Fee Show------------------>
                                             <div class="col-lg-6">
                                                <div class="table-responsive">
                                                   <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                      <tbody>
                                                         <tr class="table_header">
                                                            <th class="bg-teal color-palette"></th>
                                                            <th style="width: 25%;" class="bg-teal color-palette">Description</th>
                                                            <th class="text-center bg-teal color-palette"> Due Fee </th>
                                                            <th class="text-right bg-teal color-palette"> Status </th>
                                                         </tr>
                                                         <? $nk = "51";
                                                         if ($student_feepending) {
                                                            $k = 0;
                                                            foreach ($student_feepending as $val) {
                                                               $sert = $this->Comman->findridacademicer($val['r_id']);

                                                               if ($sert) { ?>
                                                                  <tr>
                                                                     <td style="width:4px;">
                                                                        <label><input id="chk<? echo $nk; ?>-<?php if ($val['amt'] < 0) {
                                                                                                                  echo round($val['amt']);
                                                                                                               } else {
                                                                                                                  echo round($val['amt']);
                                                                                                               } ?>" class="StuAttendCkrg" name="amounts[<? echo $k; ?>]" <? if ($val['amt'] < 0) { ?>onclick="checkpending(<? echo $nk; ?>,<?php echo round($val['amt']); ?>,0)" <?  } else { ?> onclick="checkpending(<? echo $nk; ?>,<?php echo round($val['amt']); ?>,0)" <? } ?> value="<?php echo $val['amt']; ?>" type="checkbox">
                                                                        </label>
                                                                     </td>
                                                                     <td style="width:4px;">
                                                                        <label><input name="student_id" value="<?php echo $val['s_id']; ?>" type="hidden">
                                                                           <input name="refrencepending[]" value="<?php echo $val['r_id']; ?>" type="hidden">
                                                                           <input name="hdfb" id="hdfbd" type="hidden" value="2">
                                                                           <input name="pendid[]" value="<?php echo $val['id']; ?>" type="hidden">
                                                                           Pending As Per Reference No <?php echo $val['recipetnos']; ?> </label>
                                                                     </td>
                                                                     <td class="text-center">
                                                                        <span class="text-black">₹ </span><?php echo $val['amt']; ?>
                                                                     </td>
                                                                     <td class="text-right"><? if ($val['amt'] < 0) { ?> Extra Paid <? } else { ?> Pending<? } ?></td>
                                                                  </tr>
                                                            <? $nk++;
                                                                  $k++;
                                                               } else if ($k == '0') {
                                                               }
                                                            }
                                                         } else { ?>
                                                            <tr>
                                                               <td colspan="4" class="text-center">No Pending Fees Yet</td>
                                                            </tr>
                                                         <? } ?>
                                                      </tbody>
                                                   </table>
                                                </div>
                                                <!---------------------------- All Custom Input, Submit Button Here------------------>
                                                <div class="table-responsive">
                                                   <table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
                                                      <tbody>
                                                         <?php if (isset($classfee) && !empty($classfee)) {  ?>
                                                            <div>
                                                               <tr class="assets_container">
                                                                  <td colspan="4" width="50%" id="chck">
                                                                     <b>Other Fee Charge : &nbsp; </b>
                                                                     <select name="quater[]" class="chkotherfeer" id="chkotherfee" onChange="chkotherfsees('chkotherfee');">
                                                                        <option value="0">- Add Other Fee -</option>
                                                                        <?php foreach ($feesheadstotal as $ky => $item) { //pr($item);
                                                                        ?>
                                                                           <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                                                                        <? } ?>
                                                                     </select>
                                                                  </td>
                                                                  <td colspan="2" width="50%">
                                                                     <b><br> </b>
                                                                     <input name="amount[]" readonly="readonly" id="otherfeeamts" value="0" placeholder="Enter Amount" type="number">
                                                                  </td>
                                                                  <td class="col-sm-2" class="subtype" style="position:relative;">
                                                                     <label></label>
                                                                     <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 21px;margin-top: 23px;"><i class="fa fa-plus-circle"></i></a>
                                                                  </td>
                                                               </tr>
                                                            </div>
                                                            <div class="after-add-more"> </div>
                                                            <!-----------------------Add More Script For Other Fee--------------------------->
                                                            <script>
                                                               $(document).ready(function() {
                                                                  var x = 0;

                                                                  $(".add_field_butto").click(function() {
                                                                     $('.after-add-more').append('<tr class="assets_container asset2"><td colspan="4" width="50%"><b>Other Fee Charge : &nbsp; </b><select name="quater[]" id="chkotherfee' + x + '"  class="chkotherfeer" onchange="chkotherfseesj(' + x + ');"><option value="">- Add Other Fee -</option><? foreach ($feesheadstotal as $ky => $item) { ?>  <option value="<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></option> <? } ?></select></td><td colspan="2" width="50%"><b><br> </b><input name="amount[]" readonly="readonly" id="otherfeeamts' + x + '" value="0" placeholder="Enter Amount" type="number"> </td><td class="col-sm-2" class="subtype" style="position:relative;" ><label></label><a href="javascript:void(0);" class="remove" id="removes' + x + '" onclick="calculatremain(' + x + ')" style="font-weight: bold; font-size: 21px;margin-top: 23px;position: absolute;"><i class="fa fa-minus-circle"></i></a> </td></tr>');
                                                                     x++;
                                                                  });

                                                                  $("body").on("click", ".remove", function() {
                                                                     // $(this).closest('.assets_container').remove();
                                                                  });

                                                               });
                                                            </script>

                                                            <script>
                                                               function calculatremain(sx) {
                                                                  var sums0h = 0;

                                                                  $("#otherfeeamts" + sx).each(function() {

                                                                     if (!isNaN(this.value) && this.value.length != 0) {
                                                                        sums0h += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");
                                                                     } else if (this.value.length != 0) {
                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums0h == '0') {

                                                                     $('#removes' + sx).closest('.assets_container').remove();

                                                                     var ssx = "#chkotherfee" + sx;
                                                                     $(ssx + ' option[value=" "]').attr("selected", true);


                                                                  }
                                                                  var ssx = "#chkotherfee" + sx;
                                                                  var opt = $(ssx + ' option:selected').val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';


                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums0h);
                                                                        var idfs = parseInt(idfs) + parseInt(sums0h);

                                                                        if ($('#otherfeeamts' + sx).val() != '0') {

                                                                           var idf = parseInt(sums0h);

                                                                        } else {

                                                                           var idf = parseInt(sums0h);
                                                                        }

                                                                        var sumkh0 = 0;

                                                                        sumkh0 = $('.tamount').text();

                                                                        var idf = parseInt(sumkh0) - parseInt(idf);



                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());
                                                                        var fdiscou = parseFloat($('#fees_discount').val());
                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);
                                                                              $(".disfee").html(discounts);
                                                                              var discounts = discounts;
                                                                              $(".discnt").html(discounts);
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('.afdiscount').val(newamount);
                                                                              $(".disfee").html(discounts);
                                                                              var discounts = discounts;
                                                                              $(".discnt").html(discounts);
                                                                           }

                                                                        } else {

                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('.afdiscount').val(newamount);

                                                                           }

                                                                        }

                                                                        $('#removes' + sx).closest('.assets_container').remove();

                                                                     },
                                                                  });


                                                               }


                                                               $(document).on('focus', "#otherfeeamts0", function() {

                                                               }).on('blur', "#otherfeeamts0", function() {
                                                                  $('#sum1').html('0');
                                                                  $('#dueextras').val('0');

                                                                  calculateSumerdd0();


                                                               });


                                                               $(document).on('focus', "#otherfeeamts1", function() {

                                                               }).on('blur', "#otherfeeamts1", function() {


                                                                  $('#sum1').html('0');
                                                                  $('#dueextras').val('0');

                                                                  calculateSumerdd1();


                                                               });


                                                               $(document).on('focus', "#otherfeeamts2", function() {

                                                               }).on('blur', "#otherfeeamts2", function() {


                                                                  $('#sum1').html('0');
                                                                  $('#dueextras').val('0');

                                                                  calculateSumerdd2();


                                                               });

                                                               $(document).on('focus', "#otherfeeamts3", function() {

                                                               }).on('blur', "#otherfeeamts3", function() {


                                                                  $('#sum1').html('0');
                                                                  $('#dueextras').val('0');

                                                                  calculateSumerdd3();


                                                               });


                                                               $(document).on('focus', "#otherfeeamts4", function() {

                                                               }).on('blur', "#otherfeeamts4", function() {


                                                                  $('#sum1').html('0');
                                                                  $('#dueextras').val('0');

                                                                  calculateSumerdd4();


                                                               });

                                                               $(document).on('focus', "#otherfeeamts5", function() {

                                                               }).on('blur', "#otherfeeamts5", function() {


                                                                  $('#sum1').html('0');
                                                                  $('#dueextras').val('0');

                                                                  calculateSumerdd5();


                                                               });


                                                               function calculateSumerdd0() {
                                                                  var sums0 = 0;
                                                                  $("#otherfeeamts0").each(function() {

                                                                     if (!isNaN(this.value) && this.value.length != 0) {

                                                                        sums0 += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");
                                                                     } else if (this.value.length != 0) {
                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums0 == '0') {
                                                                     $('#chkotherfee0 option[value=" "]').attr("selected", true);


                                                                  }

                                                                  var opt = $("#chkotherfee0 option:selected").val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';

                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums0);
                                                                        var idfs = parseInt(idfs) + parseInt(sums0);

                                                                        $('.tamount').text('0');


                                                                        if ($('#otherfeeamts0').val() != '0') {

                                                                           var idf = parseInt(sums0);

                                                                        } else {

                                                                           var idf = parseInt(sums0);
                                                                        }

                                                                        var sumk0 = 0;
                                                                        $('input:checkbox[name="amount[]"]:checked').each(function() {
                                                                           sumk0 += parseFloat($(this).val());
                                                                        });

                                                                        var sumsk0 = 0;
                                                                        $('.StuAttendCkrg:checkbox:checked').each(function() {
                                                                           sumsk0 += parseFloat($(this).val());
                                                                        });


                                                                        if ($('#otherfeeamts').val() != '0' && $('#otherfeeamts').length) {
                                                                           sumsk0 += parseFloat($('#otherfeeamts').val());
                                                                        }


                                                                        if ($('#otherfeeamts1').val() != '0' && $('#otherfeeamts1').length) {
                                                                           sumsk0 += parseFloat($('#otherfeeamts1').val());
                                                                        }

                                                                        if ($('#otherfeeamts2').val() != '0' && $('#otherfeeamts2').length) {
                                                                           sumsk0 += parseFloat($('#otherfeeamts2').val());
                                                                        }


                                                                        if ($('#otherfeeamts3').val() != '0' && $('#otherfeeamts3').length) {
                                                                           sumsk0 += parseFloat($('#otherfeeamts3').val());
                                                                        }


                                                                        if ($('#otherfeeamts4').val() != '0' && $('#otherfeeamts4').length) {
                                                                           sumsk0 += parseFloat($('#otherfeeamts4').val());
                                                                        }


                                                                        if ($('#otherfeeamts5').val() != '0' && $('#otherfeeamts5').length) {
                                                                           sumsk0 += parseFloat($('#otherfeeamts5').val());
                                                                        }



                                                                        var idf = parseInt(sumk0) + parseInt(idf) + parseInt(sumsk0);



                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());
                                                                        var fdiscou = parseFloat($('#fees_discount').val());

                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                           }
                                                                           $('.afdiscount').val(newamount);
                                                                           $(".disfee").html(discounts);
                                                                           var discounts = discounts;
                                                                           $(".discnt").html(discounts);


                                                                        } else {


                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('.afdiscount').val(newamount);

                                                                           }

                                                                        }
                                                                     },
                                                                  });


                                                               }



                                                               function calculateSumerdd1() {
                                                                  var sums1 = 0;

                                                                  $("#otherfeeamts1").each(function() {

                                                                     if (!isNaN(this.value) && this.value.length != 0) {



                                                                        sums1 += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");
                                                                     } else if (this.value.length != 0) {
                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums1 == '0') {
                                                                     $('#chkotherfee1 option[value=" "]').attr("selected", true);


                                                                  }



                                                                  var opt = $("#chkotherfee1 option:selected").val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';


                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums1);
                                                                        var idfs = parseInt(idfs) + parseInt(sums1);

                                                                        $('.tamount').text('0');


                                                                        if ($('#otherfeeamts1').val() != '0') {

                                                                           var idf = parseInt(sums1);

                                                                        } else {

                                                                           var idf = parseInt(sums1);
                                                                        }

                                                                        var sumk1 = 0;
                                                                        $('input:checkbox[name="amount[]"]:checked').each(function() {
                                                                           sumk1 += parseFloat($(this).val());
                                                                        });

                                                                        var sumsk1 = 0;
                                                                        $('.StuAttendCkrg:checkbox:checked').each(function() {
                                                                           sumsk1 += parseFloat($(this).val());
                                                                        });




                                                                        if ($('#otherfeeamts').val() != '0' && $('#otherfeeamts').length) {
                                                                           sumsk1 += parseFloat($('#otherfeeamts').val());
                                                                        }


                                                                        if ($('#otherfeeamts0').val() != '0' && $('#otherfeeamts0').length) {
                                                                           sumsk1 += parseFloat($('#otherfeeamts0').val());
                                                                        }

                                                                        if ($('#otherfeeamts2').val() != '0' && $('#otherfeeamts2').length) {
                                                                           sumsk1 += parseFloat($('#otherfeeamts2').val());
                                                                        }


                                                                        if ($('#otherfeeamts3').val() != '0' && $('#otherfeeamts3').length) {
                                                                           sumsk1 += parseFloat($('#otherfeeamts3').val());
                                                                        }


                                                                        if ($('#otherfeeamts4').val() != '0' && $('#otherfeeamts4').length) {
                                                                           sumsk1 += parseFloat($('#otherfeeamts4').val());
                                                                        }


                                                                        if ($('#otherfeeamts5').val() != '0' && $('#otherfeeamts5').length) {
                                                                           sumsk1 += parseFloat($('#otherfeeamts5').val());
                                                                        }


                                                                        var idf = parseInt(sumk1) + parseInt(idf) + parseInt(sumsk1);



                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());

                                                                        var fdiscou = parseFloat($('#fees_discount').val());

                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                           }
                                                                           $('.afdiscount').val(newamount);
                                                                           $(".disfee").html(discounts);
                                                                           var discounts = discounts;
                                                                           $(".discnt").html(discounts);


                                                                        } else {


                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('.afdiscount').val(newamount);

                                                                           }




                                                                        }

                                                                     },
                                                                  });



                                                               }



                                                               function calculateSumerdd2() {
                                                                  var sums2 = 0;

                                                                  $("#otherfeeamts2").each(function() {

                                                                     if (!isNaN(this.value) && this.value.length != 0) {



                                                                        sums2 += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");
                                                                     } else if (this.value.length != 0) {
                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums2 == '0') {
                                                                     $('#chkotherfee2 option[value=" "]').attr("selected", true);


                                                                  }

                                                                  var opt = $("#chkotherfee2 option:selected").val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';


                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums2);
                                                                        var idfs = parseInt(idfs) + parseInt(sums2);

                                                                        $('.tamount').text('0');


                                                                        if ($('#otherfeeamts2').val() != '0') {

                                                                           var idf = parseInt(sums2);

                                                                        } else {

                                                                           var idf = parseInt(sums2);
                                                                        }

                                                                        var sumk2 = 0;
                                                                        $('input:checkbox[name="amount[]"]:checked').each(function() {
                                                                           sumk2 += parseFloat($(this).val());
                                                                        });

                                                                        var sumsk2 = 0;
                                                                        $('.StuAttendCkrg:checkbox:checked').each(function() {
                                                                           sumsk2 += parseFloat($(this).val());
                                                                        });




                                                                        if ($('#otherfeeamts').val() != '0' && $('#otherfeeamts').length) {
                                                                           sumsk2 += parseFloat($('#otherfeeamts').val());
                                                                        }


                                                                        if ($('#otherfeeamts0').val() != '0' && $('#otherfeeamts0').length) {
                                                                           sumsk2 += parseFloat($('#otherfeeamts0').val());
                                                                        }

                                                                        if ($('#otherfeeamts1').val() != '0' && $('#otherfeeamts1').length) {
                                                                           sumsk2 += parseFloat($('#otherfeeamts1').val());
                                                                        }


                                                                        if ($('#otherfeeamts3').val() != '0' && $('#otherfeeamts3').length) {
                                                                           sumsk2 += parseFloat($('#otherfeeamts3').val());
                                                                        }


                                                                        if ($('#otherfeeamts4').val() != '0' && $('#otherfeeamts4').length) {
                                                                           sumsk2 += parseFloat($('#otherfeeamts4').val());
                                                                        }


                                                                        if ($('#otherfeeamts5').val() != '0' && $('#otherfeeamts5').length) {
                                                                           sumsk2 += parseFloat($('#otherfeeamts5').val());
                                                                        }

                                                                        var idf = parseInt(sumk2) + parseInt(idf) + parseInt(sumsk2);



                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());

                                                                        var fdiscou = parseFloat($('#fees_discount').val());

                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                           }
                                                                           $('.afdiscount').val(newamount);
                                                                           $(".disfee").html(discounts);
                                                                           var discounts = discounts;
                                                                           $(".discnt").html(discounts);


                                                                        } else {


                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('.afdiscount').val(newamount);

                                                                           }

                                                                        }

                                                                     },
                                                                  });

                                                               }

                                                               function calculateSumerdd3() {
                                                                  var sums3 = 0;

                                                                  $("#otherfeeamts3").each(function() {

                                                                     if (!isNaN(this.value) && this.value.length != 0) {

                                                                        sums3 += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");
                                                                     } else if (this.value.length != 0) {
                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums3 == '0') {
                                                                     $('#chkotherfee3 option[value=" "]').attr("selected", true);

                                                                  }

                                                                  var opt = $("#chkotherfee3 option:selected").val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';

                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums3);
                                                                        var idfs = parseInt(idfs) + parseInt(sums3);

                                                                        $('.tamount').text('0');


                                                                        if ($('#otherfeeamts3').val() != '0') {

                                                                           var idf = parseInt(sums3);

                                                                        } else {

                                                                           var idf = parseInt(sums3);
                                                                        }

                                                                        var sumk3 = 0;
                                                                        $('input:checkbox[name="amount[]"]:checked').each(function() {
                                                                           sumk3 += parseFloat($(this).val());
                                                                        });

                                                                        var sumsk3 = 0;
                                                                        $('.StuAttendCkrg:checkbox:checked').each(function() {
                                                                           sumsk3 += parseFloat($(this).val());
                                                                        });

                                                                        if ($('#otherfeeamts').val() != '0' && $('#otherfeeamts').length) {
                                                                           sumsk3 += parseFloat($('#otherfeeamts').val());
                                                                        }

                                                                        if ($('#otherfeeamts0').val() != '0' && $('#otherfeeamts0').length) {
                                                                           sumsk3 += parseFloat($('#otherfeeamts0').val());
                                                                        }

                                                                        if ($('#otherfeeamts1').val() != '0' && $('#otherfeeamts1').length) {
                                                                           sumsk3 += parseFloat($('#otherfeeamts1').val());
                                                                        }


                                                                        if ($('#otherfeeamts2').val() != '0' && $('#otherfeeamts2').length) {
                                                                           sumsk3 += parseFloat($('#otherfeeamts2').val());
                                                                        }

                                                                        if ($('#otherfeeamts4').val() != '0' && $('#otherfeeamts4').length) {
                                                                           sumsk3 += parseFloat($('#otherfeeamts4').val());
                                                                        }

                                                                        if ($('#otherfeeamts5').val() != '0' && $('#otherfeeamts5').length) {
                                                                           sumsk3 += parseFloat($('#otherfeeamts5').val());
                                                                        }

                                                                        var idf = parseInt(sumk3) + parseInt(idf) + parseInt(sumsk3);


                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());

                                                                        var fdiscou = parseFloat($('#fees_discount').val());

                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                           }
                                                                           $('.afdiscount').val(newamount);
                                                                           $(".disfee").html(discounts);
                                                                           var discounts = discounts;
                                                                           $(".discnt").html(discounts);


                                                                        } else {


                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);
                                                                              $('.afdiscount').val(newamount);

                                                                           }

                                                                        }

                                                                     },
                                                                  });

                                                               }

                                                               function calculateSumerdd4() {
                                                                  var sums4 = 0;

                                                                  $("#otherfeeamts4").each(function() {

                                                                     if (!isNaN(this.value) && this.value.length != 0) {
                                                                        sums4 += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");
                                                                     } else if (this.value.length != 0) {
                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums4 == '0') {
                                                                     $('#chkotherfee4 option[value=" "]').attr("selected", true);

                                                                  }
                                                                  var opt = $("#chkotherfee4 option:selected").val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';


                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums4);
                                                                        var idfs = parseInt(idfs) + parseInt(sums4);

                                                                        $('.tamount').text('0');


                                                                        if ($('#otherfeeamts4').val() != '0') {

                                                                           var idf = parseInt(sums4);

                                                                        } else {

                                                                           var idf = parseInt(sums4);
                                                                        }

                                                                        var sumk4 = 0;
                                                                        $('input:checkbox[name="amount[]"]:checked').each(function() {
                                                                           sumk4 += parseFloat($(this).val());
                                                                        });

                                                                        var sumsk4 = 0;
                                                                        $('.StuAttendCkrg:checkbox:checked').each(function() {
                                                                           sumsk4 += parseFloat($(this).val());
                                                                        });




                                                                        if ($('#otherfeeamts').val() != '0' && $('#otherfeeamts').length) {
                                                                           sumsk4 += parseFloat($('#otherfeeamts').val());
                                                                        }


                                                                        if ($('#otherfeeamts0').val() != '0' && $('#otherfeeamts0').length) {
                                                                           sumsk4 += parseFloat($('#otherfeeamts0').val());
                                                                        }

                                                                        if ($('#otherfeeamts1').val() != '0' && $('#otherfeeamts1').length) {
                                                                           sumsk4 += parseFloat($('#otherfeeamts1').val());
                                                                        }


                                                                        if ($('#otherfeeamts2').val() != '0' && $('#otherfeeamts2').length) {
                                                                           sumsk4 += parseFloat($('#otherfeeamts2').val());
                                                                        }


                                                                        if ($('#otherfeeamts3').val() != '0' && $('#otherfeeamts3').length) {
                                                                           sumsk4 += parseFloat($('#otherfeeamts3').val());
                                                                        }


                                                                        if ($('#otherfeeamts5').val() != '0' && $('#otherfeeamts5').length) {
                                                                           sumsk4 += parseFloat($('#otherfeeamts5').val());
                                                                        }

                                                                        var idf = parseInt(sumk4) + parseInt(idf) + parseInt(sumsk4);



                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());

                                                                        var fdiscou = parseFloat($('#fees_discount').val());

                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                           }
                                                                           $('.afdiscount').val(newamount);
                                                                           $(".disfee").html(discounts);
                                                                           var discounts = discounts;
                                                                           $(".discnt").html(discounts);


                                                                        } else {

                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('.afdiscount').val(newamount);

                                                                           }



                                                                        }

                                                                     },
                                                                  });



                                                               }


                                                               function calculateSumerdd5() {
                                                                  var sums5 = 0;

                                                                  $("#otherfeeamts5").each(function() {



                                                                     if (!isNaN(this.value) && this.value.length != 0) {



                                                                        sums5 += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");
                                                                     } else if (this.value.length != 0) {
                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums5 == '0') {
                                                                     $('#chkotherfee5 option[value=" "]').attr("selected", true);


                                                                  }



                                                                  var opt = $("#chkotherfee5 option:selected").val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';


                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums5);
                                                                        var idfs = parseInt(idfs) + parseInt(sums5);

                                                                        $('.tamount').text('0');


                                                                        if ($('#otherfeeamts5').val() != '0') {

                                                                           var idf = parseInt(sums5);

                                                                        } else {

                                                                           var idf = parseInt(sums5);
                                                                        }

                                                                        var sumk5 = 0;
                                                                        $('input:checkbox[name="amount[]"]:checked').each(function() {
                                                                           sumk5 += parseFloat($(this).val());
                                                                        });

                                                                        var sumsk5 = 0;
                                                                        $('.StuAttendCkrg:checkbox:checked').each(function() {
                                                                           sumsk5 += parseFloat($(this).val());
                                                                        });




                                                                        if ($('#otherfeeamts').val() != '0' && $('#otherfeeamts').length) {
                                                                           sumsk5 += parseFloat($('#otherfeeamts').val());
                                                                        }


                                                                        if ($('#otherfeeamts0').val() != '0' && $('#otherfeeamts0').length) {
                                                                           sumsk5 += parseFloat($('#otherfeeamts0').val());
                                                                        }

                                                                        if ($('#otherfeeamts1').val() != '0' && $('#otherfeeamts1').length) {
                                                                           sumsk5 += parseFloat($('#otherfeeamts1').val());
                                                                        }


                                                                        if ($('#otherfeeamts2').val() != '0' && $('#otherfeeamts2').length) {
                                                                           sumsk5 += parseFloat($('#otherfeeamts2').val());
                                                                        }


                                                                        if ($('#otherfeeamts3').val() != '0' && $('#otherfeeamts3').length) {
                                                                           sumsk5 += parseFloat($('#otherfeeamts3').val());
                                                                        }


                                                                        if ($('#otherfeeamts4').val() != '0' && $('#otherfeeamts4').length) {
                                                                           sumsk5 += parseFloat($('#otherfeeamts4').val());
                                                                        }

                                                                        var idf = parseInt(sumk5) + parseInt(idf) + parseInt(sumsk5);



                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());

                                                                        // alert($('#fees_discount').val());
                                                                        var fdiscou = parseFloat($('#fees_discount').val());

                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                           }
                                                                           $('.afdiscount').val(newamount);
                                                                           $(".disfee").html(discounts);
                                                                           var discounts = discounts;
                                                                           $(".discnt").html(discounts);


                                                                        } else {


                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('.afdiscount').val(newamount);

                                                                           }




                                                                        }

                                                                     },
                                                                  });



                                                               }
                                                            </script>
                                                            <!----------------------Other Fee Edit Text Script------------------------------->
                                                            <script>
                                                               $(document).ready(function() {

                                                                  $("#otherfeeamts").on("blur", function() {

                                                                     $('#sum1').html('0');
                                                                     $('#dueextras').val('0');

                                                                     calculateSumer();


                                                                  });
                                                               });

                                                               function calculateSumer() {
                                                                  var sums = 0;

                                                                  $("#otherfeeamts").each(function() {

                                                                     if (!isNaN(this.value) && this.value.length != 0) {

                                                                        sums += parseFloat(this.value);
                                                                        $(this).css("background-color", "#FEFFB0");

                                                                     } else if (this.value.length != 0) {

                                                                        $(this).css("background-color", "red");
                                                                     }
                                                                  });


                                                                  if (sums == '0') {
                                                                     $('#chkotherfee option[value=" "]').attr("selected", true);


                                                                  }



                                                                  var opt = $("#chkotherfee option:selected").val();
                                                                  var boardst = '<? echo $students['board_id']; ?>';


                                                                  $.ajax({
                                                                     type: 'POST',
                                                                     url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
                                                                     data: {
                                                                        'opt': opt,
                                                                        'boardst': boardst
                                                                     },
                                                                     beforeSend: function(xhr) {
                                                                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                     },
                                                                     success: function(data) {
                                                                        var idf = parseInt($('.tamount').text()) - parseInt(data);
                                                                        var idfs = parseInt($('.afdiscount').val()) - parseInt(data);
                                                                        var idf = parseInt(idf) + parseInt(sums);
                                                                        var idfs = parseInt(idfs) + parseInt(sums);

                                                                        $('.tamount').text('0');


                                                                        if ($('#otherfeeamts').val() != '0') {

                                                                           var idf = parseInt(sums);

                                                                        } else {

                                                                           var idf = parseInt(sums);
                                                                        }

                                                                        var sumk = 0;
                                                                        $('input:checkbox[name="amount[]"]:checked').each(function() {
                                                                           sumk += parseFloat($(this).val());
                                                                        });

                                                                        var sumsk = 0;
                                                                        $('.StuAttendCkrg:checkbox:checked').each(function() {
                                                                           sumsk += parseFloat($(this).val());
                                                                        });





                                                                        if ($('#otherfeeamts0').val() != '0' && $('#otherfeeamts0').length) {
                                                                           sumsk += parseFloat($('#otherfeeamts0').val());
                                                                        }

                                                                        if ($('#otherfeeamts1').val() != '0' && $('#otherfeeamts1').length) {
                                                                           sumsk += parseFloat($('#otherfeeamts1').val());
                                                                        }


                                                                        if ($('#otherfeeamts2').val() != '0' && $('#otherfeeamts2').length) {
                                                                           sumsk += parseFloat($('#otherfeeamts2').val());
                                                                        }


                                                                        if ($('#otherfeeamts3').val() != '0' && $('#otherfeeamts3').length) {
                                                                           sumsk += parseFloat($('#otherfeeamts3').val());
                                                                        }


                                                                        if ($('#otherfeeamts4').val() != '0' && $('#otherfeeamts4').length) {
                                                                           sumsk += parseFloat($('#otherfeeamts4').val());
                                                                        }

                                                                        if ($('#otherfeeamts5').val() != '0' && $('#otherfeeamts5').length) {
                                                                           sumsk += parseFloat($('#otherfeeamts5').val());
                                                                        }

                                                                        var idf = parseInt(sumk) + parseInt(idf) + parseInt(sumsk);



                                                                        $(".tamount").html(idf);

                                                                        var toi = parseInt($('.tamount').text());
                                                                        var additionaldis = parseInt($('#additionaldis').val());

                                                                        var fdiscou = parseFloat($('#fees_discount').val());

                                                                        if (fdiscou > 0) {
                                                                           var discounts = fdiscou;
                                                                           var newamount = toi - discounts;


                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                           }
                                                                           $('.afdiscount').val(newamount);
                                                                           $(".disfee").html(discounts);
                                                                           var discounts = discounts;
                                                                           $(".discnt").html(discounts);


                                                                        } else {

                                                                           var newamount = toi;

                                                                           if (additionaldis != '0' && newamount >= additionaldis) {
                                                                              var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('#sum1').html('0');
                                                                              $('#dueextras').val('0');
                                                                              $('.afdiscount').val(newamount);

                                                                           } else {
                                                                              $('.newamnt').text(newamount);
                                                                              var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                              $('.newamnts').val(cat);

                                                                              $('.afdiscount').val(newamount);

                                                                           }


                                                                        }
                                                                     },
                                                                  });



                                                               }
                                                            </script>
                                                            <tr>
                                                               <td colspan="4" width="50%">
                                                                  <label>Receipt No.</label>
                                                                  <? $newt = $student_datasm;
                                                                  if ($newt) {  ?>
                                                                     <input name="recipetno" type="text" value="<? echo $newt; ?>" class="form-control" readonly="readonly" required="required" id="recipitno" maxlength="9" placeholder="Enter Receipt No. Here">
                                                                  <? } else { ?>
                                                                     <input name="recipetno" type="text" class="form-control" required="required" id="recipitno" maxlength="9" placeholder="Enter Receipt No. Here">
                                                                  <? } ?>
                                                               </td>
                                                               <td colspan="6" id="formnos1" style="display:none;">
                                                                  <label>Prospectus Form No.</label>
                                                                  <input name="formno" class="form-control" id="formnos" maxlength="9" placeholder="Enter Prospectus Form No.">
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="8" width="50%">
                                                                  <b style=" display:block;">Mode :</b> <span>&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" required id="radio1" name="mode" checked="checked" value="CASH" onclick="return checks(this);">Cash</label>
                                                                     <label class="radio-inline"><input type="radio" name="mode" required id="radio2" onclick="return checks(this);" value="CHEQUE">Cheque</label>
                                                                     <label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="DD" onclick="return checks(this);">DD</label>
                                                                     <label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="NETBANKING" onclick="return checks(this);">Netbanking</label>
                                                                     <label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="Credit Card/Debit Card/UPI" onclick="return checks(this);">Credit Card/Debit Card/UPI</label>
                                                                  </span>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="4" width="50%">
                                                                  <b>Discount : &nbsp; </b>
                                                                  <!----------------------------For Discount Apply Script----------------------------->
                                                                  <script>
                                                                     $(function() {
                                                                        $("#chkdiscountcateg").change(function() {
                                                                           $('#sum1').html('0');
                                                                           $('#dueextras').val('0');
                                                                           $('#fees_discount').val(0);
                                                                           $('#fulldiscount').val(0);

                                                                           $('#additionaldis').val(0);
                                                                           $("#fulldiscount").prop('checked', false);
                                                                           var vatika = '<?php echo $students['class']['id']; ?>';
                                                                           var category = '<?php echo $students['category']; ?>';

                                                                           var selectedText = $(this).find("option:selected").text();

                                                                           var setnumcnt = 0;

                                                                           var toi = parseInt($('.tamount').text());
                                                                           var additionaldis = parseInt($('#additionaldis').val());
                                                                           $('#discountcategorys').val(selectedText);
                                                                           var selectedValue = $(this).val();

                                                                           if (selectedValue != '100') {


                                                                              if (selectedValue > 0) {

                                                                                 var dasr = 0;
                                                                                 $('.StuAttendCk:checkbox:checked').each(function() {
                                                                                    var myselectedid = $(this).attr('id');
                                                                                    var vale = $(this).val();
                                                                                    var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                                                                                    var ffheads = $('#' + cleanUrl).val();

                                                                                    $.ajax({
                                                                                       type: 'POST',
                                                                                       url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                                                                       data: {
                                                                                          'ffheads': ffheads,
                                                                                          'sevalue': selectedValue,
                                                                                          'amty': vale
                                                                                       },
                                                                                       beforeSend: function(xhr) {
                                                                                          xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                                       },
                                                                                       success: function(data) {

                                                                                          if (data > 0) {
                                                                                             dasr++;
                                                                                             var toi = parseInt($('.tamount').text());
                                                                                             var additionaldis = parseInt($('#additionaldis').val());
                                                                                             var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);
                                                                                             $('#fees_discount').val(fdiscou);
                                                                                             var discounts = fdiscou;
                                                                                             var newamount = toi - discounts;

                                                                                             if (additionaldis != '0' && newamount >= additionaldis) {
                                                                                                var newamounts = parseInt(newamount) - parseInt(additionaldis);

                                                                                                $('.newamnt').text(newamount);
                                                                                                var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                                $('.newamnts').val(cat);
                                                                                                $('#sum1').html('0');
                                                                                                $('#dueextras').val('0');
                                                                                             } else {
                                                                                                $('.newamnt').text(newamount);
                                                                                                var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                                $('.newamnts').val(cat);
                                                                                             }
                                                                                             $('.afdiscount').val(newamount);
                                                                                             $(".disfee").html(discounts);
                                                                                             var discounts = discounts;
                                                                                             $(".discnt").html(discounts);

                                                                                          } else {


                                                                                          }
                                                                                       },
                                                                                    });




                                                                                 });


                                                                                 if (dasr == 0) {

                                                                                    $('#fees_discount').val('0');
                                                                                    $(".discnt").html('0');
                                                                                    var newamount = toi;
                                                                                    $('.newamnt').text(toi);
                                                                                    var cat = parseInt($('#lfines').val()) + parseInt(toi);

                                                                                    $('.newamnts').val(cat);

                                                                                    $('.afdiscount').val(toi);
                                                                                    sum1
                                                                                 }
                                                                                 var opt = $('#chkotherfee').find("option:selected").val();


                                                                                 if (opt != '') {
                                                                                    var vale = $('#otherfeeamts').val();
                                                                                    var selectedValue = selectedValue;

                                                                                    var ffheads = opt;

                                                                                    $.ajax({
                                                                                       type: 'POST',
                                                                                       url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                                                                       data: {
                                                                                          'ffheads': ffheads,
                                                                                          'sevalue': selectedValue,
                                                                                          'amty': vale
                                                                                       },
                                                                                       beforeSend: function(xhr) {
                                                                                          xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                                       },
                                                                                       success: function(data) {


                                                                                          if (data > 0) {

                                                                                             var toi = parseInt($('.tamount').text());
                                                                                             var additionaldis = parseInt($('#additionaldis').val());

                                                                                             var fdiscou = parseFloat(data);

                                                                                             $('#fees_discount').val(fdiscou);

                                                                                             var discounts = fdiscou;
                                                                                             var newamount = toi - discounts;


                                                                                             if (additionaldis != '0' && newamount >= additionaldis) {
                                                                                                var newamounts = parseInt(newamount) - parseInt(additionaldis);
                                                                                                $('.newamnt').text(newamount);
                                                                                                var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                                $('.newamnts').val(cat);

                                                                                                $('#sum1').html('0');
                                                                                                $('#dueextras').val('0');
                                                                                             } else {
                                                                                                $('.newamnt').text(newamount);
                                                                                                var cat = parseInt($('#lfines').val()) + parseInt(newamount);
                                                                                                $('.newamnts').val(cat);
                                                                                             }
                                                                                             $('.afdiscount').val(newamount);
                                                                                             $(".disfee").html(discounts);
                                                                                             var discounts = discounts;
                                                                                             $(".discnt").html(discounts);

                                                                                          } else {

                                                                                          }
                                                                                       },
                                                                                    });

                                                                                 } else {

                                                                                 }

                                                                              } else {

                                                                                 $('.tamount').text(toi);
                                                                                 $('.newamnt').text(toi);
                                                                                 var cat = parseInt($('#lfines').val()) + parseInt(toi);
                                                                                 $('.newamnts').val(cat);
                                                                                 $('.afdiscount').val(toi);
                                                                                 $(".disfee").html(0);

                                                                                 $(".discnt").html(0);
                                                                              }

                                                                           } else if (selectedValue == '100') {


                                                                              $("#fees_discount").val('');

                                                                              $(".discnt").html("0");
                                                                              alert("Not Applicable for RTE Discount!!");

                                                                           }

                                                                        });
                                                                     });
                                                                  </script>
                                                                  <?php
                                                                  if ($students['discountcategory'] != '') {
                                                                     $discoutcatryys = $students['discountcategory'];
                                                                  } ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                  <select name="discountcategory" required="required" id="chkdiscountcateg">
                                                                     <option value="0">-No Discount-</option>
                                                                     <?php foreach ($discountCategorylist as $ky => $item) { ?>
                                                                        <option value="<?php echo $item['id']; ?>" <?php if ($item['name'] == $discoutcatryys) { ?> selected="selected" <? } ?>><?php echo $item['name']; ?></option>
                                                                     <?php } ?>
                                                                  </select>
                                                               </td>
                                                               <td colspan="4" width="50%">
                                                                  <b>Paydate : &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                     &nbsp; &nbsp;</b>
                                                                  <? if ($paydatef) { ?>
                                                                     <input type="text" style="max-width:
                                  126px;" class="abs_remark
                                  stuattendance-sa_date " readonly="readonly" name="paydate" maxlength="50" placeholder="Enter Paydate" value="<? echo $paydatef; ?>" required="">
                                                                  <? } else { ?><input type="text" style="max-width:
                                  126px;" class="abs_remark
                                  stuattendance-sa_date " readonly="readonly" name="paydate" maxlength="50" placeholder="Enter Paydate" value="<? echo date('d-m-Y'); ?>" required="">
                                                                  <? } ?>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="4" width="50%">
                                                                  <style>
                                                                     input[type='number'] {
                                                                        -moz-appearance: textfield;
                                                                     }

                                                                     /* Webkit browsers like Safari and Chrome */
                                                                     input[type=number]::-webkit-inner-spin-button,
                                                                     input[type=number]::-webkit-outer-spin-button {
                                                                        -webkit-appearance: none;
                                                                        margin: 0;
                                                                     }
                                                                  </style>
                                                                  <b>Total Amount : &nbsp;</b> <span class="text-black">&#8377; </span><span class="tamount">0</span>
                                                                  <input type="hidden" value="<?php echo $discount_fees; ?>" name="discount" id="fees_discount">
                                                                  <?php
                                                                  foreach ($studentfees as $h => $ff) {
                                                                     if (isset($ff['discountcategory'])) {
                                                                        $discoutcatrysy = $ff['discountcategory'];
                                                                     }
                                                                  }
                                                                  if ($students['discountcategory'] != '') {
                                                                     $discoutcatrysy = $students['discountcategory'];
                                                                  } else {

                                                                     $discoutcatrysy = $discoutcatrysy;
                                                                  }

                                                                  ?>
                                                                  <input type="hidden" value="<? echo $discoutcatrysy; ?>" name="discountcategorys" id="discountcategorys">
                                                               </td>
                                                               <td colspan="4" width="50%">
                                                                  <b>(+)Late Fee :</b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                                                                  <span class="text-black">&#8377; </span>
                                                                  <input name="lfine" style="max-width: 42%;" id="lfines" value="0" type="number">
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="4" width="50%">
                                                                  <b>(-)Discount : </b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-black">&#8377; </span> <span class="discnt"><? if ($discount_fees) {
                                                                                                                                                                                             echo $discount_fees; ?> <? } else { ?> 0 <? }
                                                                           ?></span>
                                                               </td>
                                                               <td colspan="4">
                                                                  <b>(-)Add. Discount :&nbsp; </b>
                                                                  <span class="text-black">&#8377; </span> <input type="number" placeholder="Additional Discount" min="0" id="additionaldis" name="addtionaldiscount" value="0" style="width: 42%;" maxlength="10">
                                                                  <input type="checkbox" name="fulldiscount" value="5" id="fulldiscount" title="Whole Year Fee Discount (5%)" style="display:none;">
                                                               </td>
                                                            </tr>
                                                            <!---------------For Full Discount Click Script----------------------------->
                                                            <script>
                                                               $(document).ready(function() {
                                                                  $("#fulldiscount").on("click", function() {

                                                                     if ($('#fulldiscount:checked').length == '1') {
                                                                        var susm = 0;



                                                                        var fdiscou = 0;
                                                                        var selectedValue = $("#chkdiscountcateg option:selected").val();


                                                                        $('.lnm:checkbox:checked').each(function() {
                                                                           var myselectedid = $(this).attr('id');
                                                                           var vale = $(this).val();
                                                                           var cleanUrl = myselectedid.replace(/^chk/, 'sp');
                                                                           var ffheads = $('#' + cleanUrl).val();
                                                                           $.ajax({
                                                                              type: 'POST',
                                                                              async: false,
                                                                              url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
                                                                              beforeSend: function(xhr) {
                                                                                 xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                                                              },
                                                                              data: {
                                                                                 'ffheads': ffheads,
                                                                                 'sevalue': selectedValue,
                                                                                 'amty': vale
                                                                              },
                                                                              success: function(data) {
                                                                                 if (data > 0) {
                                                                                    fdiscou += parseFloat(data);
                                                                                 } else {
                                                                                    fdiscou += 0;

                                                                                 }
                                                                              },
                                                                           });


                                                                        });

                                                                        $(".lnm").each(function() {

                                                                           if (!isNaN(this.value) && this.value.length != 0) {

                                                                              susm += parseFloat(this.value);

                                                                           } else if (this.value.length != 0) {}
                                                                        });

                                                                        if (confirm("Do You Want to Apply Whole Year Discount(5%) ?")) {


                                                                           var susms = parseInt(susm) - parseInt(fdiscou);



                                                                           var discounsts = susms / 100 * 5;
                                                                           discounsts = Math.floor(discounsts);
                                                                           $("#additionaldis").val(discounsts);
                                                                           var depositamt = parseInt($('#depositamt').val());
                                                                           $('#sum1').html('0');
                                                                           $('#dueextras').val('0');
                                                                           var additionalamt = parseInt($('#additionaldis').val());
                                                                           if (additionalamt == '0') {
                                                                              var caa = $('.afdiscount').val();
                                                                              $('#depositamt').val(caa);

                                                                           } else if (depositamt >= additionalamt) {
                                                                              var remain = parseInt(depositamt) - parseInt(additionalamt);
                                                                              $('#depositamt').val(remain);

                                                                           }

                                                                        } else {

                                                                           $("#fulldiscount").prop('checked', false);

                                                                        }
                                                                     }

                                                                     if ($('#fulldiscount:checked').length == '0') {
                                                                        var susm = 0;
                                                                        $("#fulldiscount").prop('checked', false);
                                                                        $("#additionaldis").val('0');
                                                                        var depositamt = parseInt($('#depositamt').val());
                                                                        $('#sum1').html('0');
                                                                        $('#dueextras').val('0');
                                                                        var additionalamt = parseInt($('#additionaldis').val());
                                                                        if (additionalamt == '0') {
                                                                           var caa = $('.afdiscount').val();
                                                                           $('#depositamt').val(caa);

                                                                        } else if (depositamt >= additionalamt) {
                                                                           var remain = parseInt(depositamt) - parseInt(additionalamt);
                                                                           $('#depositamt').val(remain);

                                                                        }

                                                                     }

                                                                  });
                                                               });
                                                            </script>
                                                            <tr>
                                                               <td colspan="4">
                                                                  <b>Net Amount : &nbsp;&nbsp;&nbsp;&nbsp;</b> <span class="text-black">&#8377; </span><span class="newamnt">0</span>
                                                                  <input type="hidden" value="0" name="fee" class="afdiscount">
                                                                  <input type="hidden" value="<?php echo $academic_year; ?>" name="acedmicyear" class="acedmicyear">
                                                                  <input name="payer" type="hidden" value="" required>
                                                               </td>
                                                               <td colspan="4">
                                                                  <b>Deposit Amount :&nbsp; <span class="text-black">&#8377; </span> </b> <input name="deposite_amt" class="newamnts" id="depositamt" style="width: 43%;" placeholder="Deposit Amount" type="number">
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="4">
                                                                  <b>Due Amount :&nbsp;</b><span id="sum1"></span><input type="hidden" id="dueextras" name="dueextra">
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="4" id="che" style="display:none;">
                                                                  <b>Cheque/Dd No. :&nbsp; </b>
                                                                  <input type="text" placeholder="Cheque/Dd Number" style="max-width: 162px;" id="chequno" onclick="checks(1)" name="cheque_no" maxlength="10">
                                                               </td>
                                                               <td colspan="4" id="bnk" style="display:none;">
                                                                  <b>Bank Name :&nbsp; </b>
                                                                  <input name="bank_id" style="max-width: 141px;" id="bank" placeholder="Enter Name" type="text">
                                                               </td>
                                                               <td colspan="4" id="ref" style="display:none;">
                                                                  <b>Reference No. :&nbsp; </b>
                                                                  <input type="text" id="refno" style="max-width: 152px;" onclick="" placeholder="Reference Number" name="ref_no" maxlength="25">
                                                               </td>
                                                            </tr>
                                                         <?php  }  ?>
                                                         <tr>
                                                            <?
                                                            if ($students['discountcategory'] != '') {
                                                               $discoutcatrysy = $students['discountcategory'];
                                                            }
                                                            if ($discoutcatrysy != '') { ?>
                                                               <td colspan="4" width="50%" style="color:red;">
                                                                  <b>Discount Taken :</b> <? if ($discoutcatrysy) {
                                                                                             echo " " . $discoutcatrysy;
                                                                                          } elseif ($discoutcatrysy) {
                                                                                             echo " " . $discoutcatrysy;
                                                                                          } ?>
                                                               </td>
                                                            <? } ?>
                                                            <td colspan="4" id="bnkcancellation" style="display:none;">
                                                               <b>Cancellation Charge :</b>
                                                               <input name="cancelid" id="cancelid" id='0' type="hidden">
                                                               <input name="bank_charge" style="max-width: 123px;" id="bankcharged" placeholder="Charge" type="number" maxlength='10'>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td colspan="8"><label>Remarks :</label>
                                                               <textarea name="remarks" class="form-control rounded-0" id="exampleFormControlTextarea2" placeholder="Enter Remarks Here" rows="3"></textarea>
                                                               <input type="hidden" name="student_id" value="<?php echo $students['id']; ?>">
                                                            </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="box-footer">
                                             <?php
                                             if (isset($classes['id'])) {
                                                echo $this->Form->submit(
                                                   'Update Fee',
                                                   array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                                                );
                                             } else {
                                                echo $this->Form->submit(
                                                   'Update Fee',
                                                   array('class' => 'btn btn-info pull-right addgen', 'title' => 'Update Fee', 'style' => 'display:none;')
                                                );
                                                echo $this->Form->submit(
                                                   'Cancel Recipiet',
                                                   array('class' => 'btn btn-info pull-right addgen23', 'title' => 'Cancel Recipiet', 'style' => 'display:none;')
                                                );
                                             }
                                             if (1 == 1) {


                                             ?>
                                                <?php
                                                echo $this->Html->link('Back', [
                                                   'action' => 'view'

                                                ], ['class' => 'btn btn-default']); ?>
                                          </div>
                                          <?php echo $this->Form->end(); ?>
                                       <? } else { ?>
                                          <div class="table-responsive">
                                             <table class="table table-striped table-hover" id="mytable">
                                                <tbody>
                                                   <tr class="table_header">
                                                      <th style="text-align:center;"> No Fees Structure for RTE Student!!</th>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       <? } ?>
                                       <!-- Am Comment due to not work -Rupam 14/04/2022 -->
                                       <script>
                                          //   $(document).ready(function(){
                                          //   $('.modalcancel').on('click',function(){
                                          //      alert('Rupam')
                                          //   	$('.nkid').val('');
                                          //   	$('.academikid').val('');
                                          //   	$('.textryu').val('');

                                          //   var idn = $(this).data("val");
                                          //   $('.nkid').val(idn);
                                          //   var recipetn = $(this).data("id");

                                          //   $('.ert').html(recipetn);
                                          //   var academicy = $(this).data("options");
                                          //   $('.academikid').val(academicy);

                                          //   });
                                          //   });
                                       </script>
                                       <!-- Modal -->
                                       <div class="modal fade" id="myModal" role="dialog">
                                          <div class="modal-dialog">
                                             <form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_formtest" validate="validate" action="<? echo ADMIN_URL; ?>studentfees/cancelledstudent">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                   <div class="modal-header" style="background-color: #3c8dbc;">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Are You Sure ? Do You Want To Cancel This Reference No. <b class="ert"> </b></h4>
                                                   </div>
                                                   <div class="modal-body">
                                                      <textarea type="text" class="textryu" name="remarks" required="required" cols="75" rows="5" placeholder="Enter Remarks For Cancellation...."></textarea>
                                                      <input type="hidden" name="id" class="nkid" value="<?php echo $valsf['id']; ?>">
                                                      <input type="hidden" name="academicyear" class="academikid" value="<?php echo $academic_year; ?>">
                                                   </div>
                                                   <div class="modal-footer">
                                                      <div class="submit">
                                                         <input type="submit" class="btn btn-info pull-right" title="Cancel" style="display: block;" value="Submit">
                                                         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                      </div>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                       <!----------------------End Of Deposit Fee------------------------------>
                                 </div>
                     </section>
                     <!-- for add student from transport  modal -->
                     <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-body">
                                 <div class="loader">
                                    <div class="es-spinner">
                                       <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- for drop student from transport  modal -->
                     <div class="modal" id="globalModaldrop" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-body">
                                 <div class="loader">
                                    <div class="es-spinner">
                                       <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
   </section>
</div>