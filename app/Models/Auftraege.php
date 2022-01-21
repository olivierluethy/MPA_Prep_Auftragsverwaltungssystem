<?php
class Auftraege
{
	public $db;

	public function __construct()
	{
		$this->db = connectDatabase();
	}

	public function createEmploy($name, $adresse, $email)
	{
		$isValid = true;
		$name = htmlspecialchars($_POST['name']);
		$adresse = htmlspecialchars($_POST['adresse']);
		$email = htmlspecialchars($_POST['email']);

		// if (preg_match("/[a-zA-Z0-9]/gm", $adresse) !== 0) {
        //     $isValid = false;
        // }

		if (strpos($email, "@") === false) {
            $isValid = false;
        }

		if($isValid){
			$statement = $this->db->prepare("INSERT INTO `mitarbeiter` (name, adresse, email) VALUES (:name, :adresse, :email)");
			$statement->bindParam(':name', $name, PDO::PARAM_STR);
			$statement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
			$statement->bindParam(':email', $email, PDO::PARAM_STR);
			$statement->execute();
		}
	}

	public function createOrder($titel, $beschreibung, $mitarbeiter, $erledigen_am, $file, $status){
		$isValid = true;
		$titel = htmlspecialchars($_POST['titel']);
		$beschreibung = htmlspecialchars($_POST['beschreibung']);
		$mitarbeiter = htmlspecialchars($_POST['mitarbeiter']);
		$erledigen_am = htmlspecialchars($_POST['erledigen_am']);

		// if (preg_match("/^[a-zA-Z\s]+$/gm", $mitarbeiter) !== 0) {
        //     $isValid = false;
        // }

		if($isValid){
			$statement = $this->db->prepare("INSERT INTO `auftraege` (titel, beschreibung, fk_mitarbeiterId, erledigen_am, status, document) 
			VALUES (:titel, :beschreibung, :fk_mitarbeiterId, :erledigen_am, :status, :document)");
			$statement->bindParam(':titel', $titel, PDO::PARAM_STR);
			$statement->bindParam(':beschreibung', $beschreibung, PDO::PARAM_STR);
			$statement->bindParam(':fk_mitarbeiterId', $mitarbeiter, PDO::PARAM_STR);
			$statement->bindParam(':erledigen_am', $erledigen_am, PDO::PARAM_STR);
			$statement->bindParam(':status', $status, PDO::PARAM_STR);
			$statement->bindParam(':document', $file, PDO::PARAM_STR);
			$statement->execute();
		}
	}

	public function deleteMitarbeiter($id){
		$statement = $this->db->prepare("DELETE FROM `mitarbeiter` WHERE id = :id");
		$statement->bindParam(':id', $id);
		$success = $statement->execute();

		if ($success == true){
			/* Dem Mitarbeiter wurde noch kein Auftrag zugeteilt */
			header('Location: http://localhost/Mini-PA-Prep/hallo/mitarbeiter');
		}else if($success == false){
			/* Dem Mitarbeiter wurde ein Auftrag zugeteilt */
			header('Location: http://localhost/Mini-PA-Prep/hallo/error');
		}
	}

	public function deleteAuftrag($id){
		$statement = $this->db->prepare("DELETE FROM `auftraege` WHERE id = :id");
		$statement->bindParam(':id', $id);
        $statement->execute();
	}

	public function updateMitarbeiter($name, $adresse, $email, $id){
		$isValid = true;
		$name = htmlspecialchars($_POST['name']);
		$adresse = htmlspecialchars($_POST['adresse']);
		$email = htmlspecialchars($_POST['email']);

		// if (preg_match("/[a-zA-Z0-9]/gm", $adresse) !== 0) {
        //     $isValid = false;
        // }

		if (strpos($email, "@") === false) {
            $isValid = false;
        }

		if ($isValid){
			$statement = $this->db->prepare("UPDATE `mitarbeiter` SET name = :name, adresse = :adresse, email = :email WHERE id = :id");
			$statement->bindParam(':name', $name);
			$statement->bindParam(':adresse', $adresse);
			$statement->bindParam(':email', $email);
			$statement->bindParam(':id', $id);
			$statement->execute();
		}
	}

	public function updateAuftraege($titel, $beschreibung, $mitarbeiter, $erledigen_am, $id){
		$isValid = true;
		$titel = htmlspecialchars($_POST['titel']);
		$beschreibung = htmlspecialchars($_POST['beschreibung']);
		$mitarbeiter = htmlspecialchars($_POST['mitarbeiter']);
		$erledigen_am = htmlspecialchars($_POST['erledigen_am']);

		if (preg_match("/^[a-zA-Z]+$/gm", $mitarbeiter) !== 0) {
            $isValid = false;
        }

		if ($isValid){
			$statement = $this->db->prepare('UPDATE `auftraege` SET titel = :titel, beschreibung = :beschreibung, fk_mitarbeiterId = :fk_mitarbeiterId, erledigen_am = :erledigen_am WHERE id = :id');
			$statement->bindParam(':titel', $titel);
			$statement->bindParam(':beschreibung', $beschreibung);
			$statement->bindParam(':fk_mitarbeiterId', $mitarbeiter);
			$statement->bindParam(':erledigen_am', $erledigen_am);
			$statement->bindParam(':id', $id);
			$statement->execute();
		}
	}

	public function changeStatus($id){
		$statement = $this->db->prepare('UPDATE `auftraege` SET status = 1 WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
	}
}