<?php
    class Post {
        // DB params
        private $conn;
        private $table = 'posts';

        // propriedades dos posts
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // constructor com DB
        public function __construct($db){
            $this->conn = $db;
        }

        // metodo de pegar posts
        public function read(){
            // cria query
            $query = 'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM 
                ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC';
            
            // prepared statement para PDO
            $stmt = $this->conn->prepare($query);
            // execute a query, de acordo com a especificacao PDO -> https://www.php.net/manual/pt_BR/pdo.prepare.php
            $stmt->execute();

            return $stmt;
        }

        // pega post unico
        public function read_single(){
            // cria query
            $query = 'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM 
                ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT 0,1';

            // prepared statement para PDO
            $stmt = $this->conn->prepare($query);
            // vincula id
            $stmt->bindParam(1, $this->id);

            // execute a query, de acordo com a especificacao PDO -> https://www.php.net/manual/pt_BR/pdo.prepare.php
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // define propriedades
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
        }

        // cria post
        public function create(){
            // cria query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id';
            
            // prepared statement
            $stmt = $this->conn->prepare($query);

            // limpa e prepara dados na query
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // vincula parametros
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            // executa query
            if ($stmt->execute()) {
                return true;
            }

            // exibe erro se algo errado ocorrer
            printf("ERROR: %s.\n", $stmt->error);

            return false;
        }
    }
?>