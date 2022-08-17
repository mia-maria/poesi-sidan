<?php

namespace App\Models;

use CodeIgniter\Model;

// Use PoemsModel in order to save poems.
class PoemsModel extends Model
{
    protected $table = 'poems';
    protected $allowedFields = ['title', 'author_id', 'body'];

    // Get all the poems. 
    public function getPoems()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT poems.id, poems.title, poems.body, poems.author_id, users.name FROM poems JOIN users ON poems.author_id = users.id');
        return $query->getResult();
    }

    // Get a specific poem. 
    public function getOnePoem($poem)
    {
        return $this->asArray()
                ->where(['id' => $poem])
                ->first();
    }

    // Get all the poems of a specific author.
    public function getMyPoems($poem)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM poems WHERE poems.author_id = ?";
        $query = $db->query($sql, [$poem]);
        return $query->getResult();
    }
}