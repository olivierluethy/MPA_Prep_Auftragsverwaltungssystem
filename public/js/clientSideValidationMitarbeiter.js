// Clientside Validierung
window.addEventListener("load", function () {

    document.querySelector('form').addEventListener('submit', function (evt) {

        var errors = false;
        var warnings = document.querySelectorAll(".warning");
        if (warnings != null) {
            warnings.forEach(element => {
                element.remove();
            });
        }


        if (document.querySelector('#name') != null) {
            if (document.querySelector('#name').value.trim() === '') {
                document.querySelector('#name').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib einen Namen ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#email') != null) {
            if (document.querySelector('#email').value.trim() === '' || !document.querySelector('#email').value.trim().includes("@")) {
                document.querySelector('#email').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib eine gültige Email ein.</label>");
                errors = true;
            }
        }

        if (document.querySelector('#adresse') != null) {
            if (document.querySelector('#adresse').value.trim() === '' || (document.querySelector('#adresse').value.includes("/^[a-zA-Z0-9]+$/gm"))) {
                document.querySelector('#adresse').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib eine gültige Adresse ein.</label>");
                errors = true;
            }
        }

        if (errors) {
            evt.preventDefault();
        }

    });
});