-- Auto-generated mock data. Loaded automatically on first DB start.
-- Login: admin@minipa.test / admin   (admin, sees edit/delete buttons)
--        any other *@minipa.test / password   (normal user)
USE minipaprep;
SET NAMES utf8mb4;

INSERT INTO mitarbeiter (name, adresse, email, password, istAdmin) VALUES
('Olivier Lüthy', 'Hauptstrasse 12, 3000 Bern', 'admin@minipa.test', '$2y$10$EXURYqj7jqd9Z0e.wGW91.pLBzuVYLFsjTe6Zq6ZtlR6qMBUAfW2q', 1),
('Sarah Meier', 'Bahnhofweg 4, 8001 Zürich', 'sarah.meier@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 1),
('Anna Keller', 'Lindenweg 7, 4051 Basel', 'anna.keller@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Marco Rossi', 'Via Nassa 22, 6900 Lugano', 'marco.rossi@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Julia Schmid', 'Seestrasse 89, 6003 Luzern', 'julia.schmid@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Thomas Brunner', 'Gartenstrasse 1, 9000 St. Gallen', 'thomas.brunner@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Fatima Al-Hassan', 'Rue du Marché 18, 1204 Genève', 'fatima.alhassan@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Peter Müller-Lüdenscheidt', 'Industriestr. 144, 5000 Aarau', 'peter.mueller@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Lena Hofer', 'Dorfplatz 3, 7000 Chur', 'lena.hofer@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('David Kim', 'Sonnenbergstrasse 55, 8400 Winterthur', 'david.kim@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Nicole Frei', 'Weinbergstr. 9, 8200 Schaffhausen', 'nicole.frei@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Élodie Béatrice von Grünigen-Stäuble', 'Rosenweg 2, 3600 Thun', 'elodie.vg@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Robert O\'Brien', 'Quai 5, 2000 Neuchâtel', 'robert.obrien@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0),
('Test Ohne Auftrag', 'Teststrasse 0, 0000 Nirgendwo', 'frei@minipa.test', '$2y$10$osH2XlW7WC0qTJUqMwQACujPT6tNoChnz.8fIQ1dkIMJHNlxHqtCi', 0);

INSERT INTO auftraege (titel, beschreibung, fk_mitarbeiterId, erledigen_am, status, document) VALUES
('Drucker im 2. Stock reparieren', 'Der Netzwerkdrucker (HP LaserJet) zieht kein Papier ein.', 3, '2026-05-16', 0, 'fehlerbericht.pdf'),
('Onboarding neue Mitarbeiterin', 'Arbeitsplatz, Laptop und Zugänge für die neue Kollegin vorbereiten.', 2, '2026-06-20', 0, 'checkliste.pdf'),
('Backup-Konzept überarbeiten', 'Dieser Auftrag enthält bewusst eine sehr lange Beschreibung, um zu testen wie das UI mit viel Text umgeht: Tabellenbreite, Zeilenumbruch, Lesbarkeit und Scrollverhalten. Dieser Auftrag enthält bewusst eine sehr lange Beschreibung, um zu testen wie das UI mit viel Text umgeht: Tabellenbreite, Zeilenumbruch, Lesbarkeit und Scrollverhalten. Dieser Auftrag enthält bewusst eine sehr lange Beschreibung, um zu testen wie das UI mit viel Text umgeht: Tabellenbreite, Zeilenumbruch, Lesbarkeit und Sc', 6, '2026-06-23', 0, 'konzept_v3.docx'),
('Server-Update einspielen', 'Sicherheitsupdates auf dem Webserver installieren und neu starten.', 10, '2026-06-28', 0, 'changelog.txt'),
('Kundentermin Offerte Müller AG', 'Offerte für die neue Telefonanlage vorbereiten und präsentieren.', 4, '2026-07-02', 0, 'offerte.pdf'),
('VPN-Zugang einrichten', 'Externer Mitarbeiter benötigt einen sicheren VPN-Zugang.', 9, '2026-06-10', 0, ''),
('Lizenzen Office 365 erneuern', 'Jährliche Verlängerung der Microsoft-365-Lizenzen prüfen.', 5, '2026-07-09', 0, 'rechnung.pdf'),
('Webseite: Kontaktformular defekt', 'Das Kontaktformular sendet keine E-Mails mehr seit dem letzten Deploy.', 3, '2026-06-24', 0, 'screenshot.png'),
('Schulung Datenschutz (DSGVO)', 'Interne Schulung für alle Abteilungen organisieren.', 7, '2026-07-25', 0, 'folien.pptx'),
('Telefonliste aktualisieren', 'Neue Durchwahlen ins Intranet eintragen.', 11, '2026-04-26', 1, 'liste.xlsx'),
('Notebook bestellen', 'Lenovo ThinkPad für die Buchhaltung bestellen.', 8, '2026-05-26', 1, 'bestellung.pdf'),
('Passwort-Richtlinie kommunizieren', 'Neue Richtlinie an alle Mitarbeitenden versenden.', 2, '2026-06-05', 1, ''),
('Migration Mailserver', 'Umzug der Postfächer auf den neuen Exchange-Server.', 10, '2026-07-16', 0, 'migrationsplan.pdf'),
('Defekte Maus ersetzen', 'Maus von Arbeitsplatz 14 funktioniert nicht mehr.', 12, '2026-06-26', 0, 'x'),
('Inventar IT-Hardware', 'Vollständige Inventur aller Laptops, Monitore und Docks.', 6, '2026-08-09', 0, 'inventar.xlsx'),
('Firewall-Regeln prüfen', 'Dieser Auftrag enthält bewusst eine sehr lange Beschreibung, um zu testen wie das UI mit viel Text umgeht: Tabellenbreite, Zeilenumbruch, Lesbarkeit und Scrollverhalten. Dieser Auftrag enthält bewusst eine sehr lange Beschreibung, um zu testen wie das UI mit viel Text umgeht: Tabellenbreite, Zeilenumbruch, Lesbarkeit und Scrollverhalten. Dieser Auftrag enthält bewusst eine sehr lange Beschreibung, um zu testen wie das UI mit viel Text umgeht: Tabellenbreite, Zeilenumbruch, Lesbarkeit und Sc', 5, '2026-06-17', 0, 'audit.pdf'),
('Gäste-WLAN einrichten', 'Separates WLAN für Besucher mit Tagespasswort.', 4, '2026-06-30', 0, 'anleitung.pdf'),
('Monitor flackert', 'Monitor im Sitzungszimmer flackert beim Anschluss via HDMI.', 9, '2026-06-22', 0, ''),
('Software-Rollout Adobe CC', 'Adobe Creative Cloud auf allen Marketing-Rechnern verteilen.', 7, '2026-07-05', 0, 'paket.zip'),
('Telefonanlage konfigurieren', 'Neue Anrufgruppen für den Support einrichten.', 3, '2026-02-25', 1, 'config.json'),
('Datensicherung wiederherstellen', 'Versehentlich gelöschte Datei aus dem Backup zurückholen.', 8, '2026-06-25', 0, 'ticket.pdf'),
('Schädlingsbefall: Phishing-Mail', 'Mitarbeitende über aktuelle Phishing-Welle informieren.', 2, '2026-06-24', 0, 'beispiel.eml'),
('Druckerpatronen nachbestellen', 'Toner für alle Etagendrucker nachbestellen.', 11, '2026-06-29', 0, ''),
('Langer Titel der die Spaltenbreite testen soll!!', 'Kurz.', 13, '2026-07-03', 0, 'y'),
('Райан тест Unicode 你好 😀', 'Auftrag mit Sonderzeichen und Emoji zum Testen der Kodierung 🚀.', 4, '2026-07-07', 0, 'üäö.pdf'),
('Klimaanlage Serverraum', 'Wartung der Klimaanlage im Serverraum durch externe Firma.', 6, '2026-06-15', 0, 'wartung.pdf'),
('Onboarding Praktikant', 'Zugänge und Arbeitsplatz für den Sommerpraktikanten.', 5, '2026-06-27', 0, ''),
('Alte Hardware entsorgen', 'Fachgerechte Entsorgung von 12 alten PCs.', 8, '2025-12-07', 1, 'protokoll.pdf'),
('SSL-Zertifikat erneuern', 'Das Zertifikat für shop.firma.ch läuft bald ab.', 10, '2026-07-01', 0, 'cert.pem'),
('Intranet-Suche langsam', 'Die Volltextsuche im Intranet braucht über 10 Sekunden.', 9, '2026-06-21', 0, 'log.txt');
