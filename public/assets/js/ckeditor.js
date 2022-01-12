// on initialise ckeditor

BalloonEditor
    .create(document.querySelector("#editor"))
    .then(editor => {
        document.querySelector("#article form").addEventListener
        ("submit", function(e){
            e.preventDefault();
            this.querySelector("#editor + input").value = editor.getData();
        })
    });