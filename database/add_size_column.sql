-- Run this once in phpMyAdmin if your products table has no size/gender fields yet.
-- Each thrift item stores one accepted size only.

ALTER TABLE products ADD COLUMN IF NOT EXISTS gender VARCHAR(20) DEFAULT 'Unisex' AFTER category;
ALTER TABLE products ADD COLUMN IF NOT EXISTS size VARCHAR(30) DEFAULT 'One Size' AFTER gender;
ALTER TABLE products MODIFY COLUMN size VARCHAR(30) DEFAULT 'One Size';

UPDATE products
SET size = CASE
    WHEN category = 'Shoes' THEN ELT(FLOOR(1 + RAND() * 7), 'UK 5', 'UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11')
    WHEN category IN ('Accessories', 'Bags') THEN 'One Size'
    WHEN category = 'Bottoms' THEN ELT(FLOOR(1 + RAND() * 6), 'XS', 'S', 'M', 'L', 'XL', 'XXL')
    WHEN category = 'Dresses' THEN ELT(FLOOR(1 + RAND() * 5), 'XS', 'S', 'M', 'L', 'XL')
    ELSE ELT(FLOOR(1 + RAND() * 6), 'XS', 'S', 'M', 'L', 'XL', 'XXL')
END
WHERE size IS NULL OR size = '' OR size = 'One Size';
