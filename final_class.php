<?php

class Kendaraan {

    final public function mesin() {
        echo "Mesin standar";
    }

}

class Mobil extends Kendaraan {

    // ERROR jika override
    public function mesin() {
        echo "Mesin mobil";
    }

}

?>