<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class Amostra
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function createAmostra(string $nome, string $data, string $local, string $parecer): int|bool
    {
        try {
            $sql = "INSERT INTO amostras (nome, data_coleta, local_coleta, parecer, criado_em) VALUES (:nome, :data, :local, :parecer, NOW())";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":data", $data, PDO::PARAM_STR);
            $stmt->bindParam(":local", $local, PDO::PARAM_STR);
            $stmt->bindParam(":parecer", $parecer, PDO::PARAM_STR);

            $stmt->execute();

            return (int) $this->db->lastInsertId();

        } catch (PDOException $error) {
            error_log("Erro ao criar amostra: " . $error->getMessage());
            return false;
        }
    }

    public function createParametros(int $id_amostra, array $parametros, array $classificacoes): bool
    {
        try {
            $sql = "INSERT INTO parametros_agua
                        (id_amostra, ph, ph_classificacao, turbidez, turbidez_classificacao,
                         cloro_residual, cloro_classificacao, dureza, dureza_classificacao,
                         temperatura, temperatura_classificacao)
                    VALUES
                        (:id_amostra, :ph, :ph_c, :turbidez, :turbidez_c,
                         :cloro, :cloro_c, :dureza, :dureza_c,
                         :temperatura, :temperatura_c)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id_amostra", $id_amostra, PDO::PARAM_INT);
            $stmt->bindValue(":ph", $parametros["ph"], PDO::PARAM_STR);
            $stmt->bindValue(":ph_c", $classificacoes["ph"], PDO::PARAM_STR);
            $stmt->bindValue(":turbidez", $parametros["turbidez"], PDO::PARAM_STR);
            $stmt->bindValue(":turbidez_c", $classificacoes["turbidez"], PDO::PARAM_STR);
            $stmt->bindValue(":cloro", $parametros["cloro"], PDO::PARAM_STR);
            $stmt->bindValue(":cloro_c", $classificacoes["cloro"], PDO::PARAM_STR);
            $stmt->bindValue(":dureza", $parametros["dureza"], PDO::PARAM_STR);
            $stmt->bindValue(":dureza_c", $classificacoes["dureza"], PDO::PARAM_STR);
            $stmt->bindValue(":temperatura", $parametros["temperatura"], PDO::PARAM_STR);
            $stmt->bindValue(":temperatura_c", $classificacoes["temperatura"], PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao salvar parâmetros da amostra: " . $error->getMessage());
            return false;
        }
    }

    public function createBiofiltro(int $id_amostra, string $parametro, float $valor_antes, float $valor_depois, float $eficiencia): bool
    {
        try {
            $sql = "INSERT INTO biofiltro_resultados (id_amostra, parametro, valor_antes, valor_depois, eficiencia)
                    VALUES (:id_amostra, :parametro, :antes, :depois, :eficiencia)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id_amostra", $id_amostra, PDO::PARAM_INT);
            $stmt->bindValue(":parametro", $parametro, PDO::PARAM_STR);
            $stmt->bindValue(":antes", $valor_antes, PDO::PARAM_STR);
            $stmt->bindValue(":depois", $valor_depois, PDO::PARAM_STR);
            $stmt->bindValue(":eficiencia", $eficiencia, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao salvar resultado do biofiltro: " . $error->getMessage());
            return false;
        }
    }

    public function getAmostraById(int $id): array|bool
    {
        try {
            $sql = "SELECT * FROM amostras WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            error_log("Erro ao buscar amostra: " . $error->getMessage());
            return false;
        }
    }
}
