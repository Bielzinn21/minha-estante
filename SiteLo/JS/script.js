document.addEventListener('DOMContentLoaded', () => {
    let books = [
        { id: 1, title: "O Pequeno Príncipe", author: "Antoine de Saint-Exupéry", genre: "Fábula", cover: "https://m.media-amazon.com/images/I/71pE7jSsa2L._SL1500_.jpg", rating: 5, notes: "Clássico sobre a vida." },
        { id: 2, title: "O Hobbit", author: "J.R.R. Tolkien", genre: "Fantasia", cover: "https://m.media-amazon.com/images/I/91M9xPIf10L._SL1500_.jpg", rating: 4, notes: "Aventura incrível!" }
    ];

    const bookListContainer = document.getElementById('book-list-container');
    const searchInput = document.getElementById('searchInput');
    const noResultsDiv = document.getElementById('no-results');
    const bookForm = document.getElementById('bookForm');
    const modalInstance = new bootstrap.Modal(document.getElementById('bookModal'));

    const statsTotalLivros = document.getElementById('stats-total-livros');
    const statsMediaNotas = document.getElementById('stats-media-notas');

    let editingBookId = null;

    function renderStars(rating) {
        return Array.from({length:5}, (_,i) => i < rating ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star-fill empty"></i>').join(' ');
    }

    function renderBooks(list) {
        bookListContainer.innerHTML = '';
        noResultsDiv.style.display = list.length === 0 ? 'block' : 'none';

        list.forEach(book => {
            const card = document.createElement('div');
            card.className = 'col-lg-3 col-md-4 col-sm-6';
            card.innerHTML = `
                <div class="card h-100 book-card">
                    <img src="${book.cover || 'https://via.placeholder.com/350x500.png?text=Sem+Capa'}" class="card-img-top book-cover" alt="${book.title}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${book.title}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">${book.author}</h6>
                        <div class="star-rating">${renderStars(book.rating)}</div>
                        <p class="card-text"><span class="badge bg-genre">${book.genre}</span></p>
                        <button class="btn btn-outline-primary btn-sm mt-auto mb-2" onclick="showNotesModal(${book.id})"><i class="bi bi-journal-text"></i> Ver Anotações</button>
                        <button class="btn btn-outline-warning btn-sm mt-auto" onclick="editBook(${book.id})"><i class="bi bi-pencil-fill"></i> Editar</button>
                    </div>
                </div>`;
            bookListContainer.appendChild(card);
        });
    }

    function updateStats() {
        statsTotalLivros.textContent = books.length;
        const avg = books.length ? (books.reduce((a,b)=>a+b.rating,0)/books.length).toFixed(1) : 0.0;
        statsMediaNotas.innerHTML = `${avg} <i class="bi bi-star-fill text-warning"></i>`;
    }

    function filterBooks() {
        const term = searchInput.value.toLowerCase().trim();
        const filtered = term ? books.filter(b => b.title.toLowerCase().includes(term) || b.author.toLowerCase().includes(term) || b.genre.toLowerCase().includes(term)) : books;
        renderBooks(filtered);
    }

    function setupStarRatingInput() {
        const starGroup = document.querySelector('.star-input-group');
        const stars = starGroup.querySelectorAll('.star-input');
        const ratingInput = document.getElementById('bookRating');
        stars.forEach(star => star.addEventListener('click', () => {
            starGroup.dataset.rating = star.dataset.value;
            ratingInput.value = star.dataset.value;
        }));
    }

    window.showNotesModal = (bookId) => {
        const book = books.find(b=>b.id===bookId);
        if(!book) return;
        document.getElementById('notesModalTitle').textContent = `Anotações sobre: ${book.title}`;
        document.getElementById('notesModalBody').innerHTML = `<p>${book.notes || "<em>Nenhuma anotação registrada.</em>"}</p>`;
        new bootstrap.Modal(document.getElementById('notesModal')).show();
    }

    window.editBook = (bookId) => {
        const book = books.find(b=>b.id===bookId);
        if(!book) return;
        editingBookId = bookId;
        document.getElementById('bookModalLabel').textContent = 'Editar Livro';
        document.getElementById('bookTitle').value = book.title;
        document.getElementById('bookAuthor').value = book.author;
        document.getElementById('bookGenre').value = book.genre;
        document.getElementById('bookCover').value = book.cover;
        document.getElementById('bookRating').value = book.rating;
        document.querySelector('.star-input-group').dataset.rating = book.rating;
        document.getElementById('bookNotes').value = book.notes;
        modalInstance.show();
    }

    bookForm.addEventListener('submit', e => {
        e.preventDefault();
        const newBookData = {
            id: editingBookId || Date.now(),
            title: document.getElementById('bookTitle').value,
            author: document.getElementById('bookAuthor').value,
            genre: document.getElementById('bookGenre').value,
            cover: document.getElementById('bookCover').value,
            rating: parseInt(document.getElementById('bookRating').value,10),
            notes: document.getElementById('bookNotes').value
        };
        if(editingBookId){
            books = books.map(b => b.id === editingBookId ? newBookData : b);
            editingBookId = null;
        } else {
            books.unshift(newBookData);
        }
        renderBooks(books);
        updateStats();
        bookForm.reset();
        document.querySelector('.star-input-group').dataset.rating = 0;
        modalInstance.hide();
    });

    searchInput.addEventListener('keyup', filterBooks);
    setupStarRatingInput();
    renderBooks(books);
    updateStats();
});
