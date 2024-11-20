<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Glauber Shoity Nakai">
    <meta name="author" content="Kamilla Barros Silva">
    <meta name="author" content="Wellington Henrique da Silva Lima">
    <link rel="stylesheet" type="text/css" href="CSS/index.css" media="screen" />

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
            <div class="container_welcome">
                <h1>Bem-vindo à <b class="uni">Uni</b><b class="academy">Academy</b>!</h1>
                <p>Sua jornada de aprendizado começa aqui. Na UniAcademy, oferecemos cursos inovadores e flexíveis, criados para atender às suas necessidades, seja para desenvolver novas habilidades ou se aprofundar em áreas específicas.</p>
            </div>
        </section>

        <article>
            <h2>Cursos Disponíveis</h2>
            <div class="courses">
                <?php
                require 'PHP/dbConnection.php';
                $dbConnection = MongoDBConnection::getInstance();
                $collection = $dbConnection->getCollection("course");

                $courses = $collection->find();

                foreach ($courses as $course) {
                    echo "<fieldset>";
                    echo "<h3>" . htmlspecialchars($course['nome']) . "</h3>";
                    echo "<p><strong>Preço:</strong> R$ " . number_format($course['preco'], 2, ',', '.') . "</p>";
                    echo "<p><strong>Horas:</strong> " . intval($course['horas']) . " horas</p>";
                    echo "<p><strong>Nível:</strong> " . htmlspecialchars($course['nivel']) . "</p>";
                    echo "<p><strong>Descrição:</strong> " . htmlspecialchars($course['descricao']) . "</p>";
                    echo "</fieldset>";
                }
                ?>
            </div>
        </article>
    </main>
</body>
</html>
