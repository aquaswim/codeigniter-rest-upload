<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Upload
 * Class untuk upload file
 * @property CI_Upload upload
 * @property CI_Input input
 * @property CI_Output output
 */
class Upload extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		// load ci_upload here
		$this->load->library('upload');
	}

	public function index()
	{
		$this->send_json([
			'message'=> 'Hello world!'
		]);
	}

	/**
	 * All file upload (bellow 2mb)
	 */
	public function file()
	{
		try{
			// reinitialize here or do it in __construct
			$config['upload_path']          = './uploads/files/';
			$config['max_size']             = 2048;
			$config['allowed_types']        = '*';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors('',';'));
			}
			$this->send_json([
				'message'=> 'OK',
			]);
		}catch (Exception $e) {
			$this->send_json([
				'message'=>$e->getMessage()
			], 500);
		}
	}

	/**
	 * Only image allowed upload
	 */
	public function image()
	{
		try{
			// reinitialize here or do it in __construct
			$config['upload_path']          = './uploads/images/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 2048;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors('',';'));
			}
			$this->send_json([
				'message'=> 'OK',
			]);
		}catch (Exception $e) {
			$this->send_json([
				'message'=>$e->getMessage()
			], 500);
		}
	}

	/**
	 * Output as json
	 * @param $data
	 * @param int $code
	 */
	private function send_json($data, $code = 200)
	{
		$this
			->output
			->set_content_type('json')
			->set_status_header($code)
			->set_output(json_encode($data));
	}
}
