<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddPostData extends Seeder
{
    public function run()
    {
        $this->db->table('posts')->insert( [
            'title'   => 'Post title #1',
            'content' => 'Post content #1',
        ]);
        
        $this->db->table('posts')->insert( [
            'title'   => 'Post title #2',
            'content' => 'Post content #2',
        ]);
    }
}
