<?php
require 'dbConnection.php';

$dbConnection = MongoDBConnection::getInstance();
$collection = $dbConnection->getCollection("student");

$fullName = $_POST['fullName'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$fatherName = $_POST['fatherName'];
$motherName = $_POST['motherName'];
$city = $_POST['city'];
$state = $_POST['state'];
$road = $_POST['road'];
$number = $_POST['number'];
$complement = $_POST['complement'];


$existingStudent = $collection->findOne(['cpf' => $cpf]);

if ($existingStudent) {
    echo "<script>alert('Aluno já cadastrado!'); window.location.href = '../cadastrarAluno.html';</script>";
} else {
    $result = $collection->insertOne([
        'nomeCompleto' => $fullName,
        'cpf' => $cpf,
        'rg' => $rg,
        'nomePai' => $fatherName,
        'nomeMae' => $motherName,
        'endereco' => [
            'cidade' => $city,
            'estado' => $state,
            'rua' => $road,
            'numero' => $number,
            'complemento' => $complement
        ]
    ]);

    if ($result->getInsertedCount() > 0) {
        echo "<script>alert('Aluno cadastrado com sucesso!'); window.location.href = '../cadastrarAluno.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar o aluno. Tente novamente.'); window.location.href = '../cadastrarAluno.html';</script>";
    }
}
?>
