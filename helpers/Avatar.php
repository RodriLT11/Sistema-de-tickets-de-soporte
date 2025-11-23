<?php 

class Avatar {
    // https://ui-avatars.com/api/?name=Juan+Megalos&background=random&color=fff
    private const string BASE_API_URL = "https://ui-avatars.com/api/";
    private const string BASE_PATH_AVATAR = __DIR__  . "/../public/assets/avatar/";


    public static function get_avatar_url(?int $user_id = null, ?string $username = null): string {
        // Si no se proporcionan parámetros, obtenerlos de la sesión
        if ($user_id === null || $username === null) {
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
                throw new Exception("No hay usuario autenticado en la sesión");
            }
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
        }
        
        $file_path = self::get_avatar($user_id, $username);
        
        // Convertir la ruta absoluta del servidor a ruta web
        // Ejemplo: /home/user/.../public/assets/avatar/avatar_1_Juan.png -> /public/assets/avatar/avatar_1_Juan.png
        $web_path = str_replace(__DIR__ . '/../', '/', $file_path);
        
        return $web_path;
    }

    public static function get_avatar(int $user_id, string $username): string {

        $path_avatar = self::BASE_PATH_AVATAR .'avatar_' . $user_id . '_' . $username . '.png' ;
        if (file_exists($path_avatar)) {
            return $path_avatar;
        }

        $name = trim($username);
        $avatar_url = self::BASE_API_URL . '?name=' . urlencode($name) . '&background=random&color=fff&rounded=true';
        $image_data = file_get_contents($avatar_url);

        if ($image_data !== false) {
            $directory = dirname($path_avatar);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            file_put_contents($path_avatar, $image_data);
        }

        return $path_avatar;
    }

    public function save_avatar_into_folder(int $user_id, string $username): string {
        $name = trim($username);

        $avatar_url = self::BASE_API_URL . '?name='. urlencode($name) . '&background=random&color=fff&rounded=true';
        $image_data = file_get_contents($avatar_url);

        if ($image_data === false) {
            throw new Exception("No se pudo descargar el avatar desde la API");
        }

        $filename = 'avatar_' . $user_id . '_' . $username . '.png';
        $filepath = self::BASE_PATH_AVATAR . $filename;

        $directory = dirname($filepath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $result = file_put_contents($filepath, $image_data);

        if ($result === false) {
            throw new Exception("No se pudo guardar el avatar en: " . $filepath);
        }

        return $filepath;
    }

    public function assign_avatar_to_user(int $user_id, string $username, $conn): bool {
        $path_avatar = $this->save_avatar_into_folder($user_id, $username);

        $sql = "UPDATE users SET avatar = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conn->error);
        }

        $stmt->bind_param("si", $path_avatar, $user_id);
        $result = $stmt->execute();

        if (!$result) {
            throw new Exception("Error al actualizar el avatar en la base de datos: " . $stmt->error);
        }

        $stmt->close();

        return true;
    }

}

