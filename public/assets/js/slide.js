console.log('test');

window.onload = () => {

    let activer = document.querySelectorAll("[type=checkbox]");
    for(let bouton of activer){
        bouton.addEventListener('click', function () {
            let xmlhttp = new XMLHttpRequest();

            xmlhttp.open("get", `/admin/slider/activer/${this.dataset.id}`);
            xmlhttp.send();
        });
    }

    let supprimer = document.querySelectorAll('.modal-trigger');
    for(let bouton of supprimer){
        bouton.addEventListener('click', function () {
            document.querySelector('.modal-footer a').href = `/admin/slider/delete/${this.dataset.id}`
            document.querySelector('.modal-body').innerText = `Ëtes-vous sûr de vouloir supprimer cette image`
        })
    } 
};