<?php

namespace App\Models;

class Seeds
{
    public static function getSeeds()
    {
        return [
            Seeds::moviesSeeds(),
            Seeds::tagsSeeds(),
            Seeds::moviesTagsSeeds(),
            Seeds::roomsSeeds(),
            Seeds::eventsSeeds()
        ];
    }


    // MOVIES
    private static function moviesSeeds()
    {
        return [
            "table" => "event",
            "values" => "
            ('60e7329bb04ff4-30790843-60e7329bb0506', 'Venom', 'synopsissynopsissynopsis', '/Views/images/event_venom.jpg', 'Ruben Fleischer', 'Tom Hardy; Michelle Williams', '2021-07-08 17:15:07', NULL),
            ('60e73347ba4626-13094074-60e73347ba46a', '7 Vies', 'synopsissynopsissynopsis', '/Views/images/event_7_vies.jpg', 'Gabriele Muccino', 'Will Smith; Rosario Dawson', '2021-07-08 17:17:59', NULL),
            ('60e733f8052ee1-07640596-60e733f8052f1', 'War Dogs', 'synopsissynopsissynopsis', '/Views/images/event_war_dogs.jpg', 'Todd Phillips', 'Jonah Hill; Miles Teller', '2021-07-08 17:20:56', NULL),
            ('60e7346718c2e9-18030528-60e7346718c32', 'Saw V', 'synopsissynopsissynopsis', '/Views/images/event_saw_v.jpg', 'David Hackl', 'Tobin Bell; Scott Patterson', '2021-07-08 17:22:47', NULL),
            ('60e735ac2665e6-91101410-60e735ac26665', 'Alien: Covenant', 'synopsissynopsissynopsis', '/Views/images/event_alien__covenant.jpg', 'Ridley Scott', 'Michael Fassbender; Katherine Waterston', '2021-07-08 17:28:12', NULL),
            ('60e735f87aae33-97611164-60e735f87aae6', 'Interstellar', 'synopsissynopsissynopsis', '/Views/images/event_interstellar.jpg', 'Christopher Nolan', 'Matthew McConaughey; Anne Hathaway', '2021-07-08 17:29:28', NULL),
            ('60e736330712c3-78725207-60e7363307130', 'Pirates des Caraïbes', 'synopsissynopsissynopsis', '/Views/images/event_pirates_des_caraïbes.jpg', 'Gore Verbinski', 'Johnny Depp; Geoffrey Rush', '2021-07-08 17:30:27', NULL),
            ('60e736b0469372-12508894-60e736b04693b', 'Assassin\'s Creed', 'synopsissynopsissynopsis', '/Views/images/event_assassin_s_creed.jpg', 'Justin Kurzel', 'Michael Fassbender; Marion Cotillard', '2021-07-08 17:32:32', NULL),
            ('60e736ed295956-15142006-60e736ed2959a', 'La Momie', 'synopsissynopsissynopsis', '/Views/images/event_la_momie.jpg', 'Alex Kurtzman', 'Tom Cruise; Sofia Boutella', '2021-07-08 17:33:33', NULL),
            ('60e73765902bd7-54328837-60e73765902c8', 'Insidious', 'synopsissynopsissynopsis', '/Views/images/event_insidious.jpg', 'James Wan', 'Patrick Wilson; Rose Byrne', '2021-07-08 17:35:33', NULL),
            ('60e737a18fa3f3-74641863-60e737a18fa43', 'John Wick', 'synopsissynopsissynopsis', '/Views/images/event_john_wick.jpg', 'Chad Stahelski', 'Keanu Reeves; Alfie Allen', '2021-07-08 17:36:33', NULL);"
        ];
    }

