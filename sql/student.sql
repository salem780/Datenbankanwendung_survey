CREATE TABLE student (
MNR CHAR(7) PRIMARY KEY,
student_name VARCHAR (32) NOT NULL,
FOREIGN KEY (c_token) REFERENCES course (c_token),
)