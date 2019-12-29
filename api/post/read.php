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

    // query que traz conteudo do post
    $result = $post->read();
    // pega contagem de linhas
    $num = $result->rowCount();

    // verifica se existem posts
    if ($num > 0) {
        // array do conteudo do post
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            // funcao extract() trata chaves de arrays como variaveis, permitindo seu uso no array post_item, abaixo
            // $row['title]
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                // conteudos de posts contem HTML, entao eh preciso trata-lo abaixo
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            // insere em "data"
            array_push($posts_arr['data'], $post_item);
        }

        // transforma array do PHP em JSON e o retorna
        echo json_encode($posts_arr);
    } else {
        // se nao existirem posts
        echo json_encode(
            array('message' => 'No posts')
        );
    }
    
?>