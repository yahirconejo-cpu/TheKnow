<?php
    function connectedPDO() {
        $dbPath = 'C:\wamp64\www\TheKnow-main\Data\Website2.db';
        try {
            $pdo = new PDO('sqlite:' . $dbPath);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }