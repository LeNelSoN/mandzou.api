CREATE TABLE Category(
   Id_Category VARCHAR(255),
   title VARCHAR(255),
   description TEXT,
   is_deleted BOOLEAN,
   PRIMARY KEY(Id_Category)
);

CREATE TABLE Appuser(
   Id_Appuser VARCHAR(255),
   login VARCHAR(255),
   password VARCHAR(50),
   PRIMARY KEY(Id_Appuser)
);

CREATE TABLE Customer(
   Id_Customer VARCHAR(255),
   first_name VARCHAR(255),
   last_name VARCHAR(255),
   address TEXT,
   is_admin BOOLEAN,
   is_deleted BOOLEAN,
   Id_Appuser VARCHAR(255),
   PRIMARY KEY(Id_Customer),
   UNIQUE(Id_Appuser),
   FOREIGN KEY(Id_Appuser) REFERENCES Appuser(Id_Appuser)
);

CREATE TABLE Cart(
   Id_Cart VARCHAR(255),
   Id_Customer VARCHAR(255),
   PRIMARY KEY(Id_Cart),
   FOREIGN KEY(Id_Customer) REFERENCES Customer(Id_Customer)
);

CREATE TABLE Product(
   Id_Product VARCHAR(255),
   title_fr VARCHAR(50),
   title_en VARCHAR(50),
   description_en VARCHAR(50),
   description_fr TEXT,
   price DECIMAL(15,2),
   is_deleted BOOLEAN,
   Id_Cart VARCHAR(255),
   Id_Category VARCHAR(255),
   PRIMARY KEY(Id_Product),
   FOREIGN KEY(Id_Cart) REFERENCES Cart(Id_Cart),
   FOREIGN KEY(Id_Category) REFERENCES Category(Id_Category)
);

CREATE TABLE Picture(
   Id_Picture VARCHAR(255),
   url TEXT,
   alt VARCHAR(255),
   is_deleted BOOLEAN,
   Id_Product VARCHAR(255),
   PRIMARY KEY(Id_Picture),
   FOREIGN KEY(Id_Product) REFERENCES Product(Id_Product)
);
