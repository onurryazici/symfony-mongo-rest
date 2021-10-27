<?php
namespace App\Implementation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;

interface IDataAccessLayer {
    public function add(Request $request);
    public function delete($id);
    public function findAll();
    public function update(Request $request, $id);
}
?>