<?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
<section class="tabs-menu leftMenu">
    <div class="drawerLogo">
        <?php if ($role_id == '105') {  ?>
            <a href="<?php echo SITE_URL; ?>admin/dashboards/headbranch/">
            <?php } else { ?>
                <a href="<?php echo SITE_URL; ?>admin/dashboards/adminbranch/">
                <?php  } ?>
                <?php $findlogo = $this->Comman->findlogo();
                ?>
                <!-- <img src="<?php //echo SITE_URL;
                                ?>images/<?php //echo $findlogo['header_logo']; 
                                                                ?>" class="fullLogo" alt="logo"> -->
                <img src="<?php echo SITE_URL; ?>images/<?php echo $findlogo['small_logo']; ?>" class="fullLogo" alt="logo">

                <img src="<?php echo SITE_URL; ?>images/<?php echo $findlogo['small_logo']; ?>" class="smallLogo" alt="logo">
                </a>
    </div>
    <!-- <div class="container-fluid">
      <div class="row">
          <div class="col-sm-3"> -->
    <?php $findmenumodule = $this->Comman->findrolemenu(); 

    ?>
    <ul class="nav nav-tabs sideMenu">
        <?php $menu = 0;
        $i = 0;
       foreach ($findmenumodule as $key => $itemd) { //pr($itemd);die;
        // pr($itemd);die;
            
        ?>
            <li class="mainMenu<?php echo $menu; ?>">
                <a data-toggle="tab" href="#menu11<?php echo $i; ?>">
                    <!-- <i class="fa fa-user" aria-hidden="true"></i> -->
                    <?php $file =  '/var/www/html/idsprime/webroot/images/' . $itemd['module'] . '-manager.png';
                    if ($file) {   ?>
                        <img src="<?php echo SITE_URL; ?>images/<?php echo $itemd['module']; ?>-manager.png">
                    <?php } else {  ?>
                        <img src="<?php echo SITE_URL; ?>images/Prospectus-manager.png" alt="Registration Manager">
                    <?php } ?>
                    <span><?php echo $itemd['module']; ?></span>
                    <i class="fa fa-chevron-right pull-right" aria-hidden="true"></i>
                 
                </a>


                <script>
                    $(document).ready(function() {
                        $(".mainMenu<?php echo $menu; ?> a").click(function() {
                            $(".mainMenu<?php echo $menu; ?>").addClass("step2");
                        });
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        $(".tabHeading").click(function() {
                            $(".mainMenu<?php echo $menu; ?>").removeClass("step2");
                        });
                    });
                </script>
                <!-- <div id="menu11<?php echo $i; ?>" class="tab-pane fade <?php if ($i == '0') { ?> in active <?php } ?>"> -->
                <ul>
                    <!-- <li>
               <a href="#">
                   <i class="fa fa-users"></i>
                   <span><?php echo $itemd['module']; ?></span>
               </a>
               </li> -->
                    <p class="menuBack">
                        <a href="#" class="tabHeading">
                            <!-- <i class="fa fa-users"></i> -->
                            <?php if ($file) {   ?>
                                <img src="<?php echo SITE_URL; ?>images/<?php echo $itemd['module']; ?>-manager.png" alt="Registration Manager">
                                <span><?php echo $itemd['module']; ?></span>
                                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            <?php } else {  ?>
                                <img src="<?php echo SITE_URL; ?>images/Prospectus-manager.png" alt="Registration Manager">
                                <span><?php echo $itemd['module']; ?></span>
                                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            <?php } ?>
                        </a>
                    </p>
                    <?php $findmenumodulejk = $this->Comman->findrolemenucontent($itemd['module']);
                    foreach ($findmenumodulejk as $jki => $rty) {
                        if ($rty['action'] == "prospectus_add") { //echo 'hello'; die; 
                    ?>
                            <li>
                                <a id="update-data" href="<?php echo SITE_URL; ?>admin/<?php echo $rty['controller']; ?>/<?php echo $rty['action']; ?>" data-target="#globalModalkj" data-toggle="modal" data-modal-size="modal-lg">
                                    <?php
                                    $file =  '/var/www/html/idsprime/webroot/images/subMenu/' . $rty['menu'] . '-sub.png';
                                    if ($file) {  ?>
                                        <img src="<?php echo SITE_URL; ?>images/subMenu/<?php echo $rty['menu']; ?>-sub.png" alt="submenu" class="submenuIcon">
                                    <?php } else {  ?>
                                        <img src="<?php echo SITE_URL; ?>images/subMenu/View All Prospectus-sub.png" alt="Registration Manager" alt="submenu" class="submenuIcon">
                                    <?php } ?>
                                    <span><?php echo $rty['menu']; ?></span>
                                </a>
                            </li>
                        <?php } else {
                            //sanjay code 28-12-2022
                            $helpcount = $this->Comman->helpcount($rty['action']);
                        ?>
                            <li style="display: flex; align-items: center;">
                                <a href="<?php echo ADMIN_URL; ?><?php echo $rty['controller']; ?>/<?php echo $rty['action']; ?>">
                                    <!-- <i class="fa fa-reorder"></i> -->
                                    <?php
                                    $file =  '/var/www/html/idsprime/webroot/images/subMenu/' . $rty['menu'] . '-sub.png';
                                    if ($file) {   ?>
                                        <img src="<?php echo SITE_URL; ?>images/subMenu/<?php echo $rty['menu']; ?>-sub.png" alt="submenu" class="submenuIcon">
                                    <?php } else { ?>
                                        <img src="<?php echo SITE_URL; ?>images/subMenu/View All Prospectus-sub.png" alt="Registration Manager" alt="submenu" class="submenuIcon">
                                    <?php } ?>
                                    <span><?php echo $rty['menu']; ?></span>
                                </a>
                                <?php
                                //sanjay code 28-12-2022
                                if ($rty['module'] == "Help Manager") {
                                    echo '<div  style="
                    color: yellow;
                   ">(' . $helpcount[0]['count'] . ')</div>';
                                } ?>
                            </li>
                    <?php }
                    } ?>
                    <li class="returnBack">
                        <a href="#" class="tabHeading"><i class="fas fa-undo"></i> <span>Back To Menu</span></a>
                    </li>
                </ul>
            </li>
        <?php $menu++;
            $i++;
        } ?>
    </ul>
    <!-- </div> -->
    <!--col-sm-3-->
    <!-- </div> -->
    <!--row-->
