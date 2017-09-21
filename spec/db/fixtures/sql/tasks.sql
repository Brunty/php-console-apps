INSERT INTO Tasks (id, name, added_on)
VALUES
('095ae2fb-cf7b-4dcd-829f-e10e3ce84a3d', 'Task 1', '2016-10-05 03:04:05'),
('cfa02e73-d510-4c09-8bb5-e46c9c806b9b', 'Task 2', '2016-10-06 02:03:04'),
('b1b0c0ce-cc9c-458e-b648-de19e0aac496', 'Task 3', '2016-10-07 01:02:03');

UPDATE Tasks SET complete = 1 WHERE id = 'b1b0c0ce-cc9c-458e-b648-de19e0aac496';
