<?php

// initialize the environment and get dependency injection container
$tServices = require __DIR__ . "/src/bootstrap.php";

// exception handling
set_exception_handler(function ($uException) use ($tServices) {
    // TODO: Return HTTP status 403 within Response class.
    header("HTTP/1.0 403 Forbidden");

    $tFormatter = $tServices["formatter"];
    $tFormatter->writeHeader(2, "Error");
    $tFormatter->write($uException->getMessage());

    exit(1);
});

// set up server class
$tServer = new \SqlSync\Server\Server($tServices);

// get database from url part: ?db=
$tDatabase = rtrim($tServices["request"]->get("db", ""));

// set output
$tHandle = fopen("php://output", "wb");

// start dumping database
$tServer->dump($tDatabase, $tHandle);

exit(0);
