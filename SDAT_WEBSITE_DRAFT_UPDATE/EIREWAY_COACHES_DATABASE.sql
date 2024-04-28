CREATE DATABASE IF NOT EXISTS EIRE_WAY_COACHES;
USE EIRE_WAY_COACHES;

CREATE TABLE IF NOT EXISTS ADMINISTRATOR (
  Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(255) NOT NULL,
  Password TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS USER (
  User_ID INT AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL UNIQUE,
  Phone VARCHAR(15),
  Address TEXT,
  Password TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS GUEST_USER (
  Email VARCHAR(255) PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS CAREERS (
  Applicant_ID INT AUTO_INCREMENT PRIMARY KEY,
  Category VARCHAR(255),
  Name VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS HELP_AND_SUPPORT (
  Request_ID INT AUTO_INCREMENT PRIMARY KEY,
  User_ID INT,
  Comment TEXT,
  FOREIGN KEY (User_ID) REFERENCES USER(User_ID)
);

CREATE TABLE IF NOT EXISTS FEEDBACK (
  Reference_ID INT AUTO_INCREMENT PRIMARY KEY,
  User_ID INT,
  Admin_ID INT,
  Feedback_Content TEXT,
  FOREIGN KEY (User_ID) REFERENCES USER(User_ID),
  FOREIGN KEY (Admin_ID) REFERENCES ADMINISTRATOR(Admin_ID)
);

CREATE TABLE IF NOT EXISTS CITIES (
  City_ID INT AUTO_INCREMENT PRIMARY KEY,
  City_Name VARCHAR(255) NOT NULL
);

INSERT INTO CITIES (City_ID, City_Name) VALUES
(1, 'Dublin'),
(2, 'Cork'),
(3, 'Galway'),
(4, 'Limerick'),
(5, 'Waterford'),
(6, 'Drogheda'),
(12, 'Navan'),
(13, 'Ennis'),
(14, 'Tralee'),
(15, 'Carlow');

CREATE TABLE IF NOT EXISTS ROUTE (
  Route_ID INT AUTO_INCREMENT PRIMARY KEY,
  Routes VARCHAR(255) NOT NULL
);

INSERT INTO ROUTE (Route_ID, Routes) VALUES
(15, 'Dublin-Cork'),
(16, 'Dublin-Galway'),
(17, 'Dublin-Limerick'),
(18, 'Dublin-Waterford'),
(19, 'Dublin-Drogheda'),
(20, 'Dublin-Navan'),
(21, 'Dublin-Ennis'),
(22, 'Dublin-Tralee'),
(23, 'Dublin-Carlow'),
(24, 'Cork-Galway'),
(25, 'Cork-Limerick'),
(26, 'Cork-Waterford'),
(27, 'Cork-Drogheda'),
(28, 'Cork-Navan'),
(29, 'Cork-Ennis'),
(30, 'Cork-Tralee'),
(31, 'Cork-Carlow'),
(32, 'Galway-Limerick'),
(33, 'Galway-Waterford'),
(34, 'Galway-Drogheda'),
(35, 'Galway-Navan'),
(36, 'Galway-Ennis'),
(37, 'Galway-Tralee'),
(38, 'Galway-Carlow'),
(39, 'Limerick-Waterford'),
(40, 'Limerick-Drogheda'),
(41, 'Limerick-Navan'),
(42, 'Limerick-Ennis'),
(43, 'Limerick-Tralee'),
(44, 'Limerick-Carlow'),
(45, 'Waterford-Drogheda'),
(46, 'Waterford-Navan'),
(47, 'Waterford-Ennis'),
(48, 'Waterford-Tralee'),
(49, 'Waterford-Carlow'),
(50, 'Drogheda-Navan'),
(51, 'Drogheda-Ennis'),
(52, 'Drogheda-Tralee'),
(53, 'Drogheda-Carlow'),
(54, 'Navan-Ennis'),
(55, 'Navan-Tralee'),
(56, 'Navan-Carlow'),
(57, 'Ennis-Tralee'),
(58, 'Ennis-Carlow'),
(59, 'Tralee-Carlow');

CREATE TABLE IF NOT EXISTS TICKET (
  Ticket_ID INT AUTO_INCREMENT PRIMARY KEY,
  Route_ID INT,
  Date DATE,
  Time VARCHAR(5),
  Seat_Type VARCHAR(50),
  Num_Seats INT,
  FOREIGN KEY (Route_ID) REFERENCES ROUTE(Route_ID)
);

CREATE TABLE IF NOT EXISTS BOOKING (
  Booking_ID INT AUTO_INCREMENT PRIMARY KEY,
  User_ID INT,
  Ticket_ID INT,
  FOREIGN KEY (User_ID) REFERENCES USER(User_ID),
  FOREIGN KEY (Ticket_ID) REFERENCES TICKET(Ticket_ID)
);

CREATE TABLE IF NOT EXISTS PAYMENT (
  Payment_ID INT AUTO_INCREMENT PRIMARY KEY,
  Booking_ID INT,
  Transaction_Date DATE,
  Amount DECIMAL(10, 2),
  FOREIGN KEY (Booking_ID) REFERENCES BOOKING(Booking_ID)
);

ALTER TABLE PAYMENT DROP COLUMN Amount;

