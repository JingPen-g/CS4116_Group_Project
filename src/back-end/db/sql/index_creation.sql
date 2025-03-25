USE 4592700_fursure;

CREATE INDEX idx_email ON Users(Email);
CREATE INDEX idx_business_email ON Business(Email);
CREATE INDEX idx_service_business ON Service(Business_ID);
CREATE INDEX idx_advertisement_business ON Advertisement(Business_ID);
CREATE INDEX idx_review_service ON Review(Service_ID);
CREATE INDEX idx_review_Users ON Review(Users_ID);