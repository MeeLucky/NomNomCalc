<?php 
    header('Content-Type: application/json');

    if(isset($_COOKIE['user_id'])) {
        $id_users = $_COOKIE['user_id'];
        
        $stmt = $dbh->prepare("SELECT * FROM days WHERE id_users = :id_users");
        $stmt->execute([':id_users' => $id_users]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode($data);
    } else {
        echo json_encode(0);
    }
    exit;
?>