<?php
namespace Freeway\Helper;

use PDO;

enum DB: string {
	case MYSQL = 'mysql';
	case MYSQL_SOCKET = 'mysql';
	case PGSQL = 'pgsql';
	case SQLITE = 'sqlite';
	case SQLSRV = 'sqlsrv';

	public function connect(string $identifier): PDO {
		[
			"{$identifier}_HOST" => $host,
			"{$identifier}_PORT" => $port,
			"{$identifier}_SOCKET" => $socket,
			"{$identifier}_USERNAME" => $username,
			"{$identifier}_PASSWORD" => $password,
			"{$identifier}_DATABASE" => $database
		] = $_ENV;

		$elm = match ($this) {
			self::MYSQL => [
				'host' => $host,
				'port' => $port,
				'dbname' => $database,
				'charset' => 'utf8mb4'
			],

			self::MYSQL_SOCKET => [
				'unix_socket' => $socket,
				'dbname' => $database,
				'charset' => 'utf8mb4'
			],

			self::PGSQL => [
				'host' => $host,
				'port' => $port,
				'dbname' => $database,
				'sslmode' => false
			],

			self::SQLITE => sprintf(
				$this->value,
				is_file(realpath($database ?? '')) ?: ':memory:'
			)
		};
		$dsn = urldecode(http_build_query($elm, '', ';'));

		return new PDO("{$this->value}:{$dsn}", $username, $password);
	}
}
