<?php
interface IDAO {
    public function findById($pk);
    public function listAll();
    public function insert($object);
    public function update($object);
    public function delete($pk);
}
?>