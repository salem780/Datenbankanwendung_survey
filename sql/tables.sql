CREATE TABLE survey(
s_token CHAR(4) PRIMARY KEY,
s_title VARCHAR (32) NOT NULL UNIQUE,
username VARCHAR (32),
FOREIGN KEY (username) REFERENCES surveyor (username) on delete cascade on update cascade
);


CREATE TABLE surveyor (
username VARCHAR (32) PRIMARY KEY,
password VARCHAR (256) NOT NULL
);


CREATE TABLE answered (
    MNR CHAR(8),
    s_token CHAR(4),
    FOREIGN KEY (MNR) REFERENCES Student (MNR) on delete cascade on update cascade,
    FOREIGN KEY (s_token) REFERENCES Survey (s_token) on delete cascade on update cascade,
    comment VARCHAR (256),
    status BIT NOT NULL,
    CONSTRAINT PK_Answered PRIMARY KEY (MNR, s_token)
);

CREATE TABLE course (
c_token CHAR(8) PRIMARY KEY,
c_name VARCHAR (32) NOT NULL
);

CREATE TABLE Rating (
    MNR CHAR(4),
    ID INT,
    s_token CHAR(4),
    FOREIGN KEY (MNR) REFERENCES Student (MNR) on delete cascade on update cascade,
    FOREIGN KEY (ID) REFERENCES Question (ID) on delete cascade on update cascade,
    FOREIGN KEY (s_token) REFERENCES Question (s_token) on delete cascade on update cascade,
    a_value INT CHECK (a_value >=1 AND a_value <=5),
    CONSTRAINT PK_Rating PRIMARY KEY (MNR, ID,s_token)
);


CREATE TABLE student (
MNR CHAR(8) PRIMARY KEY,
student_name VARCHAR (32) NOT NULL,
c_token CHAR(8),
FOREIGN KEY (c_token) REFERENCES course (c_token) on delete cascade on update cascade
);


CREATE TABLE Question (
ID INT,
Text VARCHAR(256),
s_token CHAR(4),
FOREIGN KEY (s_token) REFERENCES survey(s_token) on delete cascade on update cascade,
CONSTRAINT PK_Question PRIMARY KEY (ID, s_token)
);


CREATE TABLE Activation (
c_token CHAR(8),
s_token CHAR(4),
FOREIGN KEY(c_token) REFERENCES course(c_token) on delete cascade on update cascade,
FOREIGN KEY(s_token) REFERENCES survey(s_token) on delete cascade on update cascade,
CONSTRAINT PK_Activation PRIMARY KEY (c_token, s_token )
);
