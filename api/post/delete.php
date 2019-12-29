<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // instancia DB e conexao
    $database = new Database();
    $db = $database->connect();

    // instancia objeto dos posts do blog
    $post = new POST($db);

    // pega conteudo do post
    $data = json_decode(file_get_contents("php://input"));

    // define ID para atualizar
    $post->id = $data->id;

    // apaga o post
    if ($post->delete()) {
        echo json_encode(
            array('message' => 'Post apagado!')
        );
    } else {
        echo json_encode(
            array('message' => 'Post não apagado')
        );
    }
?>