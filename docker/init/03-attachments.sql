-- Turn the legacy single `document` filename on each seeded Auftrag into a
-- proper attachment row, so the mock data shows real (downloadable) Anhänge.
-- (These migrated rows carry the filename only — no original file bytes exist.)
USE minipaprep;

INSERT INTO attachment (auftrag_id, filename, content_type, size, content)
SELECT id, document, NULL, 0, NULL
FROM auftraege
WHERE document IS NOT NULL AND document <> '' AND document <> 'x' AND document <> 'y';
