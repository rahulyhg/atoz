<?php

class BookappointmentController extends Controller {

    public function actionIndex() {
        $session = new CHttpSession;
        $session->open();
        $role_id = $session["user_role_id"];
        $model = new PatientAppointmentDetails;
        $commonobj = new CommonFunction;
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->user->id;
        $doctorModel = Yii::app()->db->createCommand()->select("parent_hosp_id,hospital_name")->from("az_user_details")->where("user_id = :id", array(":id" => $id))->queryRow();
        $request = Yii::app()->request;
        $patientid = "";
        $patientinfo = array();
        if (isset($_GET['id'])) {
            $queryid = Yii::app()->request->getParam('id');
            $date = date('Y-m-d');
            $patientinfo = Yii::app()->db->createCommand()->select('*')->from('az_aptmt_query')->where('id=:queryid', array(':queryid' => $queryid))->queryRow();
            //print_r($patientinfo);
            //  echo $patientinfo['preferred_day'];;exit;
            $patientid = $patientinfo['created_by'];
            $model->patient_id = $patientid;
            $model->patient_name = $patientinfo['patient_name'];
            $model->patient_mobile= $patientinfo['patient_mobile'];
            $model->doc_fees = $patientinfo['apt_fees'];
            $model->type_of_visit = $patientinfo['type_of_visit'];
            //$model->patient_mobile = $patientinfo['creator_number'];
            $model->appointment_date = date("d-m-Y", strtotime($patientinfo['preferred_day']));
            $model->promo_id = $patientinfo['promo_id'];
            $model->enquiry_id = $patientinfo['id'];
            if (!empty($patientinfo['clinic_id'])) {
                $model->hospital_id = $patientinfo['clinic_id'];
                $model->is_clinic = 'Y';
            }
        }
        if (isset($_POST['PatientAppointmentDetails'])) {
            //echo "<pre>";print_r($_POST);exit;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = $request->getPost("PatientAppointmentDetails");
                $pmobile = $postArr['patient_mobile'];

                $model->patient_name = $postArr['patient_name'];
                $model->patient_mobile = $postArr['patient_mobile'];
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                $model->doctor_id = $id;
                $model->created_by = $id;
                $model->hospital_id = $postArr['hospital_id'];
                $model->is_clinic = $postArr['is_clinic'];
                $model->enquiry_id = $postArr['enquiry_id'];
                $model->doc_fees = $postArr['doc_fees'];
                $model->patient_id = $postArr['patient_id'];
                $aptDay = "";
                if (!empty($postArr['type_of_visit'])) {
                    $model->type_of_visit = $postArr['type_of_visit'];
                }
                if (!empty($postArr['appointment_date'])) {
                    $appointmentdate = date("Y-m-d", strtotime($postArr['appointment_date']));
                    $model->appointment_date = $appointmentdate;
                    $aptDay = date("l",  strtotime($postArr['appointment_date']));
                }
                if (!empty($_POST['reservation_slot'])) {
                    $model->time = $_POST['reservation_slot'];
                }else{
                    throw new Exception("Please Select Time");
                }
                $model->day = $aptDay;
                //echo'<pre>';print_r($model);exit;
                if ($model->save()) {

                    $eid = $model->enquiry_id;
                    $time = date('h:i a',$postArr['time']);
                    if (!empty($eid)) {
                        Yii::app()->db->createCommand()->update('az_aptmt_query', array(
                            'apt_confirm' => 'Yes',
                                ), 'id=:id', array(':id' => $eid));
                    }
                    $transaction->commit();
                    $commonobj->sendSms($pmobile, "Reminder: Your appointment time $time on ".date("d-m-Y", strtotime($model->appointment_date)).".  Pl ensure to be on time for best services.");
//                    Your doctor appointment is on $time dt. $DrName['first_name'].$DrName['last_name']. Pl ensure to be on time, else communicate any change well before. Thank you.

                    Yii::app()->user->setFlash('Success', 'Appointment successfully Scheduled');
                    $this->redirect(array("site/docViewAppointment"));
                } else {
                    //print_r($model->getErrors());
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('index', array('model' => $model, 'id' => $id, 'doctorModel' => $doctorModel, 'patientid' => $patientid, 'role_id' => $role_id,'queryid' => $queryid));
    }
    
    public function actionHospitaldr($enquiry = "") {
        $this->layout = 'adminLayout';
        $session = new CHttpSession;
        $session->open();
        $role_id = $session["user_role_id"];
        $model = new PatientAppointmentDetails;
        $commonobj = new CommonFunction;
        $hid = Yii::app()->user->id;
        $request = Yii::app()->request;
        $patientid = "";
        $patientinfo = array();
        if (!empty($enquiry)) {
            $queryid = $enquiry;
            $patientinfo = Yii::app()->db->createCommand()->select('*')->from('az_aptmt_query')->where('id=:queryid', array(':queryid' => $queryid))->queryRow();
            $patientid = $patientinfo['created_by'];
            $model->patient_id = $patientid;
            $model->patient_name = $patientinfo['patient_name'];
            $model->patient_mobile= $patientinfo['patient_mobile'];
            $model->doc_fees = $patientinfo['apt_fees'];
            $model->type_of_visit = $patientinfo['type_of_visit'];
            //$model->patient_mobile = $patientinfo['creator_number'];
            $model->appointment_date = date("d-m-Y", strtotime($patientinfo['preferred_day']));
            $model->promo_id = $patientinfo['promo_id'];
            $model->enquiry_id = $patientinfo['id'];
            $model->doctor_id = $patientinfo['doctor_id'];
            if (!empty($patientinfo['clinic_id'])) {
                $model->hospital_id = $patientinfo['clinic_id'];
                $model->is_clinic = 'Y';
            }
        }
        if (isset($_POST['PatientAppointmentDetails'])) {
            //echo "<pre>";print_r($_POST);exit;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $request = Yii::app()->request;
                $postArr = $request->getPost("PatientAppointmentDetails");
                $pmobile = $postArr['patient_mobile'];

                $model->patient_name = $postArr['patient_name'];
                $model->patient_mobile = $postArr['patient_mobile'];
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                $model->doctor_id = $postArr['doctor_id'];
                $model->created_by = $hid;
                $model->hospital_id = $postArr['hospital_id'];
                $model->is_clinic = $postArr['is_clinic'];
                $model->enquiry_id = $postArr['enquiry_id'];
                $model->doc_fees = $postArr['doc_fees'];
                $model->patient_id = $postArr['patient_id'];
                $aptDay = "";
                if (!empty($postArr['type_of_visit'])) {
                    $model->type_of_visit = $postArr['type_of_visit'];
                }
                if (!empty($postArr['appointment_date'])) {
                    $appointmentdate = date("Y-m-d", strtotime($postArr['appointment_date']));
                    $model->appointment_date = $appointmentdate;
                    $aptDay = date("l",  strtotime($postArr['appointment_date']));
                }
                if (!empty($_POST['reservation_slot'])) {
                    $model->time = $_POST['reservation_slot'];
                }else{
                    throw new Exception("Please Select Time");
                }
                $model->day = $aptDay;
                //echo'<pre>';print_r($model);exit;
                if ($model->save()) {

                    $eid = $model->enquiry_id;
                    $time = date('h:i a',$postArr['time']);
                    if (!empty($eid)) {
                        Yii::app()->db->createCommand()->update('az_aptmt_query', array( 'apt_confirm' => 'Yes'), 'id=:id', array(':id' => $eid));
                    }
                    $transaction->commit();
                    $commonobj->sendSms($pmobile, "Reminder: Your appointment time $time on ".date("d-m-Y", strtotime($model->appointment_date)).".  Pl ensure to be on time for best services.");
//                    Your doctor appointment is on $time dt. $DrName['first_name'].$DrName['last_name']. Pl ensure to be on time, else communicate any change well before. Thank you.

                    Yii::app()->user->setFlash('Success', 'Appointment successfully Scheduled');
                    $this->redirect(array("site/hosViewAppointment"));
                } else {
                    //print_r($model->getErrors());
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('hospitaldr', array('model' => $model, 'hid' => $hid ));
    }

    public function actionGetMonthCalendar() {
        $patientAppModel = new PatientAppointmentDetails();
        $requestObj = Yii::app()->request;
        $year = $requestObj->getParam('year');
        $month = $requestObj->getParam('month');
        $calendar_id = $requestObj->getParam('calendar_id');
        $doctid = $requestObj->getParam('doctid');
        $hospitalid = $requestObj->getParam('hospitalid');
        $is_clinic = $requestObj->getParam('is_clinic');
        $this->renderPartial('monthcalender', array('year' => $year, 'month' => $month, 'calendar_id' => $calendar_id, 'doctid' => $doctid, "hospitalid" => $hospitalid, "is_clinic" => $is_clinic, 'patientAppModel' => $patientAppModel));
    }

    public function actionFillSlotsPopup() {
        $patientAppModel = new PatientAppointmentDetails();
        $requestObj = Yii::app()->request;
        $year = $requestObj->getParam('year');
        $month = $requestObj->getParam('month');
        $calendar_id = $requestObj->getParam('calendar_id');
        $doctid = $requestObj->getParam('doctid');
        $hospitalid = $requestObj->getParam('hospitalid');
        $is_clinic = $requestObj->getParam('is_clinic');
        $day = $requestObj->getParam('day');
        $this->renderPartial('fillSlotsPopup', array('year' => $year, 'month' => $month, 'calendar_id' => $calendar_id, 'doctid' => $doctid, "hospitalid" => $hospitalid, "is_clinic" => $is_clinic, "day" => $day, 'patientAppModel' => $patientAppModel));
    }

    public function actionGetBookingForm() {
        $patientAppModel = new PatientAppointmentDetails();
        $requestObj = Yii::app()->request;
        $year = $requestObj->getParam('year');
        $month = $requestObj->getParam('month');
        $calendar_id = $requestObj->getParam('calendar_id');
        $doctid = $requestObj->getParam('doctid');
        $hospitalid = $requestObj->getParam('hospitalid');
        $is_clinic = $requestObj->getParam('is_clinic');
        $day = $requestObj->getParam('day');
        $this->renderPartial('getBookingForm', array('year' => $year, 'month' => $month, 'calendar_id' => $calendar_id, 'doctid' => $doctid, "hospitalid" => $hospitalid, "is_clinic" => $is_clinic, "day" => $day, 'patientAppModel' => $patientAppModel));
    }

    public function actionHospitalService($enquiry = "") {
        $this->layout = 'adminLayout';
        $session = new CHttpSession;
        $session->open();
        $role_id = $session["user_role_id"];
        $model = new LabBookDetails();
        $commonobj = new CommonFunction;
        $hid = Yii::app()->user->id;
        $request = Yii::app()->request;
        $patientid = "";
        $patientinfo = array();
        if (!empty($enquiry)) {
            $model = LabBookDetails::model()->findByAttributes(array('book_id' => $enquiry));
        }
        $model->parent_hosp_id = $hid;
        if (isset($_POST['LabBookDetails'])) {
            //echo "<pre>";print_r($_POST);exit;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $request = Yii::app()->request;
                $postArr = $request->getPost("LabBookDetails");
                $pmobile = $postArr['mobile_no'];
                if (!empty($postArr['query_bookid'])) {
                    $model = LabBookDetails::model()->findByAttributes(array('book_id' => $postArr['query_bookid']));
                }
                $model->full_name = $postArr['full_name'];
                $model->mobile_no = $postArr['mobile_no'];
                $model->updated_date = date('Y-m-d H:i:s');
                $model->center_id = $postArr['center_id'];
                $model->parent_hosp_id = $postArr['parent_hosp_id'];
                $model->relation = $postArr['relation'];
                $model->other_relation_dis = !empty($postArr['other_relation_dis']) ? $postArr['other_relation_dis'] : NULL;
                $model->patient_age = $postArr['patient_age'];
                $model->patient_id = $postArr['patient_id'];
                $model->service_name = !empty($postArr['service_name']) ? $postArr['service_name'] : NULL;
                if (!empty($postArr['pincode'])) {
                    $model->collect_home = "YES";
                    $model->pincode = $postArr['pincode'];
                    $model->country_id = 1;
                    $model->country_name = "India";
                    $model->state_id = $postArr['state_id'];
                    $model->state_name = $postArr['state_name'];
                    $model->city_id = $postArr['city_id'];
                    $model->city_name = $postArr['city_name'];
                    $model->area_id = $postArr['area_id'];
                    $model->area_name = $postArr['area_name'];
                    $model->landmark = $postArr['landmark'];
                    $model->address = $postArr['address'];
                } else {
                    $model->collect_home = "NO";
                }
                $aptDay = "";
                if (!empty($_POST['PatientAppointmentDetails']['appointment_date'])) {
                    $appointmentdate = date("Y-m-d", strtotime($_POST['PatientAppointmentDetails']['appointment_date']));
                    $model->appointment_date = $appointmentdate;
                    $aptDay = date("l",  strtotime($_POST['PatientAppointmentDetails']['appointment_date']));
                }
                if (!empty($_POST['reservation_slot'])) {
                    $model->appointment_time = $_POST['reservation_slot'];
                }else{
                    throw new Exception("Please Select Time");
                }
                if (!empty($postArr['blood_group']))
                    $model->blood_group = $postArr['blood_group'];
                if (!empty($postArr['no_of_unit']))
                    $model->no_of_unit = $postArr['no_of_unit'];
                $model->status = "Confirm";
                
                $doctordisImageObj = CUploadedFile::getInstance($model, "discription_doc");
                // echo"<pre>";print_r($doctordisImageObj);exit;
                if (!empty($doctordisImageObj)) {
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profileDir = 'doctordis/';                                    //profilepic
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("Y") . "/";                    //year
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("M") . "/";                    //month
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $path_part = pathinfo($doctordisImageObj->name);
                    $fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                    $model->discription_doc = $fname;

                    $doctordisImageObj->saveAs($baseDir . $model->discription_doc);
                }
                //echo'<pre>';print_r($model);exit;
                if ($model->save()) {
                    $time = date('h:i a',$model->appointment_time);
                    $transaction->commit();
                    $commonobj->sendSms($pmobile, "Reminder: Your appointment time $time on ".date("d-m-Y", strtotime($model->appointment_date)).".  Pl ensure to be on time for best services.");
//                    Your doctor appointment is on $time dt. $DrName['first_name'].$DrName['last_name']. Pl ensure to be on time, else communicate any change well before. Thank you.
                    Yii::app()->user->setFlash('Success', 'Appointment successfully Scheduled');
                    $this->redirect(array("bookappointment/hosServiceAppointment"));
                } else {
                    //print_r($model->getErrors());
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('hospitalService', array('model' => $model, 'hid' => $hid ));
    }
    public function actionManageAppointmentServices() {
        $this->layout = 'adminLayout';
        $model = new LabBookDetails();
        $model->unsetAttributes();
        $this->render('manageAppointmentServices', array(
            'model' => $model
        ));
    }
    public function actionHosServiceAppointment() {
        $this->layout = 'adminLayout';
        $model = new LabBookDetails();
        $model->unsetAttributes();
        $this->render('hosServiceAppointment', array(
            'model' => $model
        ));
    }
}
