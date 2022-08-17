<?php

namespace App\Controllers;

class Pages extends BaseController
{
  // Show start-page.
	public function index()
	{
		echo view('templates/header');
    echo view('pages/home');
    echo view('templates/footer');
	}

  public function view ($page = 'home') {

    if (!is_file(APPPATH.'/Views/pages/'.$page.'.php')) {
        // The page does not exist!
        throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
    }

    echo view('templates/header');
    echo view('pages/'. $page);
    echo view('templates/footer');
  }
}