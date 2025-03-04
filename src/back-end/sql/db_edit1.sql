USE 4592700_fursure;

CREATE TABLE Transactions (
    Transaction_ID INT AUTO_INCREMENT PRIMARY KEY,
    Users_ID INT,
    Business_ID INT,
    Service_ID INT,
    Amount DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (Users_ID) REFERENCES Users(Users_ID) ON DELETE SET NULL,
    FOREIGN KEY (Business_ID) REFERENCES Business(Business_ID) ON DELETE SET NULL,
    FOREIGN KEY(Service_ID) REFERENCES Service(Service_ID) ON DELETE SET NULL
);

ALTER TABLE Service 
ADD COLUMN Location VARCHAR(200);

ALTER TABLE Users 
ADD COLUMN Location VARCHAR(200) NULL, 
ADD COLUMN ProfilePicturePath VARCHAR(200) NULL;

ALTER TABLE Business
ADD COLUMN ProfilePicturePath VARCHAR(200) NULL;

CREATE TABLE Pet (
    Pet_ID INT AUTO_INCREMENT PRIMARY KEY,
    Users_ID INT NOT NULL,
    Name VARCHAR(30) NOT NULL,
    Description TEXT,
    ProfilePicturePath VARCHAR(200) NULL,
    Type VARCHAR(50) NOT NULL,
    Warnings TEXT NULL,
    HiddenWarnings TEXT NULL
);

