const tbody = document.querySelector('tbody');
const btnSalvar = document.querySelector('#btnSalvar');

if (btnSalvar) {
    btnSalvar.addEventListener('click', (e) => {
        e.preventDefault();

        const nome = document.querySelector('#nome').value;
        const raca = document.querySelector('#raca').value;
        const idade = document.querySelector('#idade').value;
        const tutor = document.querySelector('#tutor').value;

        const formData = new FormData();
        formData.append('nome', nome);
        formData.append('raca', raca);
        formData.append('idade', idade);
        formData.append('tutor', tutor);

        fetch('crud.php?action=create', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pet inserido com sucesso!');
                window.location.href = 'index.html';
            } else {
                alert('Erro ao inserir pet.');
            }
        });
    });
}

function loadItens() {
    fetch('crud.php?action=read')
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = '';
            data.itens.forEach(item => {
                insertItem(item);
            });
        });
}

function insertItem(item) {
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td>${item.nome}</td>
        <td>${item.raca}</td>
        <td>${item.idade}</td>
        <td>${item.tutor}</td>
        <td class="acao"><i class="fas fa-edit" onclick="editItem(${item.id})"></i></td>
        <td class="acao"><i class="fas fa-trash" onclick="deleteItem(${item.id})"></i></td>
    `;
    tbody.appendChild(tr);
}

function deleteItem(id) {
    fetch(`crud.php?action=delete&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadItens();
            } else {
                alert('Erro ao deletar item.');
            }
        });
}

if (tbody) {
    loadItens();
}
