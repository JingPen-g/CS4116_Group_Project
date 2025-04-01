ALTER TABLE Advertisement
ADD FULLTEXT(Name, Description);

ALTER TABLE Advertisement
ADD COLUMN UploadDate DateTime DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE Advertisement
ADD COLUMN Service_IDs JSON;