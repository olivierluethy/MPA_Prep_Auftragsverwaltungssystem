<?php

class WelcomeController
{
    /* True when the request comes from our fetch() calls (modal create/edit/delete).
       In that case we answer with a bare status code instead of an HTML redirect,
       so the front-end can refresh the table in place without a page navigation. */
    private function isXhr(): bool
    {
        return strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';
    }

    /* All tasks, enriched with the employee name + id and status, newest due first. */
    private function allTasks(PDO $pdo): array
    {
        $sql = 'SELECT a.id, a.titel, a.beschreibung, a.fk_mitarbeiterId AS mitarbeiterId,
                       m.name, a.erledigen_am, a.status
                FROM auftraege a
                INNER JOIN mitarbeiter m ON m.id = a.fk_mitarbeiterId
                ORDER BY a.erledigen_am ASC';
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    private function allEmployees(PDO $pdo): array
    {
        return $pdo->query('SELECT id, name, adresse, email FROM mitarbeiter ORDER BY name ASC')
                   ->fetchAll(PDO::FETCH_ASSOC);
    }

	public function index()
	{
        $pdo = connectDatabase();
        $auftraege   = $this->allTasks($pdo);
        $mitarbeiter = $this->allEmployees($pdo);
		require 'app/Views/welcome.view.php';
	}

	public function auftraege()
    {
        $pdo = connectDatabase();
        $auftraege   = $this->allTasks($pdo);
        $mitarbeiter = $this->allEmployees($pdo);
		require 'app/Views/auftraege.view.php';
	}

	public function mitarbeiter()
    {
        $pdo = connectDatabase();
        $mitarbeiter = $this->allEmployees($pdo);
		require 'app/Views/mitarbeiter.view.php';
	}

	public function addEmploy()
    {
        $auftraege = new Auftraege();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auftraege->createEmploy($_POST['name'] ?? '', $_POST['adresse'] ?? '', $_POST['email'] ?? '');
            if ($this->isXhr()) { http_response_code(204); return; }
            header('Location: ../mitarbeiter');
            return;
        }

        /* GET = standalone fallback form (the normal flow uses the modal) */
        $pdo = connectDatabase();
        $mitarbeiter = $this->allEmployees($pdo);
		require 'app/Views/addEmploy.view.php';
	}

	public function addOrder()
    {
        $auftraege = new Auftraege();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auftraege->createOrder(
                $_POST['titel'] ?? '', $_POST['beschreibung'] ?? '', $_POST['mitarbeiter'] ?? '',
                $_POST['erledigen_am'] ?? '', $_POST['file'] ?? '', 0
            );
            if ($this->isXhr()) { http_response_code(204); return; }
            header('Location: ../auftraege');
            return;
        }

        $pdo = connectDatabase();
        $mitarbeiter = $this->allEmployees($pdo);
		require 'app/Views/addOrder.view.php';
	}

    public function deleteMit()
    {
        $auftraege = new Auftraege();
        $id = $_GET['id'] ?? 0;

        try {
            $auftraege->deleteMitarbeiter($id);
        } catch (PDOException $e) {
            /* Employee is still assigned to a task -> FK constraint */
            if ($this->isXhr()) {
                http_response_code(409);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Der Mitarbeiter kann nicht gelöscht werden, da er einer Aufgabe zugeteilt worden ist.']);
                return;
            }
            header('Location: ../error');
            return;
        }

        if ($this->isXhr()) { http_response_code(204); return; }
        header('Location: ../mitarbeiter');
    }

    public function deleteAuf()
    {
        $auftraege = new Auftraege();
        $auftraege->deleteAuftrag($_GET['id'] ?? 0);
        if ($this->isXhr()) { http_response_code(204); return; }
        header('Location: ../auftraege');
    }

    public function updateMit()
    {
        $auftraege = new Auftraege();
        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auftraege->updateMitarbeiter($_POST['name'] ?? '', $_POST['adresse'] ?? '', $_POST['email'] ?? '', $id);
            if ($this->isXhr()) { http_response_code(204); return; }
            header('Location: ../mitarbeiter');
            return;
        }

        $pdo = connectDatabase();
        $statement = $pdo->prepare('SELECT * FROM mitarbeiter WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $auftraege = $statement->fetchAll();
        require 'app/Views/editEmploy.view.php';
    }

    public function updateAuf()
    {
        $auftraege = new Auftraege();
        $id = $_GET['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auftraege->updateAuftraege($_POST['titel'] ?? '', $_POST['beschreibung'] ?? '', $_POST['mitarbeiter'] ?? '', $_POST['erledigen_am'] ?? '', $id);
            if ($this->isXhr()) { http_response_code(204); return; }
            header('Location: ../auftraege');
            return;
        }

        $pdo = connectDatabase();
        $statement = $pdo->prepare('SELECT * FROM auftraege WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $auftraege = $statement->fetchAll();

        $statement = $pdo->prepare('SELECT * FROM mitarbeiter');
        $statement->execute();
        $mitarbeiter = $statement->fetchAll();
        require 'app/Views/editOrder.view.php';
    }

    public function changeStatus()
    {
        $auftraege = new Auftraege();
        $auftraege->changeStatus($_GET['id'] ?? 0);
        if ($this->isXhr()) { http_response_code(204); return; }
        header('Location: ../auftraege');
    }

    public function login()    { require 'app/Views/login.php'; }
    public function logout()   { require 'app/Views/logout.php'; }
    public function config()   { require 'app/Views/config.php'; }
    public function register() { require 'app/Views/register.view.php'; }
    public function error()    { require 'app/Views/error.view.php'; }
}
