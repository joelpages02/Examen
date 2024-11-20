<?php

class Songs
{
    private PDO $sql;

    public function __construct(PDO $sql)
    {
        $this->sql = $sql;
    }

    //  id_song | song_name | artist   | duration | song_path
    public function addSong($song_name, $artist, $song_path)
    {
        $query = "INSERT INTO songs (song_name, artist, song_path) VALUES (:song_name, :artist, :song_path)";
        $stm = $this->sql->prepare($query);
        $stm->execute([":song_name" => $song_name, ":artist" => $artist, ":song_path" => $song_path]);
    }

    public function getAllSongs()
    {
        $query = "SELECT id_song, song_name, artist, duration, song_path FROM songs";
        $stm = $this->sql->prepare($query);
        $stm->execute();

        // Recupera todas las canciones como un arreglo asociativo
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSongById($id_song)
    {
        $query = "SELECT song_name, artist, duration, song_path FROM songs WHERE id_song = :id_song;";
        $stm = $this->sql->prepare($query);
        $stm->execute([":id_song" => $id_song]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    //  id_song | song_name | artist   | duration | song_path
    public function updateSong($id_song, $song_name, $artist, $song_path)
    {
        // Asegurarse de que todos los parámetros estén presentes en la consulta
        $query = "UPDATE songs SET 
            song_name = :song_name, 
            artist = :artist, 
            song_path = :song_path
            WHERE id_song = :id_song";  // Es importante que este marcador también esté en el array

        // Preparar la consulta
        $stm = $this->sql->prepare($query);

        // Crear el array de parámetros con todos los valores necesarios
        $params = [
            ':song_name' => $song_name,
            ':artist' => $artist,
            ':song_path' => $song_path,
            ':id_song' => $id_song // Asegúrate de pasar el ID aquí
        ];

        // Ejecutar la consulta con los parámetros correctos
        $result = $stm->execute($params);

        return $result;
    }

    public function delete($id_song){
        $query = "DELETE FROM songs where id_song = :id_song";
        $stm = $this->sql->prepare($query);
        $stm->execute([":id_song" => $id_song]);

        if ($stm->errorCode() !== '00000') {
            $err = $stm->errorInfo();
            die("Error al eliminar: {$err[0]} - {$err[1]}\n{$err[2]}");
        }
    }
}
