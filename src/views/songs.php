<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Songs</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="/css/datatables.css" rel="stylesheet" crossorigin="anonymous">
    <link href="/css/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/main.js"></script>
</head>

<body>

    <!-- Navbar -->
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Examen1</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?r=formsongs">Añadir Canciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index.php?r=songs">Canciones</a>
                        </li>
                    </ul>
                 
                </div>
            </div>
        </nav>
    </div>

    <!-- Tabla de canciones -->
    <div class="container">
        <div class="table-responsive mt-4 rounded">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><i class="bi bi-music-note"></i> Nombre</th>
                        <th scope="col"><i class="bi bi-person"></i> Artista</th>
                        <th scope="col"><i class="bi bi-clock"></i> Duración</th>
                        <th scope="col"><i class="bi bi-controller"></i> Controles</th>
                        <th scope="col"><i class="bi bi-sliders"></i> Config</th>
                    </tr>
                </thead>
                <?php if (!empty($songs)): ?>
                    <?php foreach ($songs as $song): ?>
                        <!-- id_song | song_name | artist | duration | song_path -->
                        <tbody>
                            <tr data-song-id="<?= $song['id_song'] ?>">
                                <td class="m-4"><i class="bi bi-music-note-beamed"></i> <?= $song['song_name'] ?></td>
                                <td><i class="bi bi-person-circle"> <?= $song['artist'] ?></i></td>
                                <td id="durationBtn"><i class="bi bi-clock"></i></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-start gap-2 p-2 w-100">
                                        <!-- Contenedor del reproductor de audio -->
                                        <div class="audio-player bg-white rounded-3 shadow-sm p-2 flex-grow-1">
                                            <audio id="myAudio" controls class="w-100">
                                                <source src="<?= htmlspecialchars($song['song_path']) ?>" type="audio/mpeg">
                                                Tu navegador no soporta el elemento de audio.
                                            </audio>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- Botón para abrir el modal de edición -->
                                    <button class="btn btn-warning m-1" data-bs-toggle="modal" data-bs-target="#editSongModal-<?= $song['id_song'] ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        </tbody>

                        <!-- Modal de edición -->
                        <div class="modal fade" id="editSongModal-<?= $song['id_song'] ?>" tabindex="-1" aria-labelledby="editSongModalLabel-<?= $song['id_song'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSongModalLabel-<?= $song['id_song'] ?>">Editar Canción</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para editar la canción -->
                                        <form action="index.php?r=updatesong" id="editSongForm" method="post" enctype="multipart/form-data">
                                            <input type="text" hidden name="song_id" value="<?= $song['id_song'] ?>">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="song_name" value="<?= $song['song_name'] ?>" class="form-control" id="song_name" placeholder="505">
                                                <label for="song_name">Nombre de la canción</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="artist" value="<?= $song['artist'] ?>" class="form-control" id="artist" placeholder="Artic Monkeys">
                                                <label for="artist">Artista</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="file" name="song" accept="audio/*" class="form-control" id="song">
                                                <label for="song">Seleccionar una nueva canción</label>
                                                <?php if (!empty($song['song_path'])): ?>
                                                    <small class="form-text text-muted">
                                                        Canción actual:
                                                        <a href="<?= $song['song_path'] ?>" target="_blank"><?= basename($song['song_path']) ?></a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            <button class="btn btn-primary mt-3" type="submit">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tbody>
                        <tr>
                            <td colspan="4">No hay canciones disponibles</td>
                        </tr>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <!-- Archivos necesarios para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>