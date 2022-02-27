<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';


// instantiate DB

$database = new Database();
$db = $database->connect();


// Instantiate new post

$post = new Post($db);

// query
$result = $post->read();

// get row count

$num = $result->rowCount();

if($num > 0) {
    $posts_arr = array();
    $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array( 
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // Push to "data"

        array_push($posts_arr['data'], $post_item);
    }

    // convert to json

    echo json_encode($posts_arr);
} else {
    // If no post
    echo json_encode(
        array('message' => 'No Post found')
    );
}



?>