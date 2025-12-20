<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
include '../vendor/tecnickcom/tcpdf/tcpdf.php';


class ExamController extends AppController
{
    //initialize component
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Classes');
        $this->loadModel('AcademicYear');
        $this->loadModel('Sections');
        $this->loadModel('Exam');
        $this->loadModel('CourseSubjects');
        $this->loadModel('SubjectMarks');
        $this->loadModel('Students');
        $this->loadModel('ExamResult');
        $this->loadModel('Classections');
        $this->loadModel('StudentFinalResult');
    }

    public function index()
    {
        $exams = $this->Exam->find('all')->order(['id' => 'DESC'])->toarray();
        $this->set('exams', $exams);
        $this->viewBuilder()->layout('admin');
    }

    // exam add function finish 
    public function add()
    {
        $this->loadModel('SubjectMarks');
        $this->viewBuilder()->layout('admin');

        $course = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'id', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
        $allSubject = $this->CourseSubjects->find('all')->select(['id', 'subject', 'course_id', 'year'])->where(['status' => 'Y'])->order(['id' => 'ASC'])->toArray();

        $this->set(compact('course', 'academic_session', 'sections', 'allSubject'));


        if ($this->request->is(['post', 'put'])) {

            // only for one add in exam in the year at base course_id && year_id
            $exam_date = $this->request->data['exam_date'];
            $exams = $this->Exam->find('all')->where(['course_id' => $this->request->data['course_id'], 'year_id' => $this->request->data['year_id']])->order(['id' => 'DESC'])->first();

            if (date('Y', strtotime($exam_date)) == date('Y', strtotime($exams['exam_date']))) {
                $this->Flash->error(__('Your Exam already exists this Course & Year/Semester.'));
                return $this->redirect(['action' => 'index']);
            }

            // start already data exist data find code 
            $already_exists = $this->Exam->exists(['exam_name' => $this->request->data['exam_name'], 'course_id' => $this->request->data['course_id'], 'year_id' => $this->request->data['year_id']]);

            $course_name = $this->Classes->get($this->request->data['course_id']);
            if ($already_exists == 1 && (!empty($already_exists))) {
                $this->Flash->error(__('Your exam name ' . $this->request->data['exam_name'] . ' is exists this course ' . $course_name['title']));
                return $this->redirect(['action' => 'add']);
            }

            $this->request->data['exam_date'] = date('Y-m-d', strtotime($this->request->data['exam_date']));
            if ($this->request->data['result_date']) {
                $this->request->data['result_date'] = date('Y-m-d', strtotime($this->request->data['result_date']));
            }
            // end already data exist data find code 

            $exam = $this->Exam->newEntity();

            $this->request->data['year_id'] = $this->request->data['exam_year'];

            $exams = $this->Exam->patchEntity($exam, $this->request->data);
            $result = $this->Exam->save($exams);


            if ($this->request->is(['post', 'put'])) {

                $allMarks = $this->request->data['marks'];
                foreach ($allMarks as $key => $subject_id) {
                    $exam_data['subject_id'] = $key;
                    $exam_data['exam_year'] = $this->request->data['exam_year'];
                    $exam_data['exam_id'] = $result['id'];
                    $exam_data['marks'] = $subject_id[0];
                    $exam_new = $this->SubjectMarks->newEntity();
                    $update_SubjectMarks = $this->SubjectMarks->patchEntity($exam_new, $exam_data);

                    $this->SubjectMarks->save($update_SubjectMarks);
                }


                // student add in StudentExamResultTable
                $AllStudentdata = $this->Students->find('all')->select(['id', 'fname', 'middlename', 'lname', 'fathername', 'enrolment_no', 'roll_no', 'batch', 'enroll', 'exam_year', 'section_id', 'class_id'])->distinct(['Students.id'])
                    ->where(['Students.exam_year' => $result['exam_year']])->order(['id' => 'ASC'])->toarray();

                foreach ($AllStudentdata as $value) {

                    $subject_id = $this->SubjectMarks->find('all')->where(['SubjectMarks.exam_id' => $result['id'], 'SubjectMarks.exam_year' => $value['exam_year']])->toarray();

                    foreach ($subject_id as $vall) {

                        $examResultEntity = $this->ExamResult->newEntity();

                        $examResultData['exam_id'] = $result['id'];
                        $examResultData['exam_year'] = $value['exam_year'];
                        $examResultData['student_id'] = $value['id'];
                        $examResultData['subject_id'] = $vall['subject_id'];
                        $examResultData['result'] = null;
                        $examResultData['course_id'] = $value['class_id'];
                        $examResultData['year'] = $value['section_id'];

                        $saveResultData = $this->ExamResult->patchEntity($examResultEntity, $examResultData);
                        $this->ExamResult->save($saveResultData);
                    }

                    $dataEntity = $this->StudentFinalResult->newEntity();
                    // all data request store in the table in save and update 
                    $resultData['exam_id'] = $result['id'];
                    $resultData['exam_year'] = $value['exam_year'];
                    $resultData['student_id'] = $value['id'];
                    $resultData['enrolment_no'] = $value['enrolment_no'];
                    $resultData['roll_no'] = $value['roll_no'];
                    $resultData['name'] = $value['fname'] . ' ' . $value['middlename'] . ' ' . $value['lname'];
                    $resultData['subject'] = 'All';
                    $resultData['result'] = null;
                    $resultData['eligible_for'] = null;
                    $resultData['obtained_marks'] = null;
                    $resultData['total_marks'] = null;
                    $resultData['fail_in_subject'] = null;
                    $resultData['course_id'] = $value['class_id'];
                    $resultData['year'] = $value['section_id'];
                    $saveData = $this->StudentFinalResult->patchEntity($dataEntity, $resultData);
                    $this->StudentFinalResult->save($saveData);
                }
            }

            $this->Flash->success(__('Your Exam has been added.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id)
    {

        $exam = $this->Exam->get($id);
        if ($this->Exam->delete($exam)) {
            $this->Flash->success(__('Your Exam has been delete'));
            return $this->redirect(['action' => 'index']);
        }
    }


    public function edit($id = null)
    {
        $exam = $this->Exam->find('all')->where(['Exam.id' => $id])->first();

        $course = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('course', $course);

        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'id', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        $this->set('academic_session', $academic_session);

        $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();

        $this->set(compact('course', 'academic_session', 'sections', 'exam'));

        if ($this->request->is(['post', 'put'])) {

            $this->request->data['exam_date'] = date('Y-m-d', strtotime($this->request->data['exam_date']));
            if ($this->request->data['result_date']) {
                $this->request->data['result_date'] = date('Y-m-d', strtotime($this->request->data['result_date']));
            }
            $exams = $this->Exam->patchEntity($exam, $this->request->data);

            $this->Exam->save($exams);

            $this->Flash->success(__('Your Exam has been updated.'));
            return $this->redirect(['action' => 'index']);
        }


        $this->viewBuilder()->layout('admin');
    }


    // subject find for create exam time
    public function find_subject($classid = null, $section = null)
    {
        $this->loadModel('CourseSubjects');

        $classid = $this->request->data['id'];
        $section = $this->request->data['section'];
        $this->viewBuilder()->layout('admin');
        $course_subject = $this->CourseSubjects->find('all')->where(['CourseSubjects.course_id' => $classid, 'CourseSubjects.year' => $section])->toArray();


        echo "<table style='width:100%'>";
        if (count($course_subject) == 0) {
            echo "<tr>";
            echo "<td style='text-align:center;'><b>No Subject Avaiable</b></td>";
            echo "</tr>";
            die;
        }
        echo "<h3>Subject Name</h3>";
        foreach ($course_subject as $value) {
            echo "<tr>";
            echo "<td>" . ($value->subject ? $value->subject : "No Subject") . "</td>";
            echo "<td><input type='text' name='marks[$value->id][]' class='form-control total-marks-input' placeholder='Total Marks' autocomplete='off' onkeypress='return validateNumber(event)' maxlength='3' title='Please enter only numeric values' required></td>";
            echo "</tr>";
        }
        echo "</table>";

        die;
    }



    public function uploadexcel($id = null, $course_id = null, $section_id = null, $exam_year = null)
    {
        $this->loadModel('ExamResult');
        $this->loadModel('Students');
        $this->loadModel('Exam');
        $this->viewBuilder()->layout('admin');

        $is_finalized = $this->Exam->find('all')->where(['id' => $id])->first();
        $this->set(compact('id', 'course_id', 'section_id', 'exam_year', 'is_finalized'));

        if ($this->request->is(['post'])) {
            $is_finalized = $this->Exam->find('all')->where(['id' => $id])->first();
            $check_final['is_finalized'] = ($this->request->data['finalize']) ? $this->request->data['finalize'] : "0";
            $savefinalizedData = $this->Exam->patchEntity($is_finalized, $check_final);
            $this->Exam->save($savefinalizedData);

            if ($this->request->data['file']['tmp_name']) {

                $empexcel = $this->request->data['file'];
                $inputfilename = $empexcel['tmp_name'];
                try {
                    $objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }

                $sheet = $objPHPExcel->getActiveSheet();
                $dataArr = array();
                $highestRow = $sheet->getHighestDataRow();
                $highestColumn = $sheet->getHighestDataColumn();
                $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($row = 2; $row <= $highestRow; ++$row) {
                    $rowData = array();
                    for ($col = 0; $col < $highestColumnIndex; ++$col) {
                        $val = $sheet->getCellByColumnAndRow($col, $row)->getValue();
                        $rowData[] = $val;
                    }
                    $dataArr[] = $rowData;
                }



                // to check all student subject result and total marks
                $subjectTotal = $this->CourseSubjects->find('all')->where(['CourseSubjects.course_id' => $course_id, 'CourseSubjects.year' => $exam_year])->count();
                $indexcount = $subjectTotal + 5;

                foreach ($dataArr as $subjectRes) {

                    $student_id = $this->Students->find('all')->select(['id', 'fname', 'lname', 'enroll', 'enrolment_no', 'roll_no'])->where(['Students.enroll' => $subjectRes[1]])->first();
                    $studentId = $student_id['id'];
                    // $studentId = 254;
                    $studentName = $student_id['fname'] . ' ' . $student_id['lname'];

                    // to check backlog result and marks
                    $backlogcount = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'exam_id IN' => [$id, 0], 'exam_year' => $exam_year, 'is_backlog' => 1])->count();

                    $backlogResultcount = 0;
                    if ($backlogcount > 0) {
                        for ($i = 6; $indexcount >= $i; $i++) {
                            if ($subjectRes[$i] != 'F' && $subjectRes[$i] != 'P' && $subjectRes[$i] != 'NA') {
                                $this->Flash->error(__('You cannot fill the result except P, F and NA for student ' . $studentName . '.'));
                                return $this->redirect(['action' => 'index']);
                            }
                        }

                        $j = $i;
                        $k = $i + 1;
                        // obtain marks can not be greater then total subject marks 
                        if ($subjectRes[$k] > $subjectRes[$j]) {
                            $this->Flash->error(__('Obtain marks cannot be greater then ' . $subjectRes[$j] . ' for student ' . $studentName . '.'));
                            return $this->redirect(['action' => 'index']);
                        }
                    } else {
                        // this is for current students to check result or marks
                        for ($i = 6; $indexcount >= $i; $i++) {
                            if ($subjectRes[$i] != 'F' && $subjectRes[$i] != 'P' && $subjectRes[$i] != 'NA') {
                                $this->Flash->error(__('You cannot fill the result except P, F and NA for student ' . $studentName . '.'));
                                return $this->redirect(['action' => 'index']);
                            }
                        }
                        $j = $i;
                        $k = $i + 1;
                        // obtain marks can not be greater then total subject marks 
                        if ($subjectRes[$k] > $subjectRes[$j]) {
                            $this->Flash->error(__('Obtain marks cannot be greater then ' . $subjectRes[$j] . ' for student ' . $studentName . '.'));
                            return $this->redirect(['action' => 'index']);
                        }
                    }
                }


                foreach ($dataArr as $key => $studentArray) {
                    // student find in enroll(Schloer No) number base
                    $student_id = $this->Students->find('all')->select(['id', 'fname', 'lname', 'enroll', 'enrolment_no', 'roll_no'])->where(['Students.enroll' => $studentArray[1]])->first();
                    $studentId = $student_id['id'];

                    // find all subject in course_id && section_id base 
                    $subject_idarray = $this->CourseSubjects->find('all')->select(['id', 'subject', 'year', 'course_id'])->where(['CourseSubjects.course_id' => $course_id, 'CourseSubjects.year' => $section_id])->toarray();

                    $toatlSubject = count($subject_idarray);
                    $i = 6;
                    $getMarks = '';
                    $total_marks = 0;
                    $optain_marks = 0;
                    $subject_name = null;

                    foreach ($subject_idarray as $key => $subject_id) {
                        $subjectId = $subject_id['id'];
                        $getMarks = $studentArray[$i + $key];
                        // $total_marks = $studentArray[$i + $toatlSubject];
                        $total_marks = $studentArray[$i + $toatlSubject];

                        $optain_marks = $studentArray[$i + $toatlSubject + 1];

                        // find exists studentId or subjectId && exam_id after save data and update data
                        $existsstudent = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'ExamResult.subject_id' => $subjectId, 'exam_id' => $id, 'exam_year' => $exam_year])->count();

                        if ($getMarks == 'NA') {
                            continue;
                        }

                        if ($existsstudent == 1) {
                            $examResultEntity = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'ExamResult.subject_id' => $subjectId, 'exam_id' => $id, 'exam_year' => $exam_year, 'is_backlog' => 0])->first();

                            if ($examResultEntity) {
                                $examResultData['exam_id'] = $id;
                                $examResultData['exam_year'] = $exam_year;
                                $examResultData['student_id'] = $studentId;
                                $examResultData['subject_id'] = $subjectId;
                                $examResultData['result'] = $getMarks;
                                $examResultData['course_id'] = $course_id;
                                $examResultData['year'] = $section_id;
                                $examResultData['is_backlog'] = 0;

                                $saveResultData = $this->ExamResult->patchEntity($examResultEntity, $examResultData);
                                $this->ExamResult->save($saveResultData);
                            } else {
                                $examResultEntity_Backlog = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'ExamResult.subject_id' => $subjectId, 'exam_id' => $id, 'exam_year' => $exam_year, 'is_backlog' => 1])->first();

                                if ($examResultEntity_Backlog) {
                                    $examResultDatas['exam_id'] = $id;
                                    $examResultDatas['exam_year'] = $exam_year;
                                    $examResultDatas['student_id'] = $studentId;
                                    $examResultDatas['subject_id'] = $subjectId;
                                    $examResultDatas['result'] = $getMarks;
                                    $examResultDatas['course_id'] = $course_id;
                                    $examResultDatas['year'] = $section_id;
                                    $examResultDatas['is_backlog'] = 1;

                                    $saveResultData = $this->ExamResult->patchEntity($examResultEntity_Backlog, $examResultDatas);
                                    $this->ExamResult->save($saveResultData);
                                }
                            }
                        } else {
                            $examResultEntity_Backlog = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'ExamResult.subject_id' => $subjectId, 'exam_id' => 0, 'exam_year' => $exam_year, 'is_backlog' => 1])->first();

                            if ($examResultEntity_Backlog) {
                                $examResultDatas['exam_id'] = $id;
                                $examResultDatas['exam_year'] = $exam_year;
                                $examResultDatas['student_id'] = $studentId;
                                $examResultDatas['subject_id'] = $subjectId;
                                $examResultDatas['result'] = $getMarks;
                                $examResultDatas['course_id'] = $course_id;
                                $examResultDatas['year'] = $section_id;
                                $examResultDatas['is_backlog'] = 1;

                                $saveResultData = $this->ExamResult->patchEntity($examResultEntity_Backlog, $examResultDatas);
                                $this->ExamResult->save($saveResultData);
                            }
                        }

                        // if (($check_final['is_finalized']) == 1) {

                        //     if ($getMarks === 'F') {
                        //         $backlogResult = $this->ExamResult->newEntity();
                        //         $failResultData['exam_id'] = 0;
                        //         $failResultData['exam_year'] = $exam_year;
                        //         $failResultData['student_id'] = $studentId;
                        //         $failResultData['subject_id'] = $subjectId;
                        //         $failResultData['result'] = $getMarks;
                        //         $failResultData['course_id'] = $course_id;
                        //         $failResultData['year'] = $section_id;
                        //         $failResultData['is_backlog'] = 1;
                        //         $saveFailResultData = $this->ExamResult->patchEntity($backlogResult, $failResultData);
                        //         $this->ExamResult->save($saveFailResultData);
                        //     }
                        // }
                    }
                    // find pass student result
                    $findResultStudent = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'ExamResult.result' => 'P', 'exam_id' => $id, 'exam_year' => $exam_year])->toarray();
                    // find absent student result
                    $findAbsenttStudent = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'ExamResult.result' => 'A', 'ExamResult.result NOT IN' => 'P', 'ExamResult.result NOT IN' => 'F', 'exam_id' => $id, 'exam_year' => $exam_year])->toarray();
                    // find null student result
                    $findNotUplodedStudent = $this->ExamResult->find('all')->where(['ExamResult.student_id' => $studentId, 'ExamResult.result IS NULL', 'exam_id' => $id, 'exam_year' => $exam_year])->toarray();

                    //  find result in Pass && Remanded
                    if (count($subject_idarray) == count($findResultStudent)) {
                        $result = 'Pass';
                    } else if (count($subject_idarray) == count($findAbsenttStudent)) {
                        $result = 'Absent';
                    } else if (count($subject_idarray) == count($findNotUplodedStudent)) {
                        $result = 'Not Uploaded';
                    } else {
                        $result = 'Remanded';
                    }
                    // find Fail Subject 
                    $findFailSubject = $this->ExamResult->find('all', ['conditions' => ['ExamResult.student_id' => $studentId, 'NOT' => ['ExamResult.result IN' => ['P', 'A']], 'exam_id' => $id, 'exam_year' => $exam_year]])->toArray();

                    foreach ($findFailSubject as $failSubject) {
                        $subjectName = $this->CourseSubjects->find('all')->where(['CourseSubjects.id' => $failSubject['subject_id']])->toarray();
                        $subject_name = [];
                        foreach ($subjectName as $subject) {
                            $subject_name[] = $subject['subject'];
                        }
                    }
                    // all fail subject store 
                    $findSubjectFailStudent = implode(',', $subject_name);

                    // find exists student after data save and update 
                    $existsstudentId = $this->StudentFinalResult->exists(['student_id' => $studentId, 'exam_year' => $exam_year, 'exam_id IN' => [0, $id]]);
                    // pr($existsstudentId); die;
                    if ($existsstudentId) {
                        $dataEntity = $this->StudentFinalResult->find('all')->where(['StudentFinalResult.student_id' => $studentId, 'exam_year' => $exam_year, 'exam_id IN' => [0, $id]])->first();
                    }
                    // all data request store in the table in save and update 
                    $resultData['exam_id'] = $id;
                    $resultData['exam_year'] = $exam_year;
                    $resultData['student_id'] = $studentId;
                    $resultData['enrolment_no'] = ($studentArray[2] != '') ? $studentArray[2] : $student_id['enrolment_no'];
                    $resultData['roll_no'] = ($studentArray[3] != '') ? $studentArray[3] : $student_id['roll_no'];;
                    $resultData['name'] = $student_id['fname'] . ' ' . $student_id['middlename'] . ' ' . $student_id['lname'];
                    $resultData['subject'] = 'All';
                    $resultData['result'] = $result;
                    $resultData['eligible_for'] = 'Yes';
                    $resultData['obtained_marks'] = $optain_marks;
                    $resultData['total_marks'] = $total_marks;
                    $resultData['fail_in_subject'] = $findSubjectFailStudent;
                    $resultData['course_id'] = $course_id;
                    $resultData['year'] = $section_id;
                    $saveData = $this->StudentFinalResult->patchEntity($dataEntity, $resultData);

                    $results = $this->StudentFinalResult->save($saveData);
                    // pr($results); die;

                    // if (($check_final['is_finalized'] == 1)) {
                    //     if (!empty($results['fail_in_subject'])) {

                    //         $update_backlog_data = $this->StudentFinalResult->newEntity();
                    //         $resultData['exam_id'] = 0;
                    //         $resultData['exam_year'] = $exam_year;
                    //         $resultData['student_id'] = $studentId;
                    //         $resultData['enrolment_no'] = $student_id['enrolment_no'];
                    //         $resultData['roll_no'] = $student_id['roll_no'];
                    //         $resultData['name'] = $student_id['fname'] . ' ' . $student_id['middlename'] . ' ' . $student_id['lname'];
                    //         $resultData['subject'] = $findSubjectFailStudent;
                    //         $resultData['result'] = $result;
                    //         $resultData['eligible_for'] = 'Yes';
                    //         $resultData['obtained_marks'] = null;
                    //         $resultData['total_marks'] = null;
                    //         $resultData['fail_in_subject'] = $findSubjectFailStudent;
                    //         $resultData['course_id'] = $course_id;
                    //         $resultData['year'] = $section_id;
                    //         $saveData = $this->StudentFinalResult->patchEntity($update_backlog_data, $resultData);
                    //         $results = $this->StudentFinalResult->save($saveData);
                    //     }
                    // }
                }
            }
            $this->Flash->success(__('Result has been updated.'));
            // return $this->redirect(['action' => 'uploadexcel/' . $id . '/' . $course_id . '/' . $section_id . '/' . $exam_year]);
            return $this->redirect(['action' => 'index']);
        }
    }


    //this excel export all data proper
    public function excelexport($id = null, $course_id = null, $section_id = null, $exam_year = null)
    {
        // find exam Name  && id
        $exam_name = $this->Exam->find()->where(['id' => $id])->first();

        // find all student in course_id && section_id base
        $AllStudentdata = $this->StudentFinalResult->find('all')->where(['StudentFinalResult.exam_id' => $id, 'StudentFinalResult.course_id' => $course_id, 'StudentFinalResult.exam_year' => $exam_year])->order(['StudentFinalResult.name' => 'Asc'])->toarray();
        // pr($AllStudentdata); die


        // find all course subject in course and section base 
        $course_subject = $this->CourseSubjects->find('all')->where(['CourseSubjects.course_id' => $course_id, 'CourseSubjects.year' => $section_id])->toArray();
        // pr($course_subject);exit;

        // find Subject Id For use loop
        foreach ($course_subject as $subject) {
            $subjectId[] = $subject['id'];
        }

        // Exam Result Student get 
        $examData = $this->ExamResult->find('all')->where(['ExamResult.exam_id' => 0, 'ExamResult.subject_id IN' => $subjectId])->group('student_id')->toArray();

        foreach ($examData as $findStudent) {
            $studentId[] = $findStudent['student_id'];
        }

        // Backlog Student Data find 
        if (count($studentId) > 0) {
            $examResultStudent = $this->StudentFinalResult->find('all')->where(['StudentFinalResult.student_id IN' => $studentId])->order(['StudentFinalResult.name' => 'Asc'])->toarray();
        }

        $data = [];
        $uniqueStudentIds = [];


        // Merge data while avoiding duplicate student IDs
        foreach ($AllStudentdata as $student) {
            $studentId = $student['student_id'];
            if (!in_array($studentId, $uniqueStudentIds)) {
                $data[] = $student;
                $uniqueStudentIds[] = $studentId;
            }
        }

        foreach ($examResultStudent as $student) {
            $studentId = $student['student_id'];
            if (!in_array($studentId, $uniqueStudentIds)) {
                $data[] = $student;
                $uniqueStudentIds[] = $studentId;
            }
        }

        $this->set(compact('data', 'course_subject', 'exam_name', 'course_id', 'section_id', 'id'));
    }

    // DONE
    public function downloadpdf($id = null, $course_id = null, $exam_year = null)
    {
        //get result date
        $examResultDate = $this->Exam->find('all')->where(['Exam.id' => $id])->first();

        // All Student Data get
        $studentsPdfData = $this->StudentFinalResult->find('all')->where(['StudentFinalResult.exam_id' => $id, 'StudentFinalResult.course_id' => $course_id, 'StudentFinalResult.exam_year' => $exam_year])->order(['StudentFinalResult.name' => 'Asc'])->toArray();


        // $sitesettings = $this->Sitesettings>find('all')->where(['Sitesettings.id' => $id, 'Sitesettings.site_title' => $site_title, 'Sitesettings.site_keywords' => $site_keywords])->order(['Sitesettings.first_name' => 'Asc'])->toArray();

        // pr($sitesettings);die;

        // Top 3 student for obtained marks 
        $top3Student = $this->StudentFinalResult->find('all')->where(['StudentFinalResult.exam_id' => $id, 'StudentFinalResult.course_id' => $course_id, 'StudentFinalResult.exam_year' => $exam_year, 'StudentFinalResult.obtained_marks IS NOT NULL'])->order(['obtained_marks' => 'DESC'])->limit(3)->toArray();

        $this->set(compact('id', 'course_id', 'section_id', 'studentsPdfData', 'top3Student', 'examResultDate'));
        $this->response->type('pdf');
    }


    public function addbacklogstudent($student_id = null)
    {
        $this->loadModel('Students');
        $this->loadModel('CourseSubjects');

        $this->viewBuilder()->layout('admin');
        $student_id = $this->request->data['student_id'];
        if ($this->request->is(['post', 'put'])) {
            $FindStudent = $this->Students->find('all')->where(['Students.id' => $student_id])->first();

            if ($FindStudent['semester'] != '') {
                $FindSubject = $this->CourseSubjects->find('all')->where(['CourseSubjects.course_id' => $FindStudent['class_id'], 'CourseSubjects.year >=' => 6, 'CourseSubjects.year <' => $FindStudent['semester']])->order('CourseSubjects.id', 'ASC')->toarray();
                $exam_year = $FindStudent['semester'];
            } else {
                $FindSubject = $this->CourseSubjects->find('all')->where(['CourseSubjects.course_id' => $FindStudent['class_id'], 'CourseSubjects.year <' => $FindStudent['section_id']])->order('CourseSubjects.id', 'ASC')->toarray();
                $exam_year = $FindStudent['exam_year'];
            }

            // $FindSubject = $this->CourseSubjects->find('all')->where(['CourseSubjects.course_id' => $FindStudent['class_id'], 'CourseSubjects.year <' => $FindStudent['section_id']])->order('CourseSubjects.id', 'ASC')->toarray();
            $studentId = $FindStudent['id'];
            // $exam_year = $FindStudent['exam_year'];
            if (count($FindSubject) == 0) {
                echo "<table style='width:100%'>";
                echo "<tr>";
                echo "<td style='text-align:center;'><b>No Subject Avaiable</b></td>";
                echo "</tr>";
                echo "</table>";
                die;
            }
            echo "<div class='content-wrapper'>";
            echo "<section class='content-header'>";
            echo "<form id='myForm' action='backlogstudentpost' method='post'>";
            echo "<h4 style='margin-left: 653px;'>Is Failed</h4>";
            $subject_name = [];
            $backlog_result_show = [];
            foreach ($FindSubject as $value) {
                // for previous backlog
                $find_studnet_result = $this->ExamResult->find('all', ['conditions' => ['ExamResult.student_id' => $studentId, 'subject_id' => $value['id'], 'exam_id !=' => 0, 'is_backlog' => 1]])->first();
                if ($find_studnet_result) {
                    $backlog_result_show[] = $find_studnet_result;
                }

                $findsubjectresult = $this->ExamResult->find('all', ['conditions' => ['ExamResult.student_id' => $studentId, 'subject_id' => $value['id'], 'exam_id !=' => 0]])->first();
                // for current backlog
                $find_backlog = $this->ExamResult->find('all', ['conditions' => ['ExamResult.student_id' => $studentId, 'subject_id' => $value['id'], 'exam_id' => 0]])->first();

                if ($find_backlog) {
                    $id = $find_backlog['id'];
                    $subject_name[$id] = $value->subject;
                    continue;
                }
                // else if ($findsubjectresult) {
                //     continue;
                // }

                $FindSection = $this->Sections->find('all')->where(['Sections.id' => $value['year']])->first();
                $sectionTitle = $value->subject . '(' . $FindSection->title . ')';

                echo "<div class='col-md-8'>";
                echo "<input type='text' name='' id='' value='$sectionTitle' class='form-control' readonly>";
                echo "<input type='hidden' name='student_id' value='$studentId'>";
                echo "<input type='hidden' name='exam_year' value='$exam_year'>";
                echo "<input type='hidden' name='course_id' value='$value->course_id'>";
                echo "<input type='hidden' name='year[$value->id]' value='$value->year'>";
                echo "</div>";
                echo "<div class='col-md-2'>";
                echo "<input type='checkbox' class='checkbox' name='result[$value->id][$value->subject]' value='F'>";
                echo "</div>";
            }

            echo "<div class='col-md-6 text-left'>
             <input type='submit' value='Submit' id='submitButton' class='btn btn-primary' style='margin: 20px;'>
               </div>";
            echo "</form>";
            echo "</section>";

            echo "<style>
            table {
                width: 50%;
                border-collapse: collapse;
            }

            th, td {
                padding: 8px 12px;
                border: 1px solid #ddd;
                text-align: left;
            } 
            </style>";

            echo "<table style='margin-left: 50px; width: 84%;'>
                <thead>
            <tr>
                <th>Exam Name</th>
                <th>Subject Name</th>
                <th>Year</th>
                <th>Result</th>
                <th>Exam Date</th>
                <th>Exam Result Date</th>
                <th>Action</th> 
                </tr> 
                </thead>
                <tbody>";

            foreach ($subject_name as $key => $subj) {
                $FindSubjectsBaseYear = $this->CourseSubjects->find('all')->where(['CourseSubjects.subject LIKE' => '%' . $subj . '%'])->first();
                $year = $FindSubjectsBaseYear ? $FindSubjectsBaseYear->year : 'Year Not Found';

                echo "<tr>";
                echo "<td>Not Applicable</td>";
                echo "<td>$subj</td>";
                echo "<td>$year</td>";
                echo "<td>Exam Not Given</td>";
                echo "<td>Not Applicable</td>";
                echo "<td>Not Applicable</td>";
                echo "<td>
                            <button title='Delete' data-key='$key' data-subject='$subj' class='delete-button' style='font-size: 16px; color: red;'>
                                <span class='fa fa-trash'></span>
                            </button>
                          </td>";
                echo "</tr>";
            }

            // this code show backlog result
            foreach ($backlog_result_show as $valll) {
                $examData = $this->Exam->find('all')->where(['Exam.id' => $valll['exam_id']])->first();
                $eaxm_date = date('d-m-Y', strtotime($examData['exam_date']));
                $result_date = date('d-m-Y', strtotime($examData['result_date']));

                $FindSubjectss = $this->CourseSubjects->find('all')->where(['CourseSubjects.id' => $valll['subject_id']])->first();

                echo "<tr>
                       <td>$examData->exam_name</td>
                       <td>$FindSubjectss->subject</td>
                       <td>$valll->exam_year</td>
                       <td>$valll->result</td>
                       <td>$eaxm_date</td>
                       <td>$result_date</td>
                       <td>Not Applicable</td>
            
              </tr>";
            }
            echo "</tbody>
            </table>";
            echo "</div>";

            die;
        }
    }

    // this code for delete backlog single subject entry
    // public function deletebacklog($id = null, $subj = null)
    public function deletebacklog()
    {
        $id = $this->request->data['key'];
        $subj = $this->request->data['subject'];

        $deleteExisting_Result = $this->ExamResult->find('all')->where(['id' => $id])->first();

        // to check for any exam for this course and year
        $tocheckOpenexam = $this->Exam->find('all')->where(['course_id' => $deleteExisting_Result['course_id'], 'exam_year' => $deleteExisting_Result['exam_year'], 'is_finalized' => 0])->first();

        $deleteExisting_Result_final = $this->StudentFinalResult->find('all')->where(['student_id' => $deleteExisting_Result['student_id'], 'exam_year' => $deleteExisting_Result['exam_year'], 'course_id' => $deleteExisting_Result['course_id'], 'exam_id IN' => [0, $tocheckOpenexam['id']]])->first();

        if ($deleteExisting_Result_final) {
            $subject = $deleteExisting_Result_final['fail_in_subject'];
            $sujectArray = explode(',', $subject);
            $filteredArray = array_diff($sujectArray, [$subj]);
            $result['fail_in_subject'] = implode(',', $filteredArray);
            if (!empty($result['fail_in_subject'])) {
                $savefinalizedData = $this->StudentFinalResult->patchEntity($deleteExisting_Result_final, $result);
                $result = $this->StudentFinalResult->save($savefinalizedData);
            } else {
                $result = $this->StudentFinalResult->delete($deleteExisting_Result_final);
            }
        }
        if($deleteExisting_Result){
            $this->ExamResult->delete($deleteExisting_Result);
        }

        $rec_data['success'] = true;
        echo json_encode($rec_data);
        die;
    }

    public function backlogstudentpost()
    {
        $this->autoRender = false;
        if ($this->request->is(['post', 'put'])) {
            $studentId = $this->request->data['student_id'];
            $courseId = $this->request->data['course_id'];

            foreach ($this->request->data['result'] as $key => $result) {
                $sectionId = $this->request->data['year'][$key];
                foreach ($result as $subjectId => $val) {
                    $examResultEntity = $this->ExamResult->newEntity();
                    $subjectIds = $key;
                    $examResultData = [
                        'exam_id' => 0,
                        'student_id' => $studentId,
                        'subject_id' => $subjectIds,
                        'result' => $val,
                        'course_id' => $courseId,
                        'year' => $sectionId,
                        'exam_year' => $sectionId,
                        'is_backlog' => 1,
                    ];

                    $saveResultData = $this->ExamResult->patchEntity($examResultEntity, $examResultData);
                    $this->ExamResult->save($saveResultData);


                    if (!isset($subjectBySection[$sectionId])) {
                        $subjectBySection[$sectionId] = [];
                    }

                    // Add the subjectId to the array for the current sectionId if it's not already there
                    if (!in_array($subjectId, $subjectBySection[$sectionId])) {
                        $subjectBySection[$sectionId][] = $subjectId;
                    }
                }
            }

            // Combine subjects into a string
            foreach ($subjectBySection as $key => $valll) {
                $findSubjectFailStudent = implode(',', $valll);

                $student_info = $this->Students->find('all')->select(['id', 'fname', 'lname', 'enroll', 'enrolment_no', 'roll_no'])->where(['Students.id' => $studentId])->first();

                // to check for any exam for this course and year
                $tocheckOpenexam = $this->Exam->find('all')->where(['course_id' => $courseId, 'exam_year' => $key, 'is_finalized' => 0])->first();

                $Existing_Result_check = $this->StudentFinalResult->find('all')->where(['student_id' => $studentId, 'exam_id IN' => [0, $tocheckOpenexam['id']], 'exam_year' => $key])->first();
                // pr($Existing_Result_check);die;

                if (empty($Existing_Result_check)) {
                    $Existing_Result_check = $this->StudentFinalResult->newEntity();
                    $resultData['fail_in_subject'] = $findSubjectFailStudent;
                    $resultData['subject'] = $findSubjectFailStudent;
                    $resultData['exam_id'] = 0;
                } else {
                    $failSubject = $Existing_Result_check['fail_in_subject'];

                    $subArray = explode(',', $failSubject);
                    $subjectArray = explode(',', $findSubjectFailStudent);
                    $mergedArray = array_merge($subArray, $subjectArray);
                    $uniqueArray = array_unique($mergedArray);
                    $sub = implode(',', $uniqueArray);
                    $resultData['fail_in_subject'] = $sub;
                    $resultData['subject'] = $sub;
                    $resultData['exam_id'] = $tocheckOpenexam['id'];
                }

                //all data request store in the table in save and update 
                $res = (empty($this->request->data['result'])) ? 'Pass' : 'Remanded';
                $resultData['exam_year'] = $key;
                $resultData['student_id'] = $studentId;
                $resultData['enrolment_no'] = $student_info['enrolment_no'];
                $resultData['roll_no'] = $student_info['roll_no'];
                $resultData['name'] = $student_info['fname'] . ' ' . $student_info['middlename'] . ' ' . $student_info['lname'];
                $resultData['result'] = $res;
                $resultData['eligible_for'] = 'Yes';
                $resultData['obtained_marks'] = NULL;
                $resultData['total_marks'] = NULL;
                $resultData['course_id'] = $courseId;
                $resultData['year'] = $key;
                $saveData = $this->StudentFinalResult->patchEntity($Existing_Result_check, $resultData);
                $this->StudentFinalResult->save($saveData);
            }

            $this->Flash->success(__('Backlog student has been added.'));
            return $this->redirect(['action' => 'addbacklogstudent']);
        }
    }
}
