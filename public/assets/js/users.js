console.log("test");

window.onload = () => {

    let supprimer = document.querySelectorAll('.modal-trigger');
    for(let bouton of supprimer){
        bouton.addEventListener('click', function () {
            document.querySelector('.modal-footer a').href = `/admin/user/delete/${this.dataset.id}`
            document.querySelector('.modal-body').innerText = `Êtes-vous sûr de vouloir supprimer cet utilisateur`
        })
    }
};