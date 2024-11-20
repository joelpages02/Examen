document.addEventListener("DOMContentLoaded", () => {
  // Seleccionar todos los elementos de audio
  const audioElements = document.querySelectorAll("audio");

  // Iterar sobre cada elemento de audio
  audioElements.forEach((audioElement) => {
    // Escuchar el evento 'loadedmetadata' para cada audio
    audioElement.addEventListener("loadedmetadata", () => {
      const duration = audioElement.duration; // Obtener duración en segundos
      const formattedDuration = formatTime(duration); // Convertir a mm:ss

      // Buscar el contenedor donde mostrar la duración (por ejemplo, un <span> junto al audio)
      const durationElement = audioElement.closest("td").previousElementSibling;
      if (durationElement) {
        durationElement.textContent = formattedDuration; // Actualizar con la duración formateada
      }
    });

    // Crear controles personalizados para cada audio
    const container = audioElement.closest('.audio-player');
    const controls = document.createElement('div');
    controls.className = 'custom-controls d-flex align-items-center gap-2 mt-2';
    controls.innerHTML = `
        <button class="btn btn-sm btn-primary play-btn">
            <i class="bi bi-play-fill"></i>
        </button>
        <button class="btn btn-sm btn-secondary pause-btn">
            <i class="bi bi-pause-fill"></i>
        </button>
        <button class="btn btn-sm btn-info mute-btn">
            <i class="bi bi-volume-up-fill"></i>
        </button>
        <div class="progress flex-grow-1" style="height: 8px;">
            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
        </div>
    `;

    container.appendChild(controls);

    // Agregar eventos a los botones
    const playBtn = controls.querySelector('.play-btn');
    const pauseBtn = controls.querySelector('.pause-btn');
    const muteBtn = controls.querySelector('.mute-btn');
    const progressBar = controls.querySelector('.progress-bar');

    playBtn.addEventListener('click', () => {
        audioElement.play();
    });

    pauseBtn.addEventListener('click', () => {
        audioElement.pause();
    });

    muteBtn.addEventListener('click', () => {
        audioElement.muted = !audioElement.muted;
        muteBtn.querySelector('i').className = audioElement.muted ? 
            'bi bi-volume-mute-fill' : 'bi bi-volume-up-fill';
    });

    // Actualizar barra de progreso
    audioElement.addEventListener('timeupdate', () => {
        const progress = (audioElement.currentTime / audioElement.duration) * 100;
        progressBar.style.width = `${progress}%`;
    });
  });
});

// Función para formatear segundos a mm:ss
function formatTime(seconds) {
  const minutes = Math.floor(seconds / 60); // Obtener los minutos
  const secs = Math.floor(seconds % 60); // Obtener los segundos restantes
  return `${minutes}:${secs < 10 ? "0" : ""}${secs}`; // Formato mm:ss
}

$(document).ready(function () {
    $("#editSongForm").on("submit", function (event) {
        event.preventDefault(); // Evita el envío normal del formulario

        let formData = new FormData(this); // Crea un objeto FormData con los datos del formulario
        let songId = formData.get("song_id"); // Obtén el ID de la canción desde el formulario

        $.ajax({
            url: "index.php?r=updatesong", // La URL de tu controlador que procesa la actualización
            type: "POST", // Usamos POST para enviar los datos
            data: formData,
            processData: false, // No proceses los datos (es necesario para archivos)
            contentType: false, // No establezcas un contentType automáticamente
            success: function (response) {
                //console.log(response); // Muestra la respuesta del servidor
                alert("¡Canción actualizada correctamente!");

                // Actualiza dinámicamente los datos de la tabla
                let row = $(`tr[data-song-id='${songId}']`);
                row.find("td:nth-child(1)").html(`<i class="bi bi-music-note-beamed"></i> ${formData.get("song_name")}`);
                row.find("td:nth-child(2)").html(`<i class="bi bi-person-circle"> ${formData.get("artist")}</i>`);

                // Si se actualiza la canción, también actualiza el enlace al archivo de audio
                if (formData.get("song")) {
                    let newSongPath = response.newSongPath; // Asegúrate de devolver el nuevo path desde el servidor
                    row.find("audio source").attr("src", newSongPath);
                    row.find("audio")[0].load(); // Recarga el reproductor de audio
                }

                // Cierra el modal después de la actualización
                $(`#editSongModal-${songId}`).modal("hide");
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText); // Muestra cualquier error que ocurra
                alert("Hubo un error al actualizar la canción.");
            }
        });
    });
});
