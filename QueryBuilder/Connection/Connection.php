<?php

class Connection {
    public static function make($host, $dbname, $charset, $username, $root) {
        return new PDO ("$host; $dbname; $charset", "$username", "$root");
    }
}