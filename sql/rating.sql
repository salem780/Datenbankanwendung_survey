CREATE TABLE Rating (
    FOREIGN KEY (MNR) REFERENCES Student (MNR),
    FOREIGN KEY (ID) REFERENCES Question (ID),
    FOREIGN KEY (s_token) REFERENCES Question (s_token)
    a_value INT CHECK (a_value >=1 AND a_value <=5),
    CONSTRAINT PK_Rating PRIMARY KEY (MNR, ID,s_token)
)