    // TAGS
    private static function tagsSeeds()
    {
        return [
            "table" => "tag",
            "values" => "
            ('60e1fb1c9f7f71-43263366-60e1fb1c9f7fc', 'ACTION', '2021-07-04 18:17:00', NULL),
            ('60e732a6acb156-69506393-60e732a6acb19', 'AVENTURE', '2021-07-08 17:15:18', NULL),
            ('60e733f806b0b5-84927947-60e733f806b0f', 'COMÉDIE', '2021-07-08 17:20:56', NULL),
            ('60e733f8076b00-69047963-60e733f8076b9', 'CRIME', '2021-07-08 17:20:56', NULL),
            ('60e1fb1ca024f4-55660919-60e1fb1ca0252', 'DRAME', '2021-07-04 18:17:00', NULL),
            ('60e735ac280474-89055384-60e735ac2804d', 'HORREUR', '2021-07-08 17:28:12', NULL),
            ('60e73347bb8334-71202101-60e73347bb83b', 'MÉLODRAME', '2021-07-08 17:17:59', NULL),
            ('60e20ddd4c0004-21933902-60e20ddd4c003', 'MARVEL', '2021-07-04 19:37:01', NULL),
            ('60e73765915cd1-55088994-60e73765915d0', 'MYSTÈRE', '2021-07-08 17:35:33', NULL),
            ('60e735ac287f13-29397946-60e735ac287f4', 'SCI-FI', '2021-07-08 17:28:12', NULL),
            ('60e735ac291c45-38774405-60e735ac291c8', 'THRILLER', '2021-07-08 17:28:12', NULL);"
        ];
    }

    // MOVIES - TAGS
    private static function moviesTagsSeeds()
    {
        return [
            "table" => "event_tag",
            "values" => "
            ('60e73da73e1e23-88452425-60e73da73e1e8', '60e7329bb04ff4-30790843-60e7329bb0506', 'ACTION'),
            ('60e73da73f3485-90697542-60e73da73f34d', '60e7329bb04ff4-30790843-60e7329bb0506', 'AVENTURE'),
            ('60e73da73f74c0-22999248-60e73da73f74f', '60e7329bb04ff4-30790843-60e7329bb0506', 'SCI-FI'),
            ('60e73df177f5f7-84251357-60e73df177f6a', '60e73347ba4626-13094074-60e73347ba46a', 'MÉLODRAME'),
            ('60e73e44e2e4e5-19394051-60e73e44e2e57', '60e733f8052ee1-07640596-60e733f8052f1', 'COMÉDIE'),
            ('60e73e44e3cbe7-74076738-60e73e44e3cc7', '60e733f8052ee1-07640596-60e733f8052f1', 'CRIME'),
            ('60e73e44e44575-63238654-60e73e44e445a', '60e733f8052ee1-07640596-60e733f8052f1', 'DRAME'),
            ('60e73e7ea1fd58-68636524-60e73e7ea1fde', '60e7346718c2e9-18030528-60e7346718c32', 'HORREUR'),
            ('60e73e7ea2e8c5-64352469-60e73e7ea2e93', '60e7346718c2e9-18030528-60e7346718c32', 'THRILLER'),
            ('60e73ebab222a8-38567882-60e73ebab2233', '60e735ac2665e6-91101410-60e735ac26665', 'HORREUR'),
            ('60e73ebab35308-67570283-60e73ebab3538', '60e735ac2665e6-91101410-60e735ac26665', 'SCI-FI'),
            ('60e73ebab3b453-26120484-60e73ebab3b4a', '60e735ac2665e6-91101410-60e735ac26665', 'THRILLER'),
            ('60e73f80c03894-08560725-60e73f80c0395', '60e735f87aae33-97611164-60e735f87aae6', 'AVENTURE'),
            ('60e73f80c161c1-67942063-60e73f80c1622', '60e735f87aae33-97611164-60e735f87aae6', 'SCI-FI'),
            ('60e73fd4880028-66238950-60e73fd488009', '60e736330712c3-78725207-60e7363307130', 'ACTION'),
            ('60e73fd488d8b8-67585801-60e73fd488d90', '60e736330712c3-78725207-60e7363307130', 'AVENTURE'),
            ('60e74027c95df3-51371547-60e74027c95e7', '60e736b0469372-12508894-60e736b04693b', 'ACTION'),
            ('60e74027ca4b52-99220184-60e74027ca4bb', '60e736b0469372-12508894-60e736b04693b', 'AVENTURE'),
            ('60e7404d3ba518-30428448-60e7404d3ba5d', '60e736ed295956-15142006-60e736ed2959a', 'ACTION'),
            ('60e7404d3c9057-36831700-60e7404d3c909', '60e736ed295956-15142006-60e736ed2959a', 'AVENTURE'),
            ('60e7407b47f788-02640588-60e7407b47f7d', '60e73765902bd7-54328837-60e73765902c8', 'HORREUR'),
            ('60e7407b48ded0-83214746-60e7407b48df4', '60e73765902bd7-54328837-60e73765902c8', 'MYSTÈRE'),
            ('60e7407b492560-09664551-60e7407b49259', '60e73765902bd7-54328837-60e73765902c8', 'THRILLER'),
            ('60e740b61998a0-94835057-60e740b619991', '60e737a18fa3f3-74641863-60e737a18fa43', 'ACTION'),
            ('60e740b61a7812-46813248-60e740b61a786', '60e737a18fa3f3-74641863-60e737a18fa43', 'THRILLER');"
        ];
    }

