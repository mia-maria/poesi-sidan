<?php

namespace App\Controllers;

use App\Models\PoemsModel;
use App\Models\UsersModel;

class Poems extends BaseController {
  // Get and show all published poems.
	public function index() {
    $model = new PoemsModel();
    $data = [
      'poems'  => $model->getPoems(),
    ];

		echo view('templates/header');
    echo view('poems/home', $data);
    echo view('templates/footer');
	}

  // Check if page does not exist.
  public function view ($poem = 'home') {

    if (!is_file(APPPATH.'/Views/poems/'.$poem.'.php')) {
        // The page does not exist!
        throw new \CodeIgniter\Exceptions\PageNotFoundException($poem);
      }
    echo view('templates/header');
    echo view('poems/'. $poem);
    echo view('templates/footer');
  }

  // Get and show the poems of a member that is logged in.
  public function myPoems() {
    $model = new PoemsModel();
    $session = session();
    $id = $session->get('user');
    $data = [
      'poems'  => $model->getMyPoems($id),
    ];
    $session = session();
    $logged_in = $session->get('logged_in');

    if ($logged_in) {
		  echo view('templates/header');
      echo view('poems/myPoems', $data);
      echo view('templates/footer');
      } else {
        echo view('templates/header');
        echo view('errors/html/error_404');
        echo view('templates/footer');
      }
	  }

  // Get and show all the poems of a specific author.
  public function showPoems($id = 0) {
    $usersModel = new UsersModel();
    $poemsModel = new PoemsModel();
    $data = [
      'name'  => $user_data = $usersModel->where('id', $id)->first(),
      'poems'  => $poemsModel->getMyPoems($id),
    ];

    // Check if the author exists.
    if ($data['name']) {
		  echo view('templates/header');
      echo view('poems/authorPoems', $data);
      echo view('templates/footer');
      } else {
        echo view('templates/header');
        echo view('errors/html/error_404');
        echo view('templates/footer');
      }
	  }
  
  // Show the page where a logged in member can create a new poem.
  public function new() {
		echo view('templates/header');
    echo view('poems/new');
    echo view('templates/footer');
	}

  // A member that is logged in can create and publish a poem. 
  public function create() {
    $model = new PoemsModel();
    $data = [
      'poems'  => $model->getPoems(),
    ];
    $session = session();
    $id = $session->get('user');
    $logged_in = $session->get('logged_in');

    // Set validation rules.
    if ($logged_in && $this->request->getMethod() === 'post')  { 
        $validation =  \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'title' => [
            'label'  => 'title',
            'rules'  => 'trim|required|max_length[200]',
            'errors' => [
                'max_length' => 'Titeln får vara max 200 tecken.',
                ]
            ],
            'body' => [
            'label'  => 'body',
            'rules'  => 'trim|required'
            ]
          ]
        ); 

