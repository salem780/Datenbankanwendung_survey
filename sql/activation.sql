CREATE TABLE Activation (
FOREIGN KEY(c_token) varchar(8) REFERENCES course(c_token) PRIMARY KEY,
FOREIGN KEY(s_token) varchar(4) REFERENCES survey(s_token) PRIMARY KEY
)
