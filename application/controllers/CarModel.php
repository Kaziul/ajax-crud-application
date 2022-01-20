<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CarModel extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('Car_model');
		$rows = $this->Car_model->all();
		$data['rows'] = $rows;
		$this->load->view('car_model/list.php',$data);

	}
	public function showCreateForm()
	{
		$html = $this->load->view('car_model/create.php','',true);
		$response['html'] = $html;
		echo json_encode($response);

	}
	public function saveModel()
	{
		$this->load->model('Car_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('color', 'Color', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required');

		if($this->form_validation->run() == true){
			// save enteries to DB
			$formArray = array();
			$formArray['name'] = $this->input->post('name');
			$formArray['color'] = $this->input->post('color');
			$formArray['transmission'] = $this->input->post('transmission');
			$formArray['price'] = $this->input->post('price');
			$formArray['created_at'] = date('Y-m-d H:i:s');

			$this->Car_model->create($formArray);

			$response['status'] = 1;
			$response['message'] = "<div class=\"alert alert-success\">Record has been added successfully.</div>";


		}else{
			$response['status'] = 0;
			$response['name'] = strip_tags(form_error('name'));
			$response['color'] = strip_tags(form_error('color'));
			$response['price'] = strip_tags(form_error('price'));
			// return error messages
		}
		echo json_encode($response);

	}

	public function ajax_test(){
		$this->load->view('car_model/ajax_test');
	}
	public function ajax_form_val(){
		$this->load->view('car_model/ajax_from_val');
	}
	public function ajax_res(){
		echo 'Ajax Request';
	}



	function validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');
		if ($this->form_validation->run()) {
			$array = array(
				'success' => '<div class="alert alert-success">Thank you for Contact Us</div>'
			);
		} else {
			$array = array(
				'error'   => true,
				'name_error' => form_error('name'),
				'email_error' => form_error('email'),
				'subject_error' => form_error('subject'),
				'message_error' => form_error('message')
			);
		}

		echo json_encode($array);
	}

}
