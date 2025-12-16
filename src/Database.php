<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use PDOException;
use App\Exception\StorageException;
use PDO;
use Throwable;

class Database
{
    private PDO $conn;
    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        } catch (PDOException $e) {
            throw new StorageException('Connection error...');
        }
    }

    public function getNote(int $id): array
    {
                $query = "SELECT * FROM notes WHERE id = $id";
                $note = $this->conn->query($query)->fetch(PDO::FETCH_ASSOC);
        if (!$note) {
            throw new NotFoundException("Notatka o id: $id nie istnieje");
        }
        return $note;
    }

    public function getNotes(): array
    {
        try {
            $query = "SELECT id, title, created FROM notes";
            $notes = $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych", 400, $e);
        }
    }

    public function createNote(array $data): void
    {
        $title = $this->conn->quote($data['title']);
        $description = $this->conn->quote($data['description']);
        $created = $this->conn->quote(date('Y-m-d H:i:s'));
        try {
            $query = "INSERT INTO notes(title,description,created) VALUES($title,$description,$created)";
            $result = $this->conn->exec($query);
            dump($result);
        } catch (Throwable $e) {
            dump($e);
            exit;
        }
    }

    private function createConnection($config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    private function validateConfig(array $config): void
    {
        if (empty($config['database']) || empty($config['host']) || empty($config['user']) || empty($config['password'])) {
            throw new ConfigurationException('Storage configuration error');
        }
    }

}