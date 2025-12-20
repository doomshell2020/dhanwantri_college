<?php
//sanjay
namespace App\Controller\Admin;

use App\Controller\AppController;

class BanksController extends AppController
{
    //initialize component
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Banks');
    }

    public function index($id = null)
    {
        $this->viewBuilder()->layout('admin');
        //show data in listing
        $bankss = $this->Banks->find('all')->order(['id' => 'ASC'])->toarray();
        $this->paginate($service_data);
        //pr($locations); die;
        $this->set('bankss', $bankss);
        $this->set('ids', $id);
        if (isset($id) && !empty($id)) {

            $banks = $this->Banks->get($id);
        } else {
            $banks = $this->Banks->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            $banks = $this->Banks->patchEntity($banks, $this->request->data);
            //pr($locations); die;
            if ($this->Banks->save($banks)) {
                $this->Flash->success(__('Banks has been saved.'));
                return $this->redirect(['action' => 'index']);

            }

        }
        $this->set('banks', $banks);

    }
/*    public function add($id=null){
$this->viewBuilder()->layout('admin');
if(isset($id) && !empty($id)){
//using for edit
Banks             $locations = $this->Locations->get($id);

}else{
//using for new entry
$locations = $this->Locations->newEntity();
$statusquery = $this->Locations->find('all')->where(['Locations.status' =>'Y'])->count();
if($statusquery < 8){

$this->request->data['status'] = '1';
}else{

$this->request->data['status'] = '0';
}
}
if ($this->request->is(['post', 'put'])) {

//    pr($this->request->data); die;

// save all data in database
$locations = $this->Locations->patchEntity($locations, $this->request->data);
//pr($locations); die;
if ($this->Locations->save($locations)) {
$this->Flash->success(__('Locations has been saved.'));
return $this->redirect(['action' => 'index']);
}else{ //pr($classes->errors());
//validation error
if($locations->errors()){
$error_msg = [];
foreach( $locations->errors() as $errors){
if(is_array($errors)){
foreach($errors as $error){
$error_msg[]    =   $error;
}
}else{
$error_msg[]    =   $errors;
}
}
if(!empty($error_msg)){
$this->Flash->error(
__("Please fix the following error(s): ".implode("\n \r", $error_msg))
);
}
}

}

}

$this->set('locations', $locations);
}
 */

    public function sort()
    {
        $this->viewBuilder()->layout('admin');
        $id = $this->request->data[id];
        if (isset($id) && !empty($id)) {
            //using for edit
            $classes = $this->Locations->get($id);

        } else {
            //using for new entry
            $classes = $this->Locations->newEntity();
        }

        if ($this->request->is(['post', 'put'])) {

            //$this->request->data = $this->request->data['sort'];
            $classes->sort = $this->request->data['sort'];

            if ($this->Locations->save($classes)) {
                echo $classes['sort'];
            } else {
                echo 'wrong';

            }
        }
        die;
    }
    //view functionality
    public function view($id)
    {
        $this->viewBuilder()->layout('admin');
        //get data from paricular id
        $classes = $this->Locations->get($id);
        $this->set(compact('classes'));
    }
    //delete functionality
    public function delete($id)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $classes = $this->Banks->get($id);
        //delete pariticular entry
        if ($this->Banks->delete($classes)) {
            $this->Flash->success(__(' Banks with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }
    //status update functionality
    public function status($id, $status)
    {

        $statusquery = $this->Banks->find('all')->where(['Banks.status' => 'Y'])->count();
        if (isset($id) && !empty($id)) {
            if ($status == 'Y') {

                $status = 'N';
                //status update
                $classes = $this->Banks->get($id);
                $classes->status = $status;
                if ($this->Banks->save($classes)) {
                    $this->Flash->success(__(' Banks status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                if ($statusquery < 8) {
                    $status = 1;
                    //status update
                    $classes = $this->Banks->get($id);
                    $classes->status = $status;
                    if ($this->Banks->save($classes)) {
                        $this->Flash->success(__('Banks status has been updated.'));
                        return $this->redirect(['action' => 'index']);
                    }

                } else {
                    $this->Flash->error(__('8 Entries all ready activate. Please deactivate one of activate'));
                    return $this->redirect(['action' => 'index']);
                }
            }

        }

    }

}
