<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, 
Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';


// instantiate DB

$database = new Database();
$db = $database->connect();


// Instantiate new post

$post = new Post($db);


// Get the posted data

$data = json_decode(file_get_contents("php://input"));


$post->id = $data->id;

// Delete the post

if($post->delete()) {
    echo json_encode(
        array('message' => 'Post Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Deleted')
    );
}



?>