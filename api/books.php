<?php

require_once 'src/config.php';
require_once 'src/Book.php';


switch ($_SERVER['REQUEST_METHOD']) {
 
    case 'GET':
        if(isset($_GET['id'])) {
            $result = Book::loadFromDB($conn, $_GET['id']);
        } else {
            $result = Book::loadFromDB($conn);
        } 

        echo json_encode($result);
        break;
        
    case 'POST':
        if(strlen(trim($_POST['title'])) > 0 
            && strlen(trim($_POST['author'])) > 0) {
            $book = new Book();
            
            $result = $book->create($conn, $_POST['title'], $_POST['author'], 
                    $_POST['description']);
            echo json_encode($result);
        } else {
            echo json_encode(FALSE);
        }
        break;
        
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $del_vars);
        
        if(strlen(del_vars['id']) > 0) {
            $book = new Book();
            $result = $book->deleteFromDB($conn, $del_vars['id']);
        }
        
        echo json_encode($result);    
        break;
        
    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        
        $book = new Book();
        $result = $book->update($conn, $put_vars['id'], $put_vars['title'], $put_vars['author'], $put_vars['description']);
        
        echo json_encode($result);
        break;
    
    default :
        break;
}
