<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Estante de Livros</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/Header/style.css">
</head>
<body>

<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold" href="#">🌸 Minha Estante</a>
        <button id="addBookBtn" class="btn btn-primary btn-lg d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#bookModal">
            <i class="bi bi-plus-lg me-2"></i> Adicionar Livro
        </button>
    </div>
</nav>

<header class="page-header">
    <div class="container text-center">
        <h1 class="display-4">Meus Livros Lidos</h1>
        <p class="lead text-muted">Um cantinho para organizar e relembrar leituras.</p>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center g-3">
            <div class="col-md-4 col-lg-3">
                <div class="card stats-card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted mb-0">Livros Lidos</h5>
                        <p class="display-5 fw-bold" id="stats-total-livros">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card stats-card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted mb-0">Média de Notas</h5>
                        <p class="display-5 fw-bold" id="stats-media-notas">0.0 <i class="bi bi-star-fill text-warning"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="input-group input-group-lg shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-primary-soft"></i>
                </span>
                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Buscar por título, autor ou gênero...">
            </div>
        </div>
    </div>
</section>

<main class="container pb-5">
    <div class="row g-4" id="book-list-container"></div>
    <div id="no-results" class="text-center text-muted fs-4" style="display: none;">
        <p>Nenhum livro encontrado com esse termo. 🍃</p>
    </div>
</main>

<footer class="text-center text-muted py-4 mt-auto">
    <p>&copy; 2025 Minha Estante. Feito com <i class="bi bi-heart-fill text-danger"></i> e Bootstrap.</p>
</footer>

<!-- Modal Único para Adicionar/Editar Livro -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="bookForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Adicionar Novo Livro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editingBookId">
                    <div class="mb-3">
                        <label for="bookTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="bookTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookAuthor" class="form-label">Autor(a)</label>
                        <input type="text" class="form-control" id="bookAuthor" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookGenre" class="form-label">Gênero</label>
                        <input type="text" class="form-control" id="bookGenre" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookCover" class="form-label">URL da Imagem da Capa</label>
                        <input type="url" class="form-control" id="bookCover" placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sua Nota</label>
                        <div class="star-input-group" data-rating="0">
                            <i class="bi bi-star-fill star-input" data-value="1"></i>
                            <i class="bi bi-star-fill star-input" data-value="2"></i>
                            <i class="bi bi-star-fill star-input" data-value="3"></i>
                            <i class="bi bi-star-fill star-input" data-value="4"></i>
                            <i class="bi bi-star-fill star-input" data-value="5"></i>
                        </div>
                        <input type="hidden" id="bookRating" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="bookNotes" class="form-label">Minhas Anotações</label>
                        <textarea class="form-control" id="bookNotes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="saveBookBtn">Salvar Livro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Notas -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notesModalTitle">Anotações sobre...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" id="notesModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="JS/script.js"></script>
</body>
</html>
