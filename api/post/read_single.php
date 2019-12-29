<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // instancia DB e conexao
    $database = new Database();
    $db = $database->connect();

    // instancia objeto dos posts do blog
    $post = new POST($db);

    // pega ID da url
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // pega post
    $post->read_single();

    //cria array
    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    // transforma em JSON
    print_r(json_encode($post_arr));

?>