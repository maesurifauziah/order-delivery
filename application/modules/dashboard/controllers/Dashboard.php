<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Dashboard_model'));

        if (!$this->session->userdata('logged_in')) {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $this->load->view('dashboard_view');
    }    
}
