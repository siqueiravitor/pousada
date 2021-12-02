function msg(mensagem, action) {
    let msgArea = document.getElementById('msgArea');
    let div = document.createElement('div');

    if (action === 0) {
        div.className = "msgSuccess";
        window.navigator.vibrate(100);
    } else {
        div.className = "msgErro";
        window.navigator.vibrate(100);
        setTimeout(() => {
            window.navigator.vibrate(100);
        }, 200);
    }
    
    div.onclick = () => hidemsg(div);

    var span = document.createElement('span');
    var msgText = document.createTextNode(mensagem);

    span.appendChild(msgText);
    div.appendChild(span);
    msgArea.appendChild(div);

    setTimeout(() => {
        div.className = 'hide';
    }, 5000);
    setTimeout(() => {
        div.remove();
    }, 5750);
}

function hidemsg(div) {
    console.log(div)
    div.className = 'hide';
    setTimeout(() => {
        div.remove();
    }, 350);
}
