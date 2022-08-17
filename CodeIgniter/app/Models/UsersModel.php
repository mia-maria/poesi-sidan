<?php

namespace App\Models;

use CodeIgniter\Model;

// Use UsersModel in order to save information about members.
class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name', 'email', 'password'];
}