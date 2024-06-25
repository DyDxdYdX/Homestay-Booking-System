CREATE DATABASE homestay;

CREATE TABLE user (
  userID INT NOT NULL AUTO_INCREMENT,
  usertype INT NOT NULL COMMENT '1 - Admin, 2 - Home Owner, 3 - Customer',
  userEmail varchar(100) NOT NULL UNIQUE,
  userPwd varchar(255) NOT NULL,
  user_STATUS VARCHAR(50) COMMENT 'Active, Blocked ',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE profile (
  profID INT NOT NULL AUTO_INCREMENT,
  userID INT,
 	username VARCHAR(255),
  phoneNo VARCHAR(50),
  address TEXT,
  img_profile VARCHAR(255),
  PRIMARY KEY (`profID`),
  FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE
);

CREATE TABLE homestaylist (
  hslistID INT NOT NULL AUTO_INCREMENT,
  userID INT,
  hsname VARCHAR(255),
  hsdesc VARCHAR(255),
  hsprice DECIMAL(10,2),
  imgpath TEXT,
  PRIMARY KEY (`hslistID`),
  FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE
);

CREATE TABLE booking (
  bookingID INT NOT NULL AUTO_INCREMENT,
  userID INT,
  hslistID INT,
  book_date DATE NOT NULL DEFAULT CURRENT_DATE(),
  checkIN DATE,
  checkOUT DATE,
  payment_status VARCHAR(50) DEFAULT 'Pending' COMMENT 'Paid, Pending',
  payment_method VARCHAR(50) DEFAULT 'Pending' COMMENT'CASH, ONLINE BANKING, E_WALLET, Pendimg',
  amount_paid double(10,2),
  PRIMARY KEY (bookingID),
  FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE,
  FOREIGN KEY (hslistID) REFERENCES homestaylist(hslistID) ON DELETE CASCADE
);

CREATE TABLE news (
  	newsID INT NOT NULL AUTO_INCREMENT,
  	userID INT,
  	news TEXT,
	  remark TEXT,
    PRIMARY KEY (newsID),
  	FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE
);

CREATE TABLE feedbacks (
  fdbackID INT NOT NULL AUTO_INCREMENT,
  userID INT,
  hsname VARCHAR(255),
  dateIN DATE,
  dateOUT DATE,
  rating INT,
  fdback TEXT,
  PRIMARY KEY (fdbackID),
  FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE
);
