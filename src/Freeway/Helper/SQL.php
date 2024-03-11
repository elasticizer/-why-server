<?php
namespace Freeway\Helper;

use PDO;
use Freeway\Helper\DB;
use const Freeway\DIR_PORTAL;

class SQL {
	const DEFAULT_IDENTIFIER = 'DB';

	private PDO $connection;

	private \PDOStatement $statement;

	private static array $list = [];

	private function __construct(string $identifier, DB $database) {
		$this->connection = $database->connect($identifier);
	}

	public function run($stmt, $values = null): static {
		$this->statement->closeCursor();
		$this->statement = $this->connection->prepare($stmt);
		$this->statement->execute($values);

		return $this;
	}

	public function catch (): array {
		$stmt = $this->statement;

		return !($code = $stmt?->errorCode())
			? false
			: [
				'code' => $code,
				'info' => $stmt->errorInfo()
			];
	}

	public function amass(): array {
		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetch(): array {
		return $this->statement->fetch(PDO::FETCH_ASSOC);
	}

	public function transact($callback): bool {
		$connection = $this->connection;

		if ($connection->beginTransaction())
			throw new \Exception('Cannot start a transaction', 1);

		return $callback()
			? $connection->commit()
			: $connection->rollback();
	}

	public static function use(
		string $identifier = static::DEFAULT_IDENTIFIER
	): static {
		return static::$list[$identifier] ??= new static($identifier);
	}
}
