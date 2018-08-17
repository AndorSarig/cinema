<?php

// Database access configurations

const DSN = 'mysql:host=localhost;dbname=cinema';
const DB_USER = 'root';
const DB_PASSWD = 'password';

// Movie filters

const FILTERS = [
    'release_date',
    'genre',
    'date'
    ];

// Pagination settings

const ELEMENTS_ON_PAGE = 4;