<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function create($table=NULL)
	{
		$this->load->model('crud_model');
		$data=$this->input->post();
		if(isset($data['submit']))
			unset($data['submit']);
		$this->crud_model->create($table,$data);
	}
	public function read($table=NULL)
	{
		$this->load->model('crud_model'); 
		$key= $this->uri->segment(4, 0);
		$result=$this->crud_model->read($table,$key);
		echo json_encode($result);

	}
	public function update($table=NULL)
	{
		$this->load->model('crud_model');
		$key= $this->uri->segment(4, 0);
		$data=$this->input->post();
		if(isset($data['submit']))
			unset($data['submit']);
		$this->crud_model->update($table,$key,$data);

	}
	public function delete($table=NULL)
	{	

		$this->load->model('crud_model');
		$key= $this->uri->segment(4, 0);
		$this->crud_model->delete($table,$key);

	}
	public function createForm($table=NULL)
	{
		$this->load->helper('form');
		$this->load->model('crud_model');
		$attributes=$this->crud_model->createForm($table);
		echo "<html><body>";
		echo form_open('welcome/create/'.$table, '');
		foreach ($attributes as $field) {
			echo $field;
			$data = array(
              'name'        => $field,
              'labelfor'         => $field,
              'value'       => '',
            );
            echo form_input($data);
            echo "<br>";
		}
		echo form_submit('submit', 'Submit Post!');
		echo form_close();
		echo "</body></html>";
	}
	public function updateForm($table=NULL)
	{
		$this->load->helper('form');
		$this->load->model('crud_model');
		$key= $this->uri->segment(4, 0);
		$attributes=$this->crud_model->updateForm($table,$key);
		$fields=$this->crud_model->createForm($table);
		echo "<html><body>";
		echo form_open('welcome/update/'.$table.'/'.$key , '');
		foreach ($fields as $field) {
			echo $field;
			$data = array(
              'name'        => $field,
              'labelfor'         => $field,
              'value'       => $attributes[$field],
            );
            echo form_input($data);
            echo "<br>";
		}
		echo form_submit('submit', 'Submit Post!');
		echo form_close();
		echo "</body></html>";
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */