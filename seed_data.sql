-- Pulizia tabelle esistenti
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE games;
TRUNCATE TABLE platforms;
TRUNCATE TABLE sessions;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- Inserimento Piattaforme con Loghi (URL pubblici Wikimedia/Placeholder)
INSERT INTO platforms (id, name, slug, logo_url) VALUES 
(1, 'Xbox Series X/S', 'xbox-series-x-s', 'https://upload.wikimedia.org/wikipedia/commons/f/f9/Xbox_one_logo.svg'),
(2, 'PlayStation 5', 'playstation-5', 'https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_logo.svg'),
(3, 'PC (Steam)', 'pc-steam', 'https://upload.wikimedia.org/wikipedia/commons/8/83/Steam_icon_logo.svg'),
(4, 'Nintendo Switch', 'nintendo-switch', 'https://upload.wikimedia.org/wikipedia/commons/0/04/Nintendo_Switch_logo%2C_square.png'),
(5, 'Xbox One', 'xbox-one', 'https://upload.wikimedia.org/wikipedia/commons/f/f9/Xbox_one_logo.svg'),
(6, 'PlayStation 4', 'playstation-4', 'https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_logo.svg');

-- Inserimento Giochi Popolari con Copertine (URL pubblici IGDB/Placeholder)
-- Nota: In produzione usare API IGDB. Qui usiamo placeholder tematici o link diretti per demo.
INSERT INTO games (id, name, igdb_id, cover_image, is_multiplayer) VALUES 
(1, 'Call of Duty: Warzone', 'cod-warzone', 'https://upload.wikimedia.org/wikipedia/en/2/23/Call_of_Duty_Warzone_cover.jpg', 1),
(2, 'Fortnite', 'fortnite', 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Fortnite_F_lettermark_logo.png', 1),
(3, 'EA Sports FC 24', 'ea-fc-24', 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/EA_Sports_FC_24_Logo.svg/1200px-EA_Sports_FC_24_Logo.svg.png', 1),
(4, 'Minecraft', 'minecraft', 'https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png', 1),
(5, 'Apex Legends', 'apex-legends', 'https://upload.wikimedia.org/wikipedia/en/d/db/Apex_legends_cover.jpg', 1),
(6, 'League of Legends', 'lol', 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/LoL_Icon_Flat_GOLD.svg/1200px-LoL_Icon_Flat_GOLD.svg.png', 1),
(7, 'Valorant', 'valorant', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Valorant_logo_-_pink_color_version.svg/1200px-Valorant_logo_-_pink_color_version.svg.png', 1),
(8, 'Grand Theft Auto V', 'gta-v', 'https://upload.wikimedia.org/wikipedia/en/a/a5/Grand_Theft_Auto_V.png', 1);

-- Inserimento Utenti Demo
INSERT INTO users (id, username, email, password_hash, avatar_url) VALUES 
(1, 'ProGamer99', 'pro@lobbyup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://api.dicebear.com/7.x/avataaars/svg?seed=ProGamer99'),
(2, 'NerdGirl', 'nerd@lobbyup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://api.dicebear.com/7.x/avataaars/svg?seed=NerdGirl'),
(3, 'ConsolePeasant', 'console@lobbyup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'https://api.dicebear.com/7.x/avataaars/svg?seed=ConsolePeasant');

-- Inserimento Sessioni Demo
INSERT INTO sessions (creator_id, game_id, platform_id, session_date, start_time, duration_hours, max_players, current_players, description, status) VALUES 
(1, 1, 1, CURDATE(), '21:00:00', 2, 4, 1, 'Cerco team per vittoria BR Quartetti. No perditempo.', 'scheduled'),
(2, 3, 2, CURDATE(), '22:30:00', 1, 11, 3, 'Pro Club amichevole, cerchiamo difensori e portiere.', 'scheduled'),
(3, 4, 3, CURDATE() + INTERVAL 1 DAY, '15:00:00', 4, 10, 5, 'Server Vanilla Survival, startiamo un nuovo mondo!', 'scheduled'),
(1, 5, 3, CURDATE(), '20:00:00', 2, 3, 1, 'Grinding Ranked Gold/Plat.', 'scheduled'),
(2, 2, 4, CURDATE() + INTERVAL 2 DAY, '18:00:00', 3, 4, 2, 'Zero Build Squads for fun.', 'scheduled');
