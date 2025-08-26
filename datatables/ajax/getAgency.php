<?php
session_start();
require '../../config/db_config.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_role']) || $_SESSION['user_role']!=='admin'){
    echo json_encode(['success'=>false,'error'=>'Unauthorized']); exit;
}

$agencyId = $_GET['agency_id'] ?? null;
if(!$agencyId){ echo json_encode(['success'=>false,'error'=>'Missing agency_id']); exit; }

try{
    $pdo = connectDb();
    $stmt = $pdo->prepare("SELECT user_id, firstname, lastname, email, banned, attractions_enabled FROM users WHERE user_id=:id");
    $stmt->execute(['id'=>$agencyId]);
    $agency = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$agency){ echo json_encode(['success'=>false,'error'=>'Agency not found']); exit; }

    echo json_encode(['success'=>true, 'data'=>$agency]);
}catch(PDOException $e){
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
