<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class Pagination {
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;

    public function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass() {
        return $this->entityClass;
    }              
    
    public function setLimit($limit) {
        $this->limit = $limit;

        return $this;
    }    

    public function getLimit() {
        return $this->limit;
    }

    public function setPage($page) {
        $this->currentPage = $page;

        return $this;
    }

    public function getPage() {
        return $this->currentPage;
    }

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    public function getData() {
        // Calcul de l'offset
        $offset = $this->currentPage * $this->limit - $this->limit;
        // Demander au Repository de trouver les éléments
        $repo = $this->manager->getRepository($this->entityClass);
        $data =  $repo->findBy([], [], $this->limit, $offset);
        // Renvoyer les éléments en question
        return $data;
    }

    public function getPages() {
        // Connaître le total des enregistrements de la table
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        // Faire la division, l'arrondie et le renvoyer
        $pages = ceil($total / $this->limit);

        return $pages;
    }
}
?>