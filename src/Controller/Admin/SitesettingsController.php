<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

class SitesettingsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        //load all models
        $this->loadModel('Boards');
        $this->loadModel('Users');
        $this->loadModel('SitesettingsDetails');
        $this->loadModel('TemplateCategory');
        $this->loadModel('Template');
    }
    public function add($id = 1)
    {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Boards');
        $this->loadModel('Users');
        $this->loadModel('SitesettingsDetails');
        $this->loadModel('TemplateCategory');
        $this->loadModel('Template');
        $tmp_cats = $this->TemplateCategory->find('all')->toarray();
        foreach ($tmp_cats as $tmp_cat) {
            $tmp[$tmp_cat['name']] = $this->Template->find('all')->select(['id', 'name'])->where(['FIND_IN_SET(\'' . $tmp_cat['name'] . '\',category)'])->toarray();
        }

        $boards = $this->Boards->find('all')->toarray();
        $boardlist = $this->Users->find('all')->where(['role_id' => 1])->first();
        if ($boardlist) {
            $boardlist = $this->Users->find('all')->where(['role_id' => 1])->first();
        } else {
            $boardlist = $this->Users->find('all')->where(['role_id' => 105])->first();
        }
        $boardarray = explode(',', $boardlist['board']);
        // pr($tmp_cats);die;
        $this->set(compact(['boards', 'boardarray', 'tmp']));
        $this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'));

        if (isset($id) && !empty($id)) {
            //using for edit
            $sitesetting = $this->Sitesettings->find('all')->where(['id' => $id])->first();
            $site_details = $this->SitesettingsDetails->find('all')->where(['status' => 'Y'])->toarray();
            foreach ($site_details as $detail) :
                // pr($detail); die;
                $sitedata['address1'][$detail['board_id']] = $detail['address1'];
                $sitedata['address2'][$detail['board_id']] = $detail['address2'];
                $sitedata['phone'][$detail['board_id']] = $detail['phone'];
                $sitedata['fax'][$detail['board_id']] = $detail['fax'];
                $sitedata['website'][$detail['board_id']] = $detail['website'];
                $sitedata['email'][$detail['board_id']] = $detail['email'];
                $sitedata['fax'][$detail['board_id']] = $detail['fax'];
                $sitedata['subtitle1'][$detail['board_id']] = $detail['subtitle1'];
                $sitedata['subtitle2'][$detail['board_id']] = $detail['subtitle2'];
                $sitedata['logo'][$detail['board_id']] = $detail['logo'];
                $sitedata['sign'][$detail['board_id']] = $detail['sign'];
                $sitedata['header_logo'][$detail['board_id']] = $detail['header_logo'];
                $sitedata['tc_logo'][$detail['board_id']] = $detail['tc_logo'];
                $sitedata['small_logo'][$detail['board_id']] = $detail['small_logo'];
                $sitedata['icon'][$detail['board_id']] = $detail['icon'];
                $sitedata['pan_number'][$detail['board_id']] = $detail['pan_number'];
                $sitedata['company_name'][$detail['board_id']] = $detail['company_name'];
                $sitedata['gst_no'][$detail['board_id']] = $detail['gst_no'];
                $sitedata['tin_date'][$detail['board_id']] = date('Y-m-d', strtotime($detail['tin_date']));
                //  pr($sitedata['tin_date'][$detail['board_id']]); die;
                $sitedata['account_number'][$detail['board_id']] = $detail['account_number'];
                $sitedata['cmobile_no'][$detail['board_id']] = $detail['cmobile_no'];

                $sitedata['ifsc'][$detail['board_id']] = $detail['ifsc'];
                $sitedata['address'][$detail['board_id']] = $detail['address'];

                $sitedata['school_code'][$detail['board_id']] = $detail['school_code'];
                $sitedata['affiliation_no'][$detail['board_id']] = $detail['affiliation_no'];


            endforeach;
            $sitesetting['address1'] = $sitedata['address1'];
            $sitesetting['address2'] = $sitedata['address2'];
            $sitesetting['phone'] = $sitedata['phone'];
            $sitesetting['email'] = $sitedata['email'];
            $sitesetting['fax'] = $sitedata['fax'];
            $sitesetting['website'] = $sitedata['website'];
            $sitesetting['fax'] = $sitedata['fax'];
            $sitesetting['subtitle1'] = $sitedata['subtitle1'];
            $sitesetting['subtitle2'] = $sitedata['subtitle2'];
            $sitesetting['logo'] = $sitedata['logo'];
            $sitesetting['school_code'] = $sitedata['school_code'];
            $sitesetting['affiliation_no'] = $sitedata['affiliation_no'];
            $sitesetting['sign'] = $sitedata['sign'];
            $sitesetting['header_logo'] = $sitedata['header_logo'];
            $sitesetting['tc_logo'] = $sitedata['tc_logo'];
            $sitesetting['small_logo'] = $sitedata['small_logo'];
            $sitesetting['icon'] = $sitedata['icon'];
            $sitesetting['pan_number'] = $sitedata['pan_number'];
            $sitesetting['company_name'] = $sitedata['company_name'];
            $sitesetting['gst_no'] = $sitedata['gst_no'];
            $sitesetting['tin_date'] =  $sitedata['tin_date'];
            // pr($sitesetting['tin_date']); die;
            $sitesetting['account_number'] = $sitedata['account_number'];
            $sitesetting['ifsc'] = $sitedata['ifsc'];
            $sitesetting['address'] = $sitedata['address'];
            $sitesetting['cmobile_no'] = $sitedata['cmobile_no'];
        }

        if ($this->request->is(['post', 'put'])) {
            //  pr($this->request->data); die;

            if ($this->request->data['print'] == '') {

                $this->request->data['print'] = '0';
            }
            $conn = ConnectionManager::get('default');
            //$detail='UPDATE `users` SET `mobile` ="'.$this->request->data['mobile'].'",`email` ="'.$this->request->data['contact_email'].'" WHERE `users`.`role_id` =1';
            //$results = $conn->execute($detail);

            if ((isset($this->request->data['new_password']) && !empty($this->request->data['new_password'])) && (isset($this->request->data['confirm_pass']) && !empty($this->request->data['confirm_pass']))) {
                if ($this->request->data['new_password'] == $this->request->data['confirm_pass']) {
                    $new_pass['password'] = (new DefaultPasswordHasher)->hash($this->request->data['new_password']); //change Password                
                    $user = $this->Users->patchEntity($user, $new_pass);
                    $this->Users->save($user);
                    $this->Flash->success(__('Your new password has been changed successfully !'));
                } else {
                    $this->Flash->error(__('Your new password and confirm password doesnot match, try again.'));
                    return $this->redirect(['action' => 'add']);
                }
            } // edit site setting
            // pr($this->request->data); 
            foreach ($boardarray as $bd) {
                $exist = $this->SitesettingsDetails->exists(['board_id' => $bd]);
                if ($exist) :
                    $sitedetails = $this->SitesettingsDetails->find('all')->where(['board_id' => $bd])->first();
                else :
                    $sitedetails = $this->SitesettingsDetails->newEntity();
                endif;
                $data['board_id'] = $bd;
                $data['address1'] = $this->request->data['address1'][$bd];
                $data['address2'] = $this->request->data['address2'][$bd];
                $data['phone'] = $this->request->data['phone'][$bd];
                $data['fax'] = $this->request->data['fax'][$bd];
                $data['email'] = $this->request->data['email'][$bd];
                $data['website'] = $this->request->data['website'][$bd];
                $data['subtitle1'] = $this->request->data['subtitle1'][$bd];
                $data['subtitle2'] = $this->request->data['subtitle2'][$bd];
                $data['affiliation_no'] = $this->request->data['affiliation_no'][$bd];
                $data['school_code'] = $this->request->data['school_code'][$bd];
                $data['company_name'] = $this->request->data['cname'][$bd];
                $data['pan_number'] = $this->request->data['pan_no'][$bd];
                $data['account_number'] = $this->request->data['account_number'][$bd];
                $data['ifsc'] = $this->request->data['ifsc'][$bd];
                $data['tin_date'] =  date('Y-m-d', strtotime($this->request->data['tin_date']));
                // pr($data['tin_date']); die;
                $data['gst_no'] = $this->request->data['gst_no'][$bd];
                $data['address'] = $this->request->data['address'][$bd];
                $data['cmobile_no'] = $this->request->data['cmobile_no'][$bd];


                if (!empty($this->request->data['logo'][$bd]['name'])) :
                    ${'filename' . $bd} = $this->request->data['logo'][$bd]['name'];
                    ${'item' . $bd} = $this->request->data['logo'][$bd]['tmp_name'];
                    $ext = end(explode('.', ${'filename' . $bd}));
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'JPG' && $ext != 'jpeg' && $ext != 'png') :
                        $this->Flash->error(__('Only Image file can be uploaded'));
                        return $this->redirect(['action' => 'add']);
                    endif;
                    $name = md5(${'filename' . $bd} . uniqid());
                    ${'imagename' . $bd} = $name . '.' . $ext;
                    if (move_uploaded_file(${'item' . $bd}, "images/" . ${'imagename' . $bd})) :
                        $data['logo'] = ${'imagename' . $bd};
                    endif;
                else :
                    unset($data['logo']);
                endif;

                //small logo addd

                if (!empty($this->request->data['small_logo'][$bd]['name'])) :
                    // pr($this->request->data); die;
                    ${'filename' . $bd} = $this->request->data['small_logo'][$bd]['name'];
                    ${'item' . $bd} = $this->request->data['small_logo'][$bd]['tmp_name'];
                    $ext = end(explode('.', ${'filename' . $bd}));
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'JPG' && $ext != 'jpeg' && $ext != 'png') :
                        $this->Flash->error(__('Only Image file can be uploaded'));
                        return $this->redirect(['action' => 'add']);
                    endif;
                    $name = md5(${'filename' . $bd} . uniqid());
                    // $name = "st_matrtins_logo" .$bd;
                    ${'imagename' . $bd} = $name . '.' . $ext;
                    if (move_uploaded_file(${'item' . $bd}, "images/" . ${'imagename' . $bd})) :
                        $data['small_logo'] = ${'imagename' . $bd};
                    endif;
                else :
                    unset($data['small_logo']);
                endif;


                //small logo end 

                // icon logo

                if (!empty($this->request->data['icon'][$bd]['name'])) :
                    // pr($this->request->data); die;
                    ${'filename' . $bd} = $this->request->data['icon'][$bd]['name'];
                    ${'item' . $bd} = $this->request->data['icon'][$bd]['tmp_name'];
                    $ext = end(explode('.', ${'filename' . $bd}));
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'JPG' && $ext != 'jpeg' && $ext != 'png') :
                        $this->Flash->error(__('Only Image file can be uploaded'));
                        return $this->redirect(['action' => 'add']);
                    endif;
                    // $name = md5(${'filename' . $bd} . uniqid());
                    $name = "st_matrtins_icon_logo" . $bd;
                    ${'imagename' . $bd} = $name . '.' . $ext;
                    if (move_uploaded_file(${'item' . $bd}, "images/" . ${'imagename' . $bd})) :
                        $data['icon'] = ${'imagename' . $bd};
                    endif;
                else :
                    unset($data['icon']);
                endif;


                // icon logo end


                if (!empty($this->request->data['sign'][$bd]['name'])) :
                    ${'sign' . $bd} = $this->request->data['sign'][$bd]['name'];
                    ${'signtmp' . $bd} = $this->request->data['sign'][$bd]['tmp_name'];
                    $ext = end(explode('.', ${'sign' . $bd}));
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'JPG' && $ext != 'jpeg' && $ext != 'png') :
                        $this->Flash->error(__('Only Image file can be uploaded'));
                        return $this->redirect(['action' => 'add']);
                    endif;
                    $name1 = md5(${'sign' . $bd} . uniqid());
                    ${'boardsign' . $bd} = $name1 . '.' . $ext;
                    if (move_uploaded_file(${'signtmp' . $bd}, "images/" . ${'boardsign' . $bd})) :
                        $data['sign'] = ${'boardsign' . $bd};
                    endif;
                else :
                    unset($data['sign']);
                endif;
                if (!empty($this->request->data['header_logo'][$bd]['name'])) :
                    ${'header_logo' . $bd} = $this->request->data['header_logo'][$bd]['name'];
                    ${'header_logotmp' . $bd} = $this->request->data['header_logo'][$bd]['tmp_name'];
                    $ext = end(explode('.', ${'header_logo' . $bd}));
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'JPG' && $ext != 'jpeg' && $ext != 'png') :
                        $this->Flash->error(__('Only Image file can be uploaded'));
                        return $this->redirect(['action' => 'add']);
                    endif;
                    $name1 = md5(${'header_logo' . $bd} . uniqid());
                    ${'header_logo' . $bd} = $name1 . '.' . $ext;
                    if (move_uploaded_file(${'header_logotmp' . $bd}, "images/" . ${'header_logo' . $bd})) :
                        $data['header_logo'] = ${'header_logo' . $bd};
                    endif;
                else :
                    unset($data['header_logo']);
                endif;
                if (!empty($this->request->data['tc_logo'][$bd]['name'])) :
                    ${'tc_logo' . $bd} = $this->request->data['tc_logo'][$bd]['name'];
                    ${'tc_logotmp' . $bd} = $this->request->data['tc_logo'][$bd]['tmp_name'];
                    $ext = end(explode('.', ${'tc_logo' . $bd}));
                    if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'JPG' && $ext != 'jpeg' && $ext != 'png') :
                        $this->Flash->error(__('Only Image file can be uploaded'));
                        return $this->redirect(['action' => 'add']);
                    endif;
                    $name1 = md5(${'tc_logo' . $bd} . uniqid());
                    ${'tc_logo' . $bd} = $name1 . '.' . $ext;
                    if (move_uploaded_file(${'tc_logotmp' . $bd}, "images/" . ${'tc_logo' . $bd})) :
                        $data['tc_logo'] = ${'tc_logo' . $bd};
                    endif;
                else :
                    unset($data['tc_logo']);
                endif;




                $savedetails = $this->SitesettingsDetails->patchEntity($sitedetails, $data);
                //   pr($savedetails); die;

                $this->SitesettingsDetails->save($savedetails);
            }
            $sitesetting = $this->Sitesettings->patchEntity($sitesetting, $this->request->data);

            if ($this->Sitesettings->save($sitesetting)) {
                $this->Flash->success(__('Your site setting has been updated.'));
                return $this->redirect(['action' => 'add/' . $sitesetting['id']]);
            }
        }
        $this->set('sitesetting', $sitesetting);
        $this->set('user', $user);
    }

    public function profile($id = null)
    {
        $this->viewBuilder()->layout('admin');
    }
}
