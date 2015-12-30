<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rest extends CI_Controller {

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
	public function index($table=NULL)
	{
		$type=$this->input->server('REQUEST_METHOD');
		$seg1 = $this->uri->segment(1, 0);
		$seg2 = $this->uri->segment(2, 0);
		$seg3 = $this->uri->segment(3, 0);
		$seg4 = $this->uri->segment(4, 0);
		$seg5 = $this->uri->segment(5, 0);

		echo $seg5.' '.$seg4.' '.$seg3.' '.$seg2.' '.$table;

		

		if($type=='GET')
		{
			if(!strcasecmp($seg5, 'edit'))
				$this->updateForm($table);
			else if(!strcasecmp($seg4, 'new'))
				$this->createForm($table);
			else if($seg4==0)
				$this->read($table);
			else
				$this->read($table,$seg4);

		}
		else if($type=='POST')

			$this->create($table);
		
		else if($type=='DELETE')
			
			$this->delete($table);
		
		else if($type=='PATCH'||$type=='PUT')

			$this->update($table);
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
		$data=$this->input->input_stream();
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