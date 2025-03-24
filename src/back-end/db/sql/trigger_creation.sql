USE 4592700_fursure;

DELIMITER $$

CREATE TRIGGER auto_ban_review
AFTER INSERT ON Review
FOR EACH ROW
BEGIN
    IF NEW.Banned = TRUE THEN
    UPDATE Users
    SET Banned = TRUE
    WHERE Users_ID = NEW.Users_ID
    AND (
        (SELECT COUNT(*) FROM Review WHERE Users_ID = NEW.Users_ID AND Banned = TRUE) + 
        (SELECT COUNT(*) FROM Messages WHERE Sender_ID = NEW.Users_ID AND Banned = TRUE) >= 3
    );
    END IF;
END$$

CREATE TRIGGER auto_ban_messages
AFTER INSERT ON Messages
FOR EACH ROW
BEGIN 
    IF NEW.Banned = TRUE THEN
    UPDATE Users
    Set Banned = TRUE
    WHERE Sender_ID = NEW.Sender_ID
    AND (
        (SELECT COUNT(*) FROM Review WHERE Users_ID = NEW.Sender_ID AND Banned = TRUE) +
        (SELECT COUNT(*) FROM Messages WHERE Sender_ID = NEW.Sender_ID AND Banned = TRUE) >= 3
    );
    END IF;
END$$