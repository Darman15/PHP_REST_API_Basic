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


// Grab ID

$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// call the read single to get post

$post->read_single();

// create an array for json data

$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

print_r(json_encode($post_arr));







?>