    // ROOMS
    private static function roomsSeeds()
    {
        return [
            "table" => "room",
            "values" => "
            ('60e1fccb96a9b4-12747354-60e1fccb96aa1', 'Cinéphilia', 350, 'La salle Cinéphilia, par sa correction acoustique exclusive, offre à tout fan de cinéma les derniers films avec une restitution à 100% fidèle à la bande de son originale.','/Views/images/room_cinéphilia.jpg', 0, 1, '2021-07-04 18:24:11', NULL),
            ('60e739524582c0-75747888-60e7395245830', 'HOciné', 250, 'Pour une sensation comme chez soi, cette salle vous offre le confort comme à la maison avec les derniers films sortis au cinéma, à en profiter seul ou entre amis.', '/Views/images/room_hociné.jpg', 1, 1, '2021-07-08 17:43:46', NULL),
            ('60e7395de25124-80212817-60e7395de2516', 'Cinématographia', 250, 'Cette salle de spectacle cinématographique vous présente une large gamme de films, dans de parfaites conditions de confort et sans aucune altération.', '/Views/images/room_cinématographia.jpg', 1, 1, '2021-07-08 17:43:57', NULL),
            ('60e739672fe968-56146665-60e739672fe9a', 'Cinéaste', 200, 'Cette salle optimisée pour un meilleur visionnage propose des films avec un son optique analogique mono et stéréo Dolby A et SRSon numérique Dolby SRD. La salle est munie d\'une boucle magnétique, destinée à améliorer la sonorisation pour les malentendants.','/Views/images/room_cinéaste.jpg', 1, 0, '2021-07-08 17:44:07', NULL),
            ('60e7396f8ffd68-52676043-60e7396f8ffda', 'Ciné prémium', 100, 'La salle ICE vous présente un tout nouveau concept premium alliant les innovations techniques, le confort et l’immersion visuelle et acoustique.','/Views/images/room_ciné_prémium.jpg', 1, 1, '2021-07-08 17:44:15', NULL),
            ('60e7397988d9d7-20176471-60e7397988da2', 'CinéOptimum', 350, 'Cette salle présente à ses fidèles clients, les meilleurs films avec une résolution optimale, une qualité de son irréprochable, et un confort idéal pour toujours plus de plaisirs.','/Views/images/room_cinéoptimum.jpg', 0, 1, '2021-07-08 17:44:25', NULL);"
        ];
    }

