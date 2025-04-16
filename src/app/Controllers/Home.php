<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Post;

class Home extends BaseController
{
    const ROW_PER_PAGE = 3;
    
    public function posts(): string
    {
        $posts = model(Post::class);
        
        return view('posts', [
            'posts' => $posts->paginate(self::ROW_PER_PAGE),
            'pager' => $posts->pager,
        ]);
    }
    
    public function post(int $id): string
    {
        $post = model(Post::class)->find($id);
        
        if (!$post) {
            return view('errors/html/error_404', ['message' => 'Post not found']);
        }
        
        $sort = $this->request->getVar('sort');
        $order = $this->request->getVar('order');
        
        // todo В идеале нужна корректная валидация
        // in_list[id,date]
        // in_list[asc,desc]
        
        $sorting = [];
        
        $comments = model(Comment::class)
            ->where('post_id', $id);
        
        if ($sort && in_array(strtolower($sort), ['id', 'date'])) {
            $sort = strtolower($sort);
            $sorting[] = 'sort='.$sort;
        } else {
            $sort = 'date';
        }
        
        if ($order && in_array(strtolower($order), ['asc', 'desc'])) {
            $order = strtolower($order);
            $sorting[] = 'order=' . $order;
        } else {
            $order = 'desc';
        }
        
        $comments->orderBy($sort, $order);
        
        return view('post', [
            'post'     => $post,
            'comments' => $comments->paginate(self::ROW_PER_PAGE),
            'pager'    => $comments->pager,
            'sorting'  => !empty($sorting) ? '&' . join('&', $sorting) : '',
            'sort'     => $sort,
            'order'    => $order,
        ]);
    }
    
    public function add()
    {
        $data = [
            'name'    => $this->request->getPost('name'),
            'text'    => $this->request->getPost('text'),
            'date'    => $this->request->getPost('date'),
            'post_id' => $this->request->getPost('post_id'),
        ];
        
        $rule = [
            'name'    => 'required|max_length[200]|valid_email',
            'text'    => 'required|max_length[500]',
            'date'    => 'required|max_length[10]|valid_date',
            'post_id' => 'required|integer',
        ];
        
        if (!$this->validateData($data, $rule)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => join('<br>', $this->validator->getErrors()),
                ]);
            }
            
            return view('errors/html/error_validation', [
                'errors' => $this->validator->getErrors(),
            ]);
        }
        
        $post = model(Post::class)->find($data['post_id']);
        
        if (!$post) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Post not found']);
            }
            
            return view('errors/html/error_404', ['message' => 'Post not found']);
        }
        
        $comment = new Comment();
        $comment->save($data);
        $data['id'] = $comment->db->insertID();
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success'       => true,
                'message'       => 'Comment added',
                'comment'       => $data,
                'url_to_remove' => url_to('remove_comment', $data['id']),
                'hash'          => csrf_hash(),
            ]);
        }
        
        return redirect()->to(url_to('post', $post['id']));
    }
    
    public function remove(int $id)
    {
        $comment = model(Comment::class)->find($id);
        
        if (!$comment) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Comment not found']);
            }
            
            return view('errors/html/error_404', ['message' => 'Comment not found']);
        }
        
        model(Comment::class)->delete($id);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Comment removed',
                'id'      => $id,
            ]);
        }
        
        return redirect()->to(url_to('post', $comment['post_id']));
    }
}
