<?php

namespace Api\Shared\Infrastructure\Models;

use Api\Shared\Domain\Exception\NotFoundException;
use DomainException;
use Exception;
use mysqli;

class Database
{
    protected $connection = null;
    private string $query;
    protected string $table;
    protected mixed $pk;
    protected mixed $pk2 = '';

    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            $this->connection->set_charset('utf8');


            if (mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function select()
    {
        $this->query = "SELECT * FROM $this->table";
        $stmt = $this->connection->prepare($this->query);
        $stmt->execute();
        return $this;
    }

    public function where($column, $operator, $value) {
        // validar si no hay and
        $value = strtolower($value);
        $where = '';
        if (str_contains($this->query, 'WHERE')) {
            $where = 'AND';
        } else {
            $where = 'WHERE';
        }
        $this->query .= " $where LOWER($column) $operator $value";
        $stmt = $this->connection->prepare($this->query);
        $stmt->execute();
        return $this;
    }

    public function whereIn(string $column, array $data)
    {
        $values = "('" . implode("', '", $data) . "')";

        $this->where($column, 'IN', $values);
        return $this;
    }
    
    public function limit(int $limit, int $offset): self
    {
        $this->query .= " LIMIT $limit OFFSET $offset";
        $stmt = $this->connection->prepare($this->query);
        $stmt->execute();
        return $this;
    }

    public function get() {
        $stmt = $this->connection->prepare($this->query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function getNextId(): int
    {
        $sql = "select $this->pk + 1 as id from $this->table order by $this->pk  DESC limit 1;";
        $result = $this->query($sql);
        return $result[0]['id'] ?? 1;
    }

    public function findById(mixed $id): array
    {
        $sql = "select * from $this->table WHERE $this->pk='$id';";
        $result = $this->query($sql);
        if (count($result) === 0) {
            throw new NotFoundException("$this->pk not fount in $this->table table");
        }
        return $result[0];
    }

    public function create(array $data): bool
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $valuesSeparatedByComma = $this->getStringValues($values);
        $sql = "INSERT INTO $this->table (" . implode(', ', $keys) . ") VALUES
        ($valuesSeparatedByComma);";

        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new DomainException("Error in create $this->table table: " . mysqli_error($this->connection));
        }
    }

    public function getStringValues(array $values): string
    {
        $i = 1;
        $valuesPrint = "";
        foreach ($values as $value) {
            if ($value == null) {
                $valuesPrint .= "NULL";
            } else {
                $valuesPrint .= "'$value'";
            }

            if ($i != count($values)) {
                $valuesPrint .= ", ";
            }
            $i++;
        }
        return $valuesPrint;
    }

    public function update(array $data, mixed $id): bool
    {
        $keys = array_keys($data);
        $values = array_values($data);

        $keyValue = array_map(function ($key, $value)
        {
            if (empty($value)) {
                return "$key=NULL";
            } else {
                return "$key='$value'";
            }
        }, $keys, $values);

        $sql = "UPDATE $this->table SET " . implode(', ', $keyValue) . " WHERE $this->pk='$id'";

        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new DomainException("Error in update $this->table table: " . mysqli_error($this->connection));
        }
    }

    public function update2(array $data, mixed $id, mixed $id2): bool
    {
        $keys = array_keys($data);
        $values = array_values($data);

        $keyValue = array_map(function ($key, $value)
        {
            if (empty($value)) {
                return "$key=NULL";
            } else {
                return "$key='$value'";
            }
        }, $keys, $values);

        $sql = "UPDATE $this->table SET " . implode(', ', $keyValue) . " WHERE $this->pk='$id' AND $this->pk2='$id2'";

        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new DomainException("Error in update $this->table table: " . mysqli_error($this->connection));
        }
    }

    public function delete(mixed $id): bool
    {
        $sql = "DELETE FROM $this->table WHERE $this->pk='$id'";

        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new DomainException("Error in delete $this->table table: " . mysqli_error($this->connection));
        }
    }

    public function delete2(mixed $id, mixed $id2): bool
    {
        $sql = "DELETE FROM $this->table WHERE $this->pk='$id' AND $this->pk2='$id2'";

        if (mysqli_query($this->connection, $sql)) {
            return true;
        } else {
            throw new DomainException("Error in delete $this->table table: " . mysqli_error($this->connection));
        }
    }

    public function query($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $result;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    private function executeStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Unable to do prepared statement: " . $query);
            }
            if ($params) {
                $stmt->bind_param($params[0], $params[1]);
            }
            $stmt->execute();
            return $stmt;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