    // EVENTS (JOIN)
    private static function eventsSeeds()
    {
        return [
            "table" => "event_room",
            "values" => "
            ('60e7407b4a1f80-69315793-60e7407b4a1fc', '60e73765902bd7-54328837-60e73765902c8', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-06-28 21:00:00', '2021-06-28 23:00:00'),
            ('60e7404d3d74e6-99755797-60e7404d3d75c', '60e736ed295956-15142006-60e736ed2959a', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-07-07 22:15:00', '2021-07-07 23:30:00'),
            ('60e740b61b46d5-12223959-60e740b61b476', '60e737a18fa3f3-74641863-60e737a18fa43', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-07-29 21:00:00', '2021-07-29 23:30:00'),
            ('60e740b61c4212-11962602-60e740b61c425', '60e737a18fa3f3-74641863-60e737a18fa43', '60e739524582c0-75747888-60e7395245830', '2021-07-29 21:00:00', '2021-07-29 23:30:00'),
            ('60e740b61c7eb7-05287699-60e740b61c7ee', '60e737a18fa3f3-74641863-60e737a18fa43', '60e7395de25124-80212817-60e7395de2516', '2021-07-29 21:00:00', '2021-07-29 23:30:00'),
            ('60e740b61cef18-83281534-60e740b61cefb', '60e737a18fa3f3-74641863-60e737a18fa43', '60e7396f8ffd68-52676043-60e7396f8ffda', '2021-07-29 21:00:00', '2021-07-29 23:30:00'),
            ('60e73e44e52927-44268843-60e73e44e5298', '60e733f8052ee1-07640596-60e733f8052f1', '60e739524582c0-75747888-60e7395245830', '2021-07-30 11:00:00', '2021-07-30 13:00:00'),
            ('60e73da74043d6-77585068-60e73da740444', '60e7329bb04ff4-30790843-60e7329bb0506', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-07-30 17:00:00', '2021-07-30 19:00:00'),
            ('60e74027cbc453-63905301-60e74027cbc48', '60e736b0469372-12508894-60e736b04693b', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-07-30 19:30:00', '2021-07-30 21:30:00'),
            ('60e74027cc04c8-68329794-60e74027cc04f', '60e736b0469372-12508894-60e736b04693b', '60e739524582c0-75747888-60e7395245830', '2021-07-30 19:30:00', '2021-07-30 21:30:00'),
            ('60e74027cb46b2-96606469-60e74027cb472', '60e736b0469372-12508894-60e736b04693b', '60e7396f8ffd68-52676043-60e7396f8ffda', '2021-07-30 19:30:00', '2021-07-30 21:30:00'),
            ('60e73ebab49d41-80446842-60e73ebab49d9', '60e735ac2665e6-91101410-60e735ac26665', '60e7396f8ffd68-52676043-60e7396f8ffda', '2021-08-02 16:00:00', '2021-08-02 18:00:00'),
            ('60e73f80c23162-61645596-60e73f80c231a', '60e735f87aae33-97611164-60e735f87aae6', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-08-02 20:00:00', '2021-08-02 23:00:00'),
            ('60e73ebab4e000-17307642-60e73ebab4e03', '60e735ac2665e6-91101410-60e735ac26665', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-08-04 16:00:00', '2021-08-04 18:00:00'),
            ('60e73fd489bf11-94537879-60e73fd489bf6', '60e736330712c3-78725207-60e7363307130', '60e7397988d9d7-20176471-60e7397988da2', '2021-08-04 20:00:00', '2021-08-04 22:00:00'),
            ('60e73f80c26da0-19520962-60e73f80c26dc', '60e735f87aae33-97611164-60e735f87aae6', '60e1fccb96a9b4-12747354-60e1fccb96aa1', '2021-08-18 00:00:00', '2021-08-18 15:00:00'),
            ('60e73e7ea3c704-64315891-60e73e7ea3c76', '60e7346718c2e9-18030528-60e7346718c32', '60e7395de25124-80212817-60e7395de2516', '2021-08-18 20:00:00', '2021-08-18 22:00:00'),
            ('60e73da7408a45-62503969-60e73da7408ae', '60e7329bb04ff4-30790843-60e7329bb0506', '60e739524582c0-75747888-60e7395245830', '2021-08-20 16:00:00', '2021-08-20 18:00:00'),
            ('60e73e7ea41098-98982965-60e73e7ea410d', '60e7346718c2e9-18030528-60e7346718c32', '60e7395de25124-80212817-60e7395de2516', '2021-08-20 20:00:00', '2021-08-20 22:00:00'),
            ('60e73fd48ae261-43404185-60e73fd48ae28', '60e736330712c3-78725207-60e7363307130', '60e7396f8ffd68-52676043-60e7396f8ffda', '2021-08-20 20:00:00', '2021-08-20 22:00:00'),
            ('60e73fd48aa489-93240615-60e73fd48aa4b', '60e736330712c3-78725207-60e7363307130', '60e7397988d9d7-20176471-60e7397988da2', '2021-08-20 20:00:00', '2021-08-20 22:00:00'),
            ('60e73df179b7a7-17459358-60e73df179b7d', '60e73347ba4626-13094074-60e73347ba46a', '60e7395de25124-80212817-60e7395de2516', '2021-08-24 22:00:00', '2021-08-24 23:00:00');"
        ];
    }
}
