<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Examen1</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="/css/boostrap-utilities.css" rel="stylesheet">
    <link href="/css/datatables.css" rel="stylesheet" crossorigin="anonymous">
    <link href="/css/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>

<body class="bg-gray">

    <!-- Navbar -->
    <div class="m-4">
        <header class="navbar navbar-expand-md navbar-dark bg-orange">
            <div class="container justify-content-center">
                <h1><a class="navbar-brand font-size-500" href="index.php"></i> WEBAMP</a></h1>
                <!--  <li class="nav-item">
             <a class="nav-link" href="/index.php?r=songs">
                <i class="bi bi-music-note-list"></i> Songs
              </a>
            </li> -->
                </ul>
            </div>
    </div>
    </header>
    <div class="m-4">
        <nav class="navbar navbar-expand-md navbar-dark bg-orange">
            <div class="container-fluid justify-content-start">
                <a class="navbar-brand text-black" href="?r=formsongs"></i>Añadir Cancion</a>
                <!--  <li class="nav-item">
             <a class="nav-link" href="/index.php?r=songs">
                <i class="bi bi-music-note-list"></i> Songs
              </a>
            </li> -->
                </ul>
            </div>
        </nav>
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/datatables.js"></script>
    <script src="/js/main.js"></script>


    <!-- Tabla de canciones -->
    <div class="container">
        <div class="table-responsive rounded column-2 row-2">
            <table class="table table-striped m-4">
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
                                            <audio id="myAudio" controls class="w-100 d-none">
                                                <source src="<?= htmlspecialchars($song['song_path']) ?>" type="audio/mpeg">
                                                Tu navegador no soporta el elemento de audio.
                                            </audio>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Controles de canción">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSongModal-<?= $song['id_song'] ?>">
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

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
    <!-- <form action="/index.php?r=deletesong" method="post" enctype="multipart/form-data" class="m-2">
                                            <div class="form-floating mb-3">
                                                <input type="text" hidden name="id_song" class="form-control" id="id_song" value="<?= $song['id_song'] ?>">
                                                <button class="btn btn-primary mt-3" type="submit">Eliminar</button>
                                            </div> -->

    <!-- Archivos necesarios para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>