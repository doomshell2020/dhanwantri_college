<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class PayrollController extends AppController
{
    //initialize component
    public function beforeFilter(Event $event)
    {
    $this->Auth->allow(['salary_slip']);
    }
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Employees');
        $this->loadModel('Departments');
        $this->loadModel('Ledger');
        $this->loadModel('Salary');
        $this->loadModel('Payroll');
        $this->loadModel('Empsalary');
        $this->loadModel('Vouchername');
        $this->loadModel('Voucher');
        $this->loadModel('Ledger');
        $this->loadModel('Employeesalary');
        $this->loadModel('PayrollDepartments');
        $this->loadModel('DropOutEmployee');
        $this->loadModel('Leaves');
        $this->loadModel('Leavetype');
        $this->loadModel('EmployeeAttendance');

    }

    public function index($id = null)
    {
        $this->viewBuilder()->layout('admin');

        //show data in listing

        $pay = $this->Payroll->find('all')->first();
        $Departments = $this->Employees->find('all')->order(['Employees.id' => 'Desc'])->toarray();
        //pr($Departments); die;
        $this->set("employee", $Departments);
        $this->set("pay", $pay);
        // $payroll=$this->Payroll->find('first',array('conditions'=>array(),'recursive'=>-1));

    }
    public function addcsv()
    {

        $this->viewBuilder()->layout('admin');

    }

    public function add_excel()
    {

        $this->loadModel('Employeesanskar');

        if ($this->request->is(['post'])) {

            try {

                //pr($this->request->data); die;

                if ($this->request->data['file']['tmp_name']) {

                    $empexcel = $this->request->data['file'];
                    $excel_array = $this->get_excel_data($empexcel['tmp_name']);
//pr($excel_array); die;

                    foreach ($excel_array as $refer_data) {
                        $employee = $this->Employee->newEntity();

                        $employee = $this->Employee->patchEntity($employee, $refer_data);

                        $employee = $this->Employee->save($employee);

                    }

                    if ($employee) {
                        $this->Flash->success(__('Employees details  has been saved Successfully.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }

            } catch (\PDOException $e) {

                $this->Flash->error(__('Error:' . $e->getmessage()));
                $this->set('error', $error);
                return $this->redirect(['action' => 'add']);
            }

        }

    }

    public function get_excel_data($inputfilename)
    {

        if ($_POST) {
            //$inputfilename = $_FILES['file']['tmp_name'];
            try {
                $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $sheet = $objPHPExcel->getSheet(0);
            //pr($sheet); die;
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $c = 0;

            $firstrow = 1;
            $firstsop = $sheet->rangeToArray('A' . $firstrow . ':' . $highestColumn . $firstrow, null, true, false);
            for ($row = 2; $row <= $highestRow; $row++) {
                $filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
                //pr($filesop);

                $colB = $objPHPExcel->getActiveSheet()->getCell('A' . $row)->getValue();

                if ($colB == null || $colB == '') {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $objPHPExcel->getActiveSheet()->getCell('A' . ($row - 1))->getValue());

                }
                if ($filesop[0][0] != '') {
                    $exceldata['sanskar_eid'] = $filesop[0][0];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Employee id.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][1] != '') {
                    $exceldata['name'] = $filesop[0][1];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Employee name.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][2] != '') {
                    $exceldata['dob'] = $filesop[0][2];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Date Of Birth.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][3] != '') {
                    $exceldata['gender'] = $filesop[0][3];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Gender.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][4] != '') {
                    $exceldata['departments'] = $filesop[0][4];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Department.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][5] != '') {
                    $exceldata['designation'] = $filesop[0][5];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Designation.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][6] != '') {
                    $exceldata['father_hus_name'] = $filesop[0][6];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Father husband name.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][7] != '') {
                    $exceldata['email'] = $filesop[0][7];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Email.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][8] != '') {
                    $exceldata['cnum'] = $filesop[0][8];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Contact no.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][9] != '') {
                    $exceldata['basicsalary'] = $filesop[0][9];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Basic Salary.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][10] != '') {
                    $exceldata['Da'] = $filesop[0][10];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete DA.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][11] != '') {
                    $exceldata['sd'] = $filesop[0][11];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete SD.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][12] != '') {
                    $exceldata['bankaccountno'] = $filesop[0][12];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Bank Account no.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][13] != '') {
                    $exceldata['uan'] = $filesop[0][13];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete UAN NO.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][15] != '') {
                    $exceldata['pfnumber'] = $filesop[0][15];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete PF NO.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][14] != '') {
                    $exceldata['esi'] = $filesop[0][14];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete ESI NO.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][16] != '' || $filesop[0][16] == '0') {
                    $exceldata['leve'] = $filesop[0][16];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Leave Deduction.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][17] != '' || $filesop[0][17] == '0') {
                    $exceldata['HRA'] = $filesop[0][17];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete HRA.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][18] != '' || $filesop[0][18] == '0') {
                    $exceldata['LTA'] = $filesop[0][18];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete LTA.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][19] != '' || $filesop[0][19] == '0') {
                    $exceldata['TA'] = $filesop[0][19];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete TA.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][20] != '' || $filesop[0][20] == '0') {
                    $exceldata['PF'] = $filesop[0][20];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete PF.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][21] != '' || $filesop[0][21] == '0') {
                    $exceldata['ESI_choice'] = $filesop[0][21];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete ESI Choice.'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($filesop[0][22] != '' || $filesop[0][22] == '0') {
                    $exceldata['EPS'] = $filesop[0][22];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete EPS.'));
                    return $this->redirect(['action' => 'index']);
                }

                if ($filesop[0][23] != '') {
                    $exceldata['joinning_date'] = $filesop[0][23];
                } else {
                    $this->Flash->error(__('Your excel contains incomplete Joining Date .'));
                    return $this->redirect(['action' => 'index']);
                }

                $csv_data[] = $exceldata;
            }
            // $this->Flash->success(__('Refer has been added successfully'));

            return $csv_data;
        } else {
        }
    }

    public function syncsanskardata($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Employees');
        $this->loadModel('Employeesalary');
        $this->loadModel('Departments');
        $this->loadModel('Designations');
        // show data in listing
        // $tyu = $this->Employeesalary->find('all')->order(['id' => 'ASC'])->toarray();
        // if (empty($tyu)) {
        //     $this->Flash->error(__('There is NO Employee for salary generation.'));
        //     return $this->redirect(['action' => 'Salary_add']);

        // }
        // die;
        $employ = $this->Employeesalary->find('all')->contain(['Employees'])->where(['Employeesalary.update_emp !=' => 0])->toarray();
        //pr($employ);die;
        if (empty($employ)) {
            $this->Flash->error(__('There is NO Employee for salary generation.'));
            return $this->redirect(['action' => 'Salary_add']);

        }

        foreach ($employ as $val) {

            $accountemploy = $this->Employees->find('all')->where(['id' => $val['employee_id']])->first();
            //pr($accountemploy);die;
            $dept = $this->Departments->find('all')->where(['id' => $val['employee']['department_id']])->first();
            $desig = $this->Designations->find('all')->where(['id' => $val['employee']['designation_id']])->first();
            //pr($accountemploy);
            if (isset($accountemploy)) {
                $empl = $this->Employees->get($accountemploy['id']);
                $fn['name'] = $val['employeesanskar']['fname'] . ' ' . $val['employeesanskar']['middlename'] . ' ' . $val['employeesanskar']['lname'];
                $fn['gender'] = $val['employeesanskar']['gender'];
                $fn['dob'] = date('Y-m-d', strtotime($val['employeesanskar']['dob']));
                $fn['cnum'] = $val['employeesanskar']['mobile'];
                $fn['father_hus_name'] = $val['employeesanskar']['f_h_name'];
                $fn['email'] = $val['employeesanskar']['email'];
                $fn['departments'] = $dept['name'];
                $fn['designation'] = $desig['name'];
                $fn['status'] = $val['employeesanskar']['status'];
                $fn['joinning_date'] = date('Y-m-d', strtotime($val['employeesanskar']['joiningdate']));
                $empl = $this->Employees->patchEntity($empl, $fn);
                $erfg = $this->Employees->save($empl);
                if ($erfg) {
                    $mid = 0;
                    //$conn = ConnectionManager::get('sanskar');
                    $detail = 'UPDATE `employee_salary_setting` SET `update_emp` ="' . $mid . '" WHERE `employee_salary_setting`.`employee_id` = ' . $val['employee_id'];
                    $results = $conn->execute($detail);

                }

            }

            if (!isset($accountemploy)) {
                $emplo = $this->Employees->newEntity();
                $tn['sanskar_eid'] = $val['employee_id'];
                $tn['name'] = $val['employeesanskar']['fname'] . ' ' . $val['employeesanskar']['middlename'] . ' ' . $val['employeesanskar']['lname'];
                $tn['gender'] = $val['employeesanskar']['gender'];
                $tn['dob'] = date('Y-m-d', strtotime($val['employeesanskar']['dob']));
                $tn['cnum'] = $val['employeesanskar']['mobile'];
                $tn['father_hus_name'] = $val['employeesanskar']['f_h_name'];
                $tn['email'] = $val['employeesanskar']['email'];
                $tn['departments'] = $dept['name'];
                $tn['designation'] = $desig['name'];
                $tn['status'] = $val['employeesanskar']['status'];
                $tn['joinning_date'] = date('Y-m-d', strtotime($val['employeesanskar']['joiningdate']));
                $tn['basicsalary'] = $val['basic_salary'];
                $tn['pfnumber'] = $val['pfnumber'];
                $tn['bankaccountno'] = $val['bank_account_no'];
                $tn['uan'] = $val['uan_no'];
                $tn['esi'] = $val['esi_no'];
                $tn['Da'] = $val['da'];
                $tn['sd'] = $val['sd'];
                $tn['leve'] = $val['leve'];
                $tn['HRA'] = $val['HRA'];
                $tn['LTA'] = $val['LTA'];
                $tn['TA'] = $val['TA'];
                $tn['PF'] = $val['PF'];
                $tn['ESI_choice'] = $val['ESI_choice'];
                $tn['EPS'] = $val['EPS'];

                $emplo = $this->Employee->patchEntity($emplo, $tn);
                $sdfg = $this->Employee->save($emplo);

                if ($sdfg) {
                    $tid = 0;
                    //$conn = ConnectionManager::get('sanskar');
                    $detail = 'UPDATE `employee_salary_setting` SET `update_emp` ="' . $tid . '" WHERE `employee_salary_setting`.`employee_id` = ' . $val['employee_id'];
                    $results = $conn->execute($detail);
                }
            }

        }

        $depart = $this->Employee->find('all')->order(['id' => 'ASC'])->toarray();
        $this->set('depart', $depart);

    }

    //~ public function employeenamefinder(){
    //~ $b_name=$this->request->data['b_name'];

    //~ if( $b_name != '')
    //~ {
    //~ //show data in listing
    //~ $evbn=$this->Employee->find('all')->select(['id', 'name'])->where(['Employee.name LIKE'=>$b_name.'%'])
    //~ ->order(['Employee.name' => 'ASC'])->toarray();
    //~ $entity=array();
    //~ if(!empty($evbn)){
    //~ foreach($evbn as $val){

    //~ $entity[]=    $val['name'];
    //~ $entity[]=    $val['id'];
    //~ }
    //~ }
    //~ }
    //~ else
    //~ {
    //~ $data_list[] = [];
    //~ }
    //~ header("Content-Type: application/json");
    //~ echo json_encode($entity);

    //~ die();
    //~ // $payroll=$this->Payroll->find('first',array('conditions'=>array(),'recursive'=>-1));

    //~ }

    public function employeenamefinder()
    {
        $this->loadModel('Location');
        $prosuper = $this->request->data['fetch'];
        $i = $this->request->data['i'];
        $evbn = $this->Employee->find('all')->select(['id', 'name'])->where(['Employee.name LIKE' => $prosuper . '%'])
            ->order(['Employee.name' => 'ASC'])->toarray();
        if (isset($evbn) && $evbn['0']['id'] != '') {
            foreach ($evbn as $value) {
                echo '<li onclick="cllbck(' . "'" . $value['name'] . "'" . ',' . "'" . $value['id'] . "'" . ',' . "'" . $i . "'" . ')"><a href="#">' . $value['name'] . '</a></li>';
            }
        } else {
            echo '<li style="font-size:16px;color:#000;">No record Found</li>';
        }

        die;
    }

    public function add($id = null)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Employees');
        $locations = $this->Employees->find('list', ['keyField' => 'id', 'valueField' => 'name'])->order(['fname' => 'ASC'])->toArray();
        //$Departments=$this->Departments->find('list', ['keyField' => 'id','valueField' => 'title'])->order(['title' => 'ASC'])->toArray();

        $this->set(compact('locations'));
        $this->set("de", $Departments);
        if (isset($id) && !empty($id)) {

            $transports = $this->Employees->get($id);

        } else {

            $transports = $this->Employees->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); die;
            $empname = $this->request->data['name'];
            if (!isset($this->request->data['leve'])) {
                $this->request->data['leve'] = 0;
            }
            if (!isset($this->request->data['HRA'])) {
                $this->request->data['HRA'] = 0;
            }
            if (!isset($this->request->data['LTA'])) {
                $this->request->data['LTA'] = 0;
            }
            if (!isset($this->request->data['TA'])) {
                $this->request->data['TA'] = 0;
            }
            if (!isset($this->request->data['PF'])) {
                $this->request->data['PF'] = 0;
            }
            if (!isset($this->request->data['ESI_choice'])) {
                $this->request->data['ESI_choice'] = 0;
            }
            if (!isset($this->request->data['EPS'])) {
                $this->request->data['EPS'] = 0;
            }

            // save all data in database

            //this->request->data['gender']=$this->request->data['data']['Employee']['gender'];

            $transports = $this->Employees->patchEntity($transports, $this->request->data);
            //pr($transports); die;
            if ($resu = $this->Employees->save($transports)) {
                $lastinsid = $resu->id;
                $this->Flash->success(__('Employee has been saved.'));

                $name = $this->Ledger->find('all')->where(['Ledger.empid' => $lastinsid])->first();

                if (!empty($name)) {
                    $led = $this->Ledger->get($name['id']);
                } else {
                    $led = $this->Ledger->newEntity();
                }
                $this->request->data['title'] = $this->request->data['name'];
                $this->request->data['gid'] = 16;
                $this->request->data['cperson'] = $this->request->data['name'];
                $this->request->data['cmobile'] = $this->request->data['cnum'];
                $this->request->data['caddress'] = $this->request->data['address'];
                $this->request->data['tin'] = 0;
                $this->request->data['empid'] = $lastinsid;

                //    pr($this->request->data); die;
                $ledger = $this->Ledger->patchEntity($led, $this->request->data);

                $this->Ledger->save($ledger);

                return $this->redirect(['action' => 'index']);

            }

        }

        $this->set('transports', $transports);
    }

    //view functionality

    //delete functionality
    public function delete($id)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $classes = $this->Employee->get($id);
        //delete pariticular entry
        if ($this->Employee->delete($classes)) {
            $this->Flash->success(__(' Employee with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }
    //status update functionality

    public function get_salary_data($inputfilename)
    {

        if ($_POST) {

            //$inputfilename = $_FILES['file']['tmp_name'];
            try {
                //echo $inputfilename; die;
                $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);

            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //$sheet = $objPHPExcel->getSheet(0);
            $sheet = $objPHPExcel->getWorksheetIterator();
            //pr($sheet); die;
            $dataArr = array();
            foreach ($sheet as $hj) {
                $highestRow = $hj->getHighestDataRow();
                $highestColumn = $hj->getHighestColumn();
                $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($row = 2; $row <= $highestRow; ++$row) {
                    for ($col = 0; $col < $highestColumnIndex; ++$col) {
                        $cell = $hj->getCellByColumnAndRow($col, $row);
                        $val = $cell->getValue();
                        $dataArr[$row][$col] = $val;
                    }
                }
            }
            //pr($dataArr);  die;

            foreach ($dataArr as $df) {
                $sala = $this->Salary->newEntity();
                $tn['Eid'] = $df['0'];
                $tn['NAME'] = $df['1'];
                $tn['file'] = $this->request->data['csv']['name'];
                $tn['date'] = $this->request->data['date'];
                $tn['Leaves'] = $df['4'];
                $tn['mode'] = $this->request->data['department'];
                $sala = $this->Salary->patchEntity($sala, $tn);
                $this->Salary->save($sala);
                //pr($sala);
            }
        } else {
        }
    }

    public function salary_calc()
    {
        $this->autoRender = false;
        $this->loadModel('Employeeattendance');
        $this->loadModel('Employeesalary');
        $this->loadModel('Leaves');
        $this->loadModel('Employee');
        $this->loadModel('Salary');
        $this->loadModel('Holidayallowance');
        $this->loadModel('Events');
        $this->loadModel('PayrollDepartments');
        $this->loadModel('Carryforward');

        if ($this->request->is('post') || $this->request->is('put')) {
            // pr($_POST);die;
            $salaryofmonth = $this->request->data['date'];

            $pos = strpos($this->request->data['date'], "/");
            $mos = substr($this->request->data['date'], 0, $pos);
            $posy = $pos + 1;
            $yearofsalry = substr($this->request->data['date'], $posy);
            $dataArr = $this->request->data['id'];
            $academicyear = $this->currentacademicyear();
            $academicyear = explode('-', $academicyear);
            $acdyear = $academicyear[0];
            $acdfrom = $acdyear . '-04-01';
            $acdyear2 = $acdyear + 1;
            $predate = $yearofsalry . '-' . $mos . '-01';
            $acdto = date('Y-m-t', strtotime($predate . '-1 months'));
            $premon = date('m', strtotime($predate . '-1 months'));
            $preyear = date('Y', strtotime($predate . '-1 months'));
            $payroll = $this->Payroll->find('all')->order(['Payroll.id' => 'DESC'])->first();
            $holiday_allow = $this->Payroll->find('all')->select(['holiday_allow', 'half_day_carry'])->order(['Payroll.id' => 'DESC'])->first();

            $hol_allowance = $holiday_allow->holiday_allow;
            $half_carry = $holiday_allow->half_day_carry;
            foreach ($dataArr as $key => $values) {
                $data = array();
                $f_HRA = 0;
                $f_LTA = 0;
                $HRA = 0;
                $LTA = 0;
                $pfdecationamt = 0;
                $employer_epf_amount = 0;
                $employer_epf_decationamt = 0;
                //pr($values);die;
                //echo $values['cash_pay'];
                //pr($mos);
                $join_date = $this->Employees->find('all')->where(['id' => $key])->first();
                $j_date = date("m/Y", strtotime($join_date['joiningdate']));
                $join_leav = 0;
                $salary_ent = $this->Salary->find('all')->where(['Eid' => $key, 'month' => $mos, 'year' => $yearofsalry])->first();
                //pr($join_date);die;
                if (empty($salary_ent)) {
                    $salary_ent = $this->Salary->newEntity();
                }
                $mon_days = cal_days_in_month(CAL_GREGORIAN, $mos, $yearofsalry);
                $date = $yearofsalry . "-" . $mos . "-01";
                $end_date = $yearofsalry . "-" . $mos . "-" . $mon_days;
                $end_date = date('Y-m-d', strtotime($end_date));
                //echo $date;
                //echo $end_date;die;
                $holidaypresent = 0;
                if (strtotime("1/" . $salaryofmonth) == strtotime("1/" . $j_date)) {
                    $j_day = date("d", strtotime($join_date['joiningdate']));
                    $date1 = $yearofsalry . "-" . $mos . "-" . $j_day;
                    $mon_days1 = $mon_days - $j_day + 1;
                    $join_leav = $j_day - 1;
                } else if (strtotime("1/" . $salaryofmonth) < strtotime("1/" . $j_date)) {

                    continue;
                } else {
                    $mon_days1 = $mon_days;
                }
                if ($join_date['is_drop'] == 'Y') {
                    $drop_date = $join_date['drop_date'];

                    if (date('m', strtotime($drop_date)) == $mos && date('Y', strtotime($drop_date)) == $yearofsalry) {
                        $drop_days = date('d', strtotime($drop_date));
                        $drop_leav = $mon_days1 - $drop_days;
                    } else {
                        $drop_days = 0;
                        $drop_leav = 0;
                    }

                }
                if ($hol_allowance == 1) {
                    while ($date <= $end_date) {
                        $holiday = $this->Holidayallowance->find('all')->where(['employee_id' => $key, 'date' => $date])->first();
                        if ($holiday['type'] == "full") {
                            $holidaypresent += 1;
                        } else if ($holiday['type'] == "half") {
                            $holidaypresent += 0.5;
                        }
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    }
                }
                // pr($holidaypresent);
                //die;
                //$holiday1=$this->Holidayallowance->find('all')->where(['MONTH(from_date)'=>])

                $empDet = $this->Employeeattendance->find('all')->where(['employee_id' => $key, 'MONTH(date)' => $mos, 'YEAR(date)' => $yearofsalry, 'status IN' => ['A', 'HF', 'SL']])->toarray();

                $absentdays = 0;
                $sl = 0;
                $carry_SL = 0;
                $carry_HF = 0;
                $pre_HF = 0;
                $pre_SL = 0;
                $drop_leav = 0;
                foreach ($empDet as $emp_val) {

                    $holiday = 0;
                    $e_date = date('Y-m-d', strtotime($emp_val['date']));
                    $holiday = $this->Events->find('all')->where(['DATE(Events.starttime) <=' => $e_date, 'DATE(Events.endtime) >=' => $e_date, 'Events.eventt' => '8'])->count();
                    $app_leave = $this->Leaves->find('all')->where(['emp_id' => $key, 'date' => $e_date, 'LWP' => 'N', 'status' => 'Y'])->toarray();
                    if (empty($app_leave) && $holiday == 0) {
                        if ($emp_val['status'] == 'A') {
                            $absentdays += 1;
                        } else if ($emp_val['status'] == 'HF') {
                            if ($half_carry == 0) {
                                $absentdays += 0.5;
                            } else {
                                $carry_HF += 1;
                            }

                        } else if ($emp_val['status'] == 'SL') {
                            if ($half_carry == 0) {
                                $sl += 0.34;
                            } else {
                                $carry_SL += 1;
                            }
                        }
                    }
                }
                if ($half_carry == 0 && $sl >= 1) {
                    $absentdays = $absentdays + (INT) $sl;
                }
                $avail_lev1 = $this->Employees->find('all')->select(['CL_avail', 'CL'])->where(['id' => $key])->first();

                $avail_lev = $avail_lev1->CL - $avail_lev1->CL_avail;
                if ($half_carry == 1) {
                    if ($mos != 04) {
                        $pre_HF = $this->Carryforward->find('all')->where(['Eid' => $key, 'month' => $premon, 'year' => $preyear, 'type' => 'HF'])->count();
                        $pre_SL = $this->Carryforward->find('all')->where(['Eid' => $key, 'month' => $premon, 'year' => $preyear, 'type' => 'SL'])->count();
                    }
                    $leave_id = $this->Leavetype->find('all')->select(['id'])->where(['short_name' => 'CL'])->first();
                    $total_HF = $pre_HF + $carry_HF;
                    $total_SL = $pre_SL + $carry_SL;
                    $halfday_leave = (INT) $total_HF / 2;
                    $shortleave_leave = (INT) $total_SL / 3;

                    if ($halfday_leave > 0) {
                        for ($i = 1; $i <= $halfday_leave; $i++) {
                            $mon_count = $this->Leaves->find('all')->where(['emp_id' => $key, 'status' => 'Y', 'LWP' => 'N', 'MONTH(date)' => $mos, 'YEAR(date) ' => $yearofsalry])->count();
                            $leav_avail = $avail_lev - $mon_count;
                            if ($leav_avail > 0) {
                                $leave_ent = $this->Leaves->newEntity();
                                $ldata['date'] = $end_date;
                                $ldata['leave_type'] = $leave_id->id;
                                $ldata['narration'] = "SL and half day";
                                $ldata['status'] = 'Y';
                                $ldata['emp_id'] = $key;
                                $ldata['half_day_leave'] = 'Y';
                                $ldata['carry_leave'] = 'N';
                                $pat = $this->Leaves->patchEntity($leave_ent, $ldata);
                                $this->Leaves->save($pat);
                            } else {
                                $absentdays += 1;
                            }
                        }

                    }
                    if ($shortleave_leave > 0) {
                        for ($i = 1; $i <= $shortleave_leave; $i++) {
                            $mon_count = $this->Leaves->find('all')->where(['emp_id' => $key, 'status' => 'Y', 'LWP' => 'N', 'MONTH(date)' => $mos, 'YEAR(date) ' => $yearofsalry])->count();
                            $leav_avail = $avail_lev - $mon_count;
                            if ($leav_avail > 0) {
                                $leave_ent = $this->Leaves->newEntity();
                                $ldata['date'] = $end_date;
                                $ldata['leave_type'] = $leave_id->id;
                                $ldata['narration'] = "SL and half day";
                                $ldata['status'] = 'Y';
                                $ldata['emp_id'] = $key;
                                $ldata['half_day_leave'] = 'Y';
                                $ldata['carry_leave'] = 'N';
                                $pat = $this->Leaves->patchEntity($leave_ent, $ldata);
                                $this->Leaves->save($pat);
                            } else {
                                $absentdays += 1;
                            }
                        }
                    }
                    $mon_carry_HF = (INT) $total_HF % 2;
                    // echo $mon_carry_HF; die;
                    $mon_carry_SL = (INT) $total_SL % 3;
                    if ($mon_carry_HF > 0) {
                        $carry_data = array();
                        $carry_data['Eid'] = $key;
                        $carry_data['type'] = 'HF';
                        $carry_data['month'] = $mos;
                        $carry_data['year'] = $yearofsalry;
                        $carry_data['balance'] = $mon_carry_HF;
                        $carry = $this->Carryforward->patchEntity($this->Carryforward->newEntity(), $carry_data);
                        $this->Carryforward->save($carry);
                    }
                    if ($mon_carry_SL > 0) {
                        $carry_data = array();
                        $carry_data['Eid'] = $key;
                        $carry_data['type'] = 'SL';
                        $carry_data['month'] = $mos;
                        $carry_data['year'] = $yearofsalry;
                        $carry_data['balance'] = $mon_carry_SL;
                        $carry = $this->Carryforward->patchEntity($this->Carryforward->newEntity(), $carry_data);
                        $this->Carryforward->save($carry);
                    }

                }
                $update1['CL_avail'] = '';
                $leave_count = $this->Leaves->find('all')->where(['emp_id' => $key, 'status' => 'Y', 'LWP' => 'N', 'MONtH(date)' => $mos, 'YEAR(date)' => $yearofsalry])->count();
                $update1['CL_avail'] = $avail_lev1->CL_avail + $leave_count;
                $uptemp = $this->Employees->get($key);
                $patemp = $this->Employees->patchEntity($uptemp, $update1);
                $this->Employees->save($patemp);
                //pr($absentdays);die;
                $emp = $this->Employeesalary->find('all')->where(['employee_id' => $key])->first();
                // pr($emp);die;
                $leave = $absentdays + $join_leav + $drop_leav;

                //$daamnt = $emp['basic_salary'] * $emp['da'];
                //$daamount = $daamnt / 100;
                //pr($leave);die;
                $basicsalary = $emp['basic_salary'];
                $da = $emp['da_amt'];
                $grade_pay = $emp['grade_pay'];

                if ($emp['leve'] == '0') {

                    $leavedue = 0;

                } else {
                    if ($leave > 0) {

                        //echo $mondays;die;
                        $leavedue = ceil($basicsalary * $leave / $mon_days);
                        $leaveda = ceil($da * $leave / $mon_days);
                        $leave_grade = ceil($grade_pay * $leave / $mon_days);
                    } else {
                        $leavedue = 0;
                        $leaveda = 0;
                        $leave_grade = 0;
                    }

                }
                $holidayallowance = 0;
                if ($holidaypresent > 0) {
                    $holidayallowance = ceil($basicsalary * $holidaypresent / $mon_days);
                }
                //pr($holidayallowance);die;
                $da_earn = 0;
                $basicsalary_earn = $basicsalary - $leavedue;
                $da_earn = $da - $leaveda;
                $grade_earn = $grade_pay - $leave_grade;
                $base = $basicsalary_earn + $da_earn + $grade_earn;
                // $employer_eps_decationamt = 0;
                // $employer_epf_decationamt = 0;
                // $pfdecationamt = 0;
                //pr($basicsalary1);
                //pr($payroll);die;
                $fixed_salary = $emp['fsalary'];

                /*--------------------------------   PF Calculation ---------------------------------------------*/
                if ($base <= $payroll['pfabpamt'] && $join_date['emp_status'] != "contract") {

                    $pfamount = $base * $payroll['employeesharepf'];
                    $pfdecationamt = $pfamount / 100;
                    $employer_epf_amount = $base * $payroll['employorsharepf'];
                    $employer_epf_decationamt = $employer_epf_amount / 100;

                } else if ($base > $payroll['pfabpamt'] && $emp['PF'] == 1) {

                    $pfamount = $payroll['pfabpamt'] * $payroll['employeesharepf'];
                    $pfdecationamt = $pfamount / 100;
                    $employer_epf_amount = $payroll['pfabpamt'] * $payroll['employorsharepf'];
                    $employer_epf_decationamt = $employer_epf_amount / 100;
                    if ($pfdecationamt < $emp['pfdeduction']) {
                        $pfdecationamt = $emp['pfdeduction'];
                        if ($join_date['p_department'] == 1) {
                            $employer_epf_decationamt = $emp['pfdeduction'];
                        }

                    }

                } else if ($join_date['emp_status'] == "contract" && $emp['PF'] == 1) {
                    $pfdecationamt = $emp['pfdeduction'];
                    $employer_epf_amount = 0;

                } else if ($join_date['emp_status'] == "contract" && $emp['PF'] == 0) {
                    $pfdecationamt = 0;
                    $employer_epf_amount = 0;

                }

                /*--------------------------------   Remaining Calculation ---------------------------------------------*/
                //pr($basicsalary);die;
                $hraamount = $basicsalary * $payroll['hra'];
                if ($emp['HRA'] == '1') {
                    if (!empty($emp['hra_amt'])) {
                        $f_HRA = $emp['hra_amt'];
                        $HRA = $f_HRA - ceil($f_HRA * $leave / $mon_days);
                    } else {
                        $hraamount = $basicsalary * $payroll['hra'];
                        //$hradecationamt = $hraamount / 100;
                        $f_HRA = $hraamount / 100;
                        $HRA = $f_HRA - ceil($f_HRA * $leave / $mon_days);
                    }
                } else {
                    $f_HRA = 0;
                    $HRA = 0;
                    $hradecationamt = 0;
                }

                //pr($leavedue);die;
                //$totalducation=$pfdecationamt+$esidecationamt+$hradecationamt+$traveldecationamt+$ltadecationamt+$sdamt;
                //$totalducationss = $pfdecationamt + $esidecationamt + $sdamt;

                // $query2 = "UPDATE `salary` SET `Leaves`='$leave' , `levduc`='$leavedue' ,`SALARY`='$basicsalary' , `Employer_epf` = '$employer_epf_decationamt', `Employer_eps` = '$employer_eps_decationamt',  `EmployerEsi` = '$employeresidecationamt',  `SALARY` = '$basicsalary',`ESI` = '$esidecationamt', `PF` = '$pfdecationamt', `LTA` = '$ltadecationamt', `HRA` = '$hradecationamt',`SD` = '$sdamt', `TA` = '$traveldecationamt', `NETPAY` = '$netpay', `SD` = '$sdamt' WHERE `salary`.`Eid` = '$empid' AND `salary`.`date`='$salary_date';";

                $cca_amt = $emp['cca_amt'] - ceil($emp['cca_amt'] * $leave / $mon_days);

                $data['Eid'] = $key;
                $data['date'] = $this->request->data['date'];
                $data['actual_days'] = $mon_days1 - $leave;
                $data['mode'] = $emp['payment_mode'];
                //$data['']
                $data['levduc'] = $leavedue;
                $data['f_basic'] = $basicsalary;
                $data['f_DA'] = $da;
                $data['f_grade_pay'] = $grade_pay;
                $data['f_HRA'] = $f_HRA;
                $data['f_CCA'] = $emp['cca_amt'];
                $data['f_spl_all'] = $emp['spl_all'];
                $data['CCA'] = $cca_amt;
                $data['spl_all'] = $emp['spl_all'] - ceil($emp['spl_all'] * $leave / $mon_days);
                $data['fixed_salary'] = $emp['total'];
                $data['g_total'] = $data['f_basic'] + $data['f_HRA'] + $data['f_CCA'] + $data['f_DA'] + $data['f_spl_all'] + $data['f_grade_pay'];

                $data['basic'] = $basicsalary_earn;
                $data['spl_all'] = $emp['spl_all'] - ceil($emp['spl_all'] * $leave / $mon_days);
                $data['E_DA'] = $da_earn;
                $data['E_grade_pay'] = $grade_earn;
                $data['E_HRA'] = $HRA;
                $data['E_EPF'] = ceil($employer_epf_decationamt);
                $data['E_PF'] = ceil($pfdecationamt);
                //$data['LTA'] = $ltadecationamt;
                //$data['HRA'] = $hradecationamt;
                //$data['TA'] = $traveldecationamt;
                $data['over_time'] = $holidayallowance;

                if (strtolower($join_date['emp_status']) != "contract") {
                    $total_earnings = ceil($data['basic'] + $data['E_HRA'] + $data['CCA'] + $data['E_DA'] + $data['spl_all'] + $data['over_time'] + $data['E_grade_pay']);
                    $data['total_earnings'] = $total_earnings;
                } else {

                    $total_earnings = $data['fixed_salary'] - ceil($data['fixed_salary'] * $leave / $mon_days);
                    $data['total_earnings'] = $total_earnings;

                }

                /*--------------------------------   ESI Calculation ---------------------------------------------*/

                if ($emp['total'] <= $payroll['esiamtap']) {

                    $esiamount = $total_earnings * $payroll['employeeshareeesi'];
                    $esidecationamt = $esiamount / 100;

                    $employeresiamount = $total_earnings * $payroll['employorshareeesi'];
                    $employeresidecationamt = $employeresiamount / 100;

                } else {
                    $esidecationamt = 0;
                    $employeresidecationamt = 0;

                }

                $data['ESIC_EE'] = $employeresidecationamt;

                $data['ESIC'] = ceil($esidecationamt);
                $data['SD'] = 0;
                if ($emp['sd'] == 1) {
                    $data['SD'] = ceil($emp['total'] * $emp['sd_perc'] / 100);
                }
                $data['TDS'] = $values['tds'];
                if (strtolower($join_date['emp_status']) != "contract") {
                    $netpay = ceil($data['total_earnings'] - $data['ESIC'] - $data['E_PF'] - $data['SD'] - $data['TDS'] - $data['SD']);
                } else {
                    $netpay = $data['total_earnings'] - $data['ESIC'] - $data['E_PF'] - $data['SD'];
                }
                $data['net_salary'] = $netpay;
                $data['cost_to_employer'] = ceil($employer_epf_decationamt + $employeresidecationamt + $data['total_earnings']);
                $data['total_deductions'] = $data['E_PF'] + $data['ESIC'] + $data['SD'] + $data['TDS'];
                $data['month'] = $mos;
                $data['year'] = $yearofsalry;
                $data['payment_by_mode'] = $netpay;
                // pr($data);die;
                if (!empty($values['cash_pay'])) {
                    $data['payment_by_cash'] = $values['cash_pay'];
                    $data['payment_by_mode'] = $data['payment_by_mode'] - $values['cash_pay'];
                } else {
                    $data['cash_pay'] = 0;
                    //$data['paymentbymode'] = $netpay;
                }
                if (!empty($values['advance'])) {
                    $data['advance'] = $values['advance'];
                    $data['payment_by_mode'] = $data['payment_by_mode'] - $values['advance'];
                } else {
                    $data['advance'] = 0;
                    // $data['paymentbymode'] = $netpay;
                }

                //pr($values['cash_pay']);
                // pr($data);die;

                $patch = $this->Salary->patchEntity($salary_ent, $data);
                $save_sal = $this->Salary->save($patch);
                $sal_det[] = $save_sal;
                //pr($sal_det);die;

            }

            //pr($sal_date);die;
            $this->Flash->success(__('Salary Generated Successfully'));
            $this->redirect(array('action' => 'salary_generate'));

        }

    }

    public function csv($filename)
    {
        //echo $filename;

        //$filename = TMP . 'uploads' . DS . $filename;
        // $filename=SITE_URL.'excel_file/' . $filename;

        // open the file
        $handle = fopen($filename, "r");
        // read the 1st row as headings
        $header = fgetcsv($handle);
        //pr($handle); die;

        //$field = preg_replace('/[\x00-\x1F\x80-\xFF]/', ',', $header[0]);
        //  pr($field); die;

        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );

        // read each data row in the file
        $this->request->data['file'] = $this->request->data['csv']['name'];
        $this->request->data['mode'] = $this->request->data['department'];
        while (($row = fgetcsv($handle)) !== false) {
            $documents = $this->Salary->newEntity();
            $data = array();

            // for each header field
            //pr($newheader);
            foreach ($header as $k => $head) {

                $data[$head] = (isset($row[$k])) ? $row[$k] : ',';
                $this->request->data[$head] = (isset($row[$k])) ? $row[$k] : ',';
            }

            // pr($this->request->data); die;

            $documents = $this->Salary->patchEntity($documents, $this->request->data);
//pr($documents);

            $this->Salary->save($documents);

            //~ $this->set($data);

        }die;

        //  pr($documents);
        // close the file
        fclose($handle);

        // return the messages
        return $return;
    }

    public function sub_records()
    {

        $currentdate = date('Y-m-d');

        $netpay = $this->Salary->find()->where(['status' => 'N'])->toarray();

        $pos = strpos($netpay['0']['date'], "/");
        $mos = substr($netpay['0']['date'], 0, $pos);
        //pr($mos); die;
        //pr($netpay);die;
        //$netpay=$this->Salary->find('all',array('conditions'=>array(),'recursive'=>-1));
        $count = 0;
        $bankdu = 0;
        foreach ($netpay as $value) {

            $eid = $value['Eid'];

            $mode = $value['mode'];
            $count = $value['SALARY'];
            //$count = $count;
            $empname = $value['NAME'];
            $empledid = $this->Ledger->find()->where(['Ledger.empid' => $eid])->first();
            $lvid = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();

            //$lvid=$this->Vouchername->find('first',array('conditions'=>array('Vouchername.id'=>4)));
            $upids = $lvid['lvid'];
            $modeid = $value['mode'];
            $styped = "DR";
            $samt = $count;
            $slid = "78";
            $svid = $upids;
            $svtype = 4;
            $stdate = $currentdate;

            $tsfid = $empledid['id'];
            $dec = " ";
            $chque = " ";
            $conn1 = ConnectionManager::get('default');
            $conn2 = ConnectionManager::get('default');
            $conn3 = ConnectionManager::get('default');
            $conn4 = ConnectionManager::get('default');
            $conn5 = ConnectionManager::get('default');
            $conn6 = ConnectionManager::get('default');
            $conn7 = ConnectionManager::get('default');
            $conn8 = ConnectionManager::get('default');
            $conn9 = ConnectionManager::get('default');
            $conn10 = ConnectionManager::get('default');
            $conn11 = ConnectionManager::get('default');
            $conn12 = ConnectionManager::get('default');
            $conn13 = ConnectionManager::get('default');
            $conn14 = ConnectionManager::get('default');
            $conn15 = ConnectionManager::get('default');
            $conn16 = ConnectionManager::get('default');
            $conn17 = ConnectionManager::get('default');
            $conn18 = ConnectionManager::get('default');
            $conn19 = ConnectionManager::get('default');
            $query1 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$svid', '$slid', '$svtype', '$styped', '$samt', '$dec', '$chque', CURRENT_TIMESTAMP, '$stdate', '$stdate','0','$tsfid','$mos','$eid')";
            $id = $upids;
            $lid = $empledid['id'];
            $vtype = "4";
            $amount = $count;
            $dec = " ";
            $chque = " ";

            $date = $currentdate;
            $steup = ++$id;

            $seesion_id = 0;
            $query2 = "INSERT INTO `voucher`  (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$upids', '$lid', '$vtype', 'CR', '$amount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','78','$mos','$eid')";
            $query3 = "update `vouchername` set lvid='" . $steup . "' where id=4";
            $conn1->execute($query1);
            $conn2->execute($query2);
            $conn3->execute($query3);
            $ledgvid = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();
            $ledgaid = $ledgvid['lvid'];
            $lid = $empledid['id'];
            //echo $lid; die;
            $vtype = "4";
            $pfamount = $value['PF'];
            //$bankdu+=$pfamount;
            $dec = " ";
            $chque = " ";

            $date = $currentdate;
            $steup = ++$id;

            $query4 = "INSERT INTO `voucher`  (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$ledgaid', '$lid', '$vtype', 'DR', '$pfamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','0','87','$mos','$eid')";
            $query5 = "INSERT INTO `voucher`  (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$ledgaid', '87', '$vtype', 'CR', '$pfamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','0','$lid','$mos','$eid')";

            $query6 = "update vouchername set lvid='" . $steup . "' where id=4";
            $conn4->execute($query4);
            $conn5->execute($query5);
            $conn6->execute($query6);

            $esigvid = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();

            $esigaid = $esigvid['lvid'];
            $esiamount = $value['ESI'];
            $bankdu += $esiamount;
            $query7 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$esigaid', '$lid', '$vtype', 'DR', '$esiamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','88','$mos','$eid')";
            $query8 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$esigaid', '88', '$vtype', 'CR', '$esiamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','$lid','$mos','$eid')";
            $steup++;
            $query9 = "update vouchername set lvid='" . $steup . "' where id=4";
            $conn7->execute($query7);
            $conn8->execute($query8);
            $conn9->execute($query9);

            $sdgvid = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();
            $sdgvid = $esigvid['lvid'];
            $sdamount = $value['SD'];
            $bankdu += $sdamount;

            $query10 = "update `vouchername` set lvid='" . $steup . "' where id=4";
            $conn10->execute($query10);

            $sdgvid = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();
            $sdgvid = $esigvid['lvid'];
            $sdgvid++;
            $query11 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$sdgvid', '$lid', '$vtype', 'DR', '$sdamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','62','$mos','$eid')";
            $query12 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$sdgvid', '62', '$vtype', 'CR', '$sdamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','$lid','$mos','$eid')";
            $query13 = "update `vouchername` set lvid='" . $sdgvid . "' where id=4";
            $conn11->execute($query11);
            $conn12->execute($query12);
            $conn13->execute($query13);

            $employerpf = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();

            $emplo = $employerpf['lvid'];
            $employerpfamt = $value['Employer_epf'];
            //$bankdu+=$employerpfamt;
            $emplo += 1;

            $query14 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$emplo', '78', '$vtype', 'DR', '$employerpfamt', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','92','$mos','$eid')";
            $query15 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$emplo', '92', '$vtype', 'CR', '$employerpfamt', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','78','$mos','$eid')";

            $query16 = "update vouchername set lvid='" . $emplo . "' where id=4";
            $conn14->execute($query14);
            $conn15->execute($query15);
            $conn16->execute($query16);

            $employeresi = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();

            $emploesi = $employeresi['lvid'];
            $employerpfamt = $value['EmployerEsi'];
            //$bankdu+=$employerpfamt;
            $emploesi += 1;
            $query17 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$emploesi', '78', '$vtype', 'DR', '$employerpfamt', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','93','$mos','$eid')";
            $query18 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$emploesi', '93', '$vtype', 'CR', '$employerpfamt', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','78','$mos','$eid')";

            $queryad = "update vouchername set lvid='" . $emploesi . "' where id=4";

            $conn17->execute($query17);
            $conn18->execute($query18);
            $conn19->execute($queryad);

            //echo "hello"; die;

        }

        $salay = $this->Salary->find('all');

        foreach ($salay as $value) {
            $con1 = ConnectionManager::get('default');
            $con2 = ConnectionManager::get('default');
            $con3 = ConnectionManager::get('default');
            $employerbank = $this->Vouchername->find()->where(['Vouchername.id' => 4])->first()->toarray();

            $ab = $employerbank['lvid'];
            $ab++;
            $transmode = $value['mode'];

            $empname = $value['NAME'];
            $empledid = $this->Ledger->find()->where(['Ledger.empid' => $value['Eid'], 'Ledger.gid' => '16'])->first();
            //    $empledid=$this->Ledgers->find('first',array('conditions'=>array('Ledgers.title LIKE'=>'%'.$empname.'%','Ledgers.gid'=>'16')));
            $bankid = $empledid['id'];
            $bankamount = $value['NETPAY'];

            $quer1 = "INSERT INTO `voucher` (`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$ab', '$bankid', '4', 'DR', '$bankamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','$transmode','$mos','$eid')";
            $quer2 = "INSERT INTO `voucher`(`vid`, `ledid`, `vtype`, `transtype`, `amt`, `descr`, `chqno`, `created`, `transdate`, `modifiedate`,`c_id`,`fid`,`salryomn`,`eid`) VALUES ('$ab', '$transmode', '4', 'CR', '$bankamount', '$dec', '$chque', CURRENT_TIMESTAMP, '$date', '$date','$seesion_id','$bankid','$mos','$eid')";
            $emploesi += 1;
            $query3 = "update `vouchername` set lvid='" . $emploesi . "' where id=4";

            $con1->execute($quer1);
            $con2->execute($quer2);
            $con3->execute($query3);

        }

        $conn1ss = ConnectionManager::get('default');
        $salryde = "delete FROM salary";
        $conn1ss->execute($salryde);
        //$this->Salary->query("delete FROM `cms_salarys`");

        $this->redirect(array('action' => 'salary'));

    }
    public function payroll_setting_edit($id = null)
    {
        $this->viewBuilder()->layout('admin');

        if (isset($id) && !empty($id)) {

            $payroll = $this->Payroll->get($id);
            $this->set('payroll', $payroll);

            if ($this->request->is(['post', 'put'])) {

                // pr($this->request->data);  die;
                // save all data in database
                if (!isset($this->request->data['abovepfslab'])) {
                    $this->request->data['abovepfslab'] = 0;

                }
                if (!isset($this->request->data['half_day_carry'])) {
                    $this->request->data['half_day_carry'] = 0;

                }
                if (!isset($this->request->data['holiday_allow'])) {
                    $this->request->data['holiday_allow'] = 0;

                }
                if (!empty($this->request->data['logo'])) {
                    $ext = pathinfo($this->request->data['logo']['name'], PATHINFO_EXTENSION);
                    $logoname = uniqid() . '.' . $ext;
                    $file = '/opt/lampp/htdocs/payroll/webroot/images/' . $logoname;
                    if (move_uploaded_file($this->request->data['logo']['tmp_name'], $file)) {

                        $this->request->data['company_logo'] = $logoname;
                    }
                }

                $payroll = $this->Payroll->patchEntity($payroll, $this->request->data);
                //pr($payroll); die;
                if ($this->Payroll->save($payroll)) {
                    $this->Flash->success(__('payroll setting updated has been saved.'));
                    $this->redirect(array('action' => 'payroll_setting'));

                }

            }
        }
    }

    public function payroll_setting()
    {
        $this->viewBuilder()->layout('admin');

        $Departments = $this->Payroll->find('all')->order(['Payroll.id' => 'Desc'])->toarray();
        $this->set("employee", $Departments);

    }

    public function pdf_view($schedule_id = null)
    {

        $this->viewBuilder()->layout('ajax');
        $this->response->type('pdf');
        $students = $this->Students->find('all')->contain(['Classes', 'Sections'])->where(['Students.id' => $schedule_id])->first()->toarray();
        $this->set(compact('students'));
        $classessss = $this->Guardians->find()->where(['Guardians.user_id' => $schedule_id])->first();
        //pr($classessss); die;
        $this->set(compact('classessss'));

        $address = $this->Address->find('all')->contain(['CurCountry', 'PerCountry', 'CurStates', 'PerStates', 'CurStates', 'PerStates', 'CurCity', 'PerCity'])->where(['Address.type' => 0, 'Address.user_id' => $schedule_id])->first();

        $this->set(compact('address'));
        //    pr($address); die;

    }

    public function report($branch = null, $fdate = null, $pay_mode = null)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Ledger');
        $this->loadModel('PayrollDepartments');
        $this->loadModel('Employees');
        $ar = array('3', '4');
        $mode = $this->Ledger->find('list')->where(['Ledger.gid IN' => $ar])->toarray();
        $this->set(compact('mode'));
        $pos = strpos($fdate, "-");
        $pos += 1;
        $year = substr($fdate, $pos);
        $mon = substr($fdate, 0, $pos - 1);
        $desgname1 = $this->PayrollDepartments->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->toarray();
        $desgname = $this->PayrollDepartments->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->toarray();
        if ($pay_mode != null) {
            //echo "test";die;
            foreach ($desgname as $d_key => $des) {
                $emp_ext = $this->Salary->find('all')->contain(['Employees'])->where(['Salary.mode' => $pay_mode, 'Salary.month' => $mon, 'Salary.year' => $year, 'Employees.p_department' => $d_key])->count();
                if ($emp_ext == 0) {
                    unset($desgname[$d_key]);
                }
            }
        }
        //pr($desgname);die;
        $emp_type = $this->Employees->find('list', [
            'keyField' => 'emp_status',
            'valueField' => 'emp_status',
        ])->group('emp_status')->toarray();
        //pr($emp_type);die;
        $this->set(compact('desgname1'));
        $this->set(compact('desgname'));
        $this->set(compact('emp_type'));
        $this->set(compact('fdate'));

        if ($this->request->is('get')) {
            if (empty($fdate)) {
                $fdate = date('m-Y', strtotime('-1 Months'));
            }

            if (empty($branch)) {
                $branch = 4;
            }

            //$branch = $this->request->data['branch_id'];

            //$pay_mode = $this->request->data['payment_mode'];

            $con = array();
            $con['Salary.month'] = $mon;
            $con['Salary.year'] = $year;

            $con['Salary.status'] = "Y";
            if (!empty($pay_mode)) {
                $con['Salary.mode'] = $pay_mode;
            }
            //pr($con);die;
            $report = $this->Salary->find('all')->contain(['Employees'])->order(['Employees.fname' => 'ASC'])->where([$con])->toarray();
            $emp_types = $this->Employees->find()->select(['emp_status'])->group('emp_status')->toarray();
            //pr($report);die;
            $this->set(compact('mon'));
            $this->set(compact('year'));
            $this->set(compact('emp_types'));
            $this->set(compact('report'));
            $this->set(compact('branch'));
            $this->request->session()->delete('salary_pdf');
            $this->request->session()->write('salary_pdf', $report);
            $this->request->session()->delete('report_type');
            $this->request->session()->write('report_type', $branch);
            $fdate = str_replace('-', '/', $fdate);
            $this->request->session()->delete('sal_report_date');
            $this->request->session()->write('sal_report_date', $fdate);
            $this->request->session()->delete('desgname');
            $this->request->session()->write('desgname', $desgname);

        }

    }
    public function report_view()
    {

        if ($this->request->is('post', 'put')) {

            $branch = $this->request->data['branch_id'];
            $pos = strpos($this->request->data['fdate'], "/");
            $pos += 1;
            $year = substr($this->request->data['fdate'], $pos);
            $mon = substr($this->request->data['fdate'], 0, $pos - 1);
            $pay_mode = $this->request->data['payment_mode'];
            $dept = $this->request->data['dept'];
            $emp_type = $this->request->data['emp_type'];
            $con = array();
            $con['Salary.month'] = $mon;
            $con1['Salary.month'] = $mon;
            $con['Salary.year'] = $year;
            $con1['Salary.year'] = $year;
            if (!empty($dept)) {
                $con['Employees.p_department'] = $dept;
                $con1['DropOutEmployee.p_department'] = $dept;
            }
            $con['Salary.status'] = "Y";
            $con1['Salary.status'] = "Y";
            if (!empty($pay_mode)) {
                $con['Salary.mode'] = $pay_mode;
                $con1['Salary.mode'] = $pay_mode;
            }
            if (!empty($emp_type)) {
                $con['Employees.emp_status'] = $emp_type;
                $con1['DropOutEmployee.emp_status'] = $emp_type;
            }

            $report_exsit = $this->Salary->find('all')->contain(['Employees'])->order(['Employees.fname' => 'ASC'])->where([$con])->toarray();
            $report_drop = $this->Salary->find('all')->contain(['DropOutEmployee'])->order(['DropOutEmployee.fname' => 'ASC'])->where([$con1])->toarray();
            //pr($report_drop);die;
            $report = array_merge($report_exsit, $report_drop);
            if (empty($dept)) {

                $desgname = $this->PayrollDepartments->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'name',
                ])->toarray();

            } else {

                $desgname = $this->PayrollDepartments->find('list')->where(['id' => $dept])->toarray();
                //pr($desgname);die;
            }

            foreach ($desgname as $d_key => $des) {
                $con['Employees.p_department'] = $d_key;
                $con1['DropOutEmployee.p_department'] = $d_key;
                $emp_ext = $this->Salary->find('all')->contain(['Employees'])->where([$con])->count();
                $emp_ext1 = $this->Salary->find('all')->contain(['DropOutEmployee'])->where([$con1])->count();
                if ($emp_ext == 0 && $emp_ext1 == 0) {
                    unset($desgname[$d_key]);
                }
            }

            //pr($desgname);die;
            $this->set(compact('mon'));
            $this->set(compact('year'));
            $this->set(compact('desgname'));
            $this->set(compact('emp_types'));
            $this->set(compact('report'));
            $this->set(compact('branch'));
            $this->request->session()->delete('salary_pdf');
            $this->request->session()->write('salary_pdf', $report);
            $this->request->session()->delete('report_type');
            $this->request->session()->write('report_type', $branch);
            $this->request->session()->delete('sal_report_date');
            $this->request->session()->write('sal_report_date', $this->request->data['fdate']);

            $this->request->session()->delete('desgname');
            $this->request->session()->write('desgname', $desgname);

        }
    }
    public function report_pdf($branch = null, $fdate = null, $pay_mode = null)
    {
        if ($this->request->is('get')) {
            $this->bank_report_excel($branch, $fdate, $pay_mode = null);
            //echo "test";die;
        }
        $this->response->type('pdf');
        $report = $this->request->session()->read('salary_pdf');
        $type = $this->request->session()->read('report_type');
        $date = $this->request->session()->read('sal_report_date');
        $this->set(compact('report'));
        $this->set(compact('type'));
        $this->set(compact('date'));
    }

    public function report_view1()
    {
        $this->response->type('pdf');
        if ($this->request->is('post') || $this->request->is('put')) {
            $pos = strpos($this->request->data['fdate'], "/");
            $pos += 1;
            $year = substr($this->request->data['fdate'], $pos);
            $month = substr($this->request->data['fdate'], 0, $pos - 1);
            //pr($month);die;
            //echo date('F', strtotime($month . '01'));

            $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
            $months[(int) $month];

            $this->set("monthname", $months[(int) $month]);
            $this->set('yearname', $year);

            if ($this->request->data['branch_id'] == 1) {
                $this->set("type", $this->request->data['branch_id']);

                $pfreport = $this->Salary->find('all')->where(['year' => $year, 'month' => $month])->toarray();
                $this->set("pfreport", $pfreport);
                //pr($pfreport);die;
            }

            if ($this->request->data['branch_id'] == 2) {
                $this->set("type", $this->request->data['branch_id']);
                $pos = strpos($this->request->data['fdate'], "/");
                $pos += 1;
                $year = substr($this->request->data['fdate'], $pos);
                $month = substr($this->request->data['fdate'], 0, $pos - 1);

                $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
                $months[(int) $month];

                $this->set("monthname", $months[(int) $month]);
                $pfreport = $this->Salary->find('all')->where(['year' => $year, 'month' => $month])->toarray();
                $this->set("pfreport", $pfreport);

            }

            if ($this->request->data['branch_id'] == 3) {
                $this->set("type", $this->request->data['branch_id']);
                $pos = strpos($this->request->data['fdate'], "/");
                $pos += 1;
                $year = substr($this->request->data['fdate'], $pos);
                $month = substr($this->request->data['fdate'], 0, $pos - 1);

                $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
                $months[(int) $month];

                $this->set("monthname", $months[(int) $month]);
                $pfreport = $this->Salary->find('all')->where(['year' => $year, 'month' => $month])->toarray();
                $this->set("pfreport", $pfreport);

            }
            if ($this->request->data['branch_id'] == 4) {
                $this->set("type", $this->request->data['branch_id']);
                $pos = strpos($this->request->data['fdate'], "/");
                $pos += 1;
                $year = substr($this->request->data['fdate'], $pos);
                $month = substr($this->request->data['fdate'], 0, $pos - 1);

                $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
                $months[(int) $month];

                $this->set("monthname", $months[(int) $month]);
                $conn = connectionmanager::get('default');
                $query = "SELECT * FROM `empsalary` INNER JOIN `employee_salary_setting` ON `empsalary`.`empid`=`employee_salary_setting`.`employee_id` where `empsalary`.`yos`= '$year' AND `empsalary`.`mos`='$month'";
                //$pfreport = $this->Empsalary->find('all')->contain(['Employee'])->where(['yos' => $year, 'mos' => $month])->toarray();
                $pfreport = $conn->execute($query)->fetchAll('assoc');
                $this->set("pfreport", $pfreport);
                //pr($query);
                //pr($pfreport);die;

            }

        }

    }

    public function Ledger()
    {
        $this->viewBuilder()->layout('admin');

        $ledger = $this->Ledger->find('all')->contain(['Ledgerg'])->order(['Ledger.id' => 'Desc'])->toarray();

        $this->set("ledger", $ledger);

    }
    public function ladger_add($id = null)
    {

        $this->viewBuilder()->layout('admin');
        $pfreport = $this->Ledgerg->find('all')->toarray();

        $this->set("abc", $pfreport);
        if (isset($id) && !empty($id)) {

            $ledger = $this->Ledger->get($id);

        } else {
            $ledger = $this->Ledger->newEntity();
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            //pr($this->request->data); die;
            $ledger = $this->Ledger->patchEntity($ledger, $this->request->data);

            try {
                $this->Ledger->save($ledger);
                return $this->redirect(['action' => 'Ledger']);
            } catch (\PDOException $e) {
                $error = 'The item you are trying to delete is associated with other records';
                $this->Flash->error(__('Ledger already exists'));
                $this->set('error', $error);
                //$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
                return $this->redirect(['action' => 'ladger_add']);
            }

        }

        $this->set('ledger', $ledger);
    }

    public function salary_add()
    {

        $this->viewBuilder()->layout('admin');
        $ar = array('3', '4');
        $name = $this->Ledger->find('list')->where(['Ledger.gid IN' => $ar])->toarray();

        $this->set("abc", $name);

        $emp = $this->Salary->find('all')->contain(['Employees'])->order(['Employees.id' => 'DESC'])->toarray();
        $this->set('destionation', $emp);

        $Empname = $this->Employees->find('list')->toarray();

        $this->set("emplist", $Empname);

    }

    public function laddelete($id)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $classes = $this->Ledger->get($id);
        //delete pariticular entry
        try {
            $this->Ledger->delete($classes);
            return $this->redirect(['action' => 'Ledger']);
        } catch (\PDOException $e) {
            $error = 'The item you are trying to delete is associated with other records';
            $this->Flash->error(__('Ladeger Used '));
            $this->set('error', $error);
            //$this->Session->setFlash(__(' Lader all ready exists), 'flash/Error');
            return $this->redirect(['action' => 'ledger']);
        }

    }

    public function salary_slip($id = null)
    {

        $this->loadModel('Salary');
        $employeedata = $this->Salary->find('all')->contain(['Employees', 'Employeesalary'])->where(['Salary.id' => $id])->first();
        //pr($employeedata);die;
        $this->set("Empdetail", $employeedata);

    }

    public function salary_slip_search()
    {

        //pr($this->request->data); die;

        //pr($this->request->data); die;
        $name = $this->request->data['name'];
        $empid12 = $this->request->data['location_id'];
        $empid = $this->request->data['empid'];
        $pos = explode('/', $this->request->data['fdate']);
        $mon = $pos[0];
        $yea = $pos[1];
        $apk = '';

        // if (!empty($name)) {

        //     //$stts = array('Empsalary.empid' => $empid12);
        //     //$apk[] = $stts;
        //     $apk .= "AND `empsalary`.`empid`='$empid12'";

        // }

        if (!empty($mon)) {
            $apk .= "AND `empsalary`.`mos`='$mon'";

            // $stts = array('Empsalary.mos' => $mon);
            // $apk[] = $stts;
        }

        if (!empty($yea)) {
            $apk .= "AND `empsalary`.`yos`='$yea'";
            // $stts = array('Empsalary.yos' => $yea);
            // $apk[] = $stts;
        }
        if (!empty($empid)) {
            $apk .= "AND `empsalary`.`empid`='$empid'";
            // $stts = array('Empsalary.empid' => $empid);
            // $apk[] = $stts;
        }
        $conn = connectionmanager::get('default');
        $query = "SELECT * FROM `employee_salary_setting` INNER JOIN `empsalary` ON `empsalary`.`empid`=`employee_salary_setting`.`employee_id` where 1=1 $apk";
        //$employeedata = $this->Empsalary->find('all')->contain(['Employee'])->where($apk)->toarray();
        $employeedata = $conn->execute($query)->fetchAll('assoc');
        //pr($query);die;
        $this->set(compact('employeedata'));

    }

    public function employeelist()
    {

        $Departments = $this->Employee->find('all')->order(['Employee.id' => 'Desc'])->toarray();
        $output = "";
        $output .= '"Eid",';
        $output .= '"NAME",';
        $output .= '"UAN No",';
        $output .= '"ESI No",';
        $output .= '"Leaves",';

        $output .= "\r\n";
        foreach ($Departments as $value) {
            $output .= $value["id"] . ",";
            $output .= $value["name"] . ",";
            $output .= $value["uan"] . ",";
            $output .= $value["esi"] . ",";
            $output .= "\r\n";
        }

        $filename = "myFile.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;

        die;
    }

    public function advance_salary()
    {

        $this->viewBuilder()->layout('admin');
        //$this->loadModel('Advancedeposit');
        $this->loadModel('Advancesalary');
        $this->loadModel('Employees');
        $staff = $this->Employees->find('list', ['keyField' => 'id', 'valueField' => array('fname', 'middlename', 'lname', 'id')])->order(['fname' => 'ASC'])->toarray();
        $this->set(compact('staff'));
        $this->loadModel('Ledger');
        $pay_mode = $this->Ledger->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['gid IN' => ['3', '4']])->toarray();
        $this->set(compact('pay_mode'));
        $advance_det = $this->Advancesalary->find('all')->where(['status' => 'Y', 'deposit_date IS' => null])->order(['id' => 'DESC'])->toarray();
        $this->set(compact('advance_det'));
        //pr($advance_det);die;
        if ($this->request->is('post', 'put')) {
            //pr($this->request->data);die;
            try {
                $this->request->data['paydate'] = date('Y-m-d', strtotime($this->request->data['paydate']));
                $new = $this->Advancesalary->newEntity();
                $patch = $this->Advancesalary->patchEntity($new, $this->request->data);
                if ($this->Advancesalary->save($patch)) {
                    $this->Flash->success(__('Advance amount Updated'));
                    return $this->redirect(['action' => 'advance_salary']);

                }
            } catch (\PDOException $e) {

                $this->Flash->error(__('Error:' . $e->getmessage()));
                $this->set('error', $error);
                return $this->redirect(['action' => 'advance_salary']);
            }

        }
    }
    public function advance_deposit($id = null)
    {

        $this->loadModel('Advancedeposit');
        $this->loadModel('Advancesalary');

        if ($this->request->is('get')) {
            //pr($id);die;
            $adv_det = $this->Advancesalary->find('all')->select(['sum' => $this->Advancesalary->find()->func()->sum('amount')])->where(['employee_id' => $id, 'deposit_amount is' => null])->first();
            $this->set(compact('adv_det'));
            //pr($adv_det);die;
            $adv_dep = $this->Advancesalary->find('all')->select(['sum' => $this->Advancesalary->find()->func()->sum('deposit_amount')])->where(['employee_id' => $id, 'amount is' => null])->first();
            $this->set(compact('adv_dep'));
            $this->set(compact('id'));
            //pr($adv_dep);die;

        }
        if ($this->request->is('post')) {
            try {

                $id = $this->request->data['employee_id'];
                $this->request->data['deposit_date'] = date('Y-m-d', strtotime($this->request->data['deposit_date']));
                $new = $this->Advancesalary->newEntity();
                //pr($new);die;
                $patch = $this->Advancesalary->patchEntity($new, $this->request->data);
                //pr($patch);die;
                if ($this->Advancesalary->save($patch)) {
                    $this->Flash->success(__('Advance Deposit Updated'));
                    return $this->redirect(['controller' => 'Employees', 'action' => 'view/' . $id]);
                }

            } catch (\PDOException $e) {

                $this->Flash->error(__('Error:' . $e->getmessage()));
                $this->set('error', $error);
                return $this->redirect(['action' => 'advance_salary']);
            }
        }
    }

    public function holiday_allowance($id = null, $date = null)
    {
        $this->loadModel('Employees');
        $staff = $this->Employees->find('list', ['keyField' => 'id', 'valueField' => array('fname', 'middlename', 'lname', 'id')])->order(['fname' => 'ASC'])->toarray();
        $this->set(compact('staff'));
        $this->set(compact('id'));
        $this->set(compact('date'));

        if ($this->request->is('post')) {
            //pr($_POST);die;
            try {
                $this->loadModel('Holidayallowance');
                $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
                //$this->request->data['to_date'] = date('Y-m-d', strtotime($this->request->data['to_date']));
                $hol_all = $this->Holidayallowance->newEntity();
                $patch = $this->Holidayallowance->patchEntity($hol_all, $this->request->data);
                if ($this->Holidayallowance->save($patch)) {
                    $this->Flash->success(__('Holiday Allowance added successfully'));
                    return $this->redirect(['controller' => 'report', 'action' => 'employee_monthly_attn_report']);

                }
            } catch (\PDOException $e) {

                $this->Flash->error(__('Error:' . $e->getmessage()));
                $this->set('error', $error);
                return $this->redirect(['controller' => 'report', 'action' => 'employee_monthly_attn_report']);
            }

        }
    }
    public function delete_holiday_allowance($id = null)
    {
        $this->autoRender = false;
        if ($this->request->data) {
            $id = $this->request->data['id'];
        }
        $this->loadModel('Holidayallowance');
        $res = $this->Holidayallowance->get($id);
        if ($this->Holidayallowance->delete($res)) {
            $this->Flash->success(__('Holiday Allowance added successfully'));
            return $this->redirect(['controller' => 'report', 'action' => 'employee_monthly_attn_report']);

        }

    }
    public function salary_generate()
    {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Ledger');
        $this->loadModel('PayrollDepartments');
        $ar = array('3', '4');
        $name = $this->Ledger->find('list')->where(['Ledger.gid IN' => $ar])->toarray();
        $desgname = $this->PayrollDepartments->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->toarray();
        $this->set(compact('name'));
        $this->set(compact('desgname'));

    }
    public function available_leaves($id, $from, $to)
    {
        $lev_rule = $this->Leavetype->find('all')->where(['short_name' => 'CL'])->first();
        $emp_det = $this->Employees->find('all')->where(['id' => $id])->first();
        $lev_avl = $emp_det[$lev_rule['field_name']];
        $leave_taken = $this->Leaves->find('all')->contain(['Leavetype'])->where(['Leavetype.short_name' => 'CL', 'Leaves.status' => 'Y', 'Leaves.emp_id' => $id, 'Leaves.date >=' => $from, 'Leaves.date <=' => $to])->count();

        return $lev_det['balance'] = $lev_avl - $leave_taken;

    }
    public function findbeforedate($id, $date)
    {
        $daybefore = date('Y-m-d', strtotime('-1 days', strtotime($date)));
        $empDet = $this->Employeeattendance->find('all')->where(['employee_id' => $id, 'date' => $daybefore, 'status' => 'A'])->first();
        if (!empty($empDet)) {
            $daybefore2 = date('Y-m-d', strtotime($empDet['date'] . '-1 days'));
            $GLOBALS['leaves_con'][] = $daybefore;
            $this->findbeforedate($id, $daybefore2);

        } else {
            $GLOBALS['daybefore'] = $date;
        }

    }
    public function salary_gen_search()
    {
        //pr($this->request->data);die;
        $this->loadModel('Employeeattendance');
        $this->loadModel('Employeesalary');
        $this->loadModel('Leaves');
        $this->loadModel('Employee');
        $this->loadModel('Salary');
        $this->loadModel('Holidayallowance');
        $this->loadModel('Events');
        $this->loadModel('Carryforward');
        $date = $this->request->data['date'];

        //$pay_mode = $this->request->data['pay_mode'];
        $dept = $this->request->data['dept'];
        $pos = strpos($date, '/');
        $mon = substr($date, '0', $pos);
        $pos1 = $pos + 1;
        $year = substr($date, $pos1);

        $academicyear = $this->currentacademicyear();
        $academicyear = explode('-', $academicyear);
        $acdyear = $academicyear[0];
        $acdfrom = $acdyear . '-04-01';
        $acdyear2 = $acdyear + 1;
        $predate = $year . '-' . $mon . '-01';
        $acdto = date('Y-m-t', strtotime($predate . '-1 months'));
        $premon = date('m', strtotime($predate . '-1 months'));
        $preyear = date('Y', strtotime($predate . '-1 months'));
        $month_sal = $this->Salary->find('list', array('valueField' => 'Eid'))->where(['month' => $mon, 'year' => $year, 'status' => 'N'])->toarray();
        // pr($month_sal);die;
        $con = array();
        if (!empty($dept)) {
            $con['Employees.p_department'] = $dept;
        }
        $con['OR'] = ['Employees.is_drop' => 'N', ['Employees.is_drop' => 'Y', 'MONTH(Employees.drop_date) >=' => $mon, 'YEAR(Employees.drop_date) >=' => $year]];
        $employe = $this->Employees->find('all')->contain('Employeesalary')->where([$con])->order(['Employees.p_department' => 'ASC'])->toarray();
        // pr($employe);die;
        $not_gen = 0;

        foreach ($employe as $emp_value) {

            //pr($emp_value);
            $sal_exist = $this->Salary->find('all')->where(['Eid' => $emp_value['id'], 'month' => $mon, 'year' => $year, 'status' => 'Y'])->first();
            if (empty($sal_exist)) {
                $employees[$emp_value['id']] = $emp_value;

            }
        }

        $holiday_allow = $this->Payroll->find('all')->select(['holiday_allow', 'half_day_carry'])->order(['Payroll.id' => 'DESC'])->first();
        $hol_allowance = $holiday_allow->holiday_allow;
        $half_carry = $holiday_allow->half_day_carry;
        //pr($half_carry); die;
        $payroll = $this->Payroll->find('all')->order(['Payroll.id' => 'DESC'])->first();

        foreach ($employees as $key => $emp_values) {
            $id_emp = $emp_values['id'];
            $data = array();
            // pr($emp_values);
            $join_date = $this->Employees->find('all')->where(['id' => $emp_values['id']])->first();
            //pr($join_date);die;
            $j_date = date("m/Y", strtotime($join_date['joiningdate']));

            $salary_ent = $this->Salary->find('all')->where(['Eid' => $emp_values['id'], 'month' => $mon, 'year' => $year])->toarray();
            // pr($alary_ent); die;

            $mon_days = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
            $date1 = $year . "-" . $mon . "-01";
            $join_leav = 0;
            $drop_leav = 0;
            if (strtotime("1/" . $date) == strtotime("1/" . $j_date)) {

                $j_day = date("d", strtotime($join_date['joiningdate']));
                $date1 = $year . "-" . $mon . "-" . $j_day;
                $mon_days1 = $mon_days - $j_day + 1;
                $join_leav = $j_day - 1;
            } else if (strtotime("1/" . $date) < strtotime("1/" . $j_date)) {

                continue;
            } else {
                $mon_days1 = $mon_days;
            }

            if ($join_date['is_drop'] == 'Y') {
                $drop_date = $join_date['drop_date'];

                if (date('m', strtotime($drop_date)) == $mon && date('Y', strtotime($drop_date)) == $year) {
                    $drop_days = date('d', strtotime($drop_date));
                    $drop_leav = $mon_days1 - $drop_days;
                } else {
                    $drop_days = 0;
                    $drop_leav = 0;
                }

            }
            if (empty($salary_ent)) {
                // pr($emp_values['id']); die;
                $not_gen = 1;
            }
            $end_date = $year . "-" . $mon . "-" . $mon_days;
            $holidaypresent = 0;
            //pr($emp_values);die;
            if ($hol_allowance == 1) {
                while (strtotime($date1) <= strtotime($end_date)) {
                    $holiday = $this->Holidayallowance->find('all')->where(['employee_id' => $emp_values['id'], 'date' => $date1])->first();
                    if ($holiday['type'] == "full") {
                        $holidaypresent += 1;
                    } else if ($holiday['type'] == "half") {
                        $holidaypresent += 0.5;
                    }
                    $date1 = date("Y-m-d", strtotime("+1 day", strtotime($date1)));
                }
            }
            //$holiday1=$this->Holidayallowance->find('all')->where(['MONTH(from_date)'=>])

            $empDet = $this->Employeeattendance->find('all')->where(['employee_id' => $emp_values['id'], 'MONTH(date)' => $mon, 'YEAR(date)' => $year, 'status IN' => ['A', 'HF', 'SL']])->toarray();
            $absentdays = 0;
            $sl = 0;
            $carryforward = 0;
            $carry_HF = 0;
            $carry_SL = 0;
            $leave_days = '';
            $pre_HF = 0;
            $pre_SL = 0;
            foreach ($empDet as $emp_val) {

                $holiday = 0;
                $e_date = date('Y-m-d', strtotime($emp_val['date']));
                $holiday = $this->Events->find('all')->where(['DATE(Events.starttime) <=' => $e_date, 'DATE(Events.endtime) >=' => $e_date, 'Events.eventt' => '8'])->count();

                $app_leave = $this->Leaves->find('all')->where(['emp_id' => $emp_values['id'], 'date' => $e_date, 'status' => 'Y', 'LWP' => 'N'])->toarray();
                if (empty($app_leave) && $holiday == 0) {
                    if ($emp_val['status'] == 'A') {
                        $absentdays += 1;
                    } else if ($emp_val['status'] == 'HF') {
                        if ($half_carry == 0) {
                            $absentdays += 0.5;
                        } else {
                            $carry_HF += 1;
                        }

                    } else if ($emp_val['status'] == 'SL') {

                        if ($half_carry == 0) {
                            $sl += 0.25;
                        } else {
                            $carry_SL += 1;
                        }
                    }
                }

            }

            if ($half_carry == 0 && $sl >= 1) {
                $absentdays = $absentdays + (INT) $sl;
            }
            $avail_lev1 = $this->Employees->find('all')->select(['CL_avail', 'CL'])->where(['id' => $key])->first();

            $avail_lev = $avail_lev1->CL - $avail_lev1->CL_avail;
            if ($half_carry == 1) {
                if ($mos != 04) {
                    $pre_HF = $this->Carryforward->find('all')->where(['Eid' => $key, 'month' => $premon, 'year' => $preyear, 'type' => 'HF'])->count();
                    $pre_SL = $this->Carryforward->find('all')->where(['Eid' => $key, 'month' => $premon, 'year' => $preyear, 'type' => 'SL'])->count();
                }
                $leave_id = $this->Leavetype->find('all')->select(['id'])->where(['short_name' => 'CL'])->first();
                $total_HF = $pre_HF + $carry_HF;
                $total_SL = $pre_SL + $carry_SL;
                $halfday_leave = (INT) $total_HF / 2;
                $shortleave_leave = (INT) $total_SL / 3;
                $mon_count = $this->Leaves->find('all')->where(['emp_id' => $key, 'status' => 'Y', 'LWP' => 'N', 'MONTH(date)' => $mon, 'YEAR(date) ' => $year])->count();

                if ($halfday_leave > 0) {
                    for ($i = 1; $i <= $halfday_leave; $i++) {
                        $leav_avail = $avail_lev - $mon_count;
                        if ($leav_avail > 0) {
                            $mon_count += 1;
                        } else {
                            $absentdays += 1;
                        }
                    }

                }
                if ($shortleave_leave > 0) {
                    for ($i = 1; $i <= $shortleave_leave; $i++) {
                        $leav_avail = $avail_lev - $mon_count;
                        if ($leav_avail > 0) {
                            $mon_count += 1;
                        } else {
                            $absentdays += 1;
                        }
                    }
                }

            }

            //pr($absentdays);die;
            $netpay = 0;
            $f_HRA = 0;
            $f_LTA = 0;
            $HRA = 0;
            $LTA = 0;
            $da = 0;
            $grade_pay = 0;
            $emp = $this->Employeesalary->find('all')->where(['employee_id' => $emp_values['id']])->first();
            //pr($emp);die;
            $leave = $absentdays + $join_leav + $drop_leav;
            $leavedue = 0;
            $leaveda = 0;
            $leave_grade = 0;
            //$daamnt = $emp['basic_salary'] * $emp['da'];
            //$daamount = $daamnt / 100;
            //pr($leave);die;
            $basicsalary = $emp['basic_salary'];
            $da = $emp['da_amt'];
            $grade_pay = $emp['grade_pay'];
            if ($emp['leve'] == '0') {

                $leavedue = 0;

            } else {
                if ($leave > 0) {

                    //echo $mondays;die;
                    $leavedue = ceil($basicsalary * $leave / $mon_days);
                    $leaveda = ceil($da * $leave / $mon_days);
                    $leave_grade = ceil($grade_pay * $leave / $mon_days);

                } else {
                    $leavedue = 0;
                }

            }
            //pr($leavedue);
            $holidayallowance = 0;
            if ($holidaypresent > 0) {
                $holidayallowance = ceil($basicsalary * $holidaypresent / $mon_days);
            }

            $basicsalary_earn = $basicsalary - $leavedue;
            $da_earn = $da - $leaveda;
            $grade_earn = $grade_pay - $leave_grade;
            $base = $basicsalary_earn + $da_earn + $grade_earn;
            $employer_epf_decationamt = 0;
            $pfdecationamt = 0;
            $fixed_salary = $emp['fsalary'];
            $lev_ded = $leavedue + $leaveda + $leave_grade;
            //pr($basicsalary1);
            //pr($emp_values);die;

            /*--------------------------------   PF Calculation ---------------------------------------------*/
//echo $emp['employee']['EPS']; die;

            if ($base <= $payroll['pfabpamt'] && $emp_values['emp_status'] != "contract") {

                $pfamount = $base * $payroll['employeesharepf'];
                $pfdecationamt = $pfamount / 100;
                $employer_epf_amount = $base * $payroll['employorsharepf'];
                $employer_epf_decationamt = $employer_epf_amount / 100;

            } else if ($base > $payroll['pfabpamt'] && $emp['PF'] == 1) {

                $pfamount = $payroll['pfabpamt'] * $payroll['employeesharepf'];
                $pfdecationamt = $pfamount / 100;
                $employer_epf_amount = $payroll['pfabpamt'] * $payroll['employorsharepf'];
                $employer_epf_decationamt = $employer_epf_amount / 100;

                if ($pfdecationamt < $emp['pfdeduction']) {
                    $pfdecationamt = $emp['pfdeduction'];
                    if ($join_date['p_department'] == 1) {
                        $employer_epf_decationamt = $emp['pfdeduction'];
                    }

                }

            } else if ($emp_values['emp_status'] == "contract" && $emp['PF'] == 1) {
                $pfdecationamt = $emp['pfdeduction'];
                $employer_epf_amount = 0;
                //pr($emp);die;

            } else if ($emp_values['emp_status'] == "contract" && $emp['PF'] == 0) {
                $pfdecationamt = 0;
                $employer_epf_amount = 0;
            }

            /*--------------------------------   Remaining Calculation ---------------------------------------------*/
            //pr($basicsalary);die;

            if ($emp['HRA'] == '1') {
                if (!empty($emp['hra_amt'])) {
                    $f_HRA = $emp['hra_amt'];
                    $HRA = $f_HRA - ceil($f_HRA * $leave / $mon_days);
                } else {
                    $hraamount = $basicsalary * $payroll['hra'];
                    //$hradecationamt = $hraamount / 100;
                    $f_HRA = $hraamount / 100;
                    $HRA = $f_HRA - ceil($f_HRA * $leave / $mon_days);
                }
            } else {
                $f_HRA = 0;
                $HRA = 0;
                $hradecationamt = 0;
            }

            //pr($HRA);

            $sd = 0;

            //pr($leavedue);die;
            //$totalducation=$pfdecationamt+$esidecationamt+$hradecationamt+$traveldecationamt+$ltadecationamt+$sdamt;

            $cca_amt = $emp['cca_amt'] - ceil($emp['cca_amt'] * $leave / $mon_days);
            $data['emp_status'] = $emp_values['emp_status'];
            $data['dept'] = $emp_values['p_department'];
            $data['Eid'] = $emp_values['id'];
            $data['date'] = $this->request->data['date'];
            $data['actual_days'] = $mon_days1 - $leave;
            $data['mode'] = $emp['payment_mode'];
            //$data['']

            $data['f_basic_salary'] = $basicsalary;
            $data['f_da'] = $da;
            $data['f_grade_pay'] = $grade_pay;
            $data['f_HRA'] = $f_HRA;
            $data['f_CCA'] = $emp['cca_amt'];
            $data['f_spl_all'] = $emp['spl_all'];
            $data['CCA'] = $cca_amt;
            $data['spl_all'] = $emp['spl_all'] - ceil($emp['spl_all'] * $leave / $mon_days);
            $data['fsalary'] = $emp['total'];

            $data['basic'] = $basicsalary_earn;
            $data['DA'] = $da_earn;
            $data['grade_pay'] = $grade_earn;
            $data['HRA'] = $HRA;
            $data['Employer_epf'] = $employer_epf_decationamt;
            $data['PF'] = ceil($pfdecationamt);

            $data['over_time'] = $holidayallowance;

            $data['month'] = $mon;
            $data['year'] = $year;
            if (strtolower($emp_values['emp_status']) != "contract") {
                $total_earnings = ceil($data['basic'] + $data['HRA'] + $data['CCA'] + $data['DA'] + $data['spl_all'] + $data['over_time'] + $data['grade_pay']);
            } else {
                $total_earnings = $data['fsalary'] - ceil($data['fsalary'] * $leave / $mon_days);
                $lev_ded = ceil($data['fsalary'] * $leave / $mon_days);
            }

            $data['levduc'] = $lev_ded;
            /*--------------------------------   ESI Calculation ---------------------------------------------*/

            if ($emp['total'] <= $payroll['esiamtap']) {

                $esiamount = $total_earnings * $payroll['employeeshareeesi'];
                $esidecationamt = $esiamount / 100;

                $employeresiamount = $total_earnings * $payroll['employorshareeesi'];
                $employeresidecationamt = $employeresiamount / 100;

            } else {
                $esidecationamt = 0;
                $employeresidecationamt = 0;

            }

            $data['EmployerEsi'] = $employeresidecationamt;
            $data['ESI'] = ceil($esidecationamt);
            $data['SD'] = 0;
            if ($emp['sd'] == 1) {
                $data['SD'] = ceil($data['fsalary'] * $emp['sd_perc'] / 100);
            }
            $tds = 0;
            if (strtolower($emp_values['emp_status']) != "contract") {
                $netpay = ceil($data['basic'] + $data['HRA'] + $data['CCA'] + $data['DA'] + $data['spl_all'] + $data['over_time'] + $data['grade_pay'] - $data['ESI'] - $data['PF'] - $data['TDS'] - $data['SD']);

            } else {

                $data['total_earnings'] = $total_earnings;
                $netpay = $data['total_earnings'] - $data['ESI'] - $data['PF'] - $data['SD'];
            }
            $data['NETPAY'] = $netpay;
            if (!empty($values['cash_pay'])) {
                $data['cash_pay'] = $values['cash_pay'];
                $data['paymentbymode'] = $netpay - $values['cash_pay'];
            } else {
                $data['cash_pay'] = 0;
                $data['paymentbymode'] = $netpay;
            }

            $data['TDS'] = $emp['tds_amt'];
            $data['paymentbymode'] = $netpay - $emp['tds_amt'];

            $result[$emp_values['id']] = $data;
            // pr($data);die;
        }

        // pr($result);die;
        // pr($employees); die;
        $this->set(compact('employees'));
        $this->set(compact('result'));
        $this->set(compact('date'));
        $this->set(compact('pay_mode'));
        $this->set(compact('month_sal'));
        $this->set(compact('not_gen'));

        $salary_det = $this->Salary->find('all')->contain(['Employees'])->where(['Salary.month' => $mon, 'Salary.year' => $year, 'Salary.status' => 'N'])->toarray();
        //pr($salary_det);die;
        if (!empty($salary_det)) {
            $desgname = $this->PayrollDepartments->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
            ])->toarray();
            $this->request->session()->delete('salary_pdf');
            $this->request->session()->write('salary_pdf', $salary_det);
            $this->request->session()->delete('sal_report_date');
            $this->request->session()->write('sal_report_date', $date);
            $this->request->session()->delete('desgname');
            $this->request->session()->write('desgname', $desgname);
        }
    }
    public function draft_salary($mode = null)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Ledger');
        $this->loadModel('PayrollDepartments');
        $ar = array('3', '4');
        $name = $this->Ledger->find('list')->where(['Ledger.gid IN' => $ar])->toarray();
        $this->set(compact('name'));
        $desgname = $this->PayrollDepartments->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->toarray();

        $this->set(compact('desgname'));
        if (!empty($mode)) {
            $this->set(compact('mode'));
            $query1 = "SELECT * FROM `employee_salary_setting` RIGHT JOIN `salary` ON `salary`.`Eid`=`employee_salary_setting`.`employee_id` WHERE `salary`.`mode`=$mode  AND `salary`.`status`='N' ORDER BY `employee_salary_setting`.`employee_id` DESC";
            $conn2 = ConnectionManager::get('default');
            $emp = $conn2->execute($query1)->fetchAll('assoc');
            $this->set('destionation', $emp);
            //pr($emp);die;

        } else {
            $query1 = "SELECT * FROM `employee_salary_setting` RIGHT JOIN `salary` ON `salary`.`Eid`=`employee_salary_setting`.`employee_id` WHERE `salary`.`status`='N' ORDER BY `employee_salary_setting`.`employee_id` DESC";
            $conn2 = ConnectionManager::get('default');
            $emp = $conn2->execute($query1)->fetchAll('assoc');
            $this->set('destionation', $emp);
        }

    }
    public function salary()
    {
        $mode = $this->request->data['pay_mode'];
        $dept = $this->request->data['dept'];

        $this->set(compact('mode'));
        $this->set(compact('dept'));
        // $name = $this->Ledger->find('list')->where(['Ledger.gid IN' => $ar])->toarray();
        if (!empty($mode) && !empty($dept)) {
            $query1 = "SELECT * FROM `employee_salary_setting` INNER JOIN `employees` ON `employees`.`id`=`employee_salary_setting`.`employee_id` RIGHT JOIN `salary` ON `salary`.`Eid`=`employee_salary_setting`.`employee_id` WHERE `salary`.`mode`=$mode  AND `salary`.`status`='N' AND `employees`.`p_department`=$dept ORDER BY `employee_salary_setting`.`employee_id` DESC";
        } else if (!empty($mode)) {
            $query1 = "SELECT * FROM `employee_salary_setting` INNER JOIN `employees` ON `employees`.`id`=`employee_salary_setting`.`employee_id` RIGHT JOIN `salary` ON `salary`.`Eid`=`employee_salary_setting`.`employee_id` WHERE `salary`.`mode`=$mode  AND `salary`.`status`='N' ORDER BY `employee_salary_setting`.`employee_id` DESC";
        } else if (!empty($dept)) {
            $query1 = "SELECT * FROM `employee_salary_setting` INNER JOIN `employees` ON `employees`.`id`=`employee_salary_setting`.`employee_id` RIGHT JOIN `salary` ON `salary`.`Eid`=`employee_salary_setting`.`employee_id` WHERE `salary`.`status`='N' AND `employees`.`p_department`=$dept ORDER BY `employee_salary_setting`.`employee_id` DESC";
        } else {
            $query1 = "SELECT * FROM `employee_salary_setting` INNER JOIN `employees` ON `employees`.`id`=`employee_salary_setting`.`employee_id` RIGHT JOIN `salary` ON `salary`.`Eid`=`employee_salary_setting`.`employee_id` WHERE `salary`.`status`='N' ORDER BY `employee_salary_setting`.`employee_id` DESC";
        }
        //pr($query1);die;
        $conn2 = ConnectionManager::get('default');
        $emp = $conn2->execute($query1)->fetchAll('assoc');
        //pr($emp);die;
        //$emp = $this->Salary->find('all')->contain(['Employeesalary'])->order(['Employees.id' => 'DESC'])->toarray();
        $this->set('destionation', $emp);

    }
    public function save_salary()
    {
        $this->autoRender = false;
        $sal_det = $this->request->session()->read('final_sal');

        foreach ($sal_det as $sal_values) {
            $get_dat = $this->Salary->get($sal_values['id']);
            //pr($get_dat);die;
            $status['status'] = "Y";
            $patch = $this->Salary->patchEntity($get_dat, $status);
            $this->Salary->save($patch);
        }
        return $this->redirect(['action' => 'draft_salary']);
    }

    public function save_delete()
    {
        $this->autoRender = false;
        //pr($this->request->data);die;
        if ($this->request->is('post')) {
            $type = $this->request->data['type'];
            if ($type == "save") {
                $ids = $this->request->data['id'];
                foreach ($ids as $id) {
                    $get_dat = $this->Salary->get($id);
                    //pr($get_dat);die;
                    $status['status'] = "Y";
                    $patch = $this->Salary->patchEntity($get_dat, $status);
                    $this->Salary->save($patch);
                }
                if ($this->request->data['from'] != 'salary_gen') {
                    return $this->redirect(['action' => 'report/4/' . $get_dat['month'] . '-' . $get_dat['year'] . '/' . $get_dat['mode']]);
                }
            } else if ($type == "delete") {
                $ids = $this->request->data['id'];
                if ($this->request->data['from'] == 'salary_gen') {
                    $ids = array();
                    $s_ids = $this->request->data['id'];
                    $ids[0] = $s_ids;
                }

                foreach ($ids as $id) {

                    $res = $this->Salary->get($id);
                    $leaves = $this->Leaves->find('all')->where(['emp_id' => $res['Eid'], 'MONTH(date)' => $res['month'], 'YEAR(date)' => $res['year'], 'half_day_leave' => 'Y'])->toarray();
                    if (!empty($leaves)) {
                        $emp = $this->Employees->get($res['Eid']);
                        $cl['CL_avail'] = $emp['CL_avail'] - count($leaves);
                        // pr($cl['CL_avail']); die;
                        $emppat = $this->Employees->patchEntity($emp, $cl);
                        if ($this->Employees->save($emppat)) {
                            if ($this->Leaves->deleteAll(['emp_id' => $res['Eid'], 'MONTH(date)' => $res['month'], 'YEAR(date)' => $res['year'], 'half_day_leave' => 'Y'])) {
                                $this->Salary->delete($res);
                            }
                        }
                    } else {
                        $this->Salary->delete($res);
                    }

                }
                if ($this->request->data['from'] != 'salary_gen') {
                    $this->redirect(array('action' => 'draft_salary'));
                } else {
                    echo 1;
                }
            }
        }

    }
    public function bank_report_excel($branch = null, $fdate = null, $pay_mode = null)
    {
        //$this->autoRender = false;
        $this->loadModel('Ledger');
        $this->loadModel('PayrollDepartments');
        $this->loadModel('Employees');

        if ($this->request->is('get')) {
            if (empty($fdate)) {
                $fdate = date('m-Y', strtotime('-1 Months'));
            }

            if (empty($branch)) {
                $branch = 4;
            }
            $pos = strpos($fdate, "-");
            $pos += 1;
            $year = substr($fdate, $pos);
            $mon = substr($fdate, 0, $pos - 1);
            //$branch = $this->request->data['branch_id'];

            //$pay_mode = $this->request->data['payment_mode'];
            $desgname = $this->PayrollDepartments->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
            ])->toarray();
            if ($pay_mode != null) {
                //echo "test";die;
                foreach ($desgname as $d_key => $des) {
                    $emp_ext = $this->Salary->find('all')->contain(['Employees'])->where(['Salary.mode' => $pay_mode, 'Salary.month' => $mon, 'Salary.year' => $year, 'Employees.p_department' => $d_key])->count();
                    if ($emp_ext == 0) {
                        unset($desgname[$d_key]);
                    }
                }
            }
            $emp_type = $this->Employees->find('list', [
                'keyField' => 'emp_status',
                'valueField' => 'emp_status',
            ])->group('emp_status')->toarray();
            $con = array();
            $con['Salary.month'] = $mon;
            $con['Salary.year'] = $year;

            $con['Salary.status'] = "Y";
            if (!empty($pay_mode)) {
                $con['Salary.mode'] = $pay_mode;
            }
            //pr($con);die;
            $report = $this->Salary->find('all')->contain(['Employees'])->order(['Employees.fname' => 'ASC'])->where([$con])->toarray();
            $emp_types = $this->Employees->find()->select(['emp_status'])->group('emp_status')->toarray();
            //pr($con);die;
            $this->request->session()->delete('salary_pdf');
            $this->request->session()->write('salary_pdf', $report);
            $this->request->session()->delete('report_type');
            $this->request->session()->write('report_type', $branch);
            $fdate = str_replace('-', '/', $fdate);
            $this->request->session()->delete('sal_report_date');
            $this->request->session()->write('sal_report_date', $fdate);
            $this->request->session()->delete('desgname');
            $this->request->session()->write('desgname', $desgname);

            return;
        }
    }
    public function salary_report()
    {
        $this->viewBuilder()->layout('admin');
    }
    public function salary_excel($branch = null, $fdate = null, $pay_mode = null)
    {
        //pr($this->request->data);die;
        if (!empty($branch) || !empty($fdate) || !empty($pay_mode)) {
            $this->bank_report_excel($branch, $fdate, $pay_mode);
            //echo "test";die;
        }
        $report = $this->request->session()->read('salary_pdf');
        $type = $this->request->session()->read('report_type');
        $date = $this->request->session()->read('sal_report_date');
        $desgname = $this->request->session()->read('desgname');
        if (empty($report)) {
            $this->Flash->error(__('Salary not yet generated for this month'));

            return $this->redirect(['action' => 'report']);
        }
        //pr($desgname);die;
        $this->set(compact('report'));
        $this->set(compact('type'));
        $this->set(compact('date'));
        $this->set(compact('desgname'));

    }
    public function bank_report()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Ledger');
        $name = $this->Ledger->find('list')->where(['Ledger.gid IN' => '3'])->toarray();
        $this->set(compact('name'));

    }
    public function bank_report_search($mon = null, $year = null, $mode = null)
    {
        if ($this->request->is('post')) {
            //pr($this->request->data);
            $this->loadModel('Salary');
            $date = $this->request->data['date'];
            $mode = $this->request->data['pay_mode'];
            $date1 = explode('/', $date);
            $mon = $date1[0];
            $year = $date1[1];
            $bank_dets = $this->Salary->find('all')->where(['mode' => $mode, 'month' => $mon, 'year' => $year])->toarray();
            $this->set(compact('bank_dets'));
            //pr($bank_dets);die;
            $this->set(compact('date'));
            $this->set(compact('mode'));

        }
        if ($this->request->is('get')) {
            //pr($this->request->data);
            $this->loadModel('Salary');
            $bank_dets = $this->Salary->find('all')->where(['mode' => $mode, 'month' => $mon, 'year' => $year])->toarray();
            $this->set(compact('bank_dets'));
            //pr($bank_dets);die;
            $this->set(compact('date'));
            $this->set(compact('mode'));

        }

    }
    public function bank_excel($date = null, $mode = null)
    {
        $date1 = explode('-', $date);
        $mon = $date1[0];
        $year = $date1[1];
        $bank_dets = $this->Salary->find('all')->contain(['Employees'])->where(['mode' => $mode, 'month' => $mon, 'year' => $year])->order(['Employees.p_department' => 'ASC'])->toarray();
        if (empty($bank_dets)) {
            $this->Flash->error(__('Salary not yet generated for this month'));

            return $this->redirect(['action' => 'report']);
        }
        $this->set(compact('bank_dets'));
        $this->set(compact('date'));
        //pr($date);die;
    }
    public function salarysummary()
    {
        $this->autoRender = false;
        return $this->redirect(['action' => 'salary_summary']);
    }
    public function salary_summary()
    {
        $this->loadModel('Salary');
        $this->viewBuilder()->layout('admin');
        $ar = array('3', '4');
        $modes = $this->Ledger->find('all')->where(['Ledger.gid IN' => $ar])->toarray();
        $mon_sal = $this->Salary->find('all')->group(['month', 'year'])->order(['id' => 'DESC'])->toarray();

        foreach ($mon_sal as $months) {
            foreach ($modes as $mode) {

                $articles = TableRegistry::get('Salary');
                // $bank_dets = $this->Salary->find('all')->where(['mode' => $mode['id'], 'month' => $mon, 'year' => $year])->toarray();
                $salary = $articles->find('all')->select(['total' => $articles->find()->func()->sum('Salary.payment_by_mode')])->where(['Salary.mode' => $mode['id'], 'Salary.month' => $months['month'], 'Salary.year' => $months['year']])->first();

                $sal_det[$months['month'] . '-' . $months['year']][$mode['id']] = $salary['total'];

            }
        }

        $this->set(compact('sal_det'));
        $this->set(compact('modes'));
    }
    public function summary_search()
    {

        if ($this->request->is('post')) {
            $s_date = "01-" . $this->request->data['from_date'];
            $e_date = "01-" . $this->request->data['to_date'];
            $s_date = strtotime($s_date);
            $e_date = strtotime($e_date);
            $ar = array('3', '4');
            $modes = $this->Ledger->find('all')->where(['Ledger.gid IN' => $ar])->toarray();

            while ($s_date <= $e_date) {
                $sdate = date('d-m-Y', $s_date);
                $s_date = strtotime("+1 month", $s_date);
                $mon = date('m', strtotime($sdate));
                $year = date('Y', strtotime($sdate));
                foreach ($modes as $mode) {

                    $articles = TableRegistry::get('Salary');
                    // $bank_dets = $this->Salary->find('all')->where(['mode' => $mode['id'], 'month' => $mon, 'year' => $year])->toarray();
                    $salary = $articles->find('all')->select(['total' => $articles->find()->func()->sum('Salary.payment_by_mode')])->where(['Salary.mode' => $mode['id'], 'Salary.month' => $mon, 'Salary.year' => $year])->first();
                    $sal_det[$mon . '-' . $year][$mode['id']] = $salary['total'];

                }

            }
            $this->set(compact('sal_det'));
            $this->set(compact('modes'));

        }
    }
    public function update_salary()
    {
        $this->autoRender = false;
        $this->loadModel('Salary');
        // pr($this->request->data);die;
        $id = $this->request->data['id'];
        $bank_dets = $this->Salary->get($id);
        //pr($bank_dets);die;
        $data['TDS'] = $this->request->data['TDS'];
        $data['advance'] = $this->request->data['advance'];
        $data['payment_by_cash'] = $this->request->data['payment_by_cash'];
        $data['total_deductions'] = $bank_dets['total_deductions'] - $bank_dets['advance'] - $bank_dets['TDS'] + $data['advance'] + $data['TDS'];
        $data['net_salary'] = $bank_dets['total_earnings'] - $data['total_deductions'];
        $data['payment_by_mode'] = $bank_dets['total_earnings'] - $data['payment_by_cash'] - $data['total_deductions'];
        //pr($data);die;
        $patch = $this->Salary->patchEntity($bank_dets, $data);

        if ($this->Salary->save($patch)) {
            echo 1;
        }

    }
    public function delete_salary($mon = null, $year = null)
    {
        $this->autoRender = false;
        $this->loadModel('Salary');
        $this->loadModel('Leaves');
        $this->loadModel('Employees');
        $sal = $this->Salary->find('all')->where(['month' => $mon, 'year' => $year])->toarray();
        foreach ($sal as $salar) {
            $leaves = $this->Leaves->find('all')->where(['emp_id' => $salar['Eid'], 'MONTH(date)' => $mon, 'YEAR(date)' => $year])->toarray();
            if (!empty($leaves)) {
                $emp = $this->Employees->get($salar['Eid']);
                $cl['CL_avail'] = $emp['CL_avail'] - count($leaves);
                // pr($cl['CL_avail']); die;
                $emppat = $this->Employees->patchEntity($emp, $cl);
                if ($this->Employees->save($emppat)) {
                    $this->Leaves->deleteAll(['emp_id' => $salar['Eid'], 'MONTH(date)' => $mon, 'YEAR(date)' => $year, 'half_day_leave' => 'Y']);
                }

            }
        }

        $this->Salary->deleteAll(['Salary.month' => $mon, 'Salary.year' => $year]);
        $this->redirect(array('action' => 'salary_summary'));

    }
    public function emplist()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Employees');
        $this->loadModel('Ledger');
        $ar = array('3', '4');
        $mode = $this->Ledger->find('list')->where(['Ledger.gid IN' => $ar])->toarray();
        $this->set(compact('mode'));
        $desgname = $this->PayrollDepartments->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])->toarray();
        $this->set(compact('desgname'));
        $students = $this->Employees->find('all')->where(['Employees.is_drop' => 'N'])->order(['Employees.p_department' => 'ASC'])->toarray();

        $this->set(compact('students'));
        $rolepresent = $this->request->session()->read('Auth.User.role_id');
        $this->set(compact('rolepresent'));
    }
    public function emplistsearch()
    {
        if ($this->request->is('post')) {
            $con = array();
            if (!empty($this->request->data['payment_mode'])) {
                $con['Employeesalary.payment_mode'] = $this->request->data['payment_mode'];
            }
            if (!empty($this->request->data['dept'])) {
                $con['Employees.p_department'] = $this->request->data['dept'];
            }
            $con['Employees.status'] = 'Y';
            $students = $this->Employees->find('all')->contain(['Employeesalary'])->where([$con])->order(['Employeesalary.payment_mode' => 'ASC'])->order(['Employees.p_department' => 'ASC'])->toarray();
            $this->set(compact('students'));
            $rolepresent = $this->request->session()->read('Auth.User.role_id');
            $this->set(compact('rolepresent'));

        }
    }
    public function leave_master()
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('LeaveRules');
        $this->loadModel('Leavetype');
        $leavetype = $this->Leavetype->find('list', array('Key' => 'id', 'value' => 'short_name'))->toarray();
        //pr($leavetype); die;

        $this->set(compact('leavetype'));
    }
    public function add_lwp()
    {

        $new = $this->LWP->newEntity();
        $patch = $this->LWP->patchEntity($new, $this->request->data);
        $this->LWP->save($patch);
        return true;
    }
    public function emp_absent_report()
    {
        $this->viewBuilder()->Layout('admin');
        $this->loadModel('Leaves');
        $this->loadModel('Employees');
        $this->loadModel('Employeeattendance');
        $employees = $this->Employees->find('all')->where(['Employees.status' => 'Y'])->order(['fname' => 'ASC'])->toarray();
        $this->set('employees', $employees);
        // $date = date("Y-m-d");
        $date = "2019-10-01";
        $emp_leave = $this->Employeeattendance->find('all')->contain(['Employees'])->where(['date' => $date, 'Employeeattendance.status IN' => ['HF', 'A', 'SL']])->toarray();

        $this->set(compact('emp_leave'));

    }
    public function emp_absent_search()
    {
        $this->loadModel('Leaves');
        $this->loadModel('Employees');
        $this->loadModel('Employeeattendance');
        extract($this->request->data);
        if (!empty($employee_id)) {
            $apk['employee_id'] = $employee_id;
        }
        if (!empty($from)) {
            $apk['date >='] = $from;

        }
        if (!empty($to)) {
            $apk['date <='] = $to;

        }
        //   pr($apk); die;
        $apk['Employeeattendance.status IN'] = ['HF', 'A', 'SL'];
        $Leaves = $this->Employeeattendance->find('all')->contain(['Employees'])->where($apk)->toarray();
        $this->set(compact('Leaves'));
    }
    public function add_bank()
    {
        $new = $this->Ledger->newEntity();
        $this->request->data['gid'] = 3;
        $patch = $this->Ledger->patchEntity($new, $this->request->data);
        $this->Ledger->save($patch);
        $this->Flash->Success(__('Designation Updated Successfully'));
        return $this->redirect(['controller' => 'Leavetype', 'action' => 'index']);

    }

    public function bank_status($id = "", $status = "")
    {

        if (isset($id) && !empty($id)) {
            if ($status == 'N') {

                $status = 'Y';
                //status update
                $classes = $this->Ledger->get($id);
                $classes->status = $status;
                if ($this->Ledger->save($classes)) {
                    $this->Flash->success(__('Payment Mode status has been updated.'));
                    return $this->redirect(['controller' => 'Leavetype', 'action' => 'index']);
                }
            } else {

                $status = 'N';
                //status update
                $classes = $this->Ledger->get($id);
                $classes->status = $status;
                if ($this->Ledger->save($classes)) {
                    $this->Flash->success(__('Payment Mode status has been updated.'));
                    return $this->redirect(['controller' => 'Leavetype', 'action' => 'index']);
                }

            }

        }

    }
    public function bank_delete($id = "")
    {
        $classes = $this->Ledger->get($id);
        $this->Ledger->delete($classes);
        $this->Flash->success(__('Payment Mode Deleted Successfully'));
        return $this->redirect(['controller' => 'Leavetype', 'action' => 'index']);

    }
    public function leaves_match()
    {
        $leaves = $this->Leaves->find('all')->toarray();
        //  foreach($leaves as $leave ){
        //   $emp=$this->Employees->find('all')->where(['id'=>$leave['emp_id']])->first();
        //   $cl['CL_avail']=$emp['CL_avail']-4;
        //   $empp=$this->Employees->patchEntity($emp,$cl);
        //   $this->Employees->save($empp);
        //  }
        echo "ok";die;

    }

}
