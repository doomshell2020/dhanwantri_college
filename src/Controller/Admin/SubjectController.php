<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


class SubjectController extends AppController
{
    //initialize component
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Classes');
        $this->loadModel('AcademicYear');
        $this->loadModel('Sections');
        $this->loadModel('CourseSubjects');
        $this->loadModel('Classections');
    }

    public function index()
    {
        $sections = $this->Sections->find('all')->select(['id', 'title'])->order(['id' => 'ASC'])->toArray();

        $classes = $this->Classections->find('list', [
            'keyField' => 'Classes.id',
            'valueField' => 'Classes.wordsc',
        ])->contain(['Classes'])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();

        $req_data = $_GET;

        $course_id = $req_data['class_id'];
        $section_id = $req_data['section_id'];

        $conditions = [];
        if (!empty($course_id)) {
            $conditions['CourseSubjects.course_id'] = $course_id;
        }
        if (!empty($section_id)) {
            $conditions['CourseSubjects.year'] = $section_id;
        }
        if (!empty($conditions)) {
            $query = $this->CourseSubjects->find('all')->where($conditions)->order(['course_id' => 'asc','year' => 'asc','subject' => 'asc']);
            $course_subject = $this->paginate($query)->toarray();
        } else {
            $query = $this->CourseSubjects->find('all')->order(['course_id' => 'asc','year' => 'asc','subject' => 'asc',]);
            $course_subject =  $this->paginate($query)->toarray();
        }
        $this->set('course_subject', $course_subject);
        $this->set(compact('classes', 'sections'));

        $this->viewBuilder()->layout('admin');
    }


    public function add()
    {
        $this->viewBuilder()->layout('admin');

        $course = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'id', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
        $this->set(compact('course', 'academic_session', 'sections'));

        if ($this->request->is(['post', 'put'])) {

            $allSubject = $this->request->data['subject'];
            $courseId = $this->request->data['course_id'];
            $year = $this->request->data['year'];

            foreach ($allSubject as $subjectName) {
                $subjectData = [
                    'course_id' => $courseId,
                    'year' => $year,
                    'subject' => $subjectName,
                ];
                // find exist subject
                $exists = $this->CourseSubjects->exists(['course_id' => $courseId, 'year' => $year, 'subject' => $subjectName]);

                if ($exists == 1) {
                    // exist subject name store
                    $exit_subject_name[] = $subjectName;
                    continue;
                } else if (empty($subjectName) && $subjectName == '') {
                    // empty row not add in the database table
                    continue;
                }

                $subject = $this->CourseSubjects->newEntity();
                $subject = $this->CourseSubjects->patchEntity($subject, $subjectData);
                $this->CourseSubjects->save($subject);
            }
            if (!empty($exit_subject_name)) {
                $sub_name = implode(', ', $exit_subject_name);
                $this->Flash->error(__('Your other Subject has been added but this subject name ( ' . $sub_name . ' ) already exists.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->success(__('Your Subject has been added.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id)
    {
        $subject = $this->CourseSubjects->get($id);
        if ($this->CourseSubjects->delete($subject)) {
            $this->Flash->success(__('Your subject has been delete'));
            return $this->redirect(['action' => 'index']);
        }
    }


    public function edit($id = null)
    {
        $subject = $this->CourseSubjects->find('all')->where(['CourseSubjects.id' => $id])->first();

        $course = $this->Classes->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])->where(['Classes.status' => '1'])->order(['Classes.sort' => 'ASC'])->toArray();
        $this->set('course', $course);

        $academic_session = $this->AcademicYear->find('list', ['keyField' => 'id', 'valueField' => 'academicyear'])->order(['AcademicYear.id' => 'DESC'])->toArray();
        $this->set('academic_session', $academic_session);
        $sections = $this->Sections->find('all')->select(['id', 'title'])->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
        $this->set(compact('course', 'academic_session', 'sections', 'subject'));

        $this->viewBuilder()->layout('admin');
    }



    function search()
    {
        $req_data = $_GET;
        $course_id = $req_data['class_id'];
        $section_id = $req_data['section_id'];

        $conditions = [];
        if (!empty($course_id)) {
            $conditions['CourseSubjects.course_id'] = $course_id;
        }
        if (!empty($section_id)) {
            $conditions['CourseSubjects.year'] = $section_id;
        }
        $session = $this->request->session();
        $this->request->session()->delete('searchResult');
        $session->write('searchResult', $req_data);

        $query = $this->CourseSubjects->find('all')->where($conditions)->order(['course_id' => 'asc','year' => 'asc','subject' => 'asc']);
        $course_subject = $this->paginate($query)->toarray();
        $this->set('course_subject', $course_subject);
    }



}
