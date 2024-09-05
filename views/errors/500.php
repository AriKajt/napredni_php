<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Internal server error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">Opps!</span> Internal server error.</p>
            <p class="lead">
                Server nije u mogućnosti obraditi zahtjev, pokušajte ponovno kasnije.
            </p>
            <a href="<?php goBack() ?>" class="btn btn-primary">Povratak</a>
        </div>
    </div>
</body>
</html>