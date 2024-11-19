<?php
require 'dbConnection.php';

$dbConnection = MongoDBConnection::getInstance();
$collection = $dbConnection->getCollection("course");

$courseName = $_POST['courseName'];
$price = $_POST['price'];
$courseHours = $_POST['courseHours'];
$nivel = $_POST['nivel'];
$description = $_POST['description'];

$existingCourse = $collection->findOne(['nome' => $courseName]);

if ($existingCourse) {
    echo "<script>alert('Curso já cadastrado!'); window.location.href = '../cadastrarCurso.html';</script>";
} else {
    $result = $collection->insertOne([
        'nome' => $courseName,
        'preco' => $price,
        'horas' => $courseHours,
        'nivel' => $nivel,
        'descricao' => $description
    ]);
    
    if ($result->getInsertedCount() > 0) {
        echo "<script>alert('Curso cadastrado com sucesso!'); window.location.href = '../cadastrarCurso.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar o curso. Tente novamente.'); window.location.href = '../cadastrarCurso.html';</script>";
    }
}
?>