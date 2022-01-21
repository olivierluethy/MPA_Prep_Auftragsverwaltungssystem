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


        if (document.querySelector('#titel') != null) {
            if (document.querySelector('#titel').value.trim() === '') {
                document.querySelector('#titel').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib einen Titel ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#beschreibung') != null) {
            if (document.querySelector('#beschreibung').value.trim() === '') {
                document.querySelector('#beschreibung').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib eine Beschreibung ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#mitarbeiter') != null) {
            if (document.querySelector('#mitarbeiter').value.trim() === '') {
                document.querySelector('#mitarbeiter').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte wähle einen Mitarbeiter aus</label>");
                errors = true;
            }
        }

        if (document.querySelector('#erledigen_am') != null) {
            if (document.querySelector('#erledigen_am').value.trim() === '') {
                document.querySelector('#erledigen_am').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte wähle ein Datum aus</label>");
                errors = true;
            }
        }

        if (errors) {
            evt.preventDefault();
        }

    });
});