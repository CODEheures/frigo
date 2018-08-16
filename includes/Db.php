<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 22/12/2015
 * Time: 16:59
 */

namespace Sylvain;
use PDO;
use PDOException;

class Db {


    private $dbName;
    private $dbUser;
    private $dbPass;
    private $idConteneur;
    /**
     * @var PDO
     */
    private $db;

    public function __construct($idConteneur) {
        $this->dbName = 'frigo';
        $this->dbUser = '';
        $this->dbPass = '';
        $this->idConteneur = $idConteneur;
    }

    public function connect() {
        try {
            $this->db = new PDO('mysql:host=mariadb;dbname='. $this->dbName.';charset=utf8', $this->dbUser, $this->dbPass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'La base de donnée n\'est pas disponible';
        }
    }


    public function getContent($sortByCategorie = false) {

        $sql = 'SELECT contient.dateFin,  contient.consomme, aliment.nom AS nom_aliment, categorie.nom AS nom_categorie
                FROM contient
                INNER JOIN aliment
                ON contient.idAliment = aliment.idAliment
                INNER JOIN categorie
                ON aliment.idCategorie = categorie.idCategorie
                WHERE contient.idConteneur = :idConteneur';

        $sortByCategorie ? $sql = $sql . ' ORDER BY categorie.idCategorie, contient.dateFin' : $sql = $sql . ' ORDER BY contient.dateFin';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':idConteneur', $this->idConteneur, PDO::PARAM_INT);
            if($prepare->execute()){
                $result = $prepare->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function getCategories() {

        $sql = 'SELECT idCategorie, nom
                FROM categorie
                Order BY categorie.nom';

        try {
            $prepare = $this->db->prepare($sql);
            if($prepare->execute()){
                $result = $prepare->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function delCategory($idCategorie) {

        $sql = 'DELETE FROM categorie
                WHERE idCategorie = :idCategorie';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':idCategorie', $idCategorie, PDO::PARAM_INT);
            return $prepare->execute();
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function addCategory($name) {

        $sql = 'INSERT INTO categorie (nom)
                VALUES (:name)';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':name', $name, PDO::PARAM_STR);
            return $prepare->execute();
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function getAliments() {

        $sql = 'SELECT idAliment, nom
                FROM aliment
                Order BY aliment.nom';

        try {
            $prepare = $this->db->prepare($sql);
            if($prepare->execute()){
                $result = $prepare->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function getAlimentsByCategory($category) {

        $sql = 'SELECT aliment.idAliment, aliment.nom
                FROM aliment
                INNER JOIN categorie
                ON aliment.idCategorie = categorie.idCategorie
                WHERE categorie.idCategorie = :category
                Order BY aliment.nom';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':category', $category, PDO::PARAM_INT);
            if($prepare->execute()){
                $result = $prepare->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function getAlimentsByDate($date) {

        $sql = 'SELECT contient.idAliment, contient.dateFin, aliment.nom
                FROM contient
                INNER JOIN aliment
                ON aliment.idAliment = contient.idAliment
                WHERE contient.dateFin <= :dateFin
                Order BY contient.dateFin, aliment.nom';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':dateFin', $date, PDO::PARAM_STR);
            if($prepare->execute()){
                $result = $prepare->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function delAliment($idAliment) {

        $sql = 'DELETE FROM aliment
                WHERE idAliment = :idAliment';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':idAliment', $idAliment, PDO::PARAM_INT);
            return $prepare->execute();
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function addAliment($name, $idCategorie) {

        $sql = 'INSERT INTO aliment (nom, idCategorie)
                VALUES (:name, :idCategorie)';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':name', $name, PDO::PARAM_STR);
            $prepare->bindValue(':idCategorie', $idCategorie, PDO::PARAM_INT);
            return $prepare->execute();
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function remplir($idAliment, $date) {

        $sql = 'INSERT INTO contient (idConteneur, idAliment, dateFin, consomme)
                VALUES (:idConteneur, :idAliment, :dateFin, false)';

        try {
            $prepare = $this->db->prepare($sql);
            $prepare->bindValue(':idConteneur', $this->idConteneur, PDO::PARAM_INT);
            $prepare->bindValue(':idAliment', $idAliment, PDO::PARAM_INT);
            $prepare->bindValue(':dateFin', date('Y-m-d', strtotime($date)), PDO::PARAM_STR);
            return $prepare->execute();
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }

    public function getContient() {

        $sql = 'SELECT aliment.nom, contient.dateFin
                FROM contient
                INNER JOIN aliment
                ON aliment.idAliment = contient.idAliment
                Order BY contient.dateFin';

        try {
            $prepare = $this->db->prepare($sql);
            if($prepare->execute()){
                $result = $prepare->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
        } catch(PDOException $e) {
            echo 'Erreur de récupération des données';
        }
        return null;
    }
}