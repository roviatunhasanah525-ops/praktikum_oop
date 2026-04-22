<?php

final class Database {

    public function connect() {
        echo "Koneksi database";
    }

}

// ERROR jika dilakukan
class MyDB extends Database {

}

?>