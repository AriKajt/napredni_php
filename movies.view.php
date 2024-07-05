<?php include_once 'partials/header.php' ?>

<main class="container my-3 d-flex flex-column flex-grow-1">
    <h1>Filmovi</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Naslov</th>
                <th>Godina</th>
                <th>Zanr</th>
                <th>Mediji</th>
                <th>Tip Filma</th>
                <th>Uredi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= $movie['id'] ?></td>
                    <td style="font-weight:bold"><?= $movie['naslov'] ?></td>
                    <td><?= $movie['godina'] ?></td>
                    <td><?= $movie['zanr'] ?></td>
                    <td>
                    <?php foreach ($movie['medij'] as $medij): ?>
                        <?php 
                            /*$medijBG = match ($medij) {
                                'DVD' => 'badge text-bg-success',
                                'Blu-ray' => 'badge text-bg-info',
                                'VHS' => 'badge text-bg-warning',
                                default => 'badge text-bg-secondary'
                            };*/

                            $medijIcon = match ($medij) {
                                'DVD' => 'disc-fill text-warning',
                                'Blu-ray' => 'disc text-primary',
                                'VHS' => 'cassette-fill text-success',
                                default => 'disc text-secondary'
                            }; 
                        ?>
                        <span class="badge text-bg-light float-start"><i class="bi bi-<?= $medijIcon ?> me-1"></i><?= $medij ?></span>
                    <?php endforeach ?>
                    </td>
        
                    <td><span class="badge text-bg-primary float-middle"><?= $movie['tip_filma']?></span></td>
                    <td>
                        <a href="#" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Movie"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Movie"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>

<?php include_once 'partials/footer.php' ?>