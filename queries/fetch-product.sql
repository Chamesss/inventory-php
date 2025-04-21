-- query to fetch product by description text that takes an input keyword

SELECT * FROM products
WHERE description LIKE '%' || $1 || '%'
ORDER BY id
LIMIT 10
OFFSET 0;