        // Check if the input from the user is correctly formatted.
        $validation->withRequest($this->request)
            ->run();
         if ($validation->hasError('title') || $validation->hasError('body'))
             {
               echo view('templates/header');
               echo view('poems/new');
               echo view('templates/footer');
             } else {
               // Filter and save the poem if it is correctly formatted.
                $title = $this->request->getPost('title', FILTER_SANITIZE_STRING);
                $body = $this->request->getPost('body', FILTER_SANITIZE_STRING);
                    if($title && $body) {
                        $model->save([
                        'title'  => $title,
                        'author_id' => $id,
                        'body'  => $body,
                      ]);
                      $session = session();
                      $session->setFlashdata('message', 'Du har publicerat en dikt!');
                      $session->setFlashdata('alert-class', 'alert-success');
                      return redirect()->route('poems/myPoems', $data);
                      } else {
                        $session = session();
                        $session->setFlashdata('message', 'Dikten kunde inte sparas.');
                        $session->setFlashdata('alert-class', 'alert-danger');
                        return redirect()->route('poems/myPoems', $data);
                      }
              }
          } else {
              $session = session();
              $session->setFlashdata('message', 'För att kunna skriva en dikt behöver du vara registrerad och inloggad.');
              $session->setFlashdata('alert-class', 'alert-danger');
              return redirect()->route('user/registration');
          }
  }

  // Show a page where the author of a specific poem is able to edit the poem in question (when logged in).
  public function edit($id = 0) {
      $model = new PoemsModel();
      $data['poem'] = $model->getOnePoem($id);
      if ($data['poem']) {
        $author = $data['poem']['author_id'];
        $session = session();
        $user_id = $session->get('user');
        $logged_in = $session->get('logged_in');

        // Check if the user is authorized to edit the poem.
        if ($logged_in && $user_id === $author) {
          echo view('templates/header');
          echo view('poems/edit', $data);
          echo view('templates/footer');
        } else {
          echo view('templates/header');
          echo view('errors/html/error_403');
          echo view('templates/footer');
        }
      } else {
        echo view('templates/header');
        echo view('errors/html/error_404');
        echo view('templates/footer');
      }
	  }

  // Let the author of a specific poem update it, if logged in. Publish the updated version of the poem.
  public function update($id = 0) {
      $model = new PoemsModel();
      $data['poem'] = $model->getOnePoem($id);

      if ($data['poem']) {
        $author = $data['poem']['author_id'];
        $session = session();
        $user_id = $session->get('user');
        $logged_in = $session->get('logged_in');
        $info = [
          'poems'  => $model->getMyPoems($user_id),
        ];

        // Check if the user is authorized to update the poem. 
        // Set validation rules.
        if ($logged_in && $user_id === $author && $this->request->getMethod() === 'post') {  
          $validation =  \Config\Services::validation();
          $validation->reset();
          $validation->setRules([
            'title' => [
              'label'  => 'title',
              'rules'  => 'trim|required|max_length[200]',
              'errors' => [
                'max_length' => 'Titeln får vara max 200 tecken.',
                ]
              ],
              'body' => [
              'label'  => 'body',
              'rules'  => 'trim|required'
            ]
            ]
          );
          // Check if the edited poem is correctly formatted.
          $validation->withRequest($this->request)
              ->run();
          if ($validation->hasError('title') || $validation->hasError('body')) {
               echo view('templates/header');
               echo view('poems/edit', $data);
               echo view('templates/footer');
             } else {
                  // Filter and save the poem if it is correctly formatted.
                  $title = $this->request->getPost('title', FILTER_SANITIZE_STRING);
                  $body = $this->request->getPost('body', FILTER_SANITIZE_STRING);
                  if($title && $body) {
                      $model->update($id,[
                      'title'  => $title,
                      'body'  => $body,
                    ]);
                  $session = session();
                  $session->setFlashdata('message', 'Du har redigerat din dikt!');
                  $session->setFlashdata('alert-class', 'alert-success');
                  return redirect()->route('poems/myPoems', $info);
              } else {
                $session = session();
                $session->setFlashdata('message', 'Redigeringen lyckades inte.');
                $session->setFlashdata('alert-class', 'alert-danger');
                return redirect()->route('poems/myPoems', $info);
              }
          } 
        } else {
            echo view('templates/header');
            echo view('errors/html/error_403');
            echo view('templates/footer');
          }
      } else {
          echo view('templates/header');
          echo view('errors/html/error_404');
          echo view('templates/footer');
        }
  }

  // Show a page where the author of a poem can remove it (if logged in).
  public function remove($id = 0) {
		$model = new PoemsModel();
    $data['poem'] = $model->getOnePoem($id);
    if ($data['poem']) {
      $author = $data['poem']['author_id'];
      $session = session();
      $user_id = $session->get('user');
      $logged_in = $session->get('logged_in');

      // Check if the user is authorized to remove the poem. 
      if ($logged_in && $user_id === $author) {
        echo view('templates/header');
        echo view('poems/remove', $data);
        echo view('templates/footer');
      } else {
        echo view('templates/header');
        echo view('errors/html/error_403');
        echo view('templates/footer');
      }
    } else {
      echo view('templates/header');
      echo view('errors/html/error_404');
      echo view('templates/footer');
    }
	}

  // Let the author of a poem be able to delete it.
  public function delete($id = 0) {
    $model = new PoemsModel();
    $data['poem'] = $model->getOnePoem($id);
    if ($data['poem']) {
      $author = $data['poem']['author_id'];
      $session = session();
      $user_id = $session->get('user');
      $logged_in = $session->get('logged_in');
      $info = [
        'poems'  => $model->getMyPoems($user_id),
      ];
      // Check if the user is authorized to delete the poem.
      if ($logged_in && $user_id === $author) {
        $model->delete($id);
        $session = session();
        $session->setFlashdata('message', 'Du har raderat din dikt.');
        $session->setFlashdata('alert-class', 'alert-success');
        return redirect()->route('poems/myPoems', $info);
    } else {
      echo view('templates/header');
      echo view('errors/html/error_403');
      echo view('templates/footer');
      } 
  } else {
    echo view('templates/header');
    echo view('errors/html/error_404');
    echo view('templates/footer');
    }
  }
}