<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // instancia DB e conexao
    $database = new Database();
    $db = $database->connect();

    // instancia objeto dos posts do blog
    $post = new POST($db);

    // pega conteudo do post
    $data = json_decode(file_get_contents("php://input"));

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    // cria o post
    if ($post->create()) {
        echo json_encode(
            array('message' => 'Post criado!')
        );
    } else {
        echo json_encode(
            array('message' => 'Post não criado')
        );
    }
?>