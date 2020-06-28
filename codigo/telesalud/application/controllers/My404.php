<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My404 extends CI_Controller {
	function index() {
		header("Location: " . base_url("Pedidos"));
	}
}
