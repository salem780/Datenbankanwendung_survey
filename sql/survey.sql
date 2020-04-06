CREATE TABLE survey (
s_token CHAR(4) PRIMARY KEY,
s_title VARCHAR (32),
surveyor VARCHAR(32) REFERENCES surveyor(username)
)