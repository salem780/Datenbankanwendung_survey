CREATE TABLE Answered (
    FOREIGN KEY (MNR) REFERENCES Student (MNR),
    FOREIGN KEY (s_token) REFERENCES Survey (s_token),
    comment VARCHAR (100),
    status BIT NOT NULL,
    CONSTRAINT PK_Answered PRIMARY KEY (MNR, s_token)
)