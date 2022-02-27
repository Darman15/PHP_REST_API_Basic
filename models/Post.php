<?php

class Post {
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;

    public $title;
    public $body;
    public $author;
    public $created_at;


    // constructor 

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get post

    public function read() {
        // create query
        $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
          FROM 
          ' .$this->table . '  p
          LEFT JOIN
          categories c ON p.category_id = c.id
          ORDER BY
          p.created_at DESC';

        //  prepare statment

        $stmt = $this->conn->prepare($query);

        // Execute 

        $stmt->execute();

        return $stmt;
    }

    // for a single post

    public function read_single() {
        // create query
        $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
          FROM 
          ' . $this->table . '  p
          LEFT JOIN
          categories c ON p.category_id = c.id
        WHERE 
          p.id = ?
        LIMIT 0,1';

        // prepare
        $stmt = $this->conn->prepare($query);

        // Bind ID

        $stmt->bindParam(1, $this->id);

        // Execute 
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set the return properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    // to create a post

    public function create() {
        $query = 'INSERT INTO ' .
         $this->table . '
        SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id';

        // statment

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        

        // connect data

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
       

        if($stmt->execute()) {
            return true;
        }

        // Print error is something happens
        printf("Error: %s.\n", $stmt->error);

        return false;
    }


    // this will be used to update post
    public function update() {
        $query = 'UPDATE ' .
         $this->table . '
        SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id
        WHERE
        id = :id';

        // statment

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        

        

        // connect data

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
       

        if($stmt->execute()) {
            return true;
        }

        // Print error is something happens
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // delete post 

    public function delete() {
        $query = 'Delete From ' . $this->table . ' WHERE id = :id';

        // prepare
        $stmt = $this->conn->prepare($query);

        // Clean
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }

        // Print error is something happens
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}

?>