</section>
<?php //} 
?>
<!-- For Side Menu -->
<script>
    $(document).ready(function() {
        // $(".mainMenu0 a").click(function() {
        //     $(".mainMenu0").addClass("step2");
        // });
        $(".registrationManagerMenu a").click(function() {
            $(".registrationManagerMenu").addClass("step2");
        });
        $(".admissionMenu a").click(function() {
            $(".admissionMenu").addClass("step2");
        });
        $(".FeesMasterTab a").click(function() {
            $(".FeesMasterTab").addClass("step2");
        });
        $(".reportCenterTab a").click(function() {
            $(".reportCenterTab").addClass("step2");
        });
        $(".schoolStaffTab a").click(function() {
            $(".schoolStaffTab").addClass("step2");
        });
        $(".galleryTab a").click(function() {
            $(".galleryTab").addClass("step2");
        });
        $(".notificationsTab a").click(function() {
            $(".notificationsTab").addClass("step2");
        });
        $(".homeworkTab a").click(function() {
            $(".homeworkTab").addClass("step2");
        });

        $(".feesReport a").click(function() {
            $(".feesReport").addClass("step3");
        });
        $(".academicReport a").click(function() {
            $(".academicReport").addClass("step3");
        });
        $(".academicReport2 a").click(function() {
            $(".academicReport2").addClass("step3");
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".tabHeading").click(function() {
            $(".registrationManagerMenu").removeClass("step2");
        });
        $(".tabHeading").click(function() {
            $(".admissionMenu").removeClass("step2");
        });
        $(".tabHeading").click(function() {
            $(".FeesMasterTab").removeClass("step2");
        });
        $(".tabHeading").click(function() {
            $(".reportCenterTab").removeClass("step2");
        });
        $(".tabHeading").click(function() {
            $(".schoolStaffTab").removeClass("step2");
        });

        $(".tabHeading").click(function() {
            $(".galleryTab").removeClass("step2");
        });

        $(".tabHeading").click(function() {
            $(".notificationsTab").removeClass("step2");
        });

        $(".tabHeading").click(function() {
            $(".homeworkTab").removeClass("step2");
        });


        $(".tabHeading2 ").click(function() {
            $(".feesReport").removeClass("step3");
        });
        $(".tabHeading2 ").click(function() {
            $(".academicReport").removeClass("step3");
        });
        $(".tabHeading2 ").click(function() {
            $(".academicReport2").removeClass("step3");
        });
    });
</script>
<!-- <script>
   (function($) {
       'use strict';
   
       // call our plugin
       var Nav = new hcOffcanvasNav('#main-nav', {
           disableAt: false,
           customToggle: '.toggle',
           levelSpacing: 40,
           navTitle: 'All Categories',
           levelTitles: true,
           levelTitleAsBack: true,
           pushContent: '#container',
           labelClose: false
       });
   
       // add new items to original nav
       $('#main-nav').find('li.add').children('a').on('click', function() {
           var $this = $(this);
           var $li = $this.parent();
           var items = eval('(' + $this.attr('data-add') + ')');
   
           $li.before('<li class="new"><a href="#">' + items[0] + '</a></li>');
   
           items.shift();
   
           if (!items.length) {
               $li.remove();
           } else {
               $this.attr('data-add', JSON.stringify(items));
           }
   
           Nav.update(true); // update DOM
       });
   
       // demo settings update
   
       const update = function(settings) {
           if (Nav.isOpen()) {
               Nav.on('close.once', function() {
                   Nav.update(settings);
                   Nav.open();
               });
   
               Nav.close();
           } else {
               Nav.update(settings);
           }
       };
   
       $('.actions').find('a').on('click', function(e) {
           e.preventDefault();
   
           var $this = $(this).addClass('active');
           var $siblings = $this.parent().siblings().children('a').removeClass('active');
           var settings = eval('(' + $this.data('demo') + ')');
   
           if ('theme' in settings) {
               $('body').removeClass().addClass('theme-' + settings['theme']);
           } else {
               update(settings);
           }
       });
   
       $('.actions').find('input').on('change', function() {
           var $this = $(this);
           var settings = eval('(' + $this.data('demo') + ')');
   
           if ($this.is(':checked')) {
               update(settings);
           } else {
               var removeData = {};
               $.each(settings, function(index, value) {
                   removeData[index] = false;
               });
   
               update(removeData);
           }
       });
   })(jQuery);
   </script> -->