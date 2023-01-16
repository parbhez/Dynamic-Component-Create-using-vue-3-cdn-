<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// https://vegibit.com/developing-with-vuejs-and-php/

class TestController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('FetchCommonQuery');
        $this->load->model('Student');
        $this->load->model('Common_model', 'common');
        $userinfo = $this->session->userdata('userinfo');
    }


    public function Test()
    {
        $this->load->view('Backend/partials/top');
        $this->load->view('Backend/partials/nav');
        $this->load->view('Backend/common/message');
        $this->load->view('Backend/partials/sidebar');

        $data['submenus'] = $this->db->select('*')->from('frontend_submenu')->limit(3)->get()->result();
        $data['sponsorship_category'] = $this->db->select('*')->from('sponsorship_category')->limit(3)->get()->result();
        $data['school_register'] = $this->db->select('*')->from('school_register')->limit(3)->get()->result();

        $this->load->view('Backend/front-end-setting/Test',$data);
        $this->load->view('Backend/partials/footer');
        $this->load->view('Backend/partials/bottom');
    }

    public function filter_data()
    {
        $bcss_unique_code = $this->input->get('bcss_unique_code');
        $class_id = $this->input->get('class_id');
        $sponsorship_category_id = $this->input->get('sponsorship_category_id');
        $school_register_id = $this->input->get('school_register_id');
        $area_id = $this->input->get('area_id');
        $donar_register_id = $this->input->get('donar_register_id');
        $last_name = $this->input->get('last_name');
        $sponsor_code = $this->input->get('sponsor_code');
        $gender = $this->input->get('gender');
        $sm_status = $this->input->get('sm_status');
        
        try{
            $find = $this->Student->sm_approved_filter_children_list($bcss_unique_code, $class_id, $sponsorship_category_id, $school_register_id, $area_id, $donar_register_id, $last_name, $sponsor_code, $gender, $sm_status);
            if($find){
                echo json_encode(['status' => 'success','message' => 'Data reterieve successfully !','result' => $find,'code' => 200]);
            }else{
                echo json_encode(['status' => 'error','message' => 'Data not found !','result' => [],'code' => 404]);
            }
        }catch(\Exception $e){
           echo json_encode(['status' => 'error','message' => 'Opps!! Something Went Wrong.','result' => $e->getMessage(),'code' => 500]);
        }
    }

    public function showFrontendSubMenu()
    {
        try {
            $find = $this->db->select([
                'frontend_submenu.*',
                ])
            ->from('frontend_submenu')
            ->get()->result();

            if ($find) {
                echo json_encode(['status' => 'success', 'message' => 'Data reterieve successfully !', 'result' => $find, 'code' => 200]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data not found !', 'result' => [], 'code' => 404]);
            }
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Opps!! Something Went Wrong.', 'result' => $e->getMessage(), 'code' => 500]);
        }
    }

    public function showFrontendMenu($frontend_menu_id)
    {
        try {
            $find = $this->db->select([
                'frontend_menu.*',
                ])
            ->from('frontend_menu')
            ->where('frontend_menu_id',$frontend_menu_id)
            ->get()->result();

            if ($find) {
                echo json_encode(['status' => 'success', 'message' => 'Data reterieve successfully !', 'result' => $find, 'code' => 200]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data not found !', 'result' => [], 'code' => 404]);
            }
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Opps!! Something Went Wrong.', 'result' => $e->getMessage(), 'code' => 500]);
        }
    }



















    public function test2()
    {
        $data = $this->db->select('*')->from('student_attendance_wise_subsidy')
        ->where('month_year','2022-12')
        ->where('school_register_id',6)
        ->get()->result();

        // echo "<pre>";
        // print_r($data);
        // exit();

        $i = 62490;
        $arr = [];

        foreach ($data as $key => $value) {
            $arr['student_attendance_wise_subsidy_id'] = $i; 
            $arr['student_attendence_id'] = $value->student_attendence_id; 
            $arr['student_registration_id'] = $value->student_registration_id; 
            $arr['school_register_id'] = $value->school_register_id; 
            $arr['area_id'] = $value->area_id; 
            $arr['donar_register_id'] = $value->donar_register_id; 
            $arr['sponsorship_category_id'] = $value->sponsorship_category_id; 
            $arr['monthly_subsidy_in_bdt'] = $value->monthly_subsidy_in_bdt; 
            $arr['subsidy_adjustment'] = $value->subsidy_adjustment; 
            $arr['medical_bill'] = $value->medical_bill; 
            $arr['orphan_supply'] = $value->orphan_supply; 
            $arr['additional_payment'] = $value->additional_payment; 
            $arr['donar_wise_additional_payment_setup_id'] = $value->donar_wise_additional_payment_setup_id; 
            $arr['additional_payment_total_amount'] = $value->additional_payment_total_amount; 
            $arr['total_subsidy_payment'] = $value->total_subsidy_payment; 
            $arr['deduction'] = $value->deduction; 
            $arr['total_final_amount'] = $value->total_final_amount; 
            $arr['status'] = 2; 
            $arr['remarks'] = $value->remarks ?? ''; 
            $arr['month_year'] = '2023-01'; 
            $arr['month'] = '01'; 
            $arr['year'] = '2023'; 
            $arr['created_by'] = $value->created_by; 
            $arr['updated_by'] = $value->updated_by; 
            $arr['created_at'] = $value->created_by; 
            $arr['updated_at'] = $value->created_by; 
			$i++;
            $this->db->insert('student_attendance_wise_subsidy',$arr);

        }



        if($i > 0){
        	echo 'Total Row = '. $i;
        }



        // echo '<pre>';

        // print_r($data);



    }



















	public function demoWork()

	{

		$this->load->view('Backend/partials/top');

		$this->load->view('Backend/partials/nav');

		$this->load->view('Backend/common/message');

		$this->load->view('Backend/partials/sidebar');

		$data['demos'] = $this->db->get('demo')->result();

		$this->load->view('Backend/demo/demoWork',$data);

		$this->load->view('Backend/partials/footer');

        $this->load->view('Backend/partials/bottom');

	}



	public function updateStatus($modelReference,$action,$id){



        try {

            $data = array(

            'status' => Helper::getStatus($action),

            'updated_by' => 1,

            );

            $this->db->where('demo_id', $id);

            $result = $this->db->update($modelReference, $data);

            if ($result) {

                $showMessage = array('success' => true, 'message' => ucwords($action) .' Successfull !');

                echo json_encode($showMessage) ;

            } else {

                $showMessage = array('error' => true, 'message' => 'Something Went Wrong !');

                echo json_encode($showMessage) ;

            }

        } catch (\Exception $e) {

            $showMessage = array('error' => true, 'message' => getMessage());

            echo json_encode($showMessage) ;

        }

	}

}

