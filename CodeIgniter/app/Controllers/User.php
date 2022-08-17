<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\PoemsModel;

class User extends BaseController {

  // Check if the page exists.
  public function view ($user = 'home') {
    if (!is_file(APPPATH.'/Views/user/'.$user.'.php')) {
        // The page does not exist!
        throw new \CodeIgniter\Exceptions\PageNotFoundException($user);
    }
    echo view('templates/header');
    echo view('user/'. $user);
    echo view('templates/footer');
  }

  // Show registration-form.
	public function registration() {
    echo view('templates/header');
    echo view('user/registration');
    echo view('templates/footer');
	}

  // Register new user.
  public function register() {
    $model = new UsersModel();
    // Set validation rules.
    $validation =  \Config\Services::validation();
    $validation->reset();
    $validation->setRules([
      'name' => [
          'label'  => 'name',
          'rules'  => 'trim|required|min_length[3]|max_length[100]|is_unique[users.name]',
          'errors' => [
              'min_length' => 'Namnet behöver vara minst tre tecken.',
              'max_length' => 'Namnet kan inte vara fler än 100 tecken.',
              'is_unique' => 'Tyvärr, namnet är redan taget. Försök gärna igen!'
            ]
          ],
      'email' => [
        'label'  => 'email',
        'rules'  => 'trim|required|valid_email|max_length[100]|is_unique[users.email]',
        'errors' => [
        'valid_email' => 'Du behöver ange en giltig e-postadress.',
        'max_length' => 'E-postadressen kan inte vara fler än 100 tecken.',
        'is_unique' => 'Tyvärr, du kan inte använda den här e-postadressen.'
          ]
        ],
      'password' => [
          'label'  => 'password',
          'rules'  => 'trim|required|min_length[8]|max_length[255]',
          'errors' => [
              'min_length' => 'Lösenordet behöver vara minst 8 tecken långt.',
              'max_length' => 'Lösenordet kan inte vara fler än 255 tecken.'
            ]
          ],
          'confirmPassword' => [
              'label'  => 'confirmPassword',
              'rules'  => 'trim|required|matches[password]',
              'errors' => [
                  'matches' => 'Tyvärr, lösenordet verifierades inte.'
              ]
            ]
    ]);
    // Validate and filter input from the user.
    if ($this->request->getMethod() === 'post')  {  
       $validation->withRequest($this->request)
           ->run();
        if ($validation->hasError('name') || $validation->hasError('email')|| $validation->hasError('password') || $validation->hasError('confirmPassword'))
            {
              echo view('templates/header');
              echo view('user/registration');
              echo view('templates/footer');
            } else {
              $name = $this->request->getPost('name', FILTER_SANITIZE_STRING);
              $email = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
              $password = $this->request->getPost('password', FILTER_SANITIZE_STRING);
                if($name && $password) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $model->save([
                    'name' => $name,
                    'email' => $email,
                    'password'  => $password,
                  ]);
                $session = session();
                $session->setFlashdata('message', 'Välkommen som medlem på Poesi-sidan!');
                $session->setFlashdata('alert-class', 'alert-success');
                return redirect()->route('user/login');
                }
          }
    } else {
        echo view('templates/header');
        echo view('user/registration');
        echo view('templates/footer');
    }
  }

  // Show login-form.
  public function login() {
    echo view('templates/header');
    echo view('user/login');
    echo view('templates/footer');
	}

  // Authenticate the user. 
  public function authenticate() {
    if ($this->request->getMethod() === 'post' && $this->validate([
            'email' => 'trim|required|valid_email|is_not_unique[users.email]',
            'password' => 'trim|required',
        ])) {  
          $model = new UsersModel();
          $email = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
          $password = $this->request->getPost('password', FILTER_SANITIZE_STRING);
          $user_data = $model->where('email', $email)->first();
          $verify_password = password_verify($password, $user_data['password']);

            if ($verify_password) {
                $session = session();
                $user_info = [
                'user'  => $user_data['id'],
                'name'  => $user_data['name'],
                'logged_in' => TRUE
                ];
    
                $session->set($user_info);
                $model = new PoemsModel();
                $session = session();
                $id = $session->get('user');
                $name = $session->get('name');
                $data = [
                  'poems'  => $model->getMyPoems($id),
                ];

                $session->setFlashdata('message', 'Välkommen ' . $name . '!');
                $session->setFlashdata('alert-class', 'alert-success');
                return redirect()->route('poems/myPoems', $data);
              } else {
                // Show a message that the log in failed, without detailed information about what went wrong.
                  $session = session();
                  $session->setFlashdata('message', 'Inloggningen misslyckades.');
                  $session->setFlashdata('alert-class', 'alert-danger');
                  return redirect()->route('user/login');
                }
            } else {
                 // Show a message that the log in failed, without detailed information about what went wrong.
                 $session = session();
                 $session->setFlashdata('message', 'Inloggningen misslyckades.');
                 $session->setFlashdata('alert-class', 'alert-danger');
                 return redirect()->route('user/login');
              }
    }

  // Show page with terms of use for members.
  public function info()
	{
    $session = session();
    $logged_in = $session->get('logged_in');

    if ($logged_in) {
      echo view('templates/header');
		  echo view('user/info');
      echo view('templates/footer');
    } else {
      echo view('templates/header');
      echo view('errors/html/error_404');
      echo view('templates/footer');
    }
	}

  // Show logout-page.
  public function logout() {
		echo view('templates/header');
    echo view('user/logout');
    echo view('templates/footer');
	}

  // Let a logged in user log out.
  public function logoutUser()
	{
    $session = session();
    $logged_in = $session->get('logged_in');

    if ($logged_in) {
      $session->destroy(); 
      return redirect()->route('user/logoutMessage');
    } else {
      echo view('templates/header');
		  echo view('pages/home');
      echo view('templates/footer');
    }
	}

  // Show logout-message.
  public function message()
	{
      echo view('templates/header');
		  echo view('user/logoutMessage');
      echo view('templates/footer');
	}

  // Show page where a logged in member can choose to terminate his/her membership.
  public function remove()
	{
    $session = session();
    $logged_in = $session->get('logged_in');

    if ($logged_in) {
      echo view('templates/header');
		  echo view('user/removeMember');
      echo view('templates/footer');
    } else {
      echo view('templates/header');
      echo view('errors/html/error_403');
      echo view('templates/footer');
    }
	}

  // Delete the poems and the information of the member.
  public function delete()
	{
    $session = session();
    $user_id = $session->get('user');
    $logged_in = $session->get('logged_in');
    if ($logged_in) {
      $poemsModel = new PoemsModel();
      $usersModel = new UsersModel();
      $data = $poemsModel->getMyPoems($user_id);
      foreach ($data as $row) {
        $poemsModel->delete($row->id);
        }
      $usersModel->delete($user_id);
      $session->destroy(); 
      return redirect()->route('user/goodbyeMessage');
    } else {
      echo view('templates/header');
      echo view('errors/html/error_403');
      echo view('templates/footer');
    }
	}

  // Show goodbye message to a user who has terminated his/her membership.
  public function goodbyeMessage()
	{
      echo view('templates/header');
		  echo view('user/goodbyeMessage');
      echo view('templates/footer');
	}

}