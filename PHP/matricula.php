<?php
require 'dbConnection.php';

try {
    $dbConnection = MongoDBConnection::getInstance();
    $studentCollection = $dbConnection->getCollection("student");
    $courseCollection = $dbConnection->getCollection("course");
    $enrollmentCollection = $dbConnection->getCollection("registrations");

    $fullName = isset($_POST['fullName']) ? $_POST['fullName'] : '';
    $courseName = isset($_POST['courseName']) ? $_POST['courseName'] : '';

    if (empty($fullName)) {
        throw new Exception("Nome do aluno é obrigatório.");
    }

    if (empty($courseName)) {
        throw new Exception("Nome do curso é obrigatório.");
    }

    $existingStudent = $studentCollection->findOne(['nomeCompleto' => $fullName]);

    if (!$existingStudent) {
        throw new Exception("Aluno não encontrado. Verifique o nome do aluno e tente novamente.");
    }

    $studentId = $existingStudent['_id'];

    $existingCourse = $courseCollection->findOne(['nome' => $courseName]);

    if (!$existingCourse) {
        throw new Exception("Curso não encontrado. Verifique o nome do curso e tente novamente.");
    }

    $courseId = $existingCourse['_id']; 

    $existingEnrollment = $enrollmentCollection->findOne([
        'alunoId' => $studentId,
        'cursoId' => $courseId
    ]);

    if ($existingEnrollment) {
        throw new Exception("O aluno já está matriculado neste curso.");
    }

    $enrollmentResult = $enrollmentCollection->insertOne([
        'alunoId' => $studentId,
        'cursoId' => $courseId
    ]);

    if ($enrollmentResult->getInsertedCount() > 0) {
        echo "<script>alert('Matrícula realizada com sucesso!'); window.location.href = '../matricularAluno.html';</script>";
    } else {
        throw new Exception("Erro ao realizar a matrícula. Tente novamente.");
    }

} catch (Exception $e) {
    echo "<script>alert('Erro: " . $e->getMessage() . "'); window.location.href = '../matricularAluno.html';</script>";
}
?>