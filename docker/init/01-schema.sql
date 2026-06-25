-- ---------------------------------------------------------------------------
-- Database schema for the Mini-PA-Prep order management system.
-- This file runs automatically the first time the MySQL container starts.
--
-- Differences vs. the original MiniPAPrep.sql (and why):
--   * Tables are lowercase (mitarbeiter / auftraege) because the PHP code
--     queries them in lowercase and Linux MySQL is case-SENSITIVE about
--     table names. The original capitalised schema only worked on Windows.
--   * password / istAdmin got sensible DEFAULTs so "add employee" in the UI
--     (which does not send those fields) no longer fails.
--   * erledigen_am uses no CURRENT_TIMESTAMP default (illegal for a DATE
--     column under MySQL 8 strict mode).
--   * document is nullable so "add order" works even without an attachment.
-- ---------------------------------------------------------------------------

USE minipaprep;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS mitarbeiter (
    id       INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name     VARCHAR(50)  NOT NULL,
    adresse  VARCHAR(50)  NOT NULL,
    email    VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL DEFAULT '',
    istAdmin TINYINT(1)   NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS auftraege (
    id               INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titel            VARCHAR(50)  NOT NULL,
    beschreibung     VARCHAR(500) NOT NULL,
    fk_mitarbeiterId INT NOT NULL,
    erledigen_am     DATE DEFAULT NULL,
    status           TINYINT(1) NOT NULL DEFAULT 0,
    document         LONGBLOB,
    FOREIGN KEY (fk_mitarbeiterId) REFERENCES mitarbeiter(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- One-to-many file attachments per task. File bytes are stored as a BLOB
-- (no webroot exposure); deleting an Auftrag cascades to its attachments.
CREATE TABLE IF NOT EXISTS attachment (
    id           INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    auftrag_id   INT NOT NULL,
    filename     VARCHAR(255) NOT NULL,
    content_type VARCHAR(100) DEFAULT NULL,
    size         INT NOT NULL DEFAULT 0,
    content      LONGBLOB,
    uploaded_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (auftrag_id) REFERENCES auftraege(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
