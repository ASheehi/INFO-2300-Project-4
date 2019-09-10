-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

-- TODO: initial seed data

-- TODO: FOR HASHED PASSWORDS, LEAVE A COMMENT WITH THE PLAIN TEXT PASSWORD!

CREATE TABLE `listserve`(
   `id`INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
   `list_name`TEXT NOT NULL,
   `list_email`TEXT NOT NULL,
   `list_textbox`TEXT NOT NULL
);



CREATE TABLE `member` (
    `id`INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `name`TEXT NOT NULL,
    `position`TEXT NOT NULL,
    `year`TEXT NOT NULL,
    `major`TEXT NOT NULL,
    `fact`TEXT NOT NULL,
    `image_name` TEXT NOT NULL UNIQUE,
    `image_ext` TEXT NOT NULL,
    `description` TEXT NOT NULL
);

CREATE TABLE 'users' (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'username' TEXT NOT NULL UNIQUE,
    'password' TEXT NOT NULL
);

CREATE TABLE sessions (
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	user_id INTEGER NOT NULL,
	session TEXT NOT NULL UNIQUE
);

CREATE TABLE 'events' (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'name' TEXT NOT NULL,
    'month' INTEGER NOT NULL,
    'day' INTEGER NOT NULL,
    'year' INTEGER NOT NULL,
    'time' TEXT NOT NULL
);


INSERT INTO `listserve` (id, list_name, list_email, list_textbox) VALUES (1, 'Nicolas', 'abc123@gmail.com', 'increase my fluency in Portuguese.');

INSERT INTO `member` (id, name, position, year, major, fact, `image_name`, `image_ext`, description) VALUES (1,'Nicolas', 'President', 'Senior', 'Biological Sciences (Pre-Med)', 'I represented Peru in international little league baseball tournaments!','President', 'png', 'Nicolas');

INSERT INTO `member` (id, name, position, year, major, fact, `image_name`, `image_ext`, description) VALUES (2, 'Will', 'Vice President', 'Senior', 'Government', 'I write for CU Noodz!', 'Vice President', 'png', 'Will');

INSERT INTO `member` (id, name, position, year, major, fact, `image_name`, `image_ext`, description) VALUES (3, 'Katrina ', 'Secretary', 'Junior', 'ILR', 'I have a twin sister!', 'Secretary', 'jpg', 'Katrina');

--Image Citation :https://medium.com/personal-growth/the-5-key-ingredients-of-an-authentic-person-259914abf6d5

INSERT INTO `member` (id, name, position, year, major, fact, `image_name`, `image_ext`, description) VALUES (4, 'Nicole ', 'Treasurer', 'Junior', 'American Studies', 'I love cooking, and I love food!', 'Treasurer ', 'png', 'Nicole');

INSERT INTO users (id, username, password) VALUES (1, 'admin', '$2y$10$V/1LtHgbUfQtle41RLuAk.pvppdZ3BTgiaFvld13RgUXp5Tib23f6'); -- password: penguin

INSERT INTO events (id, name, month, day, year, time) VALUES (1, "Dia do Trabalhador", 5, 1, 2019, "03:30PM");

INSERT INTO events (id, name, month, day, year, time) VALUES (2, "Jantar do Clube", 5, 1, 2019, "05:30PM");

COMMIT;
