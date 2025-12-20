<style>
table {
    border: 1px solid #e7e7e7 !important;
}

table td,
table th {
    font-size: 12px;
    border: 1px solid #e7e7e7 !important;
}

.homeDashboardHO .view {
    display: flex;
    flex-wrap: wrap;
    margin-left:-15px;
    margin-right:-15px;
}

.homeDashboardHO .view .column {
    width: 20%;
    padding:0px 15px;
}
</style>

<div class="content-wrapper">
    <div id="homeDashboard" class="homeDashboardHO">
        <div class="container-fluid">
            <div class="blockView">
                <div class="view">
                    <div class="column">
                        <div class="detailBlocks">
                            <img src="<?php echo SITE_URL;?>images/total-students-block.png" alt="icon" />
                            <div class="blockData">
                                <p>Total Branches</p>
                                <h5>20</h5>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="detailBlocks green">
                            <img src="<?php echo SITE_URL;?>images/library-block.png" alt="icon" />
                            <div class="blockData">
                                <p>Total Staff</p>
                                <h5>1200</h5>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="detailBlocks brown">
                            <img src="<?php echo SITE_URL;?>images/staff-block.png" alt="icon" />
                            <div class="blockData">
                                <p>Total Students</p>
                                <h5>500</h5>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="detailBlocks pink">
                            <img src="<?php echo SITE_URL;?>images/new-admission-block.png" alt="icon" />
                            <div class="blockData">
                                <p>Total Attendance</p>
                                <h5>9000</h5>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="detailBlocks maroon">
                            <img src="<?php echo SITE_URL;?>images/new-admission-block.png" alt="icon" />
                            <div class="blockData">
                                <p>Fees</p>
                                <h5>20 Lac</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>