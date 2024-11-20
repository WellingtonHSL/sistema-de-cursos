<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Glauber Shoity Nakai">
    <meta name="author" content="Kamilla Barros Silva">
    <meta name="author" content="Wellington Henrique da Silva Lima">
    <link rel="stylesheet" type="text/css" href="CSS/visualizarMatricula.css" media="screen" />

    <title>UniAcademy</title>
</head>
<body>
    <header>
        <nav class="nav_header">
            <h1><a href="index.php" class="nav_title">Uni<b>Academy</b></a></h1>
        </nav>
        <nav class="nav_subheader">
            <ul class="nav_subheader_a">
                <li><a href="cadastrarCurso.html">Cadastrar Curso</a></li>
                <li><a href="cadastrarAluno.html">Cadastrar Aluno</a></li>
                <li><a href="matricularAluno.html">Matricular Aluno</a></li>
                <li><a href="visualizarMatriculas.php">Visualizar Matriculas</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Cursos e Matrículas</h2>

            <?php
                require 'PHP/dbConnection.php';

                try {
                    $dbConnection = MongoDBConnection::getInstance();
                    $courseCollection = $dbConnection->getCollection("course");
                    $enrollmentCollection = $dbConnection->getCollection("registrations");
                    $studentCollection = $dbConnection->getCollection("student");

                    $courses = $courseCollection->find();

                    foreach ($courses as $course) {
                        echo "<fieldset>";
                        echo "<h3>" . htmlspecialchars($course['nome']) . "</h3>";
                        echo "<h4> Alunos Matriculados:</h4>";

                        $registrations = $enrollmentCollection->find(['cursoId' => $course['_id']]);
                        $registrationsArray = iterator_to_array($registrations);

                        $registrationsCount = count($registrationsArray);

                        if ($registrationsCount == 0) {
                            echo "<p>Nenhum aluno matriculado.</p>";
                            echo "</fieldset>";
                        } else {
                            echo "<ul>";

                            foreach ($registrationsArray as $registration) {
                                $studentId = $registration['alunoId'];
                                $student = $studentCollection->findOne(['_id' => $studentId]);

                                if ($student) {
                                    echo "<p>" . $student['nomeCompleto'] . "</p>";
                                }
                            }
                            echo "</ul>";
                            echo "</fieldset>";
                        }
                    }
                } catch (Exception $e) {
                    echo "<p>Erro ao exibir as matrículas: " . $e->getMessage() . "</p>";
                }
            ?>
        </section>
    </main>
</body>
</html>