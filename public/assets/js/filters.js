window.onload = () => {
    const FiltersForm = document.querySelector("#filters");
    
    // on boucle sur les input
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            // ici on intercepte les clics
            // on récupère les données du formulaire
            const Form = new FormData(FiltersForm);

            // on fabrique la queryString
            const Params = new URLSearchParams();

            Form.forEach((value, key) => {
                Params.append(key, value);
            });

            // on récupère l'url active
            const Url = new URL(window.location.href);
            
            // on lance la requête ajax
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => 
                response.json()
            ).then(data => {
                // on va chercher la zone de contenu
                const content = document.querySelector("#content");

                // on remplace le contenu
                content.innerHTML = data.content;

                // on met à jour l'url
                history.pushState({}, null, Url.pathname + "?" + Params.toString());
            }).catch(e => alert(e));
        });
    });
}