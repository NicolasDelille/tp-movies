-- Sélectionnez tous les titres et années
SELECT title, year
FROM movies

-- idem, avec 100 films, classés par année de la plus récente à la plus ancienne
SELECT title, year
FROM movies
ORDER BY year DESC, title ASC
LIMIT 1000 

-- sélectionnez les titres, année et rating des 100 meilleurs films
SELECT title, year, rating
FROM movies
ORDER BY rating DESC
LIMIT 100

-- compter le nombre de films en base 
SELECT COUNT(*)
FROM movies

-- note moyenne des films
SELECT AVG(rating)
FROM movies

-- note moyenne des films, par année ?
SELECT year, AVG(rating)
FROM movies
GROUP BY year

-- année du plus vieux film
SELECT MIN(year)
FROM movies

-- année et titre du plus vieux film
SELECT title, year
FROM movies
ORDER BY year ASC
LIMIT 1

-- sélectionner le titre et le rating du film avec la moins bonne note
SELECT title, rating
FROM movies
WHERE rating = (SELECT MIN(rating) FROM movies) --ajout d'une sous-requête entre ()

-- sélectionnez les films dans lesquels joue Brad Pitt
SELECT title, cast
FROM movies
WHERE cast LIKE '%Brad Pitt%'

-- sélectionnez les films qui commencent par la lettre Z
SELECT title
FROM movies
WHERE title LIKE 'Z%' --Z% Qui commence par Z et peu importe ce qui suit

-- sélectionnez les comédies uniquement, du XXIème siècle
SELECT title, year, genres
FROM movies
WHERE genres LIKE '%comedy%' 
AND year > 2000
ORDER BY year ASC

-- sélectionnez les films dans lesquels joue Clint Eastwood ou dirigés par Clint
SELECT title, cast, directors
FROM movies
WHERE cast LIKE '%Clint Eastwood%'
OR directors LIKE '%Clint Eastwood%'
