4/24/2024:
(hello World)s
 creating Dast board : Integrating bootstrapt and creating databased connection / 4/24/2024:
4/25/2024
	Creating Admin panel : 
4/25/2024:
	Connect Db thath fetch 
4/29/2024 
	Developing Crud Update and display 
4/30/2024
	Delete Function
5/1/2024
	Login Function 
5/2/2024
	Product uploads image
5/4/2024
CREATING CUSTOMER
5/5/2024
order quantity
order-create
5/9/2024
custom js intergrate jquerry
5/10/2024 
quick index layout
5/11/2024
Creating method order 
5/13/2024
Creating incoice print receipt
5/15/2024
Insert receit in the data based
5/19/2024
vIEW AND FETCH ORDERS WITH ORDER databased
5/25/2024
Creat multi user 
5/26/2024
create user login and logout time
5/29/2024
make sure the roles cant assess weach other through tab menu
5/31/2024
make alert product 0 
6/1/2024
Make audit proper unique session
6/10/2024
add resident 
6/16/2024
phase 2 frontpage develop
6/17/2024
Total dashboard summary
6/18/2024
Sidebear active 
7/1/2024 to 7/30/2024 = designing 
8/24/2024 
this where all i the days i skip is for designing and debugging
8/25/2024 
creating maintenance requirements
8/26/2024
filtering resident request in uinique id preventing show resident to other resident
8/27/2024
acceept and reject action request 
8/28/2024
Announcement view and creating crud in hoa admin
8/29/2024
dispaly and fetch announcement and designing
8/30/2024
checking every design and functionality of sidebar
9/1/2024
htaccess for removing .php
9/2/2024
Dash board analytic complete
9/2/2024
sweetaler2 integrate for delete button
9/6/2024
Forms Adjusting
9/8/2024
request starting reopen features
9/10/2024creating delete / archive features for Hoa
9/15/ 2024
start dashboard alligning
9/16/2024
notification

IMS-ver-2-check-(Clear From Moving)


#################################################################
-- Reset IDs and Auto Increment for active_sessions
SET @num := 0;
UPDATE active_sessions SET id = @num := (@num + 1);
ALTER TABLE active_sessions AUTO_INCREMENT = 1;

SET @num := 0;
UPDATE admins SET id = @num := (@num + 1);
ALTER TABLE admins AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for announcement
SET @num := 0;
UPDATE announcement SET id = @num := (@num + 1);
ALTER TABLE announcement AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for categories
SET @num := 0;
UPDATE categories SET id = @num := (@num + 1);
ALTER TABLE categories AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for customers
SET @num := 0;
UPDATE customers SET id = @num := (@num + 1);
ALTER TABLE customers AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for orders
SET @num := 0;
UPDATE orders SET id = @num := (@num + 1);
ALTER TABLE orders AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for order_items
SET @num := 0;
UPDATE order_items SET id = @num := (@num + 1);
ALTER TABLE order_items AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for payments
SET @num := 0;
UPDATE payments SET id = @num := (@num + 1);
ALTER TABLE payments AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for products
SET @num := 0;
UPDATE products SET id = @num := (@num + 1);
ALTER TABLE products AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for product_logs
SET @num := 0;
UPDATE product_logs SET id = @num := (@num + 1);
ALTER TABLE product_logs AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for product_quantity_adjustments
SET @num := 0;
UPDATE product_quantity_adjustments SET id = @num := (@num + 1);
ALTER TABLE product_quantity_adjustments AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for product_quantity_log
SET @num := 0;
UPDATE product_quantity_log SET id = @num := (@num + 1);
ALTER TABLE product_quantity_log AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for request
SET @num := 0;
UPDATE request SET id = @num := (@num + 1);
ALTER TABLE request AUTO_INCREMENT = 1;

-- Reset IDs and Auto Increment for residents
SET @num := 0;
UPDATE residents SET id = @num := (@num + 1);
ALTER TABLE residents AUTO_INCREMENT = 1;

#################################################################

-- Disable foreign key checks (if necessary, for tables with foreign key relationships)
SET foreign_key_checks = 0;

-- Delete data from tables
DELETE FROM active_sessions;
DELETE FROM announcement;
DELETE FROM categories;
DELETE FROM customers;
DELETE FROM orders;
DELETE FROM order_items;
DELETE FROM payments;
DELETE FROM products;
DELETE FROM product_logs;
DELETE FROM product_quantity_adjustments;
DELETE FROM product_quantity_log;
DELETE FROM request;
DELETE FROM residents;

-- Re-enable foreign key checks
SET foreign_key_checks = 1;


#################################################################
SELECT 
    TABLE_NAME, 
    AUTO_INCREMENT
FROM 
    INFORMATION_SCHEMA.TABLES
WHERE 
    TABLE_SCHEMA = 'information-system-php' AND AUTO_INCREMENT IS NOT NULL;

#################################################################

SHOW TABLE STATUS LIKE 'active_sessions';
SHOW TABLE STATUS LIKE 'announcement';
SHOW TABLE STATUS LIKE 'categories';
SHOW TABLE STATUS LIKE 'customers';
SHOW TABLE STATUS LIKE 'orders';
SHOW TABLE STATUS LIKE 'order_items';
SHOW TABLE STATUS LIKE 'payments';
SHOW TABLE STATUS LIKE 'products';
SHOW TABLE STATUS LIKE 'product_logs';
SHOW TABLE STATUS LIKE 'product_quantity_adjustments';
SHOW TABLE STATUS LIKE 'product_quantity_log';
SHOW TABLE STATUS LIKE 'request';
SHOW TABLE STATUS LIKE 'residents';
#################################################################


??????????????????????????????????????????
?? ctrl+shift +R for console clear catch??
??????????????????????????????????????????

Pantayin Yung sa dash board sa stockman - Check

Pantayin Yung image nang design nang Bahay sa home page - Check

Floor area to model description - Check

Announcement deadline - since may delete button namn - Check

Make the Inactive button to be inactive in account  - Check

Backup table to backup database - Check

Resident announcement need notification  - Check

Resident maintenance  request form dropdown - Check

Every printable need summary - Check

Make the checkbox full green or put check - Check no changes

Order status remove it in order widthralaws history Tracking, 2phone no, 3date  - Check

Use full name of c phone to contractor phone  - Check

#################################################################
#Dont Forget To Change in the main laptop the inactive -> Inactive#
#################################################################

Dashboard can go to their specific feature - not-implement

Dashboard overview will pop up - not Implement

Make the contact number start for 09 - not Implement

Detailed name of company contractor - not Implement

Sysadmin quantity need unit - Not Implement
