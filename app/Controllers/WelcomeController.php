<?php

class WelcomeController
{
	public function index()
	{
		/* Für Aufträge */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT auftraege.id, auftraege.titel, auftraege.beschreibung, mitarbeiter.name, auftraege.erledigen_am FROM auftraege
INNER JOIN mitarbeiter ON mitarbeiter.id = auftraege.fk_mitarbeiterId');
        $statement->execute();
        $auftraege = $statement->fetchAll();

		/* Für Mitarbeiter */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT * FROM mitarbeiter');
        $statement->execute();
        $mitarbeiter = $statement->fetchAll();

		require 'app/Views/welcome.view.php';
	}

	public function auftraege(){
        /* Alle Aufträge */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT auftraege.id, auftraege.titel, auftraege.beschreibung, mitarbeiter.name, auftraege.erledigen_am, auftraege.status, auftraege.document FROM auftraege
INNER JOIN mitarbeiter ON mitarbeiter.id = auftraege.fk_mitarbeiterId');
        $statement->execute();
        $auftraege = $statement->fetchAll();

		/* Für offene Aufträge */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT auftraege.id, auftraege.titel, auftraege.beschreibung, mitarbeiter.name, auftraege.erledigen_am, auftraege.status, auftraege.document FROM auftraege
INNER JOIN mitarbeiter ON mitarbeiter.id = auftraege.fk_mitarbeiterId WHERE status = 0');
        $statement->execute();
        $auftraege1 = $statement->fetchAll();

        /* Für erledigte Aufträge */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT auftraege.id, auftraege.titel, auftraege.beschreibung, mitarbeiter.name, auftraege.erledigen_am, auftraege.status, auftraege.document FROM auftraege
INNER JOIN mitarbeiter ON mitarbeiter.id = auftraege.fk_mitarbeiterId WHERE status = 1');
        $statement->execute();
        $auftraege2 = $statement->fetchAll();

		require 'app/Views/auftraege.view.php';
	}

	public function mitarbeiter(){
		/* Mitarbeiter anzeigen */
		$pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT * FROM mitarbeiter');
        $statement->execute();
        $mitarbeiter = $statement->fetchAll();

		require 'app/Views/mitarbeiter.view.php';
	}

	public function addEmploy(){
        $auftraege = new Auftraege();
		require 'app/Views/addEmploy.view.php';

		$title = '';
        $pdo = connectDatabase();

        /* Mitarbeiter hinzufügen */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $adresse = $_POST['adresse'];
			$email = $_POST['email'];

            $auftraege->createEmploy($name, $adresse, $email);

            header('Location: http://localhost/Mini-PA-Prep/hallo/mitarbeiter'); // Besser: header('Location: http://localhost/deinProjekt/task);
        }
	}

	public function addOrder(){
        $auftraege = new Auftraege();

        /* Mitarbeiter anzeigen */
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare('SELECT id, name FROM mitarbeiter');
        $statement->execute();
        $mitarbeiter = $statement->fetchAll();

		require 'app/Views/addOrder.view.php';

		$title = '';
        $pdo = connectDatabase();

        /* Auftrag hinzufügen */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titel = $_POST['titel'];
            $beschreibung = $_POST['beschreibung'];
			$mitarbeiter = $_POST['mitarbeiter'];
			$erledigen_am = $_POST['erledigen_am'];
            $file = $_POST['file'];
            $status = 0;

            $auftraege->createOrder($titel, $beschreibung, $mitarbeiter, $erledigen_am, $file, $status);

            header('Location: http://localhost/Mini-PA-Prep/hallo/auftraege'); // Besser: header('Location: http://localhost/deinProjekt/task);
        }
	}

    public function deleteMit(){
        $auftraege = new Auftraege();
        
        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $auftraege->deleteMitarbeiter($id);
    }

    public function deleteAuf(){
        $auftraege = new Auftraege();

        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $auftraege->deleteAuftrag($id);
        
        header('Location: http://localhost/Mini-PA-Prep/hallo/auftraege');

        require 'app/Views/auftraege.view.php';
    }

    public function updateMit(){
        $auftraege = new Auftraege();

        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $adresse = $_POST['adresse'];
            $email = $_POST['email'];

            $auftraege->updateMitarbeiter($name, $adresse, $email, $id);
            
            header('Location: http://localhost/Mini-PA-Prep/hallo/mitarbeiter');
        }else{
            $statement = $pdo->prepare('SELECT * FROM mitarbeiter WHERE id = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            $auftraege = $statement->fetchAll();
        }
        require 'app/Views/editEmploy.view.php';
    }

    public function updateAuf(){
        $auftraege = new Auftraege();

        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titel = $_POST['titel'];
            $beschreibung = $_POST['beschreibung'];
            $mitarbeiter = $_POST['mitarbeiter'];
            $erledigen_am = $_POST['erledigen_am'];

            $auftraege->updateAuftraege($titel, $beschreibung, $mitarbeiter, $erledigen_am, $id);

            header('Location: http://localhost/Mini-PA-Prep/hallo/auftraege');
        }else{
            $statement = $pdo->prepare('SELECT * FROM auftraege WHERE id = :id');
            $statement->bindParam(':id', $id);
            $statement->execute();
            $auftraege = $statement->fetchAll();

            /* Mitarbeiter anzeigen */
            $pdo = connectDatabase();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $pdo->prepare('SELECT * FROM mitarbeiter');
            $statement->execute();
            $mitarbeiter = $statement->fetchAll();
        }
        require 'app/Views/editOrder.view.php';
    }

    public function changeStatus(){
        $auftraege = new Auftraege();

        $id = $_GET['id'];

        $title = '';
        $pdo = connectDatabase();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $auftraege->changeStatus($id);

        header('Location: http://localhost/Mini-PA-Prep/hallo/auftraege');
    }

    public function login(){
        require 'app/Views/login.php';
    }

    public function logout(){
        require 'app/Views/logout.php';
    }

    public function config(){
        require 'app/Views/config.php';
    }

    public function register(){
        require 'app/Views/register.view.php';
    }

    public function error(){
        require 'app/Views/error.view.php';
    }
}