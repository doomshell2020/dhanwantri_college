<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

class RunqueryController extends AppController
{

    public function index()
    {
        $this->viewBuilder()->layout('admin');

        if ($this->request->is(['post', 'put'])) {

            $connection = ConnectionManager::get('default');
            $results = $connection->execute('SHOW DATABASES')->fetchAll('assoc');
            $alldatabase = ['canvas','canvas_ajeetgarh','canvas_ajmer','canvas_azadnagar','canvas_bayana','canvas_bhankrota','canvas_bharatpur','canvas_bhopal','canvas_bikaner','canvas_bundi','canvas_chb','canvas_dausa','canvas_dcm','canvas_deoli','canvas_dhawas','canvas_heerapura','canvas_hyderabad','canvas_iskon','canvas_jhalmand','canvas_khairthal','canvas_kota'];
            foreach ($results as $key=> $dbname) {
                // pr($key); die;
                pr($dbname['Database']);
            }
               die;
            // $conn = ConnectionManager::get('default');

            // $data = $conn->execute("SHOW DATABASES");
        }
    }
}
