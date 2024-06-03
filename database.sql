-- Active: 1711665667615@@127.0.0.1@3306@reservation_restaurant
CREATE DATABASE reservation_restaurant;

USE reservation_restaurant;


SELECT
    *
FROM
    categories
WHERE
    id IN(
        SELECT
            category_id
        FROM
            menus
    );

SELECT
    menus.id as "menu id",
    menus.name,
    menus.price,
    COUNT(cart_items.menu_id) AS quantity,
    menus.price * cart_items.quantity AS total
FROM
    cart_items
    INNER JOIN menus ON cart_items.menu_id = menus.id
WHERE
    cart_id = 1
GROUP BY
    menu_id;

    drop Table orders;