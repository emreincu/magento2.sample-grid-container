<?php
namespace Emakina\Blog\Api;
 
interface Post
{
    /**
     * Returns post by id
     *
     * @api
     * @param string $id
     * @return array
     */
    public function getById($id);


    /**
     * Returns all posts
     *
     * @api
     * @param null
     * @return array
     */
    public function getAll();

}