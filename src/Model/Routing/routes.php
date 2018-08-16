<?php

const ROUTES = [
    "GET" => [
        "/^\/$/" => [
            "CONTROLLER"    => "\\Controller\\MovieController",
            "METHOD"        => "getAllMovies"
        ],
        "/^\/movies\/*/" => [
            "CONTROLLER"    => "\\Controller\\MovieController",
            "METHOD"        => "getAllMovies"
        ],
        "/^\/movie\/[0-9]+\/?$/" => [
            "CONTROLLER"    => "\\Controller\\MovieController",
            "METHOD"        => "getMovieById"
        ],
        "/^\/login\/?$/" => [
            "CONTROLLER"    => "\\Controller\\UserController",
            "METHOD"        => "loadLogin"
        ],
        "/^\/signup\/?$/" => [
            "CONTROLLER"    => "\\Controller\\UserController",
            "METHOD"        => "loadSignup"
        ],
        "/^\/logout\/?$/" => [
            "CONTROLLER"    => "\\Controller\\UserController",
            "METHOD"        => "logout"
        ],
        "/^\/screening\/[0-9]+\/?$/" => [
            "CONTROLLER"    => "\\Controller\\ScreeningController",
            "METHOD"        => "getBookingPageForScreening"
        ],
        "/^\/bookings\/?$/" => [
            "CONTROLLER"    => "\\Controller\\BookingController",
            "METHOD"        => "getBookingsForUser"
        ],
        "/^\/ajax\/free\/?$/" => [
            "CONTROLLER"    => "\\Controller\\AjaxController",
            "METHOD"        => "updateFreeSeats"
        ]
    ],
    "POST" => [
        "/^\/signup\/?$/" => [
            "CONTROLLER"    => "\\Controller\\UserController",
            "METHOD"        => "signup"
        ],
        "/^\/login\/?$/" => [
            "CONTROLLER"    => "\\Controller\\UserController",
            "METHOD"        => "login"
        ],
        "/^\/screening\/[0-9]+\/?$/" => [
            "CONTROLLER"    => "\\Controller\\BookingController",
            "METHOD"        => "addBooking"
        ]
    ]
];