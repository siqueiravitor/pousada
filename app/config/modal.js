function modal(children, title, area) {
    let modalDiv = document.createElement('div');
        modalDiv.id = 'abrirModal'
        modalDiv.className = 'modal';

    let div = document.createElement('div');
        div.id = 'modalArea';

    let closeBtn = document.createElement('a');
        closeBtn.href = "./controle.php";
        closeBtn.innerHTML = 'x';
        closeBtn.className = 'fechar';
        closeBtn.title = 'Fechar';

    let titulo = document.createElement('h3');
        titulo.innerHTML = title;

    modalDiv.appendChild(div);
    div.appendChild(closeBtn);
    div.innerHTML += children;
    
    area.appendChild(modalDiv);
}
