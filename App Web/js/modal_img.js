function clique(id, url_img, titulo, descricao)    {
    var modal = document.getElementById('modal');
    var modal_img = document.getElementById('imgModal');
    var modal_titulo = document.getElementById('imgTitulo');
    var modal_desc = document.getElementById('imgDesc');
    var modal_btn = document.getElementById('btnFechar');
                    
    modal.style.display = "block";
    modal_img.src = url_img;
    modal_img.alt = descricao;
    modal_titulo.innerHTML = titulo;
    modal_desc.innerHTML = descricao;
                    
    modal_btn.onclick = function()  {
        modal.style.display = "none";
    }
                    
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}
document.oncontextmenu = new Function("return false");