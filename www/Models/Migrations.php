<?php

namespace App\Models;

class Migrations
{


    public static function columns()
    {
        return [
            Migrations::commentColumns(),
            Migrations::eventColumns(),
            Migrations::eventRoomColumns(),
            Migrations::eventTagColumns(),
            Migrations::roomColumns(),
            Migrations::sessionColumns(),
            Migrations::tagColumns(),
            Migrations::userColumns(),
            Migrations::websiteColumns(),
        ];
    }

    public static function indexes()
    {
        return [
            Migrations::commentIndexes(),
            Migrations::eventIndexes(),
            Migrations::eventRoomIndexes(),
            Migrations::eventTagIndexes(),
            Migrations::roomIndexes(),
            Migrations::sessionIndexes(),
            Migrations::tagIndexes(),
            Migrations::userIndexes(),
            Migrations::websiteIndexes(),
        ];
    }

    public static function constraints()
    {
        return [
            Migrations::commentConstraints(),
            Migrations::eventRoomConstraints(),
            Migrations::eventTagConstraints(),
            Migrations::sessionConstraints(),
        ];
    }

    // COMMENT

    private static function commentColumns()
    {
        return [
            "table" => "comment",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                name varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Guest',
                content varchar(200) COLLATE utf8_unicode_ci NOT NULL,
                eventId varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                status enum('APPROVED','WAITING','DECLINED') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'WAITING',
                createdAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updatedAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
        ];
    }

    private static function commentIndexes()
    {
        return [
            "table" => "comment",
            "columns" => "
                ADD PRIMARY KEY (id),
                ADD KEY eventId (eventId)"
        ];
    }

    private static function commentConstraints()
    {
        return [
            "table" => "comment",
            "columns" => "ADD CONSTRAINT `faman_comment_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `faman_event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE"
        ];
    }


    // EVENT

    private static function eventColumns()
    {
        return [
            "table" => "event",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                title varchar(100) COLLATE utf8_unicode_ci NOT NULL,
                synopsis varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
                media varchar(137) NOT NULL,
                directors varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
                actors varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
                createdAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updatedAt timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP"
        ];
    }

    private static function eventIndexes()
    {
        return [
            "table" => "event",
            "columns" => "ADD PRIMARY KEY (id)"
        ];
    }

    // EVENT_ROOM

    private static function eventRoomColumns()
    {
        return [
            "table" => "event_room",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                eventId varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                roomId varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                startTime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                endTime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP"
        ];
    }

    private static function eventRoomIndexes()
    {
        return [
            "table" => "event_room",
            "columns" => "
                ADD PRIMARY KEY (startTime,roomId) USING BTREE,
                ADD KEY eventId (eventId),
                ADD KEY roomId (roomId)"
        ];
    }

    private static function eventRoomConstraints()
    {
        return [
            "table" => "event_room",
            "columns" => "
                ADD CONSTRAINT `faman_event_room_ibfk_1` FOREIGN KEY (`roomId`) REFERENCES `faman_room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                ADD CONSTRAINT `faman_event_room_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `faman_event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE"
        ];
    }

    // EVENT_TAG

    private static function eventTagColumns()
    {
        return [
            "table" => "event_tag",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                eventId varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                tag varchar(20) COLLATE utf8_unicode_ci NOT NULL"
        ];
    }

    private static function eventTagIndexes()
    {
        return [
            "table" => "event_tag",
            "columns" => "
                ADD PRIMARY KEY (eventId,tag),
                ADD KEY faman_event_tag_ibfk_2 (tag)"
        ];
    }

    private static function eventTagConstraints()
    {
        return [
            "table" => "event_tag",
            "columns" => "ADD CONSTRAINT `faman_event_tag_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `faman_event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE"
        ];
    }

    // ROOM

    private static function roomColumns()
    {
        return [
            "table" => "room",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                label varchar(100) COLLATE utf8_unicode_ci NOT NULL,
                capacity int(11) NOT NULL,
                description varchar(300) COLLATE utf8_unicode_ci NOT NULL,
                media varchar(137) NOT NULL,
                isHandicapAccess tinyint(1) NOT NULL DEFAULT '0',
                isAvailable tinyint(1) NOT NULL DEFAULT '1',
                createdAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updatedAt timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP"
        ];
    }

    private static function roomIndexes()
    {
        return [
            "table" => "room",
            "columns" => "ADD PRIMARY KEY (id)"
        ];
    }
    // SESSION

    private static function sessionColumns()
    {
        return [
            "table" => "session",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                userId varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                expireAt datetime DEFAULT '2022-01-01 10:10:10',
                createdAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updatedAt timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP"
        ];
    }

    private static function sessionIndexes()
    {
        return [
            "table" => "session",
            "columns" => "
                ADD PRIMARY KEY (id),
                ADD KEY userId (userId)"
        ];
    }

    private static function sessionConstraints()
    {
        return [
            "table" => "session",
            "columns" => "ADD CONSTRAINT `faman_session_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `faman_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE"
        ];
    }

    // TAG

    private static function tagColumns()
    {
        return [
            "table" => "tag",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                label varchar(20) COLLATE utf8_unicode_ci NOT NULL,
                createdAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updatedAt timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP"
        ];
    }

    private static function tagIndexes()
    {
        return [
            "table" => "tag",
            "columns" => "ADD PRIMARY KEY (label)"
        ];
    }

    // USER

    private static function userColumns()
    {
        return [
            "table" => "user",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                firstname varchar(50) COLLATE utf8_unicode_ci NOT NULL,
                lastname varchar(100) COLLATE utf8_unicode_ci NOT NULL,
                email varchar(320) COLLATE utf8_unicode_ci NOT NULL,
                password varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                role varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'MANAGER',
                isActive tinyint(1) NOT NULL DEFAULT '1',
                createdAt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updatedAt timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP"
        ];
    }

    private static function userIndexes()
    {
        return [
            "table" => "user",
            "columns" => "ADD PRIMARY KEY (id)"
        ];
    }

    // WEBSITE

    private static function websiteColumns()
    {
        return [
            "table" => "website",
            "columns" => "
                id varchar(37) COLLATE utf8_unicode_ci NOT NULL,
                about text COLLATE utf8_unicode_ci"
        ];
    }

    private static function websiteIndexes()
    {
        return [
            "table" => "website",
            "columns" => "ADD PRIMARY KEY (id)"
        ];
    }
}
